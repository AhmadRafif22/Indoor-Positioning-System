<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\Perangkat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penggunas = Pengguna::with('user', 'perangkat')->get();
        $perangkats = Perangkat::all();
        return view('admin.kelolapengguna', compact('penggunas', 'perangkats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'username.required' => 'Kolom nama harus diisi.',
            'useremail.required' => 'Kolom email harus diisi.',
            'useremail.email' => 'Email harus memiliki format yang valid.',
            'useremail.unique' => 'Email sudah digunakan oleh pengguna lain.',
            'useremail.max' => 'Email maksimal :max karakter.',
            'userpass.required' => 'Kolom password harus diisi.',
            'userpass.max' => 'Password maksimal :max karakter.',
            'kode.required' => 'Kolom kode harus diisi.',
            'kode.unique' => 'Kode sudah digunakan oleh pengguna lain.',
            'kode.max' => 'Kode maksimal :max karakter.',
            'jabatan.required' => 'Kolom jabatan harus dipilih.',
            'jabatan.in' => 'Pilihan jabatan tidak valid.',
            'perangkat_id.unique' => 'Perangkat sudah digunakan oleh pengguna lain.',
            'perangkat_id.max' => 'Perangkat ID maksimal :max karakter.',
        ];

        $request->validate([
            'username' => 'required|max:50',
            'useremail' => 'required|email|unique:users,email|max:50',
            'userpass' => 'required|max:255',
            'kode' => 'required|max:18|unique:pengguna,kode',
            'jabatan' => 'required|in:mahasiswa,dosen',
            'perangkat_id' => 'nullable|max:255|unique:pengguna,perangkat_id', // Anda mungkin ingin menyesuaikan aturan validasi ini sesuai kebutuhan
        ], $messages);

        $user = User::create([
            'name' => $request->username,
            'email' => $request->useremail,
            'password' => bcrypt($request->userpass),
        ]);

        $user->assignRole('pengguna');

        Pengguna::create([
            'user_id' => $user->id,
            'perangkat_id' => $request->perangkat_id,
            'kode' => $request->kode,
            'jabatan' => $request->jabatan,
        ]);

        return redirect()->route('pengguna.index')
            ->with('success', 'Pengguna berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pengguna  $pengguna
     * @return \Illuminate\Http\Response
     */
    public function show(Pengguna $pengguna)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pengguna  $pengguna
     * @return \Illuminate\Http\Response
     */
    public function edit(Pengguna $pengguna)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pengguna  $pengguna
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pengguna $pengguna)
    {
        $messages = [
            'username.required' => 'Kolom nama harus diisi.',
            'useremail.required' => 'Kolom email harus diisi.',
            'useremail.email' => 'Email harus memiliki format yang valid.',
            'useremail.unique' => 'Email sudah digunakan oleh pengguna lain.',
            'useremail.max' => 'Email maksimal :max karakter.',
            'userpass.required' => 'Kolom password harus diisi.',
            'userpass.max' => 'Password maksimal :max karakter.',
            'kode.required' => 'Kolom kode harus diisi.',
            'kode.unique' => 'Kode sudah digunakan oleh pengguna lain.',
            'kode.max' => 'Kode maksimal :max karakter.',
            'jabatan.required' => 'Kolom jabatan harus dipilih.',
            'jabatan.in' => 'Pilihan jabatan tidak valid.',
            'perangkat_id.unique' => 'Perangkat sudah digunakan oleh pengguna lain.',
            'perangkat_id.max' => 'Perangkat ID maksimal :max karakter.',
        ];

        $request->validate([
            'username' => 'required|max:50',
            'useremail' => 'required|email|max:50',
            'kode' => [
                'required',
                'max:18',
                Rule::unique('pengguna')->ignore($pengguna->id),
            ],
            'jabatan' => 'required|in:mahasiswa,dosen',
            'perangkat_id' => [
                'nullable',
                Rule::unique('pengguna')->ignore($pengguna->id)->where(function ($query) use ($request) {
                    return $query->where('perangkat_id', $request->perangkat_id);
                }),
            ],
        ], $messages);

        $user = $pengguna->user;
        $user->update([
            'name' => $request->username,
            'email' => $request->useremail,
        ]);

        if ($request->filled('userpass')) {
            $user->update([
                'password' => bcrypt($request->userpass),
            ]);
        }

        $user->assignRole('pengguna');

        $pengguna->update([
            'kode' => $request->kode,
            'jabatan' => $request->jabatan,
            'perangkat_id' => $request->perangkat_id,
        ]);

        return redirect()->route('pengguna.index')
            ->withErrors(['error' => 'Pengguna gagal diupdate, cek kembali inputan anda'])
            ->withInput()
            ->with('success', 'Pengguna berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pengguna  $pengguna
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Pengguna $pengguna)
    {
        if ($request->has('user_id')) {
            // Hapus pengguna
            $pengguna->delete();

            // Hapus user berdasarkan user_id yang dikirimkan bersamaan dengan formulir
            $user_id = $request->input('user_id');
            $user = User::find($user_id);
            if ($user) {
                $user->delete();
            }
        }

        return redirect()->route('pengguna.index')
            ->with('success', 'Pengguna berhasil dihapus');
    }
}
