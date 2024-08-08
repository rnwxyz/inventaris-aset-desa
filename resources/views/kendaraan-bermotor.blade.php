<x-layout.app>
    <!-- Sidebar -->
    <div id="sidebar" class="bg-white">
        <div class="container ps-5 pb-4 pe-4 pt-4">
            <img src="{{ asset('image/logo.png') }}" alt="Logo Bangli" class="img-fluid" width="150">
        </div>
        <ul class="list-unstyled border-top pt-4 ps-3 pe-3">
            <li><a href="{{ route('peralatan-mesin') }}" class="d-block text-dark p-2 fw-bold mt-2 hover-effect" style="text-decoration: none; font-size: small;">PERALATAN DAN MESIN</a></li>
            <li><a href="{{ route('bangunan-lainnya') }}" class="d-block text-dark p-2 fw-bold mt-2 hover-effect" style="text-decoration: none; font-size: small;">BANGUNAN LAINNYA</a></li>
            <li><a href="#" class="d-block text-white rounded p-2 fw-bold bg-primary mt-2" style="text-decoration: none; font-size: small;">KENDARAAN BERMOTOR</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <!-- headers -->
    <div class="main-container">
        <header class="m-2">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container d-flex">
                    <a class="navbar-brand flex-fill fs-2" href="#">{{ config('app.name', 'Laravel') }}</a>
                </div>
            </nav>
        </header>
        <div id="slot" class="pb-4">
            @if (session('error'))
            <div class="alert alert-danger d-flex justify-content-between" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close me-5" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <div class="d-flex">
                <div class="text-start p-3 fs-4">Laporan Inventaris Desa Berupa Peralatan dan Mesin</div>

                <form class="text-end pt-3 pb-3 ps-3" action="{{ route('kendaraan-bermotor.export') }}" method="GET">
                    <button type="submit" class="btn btn-success shadow-sm" style="color: white;">Unduh Laporan</button>
                </form>
                <div class="text-end pt-3 pb-3 pe-5 flex-fill">
                    <!-- Trigger the modal with a button -->
                    <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#addDataModal">
                        Tambah Data
                    </button>
                </div>
            </div>
            <div class="p-3" style="overflow-y: scroll; height: 30vw;">
                <table class="table table-bordered table-hover" style="width: 100%;">
                    <thead>
                        <tr class="text-center align-middle bg-blue" style="font-size: small;">
                            <th rowspan="2" scope="col" style="width: 5%;">No</th>
                            <th rowspan="2" scope="col" style="width: 15%;">Nama Barang</th>
                            <th rowspan="2" scope="col" style="width: 10%;">Kode Barang</th>
                            <th rowspan="2" scope="col" style="width: 5%;">NUP</th>
                            <th rowspan="2" scope="col" style="width: 5%;">Merk/Type</th>
                            <th rowspan="2" scope="col" style="width: 5%;">Tahun Perolehan</th>
                            <th rowspan="2" scope="col" style="width: 10%;">Nilai Perolehan</th>
                            <th colspan="3" scope="col" style="width: 10%;">Kode Barang</th>
                            <th rowspan="2" scope="col" style="width: 14%;">Keterangan</th>
                            <th rowspan="2" scope="col" style="width: 11%;">Aksi</th>
                        </tr>
                        <tr class="text-center align-middle" style="font-size: small;">
                            <th scope="col">B</th>
                            <th scope="col">RR</th>
                            <th scope="col">RB</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $no = 1;
                        @endphp
                        @foreach ($kendaraanBermotor as $item)
                        <tr class="text-center align-middle" style="font-size: small;">
                            <th scope="row">{{$no}}</th>
                            <td>{{$item->nama_barang}}</td>
                            <td>{{$item->kode_barang}}</td>
                            <td>{{$item->nup}}</td>
                            <td>{{$item->merk}}</td>
                            <td>{{$item->tahun_perolehan}}</td>
                            @php
                            $nilai = $item->nilai_perolehan ? 'Rp ' . number_format($item->nilai_perolehan, 0, ',', '.') : '';
                            @endphp
                            <td>{{$nilai}}</td>
                            <td>
                                @if ($item->b)
                                <img src="{{ asset('image/check.png') }}" alt="Check B" width="15">
                                @else
                                <div></div>
                                @endif
                            </td>
                            <td>
                                @if ($item->rr)
                                <img src="{{ asset('image/check.png') }}" alt="Check RR" width="15">
                                @else
                                <div></div>
                                @endif
                            </td>
                            <td>
                                @if ($item->rb)
                                <img src="{{ asset('image/check.png') }}" alt="Check RB" width="15">
                                @else
                                <div></div>
                                @endif
                            </td>
                            <td>{{$item->keterangan}}</td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editDataModal{{$item->id}}">
                                    Ubah
                                </button>
                                <form method="POST" action="{{ route('kendaraan-bermotor.delete', $item->id) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="buttom" class="btn btn-danger btn-sm" onclick="confirmation(event)">Hapus</button>
                                </form>
                            </td>

                            <!-- Modal Edit-->
                            <div class="modal fade" id="editDataModal{{$item->id}}" tabindex="-1" aria-labelledby="editDataModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editDataModalLabel">Ubah Data</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Form -->
                                            <form id="editDataForm" method="POST" action="{{ route('kendaraan-bermotor.update', $item->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-2">
                                                    <label for="namaBarang" class="form-label">Nama Barang</label>
                                                    <input type="text" class="form-control" id="namaBarang" name="nama_barang" required value="{{$item->nama_barang}}">
                                                </div>
                                                <div class="d-flex">
                                                    <div class="mb-2 me-2">
                                                        <label for="kodeBarang" class="form-label">Kode Barang</label>
                                                        <input type="text" class="form-control" id="kodeBarang" name="kode_barang" required value="{{$item->kode_barang}}">
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="nup" class="form-label">NUP</label>
                                                        <input type="text" class="form-control" id="nup" name="nup" required value="{{$item->nup}}">
                                                    </div>
                                                </div>
                                                <div class="d-flex">
                                                    <div class="mb-2 me-2">
                                                        <label for="merkType" class="form-label">Merk/Type</label>
                                                        <input type="text" class="form-control" id="merkType" name="merk" required value="{{$item->merk}}">
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="tahunPerolehan" class="form-label">Tahun Perolehan</label>
                                                        <input type="number" min="1900" max="3000" class="form-control" id="tahunPerolehan" name="tahun_perolehan" required value="{{$item->tahun_perolehan}}">
                                                    </div>
                                                </div>
                                                <div class="mb-2">
                                                    <label for="nilaiPerolehan" class="form-label">Nilai Perolehan</label>
                                                    <input type="number" class="form-control" id="nilaiPerolehan" name="nilai_perolehan" required value="{{$item->nilai_perolehan}}">
                                                </div>
                                                <div class="mb-2">
                                                    <div>Kode Barang</div>
                                                    <div>
                                                        <!-- checkbox input -->
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" id="kodeBarangB" name="kode_barang_b" value="B" @if ($item->b) checked @endif>
                                                            <label class="form-check-label" for="kodeBarangB">B</label>
                                                        </div>
                                                        <!-- checkbox input -->
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" id="kodeBarangRR" name="kode_barang_rr" value="RR" @if ($item->rr) checked @endif>
                                                            <label class="form-check-label" for="kodeBarangRR">RR</label>
                                                        </div>
                                                        <!-- checkbox input -->
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" id="kodeBarangRB" name="kode_barang_rb" value="RB" @if ($item->rb) checked @endif>
                                                            <label class="form-check-label" for="kodeBarangRB">RB</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-2">
                                                    <label for="keterangan" class="form-label">Keterangan</label>
                                                    <input type="text" class="form-control" id="keterangan" name="keterangan" value="{{$item->keterangan}}">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                    <button type="submit" class="btn btn-primary" id="saveEditDataButton">Ubah</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                        @php
                        $no++;
                        @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Add-->
    <div class="modal fade" id="addDataModal" tabindex="-1" aria-labelledby="addDataModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDataModalLabel">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form -->
                    <form id="addDataForm" method="POST" action="{{ route('kendaraan-bermotor.store') }}">
                        @csrf
                        <div class="mb-2">
                            <label for="namaBarang" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" id="namaBarang" name="nama_barang" required>
                        </div>
                        <div class="d-flex">
                            <div class="mb-2 me-2">
                                <label for="kodeBarang" class="form-label">Kode Barang</label>
                                <input type="text" class="form-control" id="kodeBarang" name="kode_barang" required>
                            </div>
                            <div class="mb-2">
                                <label for="nup" class="form-label">NUP</label>
                                <input type="text" class="form-control" id="nup" name="nup" required>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="mb-2 me-2">
                                <label for="merkType" class="form-label">Merk/Type</label>
                                <input type="text" class="form-control" id="merkType" name="merk" required>
                            </div>
                            <div class="mb-2">
                                <label for="tahunPerolehan" class="form-label">Tahun Perolehan</label>
                                <input type="number" min="1900" max="3000" class="form-control" id="tahunPerolehan" name="tahun_perolehan" required>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label for="nilaiPerolehan" class="form-label">Nilai Perolehan</label>
                            <input type="number" class="form-control" id="nilaiPerolehan" name="nilai_perolehan" required>
                        </div>
                        <div class="mb-2">
                            <div>Kode Barang</div>
                            <div>
                                <!-- checkbox input -->
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="kodeBarangB" name="kode_barang_b" value="B">
                                    <label class="form-check-label" for="kodeBarangB">B</label>
                                </div>
                                <!-- checkbox input -->
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="kodeBarangRR" name="kode_barang_rr" value="RR">
                                    <label class="form-check-label" for="kodeBarangRR">RR</label>
                                </div>
                                <!-- checkbox input -->
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="kodeBarangRB" name="kode_barang_rb" value="RB">
                                    <label class="form-check-label" for="kodeBarangRB">RB</label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary" id="saveDataButton">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function confirmation(event) {
            event.preventDefault();
            var form = event.target.form;
            swal({
                    title: "Apakah Anda Yakin?",
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
        }
    </script>
</x-layout.app>