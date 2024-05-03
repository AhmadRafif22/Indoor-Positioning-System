@extends('admin.adminlayout')

@section('content')
    <!-- Page Heading -->
    <h1 class="h2 p-4 mb-5 text-gray-800 dashboard-title fw-semibold">Kelola Perangkat ESP8266</h1>

    <div class="container">
        <div class="d-flex justify-content-end">
            <div class="d-flex tambah-btn p-2 rounded text-white" data-bs-toggle="modal" data-bs-target="#tambahperangkat">
                <span class="me-3 fw-semibold">
                    Tambah
                </span>
                <img src="{{ asset('img/Cpu-small.svg') }}" alt="" class="">
            </div>
        </div>
        <!-- Modal tambah perangkat-->
        <div class="modal fade" id="tambahperangkat" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3 fw-semibold" id="staticBackdropLabel">Tambah Perangkat</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body container">

                        <form method="POST" action="{{ route('perangkat.store') }}">
                            @csrf

                            <!-- Mac Address -->
                            <div class="mb-5">
                                <label for="mac" :value="__('mac')" class="form-label">Mac Adress</label>
                                <input type="text" class="form-control" id="mac" name="mac"
                                    :value="old('mac')" required autofocus>
                                {{-- <x-input-error :messages="$errors->get('mac')" class="mt-2 text-danger" /> --}}
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-success">tambahkan</button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
        <!-- Modal tambah perangkat-->
        <table class="table my-3">
            <thead>
                <tr class="tabel-head">
                    <th scope="col">No</th>
                    <th scope="col">Mac Adress</th>
                    <th scope="col">Ditambahkan</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $counter = 1;
                @endphp
                @foreach ($perangkats as $perangkat)
                    <tr>
                        <td>{{ $counter++ }}</td>
                        <td>{{ $perangkat->mac }}</td>
                        <td>{{ $perangkat->created_at }}</td>
                        <td class="d-flex gap-3">
                            <img src="{{ asset('img/edit-icon.svg') }}" alt="" class="edit-btn"
                                data-bs-toggle="modal" data-bs-target="#editModal{{ $perangkat->id }}">
                            <!-- Modal untuk mengedit data -->
                            <div class="modal fade" id="editModal{{ $perangkat->id }}" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-secondary fw-semibold fs-3" id="editModalLabel">Edit
                                                Perangkat</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('perangkat.update', $perangkat->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <!-- Isi form dengan data yang ada -->
                                                <div class="mb-5">
                                                    <label for="editMac" class="form-label">MAC Address</label>
                                                    <input type="text" class="form-control" id="editMac" name="mac"
                                                        value="{{ $perangkat->mac }}" required>
                                                </div>

                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>

                                @if (session('success'))
                                    <script>
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Success',
                                            text: '{{ session('success') }}',
                                            timer: 2000
                                        });
                                    </script>
                                @endif

                                @if ($errors->any())
                                    <script>
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: 'Mac Address sudah ada'
                                        });
                                    </script>
                                @endif
                            </div>
                            {{-- end modal --}}

                            <form id="deleteForm{{ $perangkat->id }}"
                                action="{{ route('perangkat.destroy', $perangkat->id) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <!-- Button untuk menampilkan konfirmasi SweetAlert -->
                                <img src="{{ asset('img/delete-icon.svg') }}" alt="" class="delete-btn"
                                    onclick="deletePerangkat({{ $perangkat->id }})">
                            </form>

                            <!-- Script untuk menampilkan konfirmasi SweetAlert -->
                            <script>
                                function deletePerangkat(perangkatId) {
                                    Swal.fire({
                                        title: 'Yakin Hapus Perangkat?',
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonText: 'Ya',
                                        cancelButtonText: 'Tidak',
                                        reverseButtons: true
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            // Submit form untuk menghapus perangkat jika dikonfirmasi
                                            document.getElementById('deleteForm' + perangkatId).submit();
                                        }
                                    });
                                }
                            </script>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
