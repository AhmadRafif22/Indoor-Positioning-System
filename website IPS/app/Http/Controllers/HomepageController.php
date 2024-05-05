<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Perangkat;
use App\Models\Pengguna;
use App\Models\User;

class HomepageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Perangkat::join('pengguna', 'perangkats.id', '=', 'pengguna.perangkat_id')
            ->join('users', 'pengguna.user_id', '=', 'users.id')
            ->select('users.id', 'users.name', 'pengguna.kode', 'pengguna.jabatan', 'perangkats.mac')
            ->get();

        // dd($data);

        return view('homepage', ['datas' => $data]);
        // return view('homepage', ['datas' => $data], ['users' => NULL]);
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $searchTerm = $request->input('term');

            $users = User::leftJoin('pengguna', 'users.id', '=', 'pengguna.user_id')
                ->leftJoin('perangkats', 'pengguna.perangkat_id', '=', 'perangkats.id')
                ->whereNotIn('users.name', ['admin'])
                ->where(function ($query) use ($searchTerm) {
                    $query->where('users.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('pengguna.kode', 'like', '%' . $searchTerm . '%');
                })
                // ->select('users.name', 'perangkats.mac', 'pengguna.kode', 'pengguna.jabatan')
                ->select('users.id', 'users.name', 'perangkats.mac', 'pengguna.kode', 'pengguna.jabatan')
                ->get();
            if ($users->isEmpty()) {
                $output = '<div class="text-center">Tidak ada hasil ditemukan.</div>';
            } else {
                $output = '';
                foreach ($users as $user) {
                    $predictionRoomMac = $user->mac ? 'Terputus' : 'Tidak Terdaftar Perangkat';
                    $output .= '<div class="modal-card p-3 m-2 mb-3 rounded-3 search-card-' . $user->id . '">
                                <div class="d-flex align-items-center">
                                    <div class="me-4" id="profile-img-search-' . $user->id . '">
                                        <img src="/img/profile-disconect.png" alt="" class="modal-img-search" style="width:60px;">
                                    </div>
                                    <div>
                                        <h5 class="fs-5 mb-1">' . $user->name . '</h5>
                                        <p class="mb-0 fs-6">' . $user->mac . '</p>
                                        <p class="mb-0 fs-6">' . $user->jabatan . ' - ' . $user->kode . '</p>
                                    </div>
                                </div>
                                <hr>
                                <h6 class="text-secondary text-end mb-0"  id="prediction-room-search-' . $user->id . '">' . $predictionRoomMac . '</h6>
                            </div>';
                }
            }

            return Response($output);
        }
        return view('homepage');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
