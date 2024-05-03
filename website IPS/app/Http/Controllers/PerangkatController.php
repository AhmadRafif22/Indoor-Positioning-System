<?php

namespace App\Http\Controllers;

use App\Models\Perangkat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerangkatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perangkats = Perangkat::all();
        return view('admin.kelolaperangkat', compact('perangkats'));
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
        $request->validate([
            'mac' => 'required|unique:perangkats|max:255'
        ]);

        Perangkat::create($request->all());

        return redirect()->route('perangkat.index')
            ->with('success', 'Perangkat berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Perangkat  $perangkat
     * @return \Illuminate\Http\Response
     */
    public function show(Perangkat $perangkat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Perangkat  $perangkat
     * @return \Illuminate\Http\Response
     */
    public function edit(Perangkat $perangkat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Perangkat  $perangkat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Perangkat $perangkat)
    {
        $request->validate([
            'mac' => 'required|unique:perangkats|max:255',
        ]);

        $perangkat->update($request->all());

        return redirect()->route('perangkat.index')
            ->withErrors('error', 'Perangkat gagal diupdate, cek kembali inputan anda')
            ->with('success', 'Perangkat berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Perangkat  $perangkat
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        DB::table('pengguna')
            ->whereExists(function ($query) use ($id) {
                $query->select(DB::raw(1))
                    ->from('perangkats')
                    ->whereRaw('perangkat_id = perangkats.id')
                    ->where('id', $id);
            })
            ->update(['perangkat_id' => null]);

        $perangkat = Perangkat::findOrFail($id);
        $perangkat->delete();

        return redirect()->route('perangkat.index')
            ->with('success', 'Perangkat berhasil dihapus.');
    }
}
