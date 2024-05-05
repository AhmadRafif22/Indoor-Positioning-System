<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Homepage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/homepage.css') }}">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <!-- Modal Login-->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-3 fw-bold" id="staticBackdropLabel">Login</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body container">

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" :value="__('Email')" class="form-label">Email
                                address</label>
                            <input type="email" class="form-control" id="email" name="email"
                                :value="old('email')" required autofocus autocomplete="username">
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
                        </div>

                        <div class="mb-5">
                            <label for="password" :value="__('Password')" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required
                                autocomplete="current-password">
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">Login</button>
                        </div>

                        <div class="container d-flex justify-content-between">
                            <!-- Remember Me -->
                            <div class="block mt-4">
                                <label for="remember_me" class="inline-flex items-center">
                                    <input id="remember_me" type="checkbox"
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                        name="remember">
                                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                                </label>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                @if (Route::has('password.request'))
                                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                        href="{{ route('password.request') }}">
                                        {{ __('Forgot your password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>


                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal Login end-->

    {{-- header --}}
    <div class="container py-5 d-flex position-relative">

        <div class="search-box p-3 rounded-3">

            <div class="search-box-container">

                <div class="d-flex justify-content-between align-items-center search-trigger mb-3">
                    <h4 class="fw-bold text-white mb-0">Cari Pengguna Perangkat</h4>
                    <span id="search-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" height="25" width="25"
                            viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                            <path fill="#ffffff"
                                d="M256 0a256 256 0 1 0 0 512A256 256 0 1 0 256 0zM135 241c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l87 87 87-87c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9L273 345c-9.4 9.4-24.6 9.4-33.9 0L135 241z" />
                        </svg>
                    </span>
                </div>

                <form id="searchForm">
                    <div class="input-group mb-3">
                        <input type="text" name="term" class="form-control" placeholder="Masukkan nama pengguna"
                            aria-label="Recipient's username" aria-describedby="button-addon2" id="searchInput">
                        <button class="btn bg-white px-1" type="reset">
                            <svg xmlns="http://www.w3.org/2000/svg" height="15" width="15"
                                viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                <path fill="#acb0c2"
                                    d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c-9.4 9.4-9.4 24.6 0 33.9l47 47-47 47c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l47-47 47 47c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-47-47 47-47c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-47 47-47-47c-9.4-9.4-24.6-9.4-33.9 0z" />
                            </svg>
                        </button>
                        <button class="btn search-btn bg-white" disabled>
                            <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20"
                                viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                <path fill="#20304c"
                                    d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            <div class="search-result-container d-none pb-4" id="search-results">

            </div>

        </div>

        <div class="d-flex header-container justify-content-between px-4 align-items-start">
            <div class="d-flex">
                <img src="{{ asset('img/jti-logo.png') }}" alt="" class="">
                <div class="px-3">
                    <h4 class="fw-bold fs-3 mt-2">Indoor Positioning System</h4>
                    <p class="fs-4 m-0">Jurusan Teknologi Informasi</p>
                    <p class="fs-4 m-0">POLINEMA</p>
                </div>
            </div>
            <div class="py-2 px-4 login-btn rounded" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                <div class=" m-0 text-decoration-none text-white fw-bold">Login</div>
            </div>



        </div>
    </div>
    {{-- header End --}}

    {{-- Peta --}}
    <div class="peta-container-wrap container py-5">
        <h2 class="fs-2 fw-bold denah-title mb-3">
            DENAH RUANGAN
        </h2>
        <div class="container p-4 rounded-4 bg-white">
            <div class="mb-4">
                <h3 class="fs-3 fw-bold">Gedung Sipil</h3>
                <h4 class="fs-4 text-secondary">Lantai 6</h4>
            </div>
            <div class="container p-3">
                <div class="peta-container px-2">

                    {{-- ruang Atas --}}
                    <div class="row mb-5">

                        {{-- Ruang Ekosistem --}}
                        <div class="flex pt-2 col kelas Ruang-Ekosistem" data-bs-toggle="modal"
                            data-bs-target="#Ekosistem">
                        </div>
                        <div class="modal fade modal-Ruang-Ekosistem" id="Ekosistem" data-bs-backdrop="static"
                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fw-bold fs-4" id="staticBackdropLabel">
                                            Ruang Ekosistem
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Ruang Ekosistem End --}}

                        {{-- Ruang LPY-3 --}}
                        <div class="flex pt-2 col kelas Ruang-LPY-3" data-bs-toggle="modal" data-bs-target="#LPY-3">
                        </div>
                        <div class="modal fade modal-Ruang-LPY-3" id="LPY-3" data-bs-backdrop="static"
                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fw-bold fs-4" id="staticBackdropLabel">
                                            Ruang LPY 3
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Ruang LPY-3 End --}}

                        {{-- Ruang LPY-2 --}}
                        <div class="flex pt-2 col kelas Ruang-LPY-2" data-bs-toggle="modal" data-bs-target="#LPY-2">
                        </div>
                        <div class="modal fade modal-Ruang-LPY-2" id="LPY-2" data-bs-backdrop="static"
                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fw-bold fs-4" id="staticBackdropLabel">
                                            Ruang LPY 2
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Ruang LPY-2 End --}}

                        {{-- Ruang Arsip --}}
                        <div class="flex pt-2 col kelas Ruang-Arsip" data-bs-toggle="modal" data-bs-target="#Arsip">
                        </div>
                        <div class="modal fade modal-Ruang-Arsip" id="Arsip" data-bs-backdrop="static"
                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fw-bold fs-4" id="staticBackdropLabel">
                                            Ruang Arsip
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Ruang Arsip End --}}

                        <div class="col-3 flex gap-2 pt-2 kelas-tengah">

                        </div>

                        {{-- Ruang Dosen-6 --}}
                        <div class="flex pt-2 col kelas Ruang-Dosen-6" data-bs-toggle="modal"
                            data-bs-target="#Dosen-6">
                        </div>
                        <div class="modal fade modal-Ruang-Dosen-6" id="Dosen-6" data-bs-backdrop="static"
                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fw-bold fs-4" id="staticBackdropLabel">
                                            Ruang Dosen 6
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Ruang Dosen-6 End --}}

                        {{-- Ruang Dosen-5 --}}
                        <div class="flex pt-2 col kelas Ruang-Dosen-5" data-bs-toggle="modal"
                            data-bs-target="#Dosen-5">
                        </div>
                        <div class="modal fade modal-Ruang-Dosen-5" id="Dosen-5" data-bs-backdrop="static"
                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fw-bold fs-4" id="staticBackdropLabel">
                                            Ruang Dosen 5
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Ruang Dosen-5 End --}}

                        {{-- Ruang Dosen-4 --}}
                        <div class="flex pt-2 col kelas Ruang-Dosen-4" data-bs-toggle="modal"
                            data-bs-target="#Dosen-4">
                        </div>
                        <div class="modal fade modal-Ruang-Dosen-4" id="Dosen-4" data-bs-backdrop="static"
                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fw-bold fs-4" id="staticBackdropLabel">
                                            Ruang Dosen 4
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Ruang Dosen-4 End --}}

                        {{-- Ruang Dosen-2 --}}
                        <div class="flex pt-2 col kelas Ruang-Dosen-2" data-bs-toggle="modal"
                            data-bs-target="#Dosen-2">
                        </div>
                        <div class="modal fade modal-Ruang-Dosen-2" id="Dosen-2" data-bs-backdrop="static"
                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fw-bold fs-2" id="staticBackdropLabel">
                                            Ruang Dosen 2
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Ruang Dosen-2 End --}}
                    </div>

                    {{-- kelas bawah --}}
                    <div class="row">
                        {{-- Ruang LSI-3 --}}
                        <div class="flex pt-2 col kelas Ruang-LSI-3" data-bs-toggle="modal" data-bs-target="#LSI-3">
                        </div>
                        <div class="modal fade modal-Ruang-LSI-3" id="LSI-3" data-bs-backdrop="static"
                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fw-bold fs-2" id="staticBackdropLabel">
                                            Ruang LSI 3
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Ruang LSI-3 End --}}

                        {{-- Ruang LSI-2 --}}
                        <div class="flex pt-2 col kelas Ruang-LSI-2" data-bs-toggle="modal" data-bs-target="#LSI-2">
                        </div>
                        <div class="modal fade modal-Ruang-LSI-2" id="LSI-2" data-bs-backdrop="static"
                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fw-bold fs-2" id="staticBackdropLabel">
                                            Ruang LSI 2
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Ruang LSI-2 End --}}

                        {{-- Ruang LSI-1 --}}
                        <div class="flex pt-2 col kelas Ruang-LSI-1" data-bs-toggle="modal" data-bs-target="#LSI-1">
                        </div>
                        <div class="modal fade modal-Ruang-LSI-1" id="LSI-1" data-bs-backdrop="static"
                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fw-bold fs-2" id="staticBackdropLabel">
                                            Ruang LSI 1
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Ruang LSI-1 End --}}

                        {{-- Ruang Baca --}}
                        <div class="flex pt-2 col kelas Ruang-Baca" data-bs-toggle="modal" data-bs-target="#Baca">
                        </div>
                        <div class="modal fade modal-Ruang-Baca" id="Baca" data-bs-backdrop="static"
                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fw-bold fs-2" id="staticBackdropLabel">
                                            Ruang Baca
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Ruang Baca End --}}

                        <div class="col-3 flex gap-2 pt-2 kelas-tengah-bawah">


                        </div>

                        {{-- Ruang Program Studi --}}
                        <div class="flex pt-2 col kelas Ruang-Program-Studi" data-bs-toggle="modal"
                            data-bs-target="#program-studi">
                        </div>
                        <div class="modal fade modal-Ruang-Program-Studi" id="program-studi"
                            data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                            aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fw-bold fs-4" id="staticBackdropLabel">
                                            Ruang Program Studi
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Ruang Program Studi End --}}

                        {{-- Ruang Jurusan --}}
                        <div class="flex pt-2 col kelas Ruang-Jurusan" data-bs-toggle="modal"
                            data-bs-target="#Jurusan">
                        </div>
                        <div class="modal fade modal-Ruang-Jurusan" id="Jurusan" data-bs-backdrop="static"
                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fw-bold fs-2" id="staticBackdropLabel">
                                            Ruang Jurusan
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Ruang Jurusan End --}}

                        {{-- Ruang Dosen-3 --}}
                        <div class="flex pt-2 col kelas Ruang-Dosen-3" data-bs-toggle="modal"
                            data-bs-target="#Dosen-3">
                        </div>
                        <div class="modal fade modal-Ruang-Dosen-3" id="Dosen-3" data-bs-backdrop="static"
                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fw-bold fs-2" id="staticBackdropLabel">
                                            Ruang Dosen 3
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Ruang Dosen-3 End --}}

                        {{-- Ruang Dosen-1 --}}
                        <div class="flex pt-2 col kelas Ruang-Dosen-1" data-bs-toggle="modal"
                            data-bs-target="#Dosen-1">
                        </div>
                        <div class="modal fade modal-Ruang-Dosen-1" id="Dosen-1" data-bs-backdrop="static"
                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fw-bold fs-2" id="staticBackdropLabel">
                                            Ruang Dosen 1
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Ruang Dosen-1 End --}}

                    </div>

                </div>
            </div>
        </div>
    </div>
    {{-- Peta end --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/mqtt/5.5.0/mqtt.min.js"></script>

    {{-- Script search --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var searchBox = document.querySelector(".search-trigger");
            var searchResultContainer = document.querySelector(".search-result-container");
            var searchIcon = document.getElementById("search-icon");

            searchBox.addEventListener("click", function() {
                searchResultContainer.classList.toggle("d-none");
                updateSearchIcon();
            });

            function updateSearchIcon() {
                if (searchResultContainer.classList.contains("d-none")) {
                    searchIcon.innerHTML =
                        '<svg xmlns="http://www.w3.org/2000/svg" height="25" width="25" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#ffffff" d="M256 0a256 256 0 1 0 0 512A256 256 0 1 0 256 0zM135 241c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l87 87 87-87c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9L273 345c-9.4 9.4-24.6 9.4-33.9 0L135 241z"/></svg>';
                } else {
                    searchIcon.innerHTML =
                        '<svg xmlns="http://www.w3.org/2000/svg" height="25" width="25" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#ffffff" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM377 271c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-87-87-87 87c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9L239 167c9.4-9.4 24.6-9.4 33.9 0L377 271z"/></svg>';
                }
            }
        });
    </script>


    {{-- Script search End --}}

    {{-- ajax live search --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            function getSavedSearchTerm() {
                return localStorage.getItem("searchInputValue") || '';
            }

            function updateSavedSearchTerm(value) {
                localStorage.setItem("searchInputValue", value);
            }

            $('#searchInput').val(getSavedSearchTerm());

            $('#searchInput').on('input', function() {
                updateSavedSearchTerm($(this).val());
            });

            $('#searchInput').on('keyup', function() {
                var searchTerm = $(this).val();
                $.ajax({
                    url: "{{ route('search') }}",
                    type: "GET",
                    data: {
                        term: searchTerm
                    },
                    success: function(data) {
                        $('#search-results').html(data);
                    }
                });
            });
        });
    </script>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'csrftoken': '{{ csrf_token() }}'
            }
        });
    </script>
    {{-- ajax live search --}}



    <script>
        const clientId = 'IPS' + Math.random().toString(16).substr(2, 8);

        const client = mqtt.connect('ws://broker.sinaungoding.com:8090', {
            clientId,
            clean: false,
            username: 'uwais',
            password: 'uw415_4Lqarn1'
        });

        var datas = @json($datas);

        client.on('connect', function() {
            console.log('Connected to MQTT broker');
            // console.log(datas);
            datas.forEach(function(item) {
                console.log(item);
                client.subscribe(item.mac + '/hasilprediksi', function(err) {
                    if (!err) {
                        console.log('Subscribed to topic: ' + item.mac + '/hasilprediksi');
                    }
                });
            });
        });

        var lastMessageTime = {};

        function setDeviceTimeout(mac) {
            setTimeout(() => {
                var currentTime = new Date();
                var lastMessageReceivedTime = lastMessageTime[mac];

                if (lastMessageReceivedTime && (currentTime - lastMessageReceivedTime > 20000)) {
                    // console.log(mac + ' terputus');

                    // Hapus ikon dari peta
                    var elementToRemove = document.querySelector('.img-' + mac);
                    if (elementToRemove) {
                        elementToRemove.remove();
                    }

                    // Hapus kartu modal
                    var cardModalOld = document.querySelector('.card-' + mac);
                    if (cardModalOld) {
                        cardModalOld.remove();
                    }

                    delete lastMessageTime[mac];
                }
            }, 20000);
        }

        client.on('message', function(topic, message) {

            const data = JSON.parse(message.toString());
            predictedRoomValue = data.predicted_room;
            mac = data.mac;


            var modifiedMacAddress1 = mac.replace(/:/g, "-");

            setDeviceTimeout(modifiedMacAddress1);

            lastMessageTime[modifiedMacAddress1] = new Date();

            // slug
            predictedRoomValue = predictedRoomValue.replace(/\s+/g, '-');

            const index = datas.findIndex(item => item.mac === mac);

            if (index !== -1) {

                datas[index].predicted_room = predictedRoomValue;

                // console.log("mac:  " + datas[index].mac + " | pred: " + datas[index].predicted_room);

                var modifiedMacAddress = datas[index].mac.replace(/:/g, "-");

                // icon map
                var elementToRemove = document.querySelector('.img-' + modifiedMacAddress);
                if (elementToRemove) {
                    elementToRemove.remove();
                }

                var element = document.querySelector('.' + datas[index].predicted_room);
                if (element) {
                    element.innerHTML +=
                        `<img src="/img/profile.png" alt="" width="30px" class="img-${modifiedMacAddress} m-1">`;
                }

                // card modal
                var cardModalOld = document.querySelector('.card-' + modifiedMacAddress);
                if (cardModalOld) {
                    cardModalOld.remove();
                }

                var modalBody = document.querySelector('.modal-' + datas[index].predicted_room +
                    ' .modal-body');

                if (modalBody) {
                    modalBody.innerHTML +=
                        `
                                <div class="modal-card p-3 m-2 mb-3 rounded-3 d-flex align-items-center card-${modifiedMacAddress}">
                                    <div class="me-4">
                                        <img src="/img/profile-active.png" alt="" class="modal-img">
                                    </div>
                                    <div>
                                        <h5 class="fs-4 mb-1">
                                            ${datas[index].name}
                                        </h5>
                                        <p class="mb-0 fs-5">${datas[index].mac}</p>
                                        <p class="mb-0 fs-5">${datas[index].jabatan} - ${datas[index].kode}</p>
                                    </div>
                                </div>
                            `;
                }

            }

        });
    </script>
</body>

</html>
