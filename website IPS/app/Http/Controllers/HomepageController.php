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

        return view('homepage', ['datas' => $data], ['users' => NULL]);
    }

    public function search(Request $request)
    {
        $searchName = $request->input('term');

        $users = User::where('name', 'like', '%' . $searchName . '%')
            ->join('pengguna', 'users.id', '=', 'pengguna.user_id')
            ->join('perangkats', 'pengguna.perangkat_id', '=', 'perangkats.id')
            ->select('users.name', 'perangkats.mac', 'pengguna.kode', 'pengguna.jabatan')
            ->get();

        $datas  = Perangkat::join('pengguna', 'perangkats.id', '=', 'pengguna.perangkat_id')
            ->join('users', 'pengguna.user_id', '=', 'users.id')
            ->select('users.id', 'users.name', 'pengguna.kode', 'pengguna.jabatan', 'perangkats.mac')
            ->get();

        foreach ($users as $user) {
            $user->active = false;
            $user->predRoom = '';
        }

        return view('homepage', compact('users', 'datas'));
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
