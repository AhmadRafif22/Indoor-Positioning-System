@extends('admin.adminlayout')

@section('content')
    <!-- Page Heading -->
    <h1 class="h2 p-4 mb-5 text-gray-800 dashboard-title fw-semibold">Kelola Pengguna Perangkat</h1>

    <div class="container">
        <div class="d-flex justify-content-end">
            <div class="d-flex tambah-btn p-2 rounded text-white" data-bs-toggle="modal" data-bs-target="#tambahpengguna">
                <span class="me-3 fw-semibold">
                    Tambah
                </span>
                <img src="{{ asset('img/adduser.svg') }}" alt="" class="">
            </div>
        </div>

        <!-- Modal tambah pengguna-->
        <div class="modal fade" id="tambahpengguna" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3 fw-semibold" id="staticBackdropLabel">Tambah pengguna</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body container">

                        <form method="POST" action="{{ route('pengguna.store') }}">
                            @csrf

                            <div class="mb-2">
                                <label for="username" :value="__('username')" class="form-label">username</label>
                                <input type="text" class="form-control" id="username" name="username"
                                    :value="old('username')" required autofocus>
                            </div>
                            <div class="mb-2">
                                <label for="useremail" :value="__('useremail')" class="form-label">Email Adress</label>
                                <input type="email" class="form-control" id="useremail" name="useremail"
                                    :value="old('useremail')" required autofocus>
                            </div>
                            <div class="mb-2">
                                <label for="userpass" :value="__('userpass')" class="form-label">Password</label>
                                <input type="text" class="form-control" id="userpass" name="userpass"
                                    :value="old('userpass')" required autofocus>
                            </div>

                            <div class="mb-2">
                                <label for="kode" :value="__('kode')" class="form-label">NIM / NIP</label>
                                <input type="text" class="form-control" id="kode" name="kode"
                                    :value="old('kode')" required autofocus>
                            </div>
                            <div class="mb-2">
                                <label for="jabatan" class="form-label">Kategori</label>
                                <select class="form-select" id="jabatan" name="jabatan" required autofocus>
                                    <option value="mahasiswa" {{ old('jabatan') == 'mahasiswa' ? 'selected' : '' }}>
                                        Mahasiswa</option>
                                    <option value="dosen" {{ old('jabatan') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                                </select>
                            </div>

                            <div class="mb-5">
                                <label for="perangkat_id" class="form-label">Perangkat</label>
                                <select class="form-select" id="perangkat_id" name="perangkat_id" autofocus>
                                    <option value="" {{ old('perangkat_id') == null ? 'selected' : '' }}>
                                        xx : xx : xx : xx : xx : xx</option>
                                    @foreach ($perangkats as $perangkat)
                                        <option value="{{ $perangkat->id }}"
                                            {{ old('perangkat_id') == $perangkat->id ? 'selected' : '' }}>
                                            {{ $perangkat->mac }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-success">tambahkan</button>
                            </div>

                        </form>

                    </div>

                </div>
            </div>
        </div>
        <!-- Modal tambah pengguna-->

        <table class="table my-3">
            <thead>
                <tr class="tabel-head">
                    <th scope="col">ID</th>
                    <th scope="col">Mac Adress</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Kategori</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penggunas as $pengguna)
                    <tr>
                        <td>{{ $pengguna->kode }}</td>
                        <td>{{ $pengguna->perangkat->mac ?? 'xx : xx : xx : xx : xx : xx' }}</td>
                        <td>{{ $pengguna->user->name }}</td>
                        <td>{{ $pengguna->jabatan }}</td>
                        <td class="d-flex gap-3">
                            <img src="{{ asset('img/edit-icon.svg') }}" alt="" class="edit-btn"
                                data-bs-toggle="modal" data-bs-target="#editModal{{ $pengguna->id }}">

                            <!-- Modal untuk mengedit data -->
                            <div class="modal fade" id="editModal{{ $pengguna->id }}" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-secondary fw-semibold fs-3" id="editModalLabel">
                                                Edit
                                                pengguna</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>

                                        <form method="POST" action="{{ route('pengguna.update', $pengguna->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-2">
                                                    <label for="username" class="form-label">Username</label>
                                                    <input type="text" class="form-control" id="username"
                                                        name="username" value="{{ $pengguna->user->name }}" required
                                                        autofocus>
                                                </div>
                                                <div class="mb-2">
                                                    <label for="useremail" class="form-label">Email Address</label>
                                                    <input type="email" class="form-control" id="useremail"
                                                        name="useremail" value="{{ $pengguna->user->email }}" required
                                                        autofocus>
                                                </div>
                                                <div class="mb-2">
                                                    <label for="userpass" class="form-label">Password</label>
                                                    <input type="text" class="form-control" id="userpass"
                                                        name="userpass" autofocus>
                                                </div>
                                                <div class="mb-2">
                                                    <label for="kode" class="form-label">NIM / NIP</label>
                                                    <input type="text" class="form-control" id="kode"
                                                        name="kode" value="{{ $pengguna->kode }}" required autofocus>
                                                </div>
                                                <div class="mb-2">
                                                    <label for="jabatan" class="form-label">Kategori</label>
                                                    <select class="form-select" id="jabatan" name="jabatan" required
                                                        autofocus>
                                                        <option value="mahasiswa"
                                                            {{ $pengguna->jabatan == 'mahasiswa' ? 'selected' : '' }}>
                                                            Mahasiswa
                                                        </option>
                                                        <option value="dosen"
                                                            {{ $pengguna->jabatan == 'dosen' ? 'selected' : '' }}>Dosen
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="mb-5">
                                                    <label for="perangkat_id" class="form-label">Perangkat</label>
                                                    <select class="form-select" id="perangkat_id" name="perangkat_id"
                                                        autofocus>
                                                        <option value=""
                                                            {{ $pengguna->perangkat_id == null ? 'selected' : '' }}>
                                                            xx : xx : xx : xx : xx : xx
                                                        </option>
                                                        @foreach ($perangkats as $perangkat)
                                                            <option value="{{ $perangkat->id }}"
                                                                {{ $pengguna->perangkat_id == $perangkat->id ? 'selected' : '' }}>
                                                                {{ $perangkat->mac }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-success">Update</button>
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
                                @else
                                    @if ($errors->any())
                                        <script>
                                            var errorMessage = '';
                                            @foreach ($errors->all() as $error)
                                                errorMessage += '{{ $error }}\n';
                                            @endforeach
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Oops...',
                                                text: errorMessage,
                                                timer: 2500
                                            });
                                        </script>
                                    @endif
                                @endif
                            </div>
                            {{-- end modal --}}

                            <form id="deleteForm{{ $pengguna->id }}"
                                action="{{ route('pengguna.destroy', $pengguna->id) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <input type="hidden" name="user_id" value="{{ $pengguna->user_id }}">

                                <!-- Button untuk menampilkan konfirmasi SweetAlert -->
                                <img src="{{ asset('img/delete-icon.svg') }}" alt="" class="delete-btn"
                                    onclick="deletePengguna({{ $pengguna->id }})">
                            </form>

                            <!-- Script untuk menampilkan konfirmasi SweetAlert -->
                            <script>
                                function deletePengguna(penggunaId) {
                                    Swal.fire({
                                        title: 'Yakin Hapus pengguna?',
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonText: 'Ya',
                                        cancelButtonText: 'Tidak',
                                        reverseButtons: true
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            // Submit form untuk menghapus pengguna jika dikonfirmasi
                                            document.getElementById('deleteForm' + penggunaId).submit();
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
