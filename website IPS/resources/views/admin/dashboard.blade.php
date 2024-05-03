@extends('admin.adminlayout')

@section('content')
    <!-- Page Heading -->
    <h1 class="h2 p-4 mb-5 text-gray-800 dashboard-title">Selamat Datang</h1>

    <div class="container row">
        <div class="col-6">
            <div class="card-dashboard p-4 rounded border-dark rounded-4">
                <div class="d-flex">
                    <div class="p-5 me-3 rounded card-icon-bg">
                        <img src="{{ asset('img/PersonCircle.svg') }}" alt="" class="">
                    </div>
                    <div class="text-black">
                        <h3 class="fs-3 fw-bold">Total</h3>
                        <h3 class="fs-3 mb-4 text-secondary">Pengguna Perangkat</h3>
                        <h1 class="fs-1 fw-bold text-secondary">
                            {{ $totalPengguna }}
                        </h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card-dashboard p-4 rounded border-dark rounded-4">
                <div class="d-flex">
                    <div class="p-5 me-3 rounded card-icon-bg">
                        <img src="{{ asset('img/Cpu.svg') }}" alt="" class="">
                    </div>
                    <div class="text-black">
                        <h3 class="fs-3 fw-bold">Total</h3>
                        <h3 class="fs-3 mb-4 text-secondary">Perangkat ESP8266</h3>
                        <h1 class="fs-1 fw-bold text-secondary">
                            {{ $totalPerangkat }}
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
