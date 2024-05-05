<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/admin/layoutadmin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vendor/all.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pengguna/pengguna-home.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- mqtt js --}}
    <script src="<https://unpkg.com/mqtt/dist/mqtt.min.js>"></script>


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar-atas navbar navbar-expand navbar-light topbar mb-4 static-top shadow py-5">
                    <div class="sidebar-brand-icon p-2">
                        <img src="{{ asset('img/jti-logo.png') }}" alt="" class="img-fluid" width="50">
                    </div>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">


                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="img-profile rounded-circle mx-3" src="{{ asset('img/profile.png') }}">
                                <span class="mr-2 d-none d-lg-inline text-white">Hi, {{ Auth::user()->name }}</span>
                                <i class="fas fa-sort-down"></i>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                {{-- <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>

                                <div class="dropdown-divider"></div> --}}
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container my-4 pengguna-content-container">
                    <div class="container mx-auto p-3 rounded-3 w-50 border pengguna-card">
                        <div class="p-2 d-flex justify-content-center my-4">
                            <div>
                                <img src="{{ asset('img/profile.png') }}" alt="" class="img-fluid"
                                    width="100">
                            </div>
                        </div>

                        <div class="container content-card-container text-black my-5">
                            <h5 class="fw-bold">
                                {{ $pengguna->jabatan }}
                            </h5>

                            @if ($pengguna->mac_address == '')
                                <h4 class="">
                                    Mac &nbsp;&nbsp;&nbsp;: Tidak ada perangkat
                                </h4>
                            @else
                                <h4 class="">
                                    Mac &nbsp;&nbsp;&nbsp;: {{ $pengguna->mac_address }}
                                </h4>
                            @endif

                            <h4 class="">
                                Nama : {{ Auth::user()->name }}
                            </h4>
                            <h4 class="">
                                NIM &nbsp;&nbsp;&nbsp;: {{ $pengguna->kode }}
                            </h4>
                        </div>

                        <div class="container my-5 lokasi-container-box">
                            <div class="p-5 rounded-4 border text-secondary text-center lokasi-container">
                                <h3 class="fw-bold lokasi-judul">
                                    Lokasi Anda
                                </h3>
                                <h2 class="fw-bold" id="predictedRoom">

                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; IPS 2024</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Yakin akan Logout?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Pilih "Logout" untuk mengonfirmasi.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-danger" :href="route('logout')"
                            onclick="event.preventDefault();
                                    this.closest('form').submit();">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('js/vendor/jquery.min.js') }}"></script>
    <script src="{{ asset('js/vendor/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('js/vendor/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/admin/sb-admin-2.min.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/mqtt/5.5.0/mqtt.min.js"></script>

    <script>
        const clientId = 'IPS' + Math.random().toString(16).substr(2, 8);

        const client = mqtt.connect('ws://broker.sinaungoding.com:8090', {
            clientId,
            clean: false,
            username: 'uwais',
            password: 'uw415_4Lqarn1'
        });

        client.on('connect', function() {
            console.log('Connected to MQTT broker');

            var mac_address = "{{ $pengguna->mac_address }}";
            console.log(mac_address);

            if (mac_address) {
                client.subscribe(mac_address + '/hasilprediksi', function(err) {
                    if (!err) {
                        console.log('Subscribed to topic: ' + mac_address + '/hasilprediksi');
                    }
                });
            } else if (mac_address == "") {
                document.getElementById("predictedRoom").innerText = "";
                document.getElementById("predictedRoom").innerText = "-";
            }
        });

        var lastMessageTime = {};

        function setTopicTimeout(topic) {
            setTimeout(() => {
                var currentTime = new Date();
                var lastMessageReceivedTime = lastMessageTime[topic];

                if (lastMessageReceivedTime && (currentTime - lastMessageReceivedTime > 20000)) {
                    console.log(topic + ' terputus');

                    document.getElementById("predictedRoom").innerText = "Terputus";

                    delete lastMessageTime[topic];
                }
            }, 20000);
        }

        client.on('message', function(topic, message) {
            const data = JSON.parse(message.toString());
            predictedRoomValue = data.predicted_room;

            document.getElementById("predictedRoom").innerText = predictedRoomValue;

            lastMessageTime[topic] = new Date();

            setTopicTimeout(topic);
        });
    </script>

    <script>
        document.getElementById("predictedRoom").innerText = "Terputus";
    </script>


</body>

</html>
