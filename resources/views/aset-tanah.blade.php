<x-layout.app>
    <!-- Sidebar -->
    <div id="sidebar" class="bg-white">
        <div class="container ps-5 pb-4 pe-4 pt-4">
            <img src="{{ asset('image/logo.png') }}" alt="Logo Bangli" class="img-fluid" width="150">
        </div>
        <ul class="list-unstyled border-top pt-4 ps-3 pe-3">
            <li><a href="{{ route('peralatan-mesin') }}" class="d-block text-dark p-2 fw-bold mt-2 hover-effect" style="text-decoration: none; font-size: small;">PERALATAN DAN MESIN</a></li>
            <li><a href="{{ route('bangunan-lainnya') }}" class="d-block text-dark p-2 fw-bold mt-2 hover-effect" style="text-decoration: none; font-size: small;">BANGUNAN LAINNYA</a></li>
            <li><a href="{{ route('kendaraan-bermotor') }}" class="d-block text-dark p-2 fw-bold mt-2 hover-effect" style="text-decoration: none; font-size: small;">KENDARAAN BERMOTOR</a></li>
            <li><a href="#" class="d-block text-white rounded p-2 fw-bold bg-primary mt-2" style="text-decoration: none; font-size: small;">ASET TANAH</a></li>
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
                <div class="text-start p-3 fs-4">Laporan Inventaris Desa Berupa Aset Tanah</div>

                <form class="text-end pt-3 pb-3 ps-3" action="{{ route('aset-tanah.export') }}" method="GET">
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
                            <th rowspan="2" scope="col" style="width: 15%;">Jenis Barang</th>
                            <th rowspan="2" scope="col" style="width: 10%;">Identitas Barang</th>
                            <th colspan="3" scope="col" style="width: 15%;">Asal Usul Barang</th>
                            <th rowspan="2" scope="col" style="width: 10%;">Tanggal Bulan Tahun Perolehan/Pembelian</th>
                            <th rowspan="2" scope="col" style="width: 10%;">Harga/Nilai Perolehan</th>
                            <th rowspan="2" scope="col" style="width: 10%;">Perkiraan Harga/Nilai Sekarang</th>
                            <th rowspan="2" scope="col" style="width: 13%;">Keterangan</th>
                            <th rowspan="2" scope="col" style="width: 12%;">Aksi</th>
                        </tr>
                        <tr class="text-center align-middle" style="font-size: small;">
                            <th scope="col">APBD</th>
                            <th scope="col">Perolehan Lain Yang Sah</th>
                            <th scope="col">Aset atau Kekayaan Asli Desa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $no = 1;
                        @endphp
                        @foreach ($asetTanah as $item)
                        <tr class="text-center align-middle" style="font-size: small;">
                            <th scope="row">{{$no}}</th>
                            <td>{{$item->jenis_barang}}</td>
                            <td>{{$item->identitas_barang}}</td>
                            <td>{{$item->apbd}}</td>
                            <td>{{$item->perolehan_lain_yang_sah}}</td>
                            <td>{{$item->aset_atau_kekayaan_asli_desa}}</td>
                            <td>{{$item->tanggal_bulan_tahun_perolehan}}</td>
                            <td>{{$item->harga_nilai_perolehan}}</td>
                            <td>{{$item->perkiraan_harga_nilai_sekarang}}</td>
                            @php
                            $nilai = $item->nilai_perolehan ? 'Rp ' . number_format($item->nilai_perolehan, 0, ',', '.') : '';
                            @endphp
                            <td>{{$item->keterangan}}</td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editDataModal{{$item->id}}">
                                    Ubah
                                </button>
                                <form method="POST" action="{{ route('aset-tanah.delete', $item->id) }}" style="display: inline;">
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
                                            <form id="editDataForm" method="POST" action="{{ route('aset-tanah.update', $item->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="d-flex">
                                                    <div class="mb-2 me-2">
                                                        <label for="jenisBarang" class="form-label">Jenis Barang</label>
                                                        <input type="text" class="form-control" id="jenisBarang" name="jenis_barang" required value="{{$item->jenis_barang}}">
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="identitasBarang" class="form-label">Identitas Barang</label>
                                                        <input type="text" class="form-control" id="identitasBarang" name="identitas_barang" required value="{{$item->identitas_barang}}">
                                                    </div>
                                                </div>
                                                <div>Asal Usul Barang</div>
                                                <div class="d-flex">
                                                    <div class="mb-2 me-2">
                                                        <label for="apbd" class="form-label">APBD</label>
                                                        <input type="text" class="form-control" id="apbd" name="apbd" required value="{{$item->apbd}}">
                                                    </div>
                                                    <div class="mb-2 me-2">
                                                        <label for="perolehanLain" class="form-label">Perolehan Lain</label>
                                                        <input type="text" class="form-control" id="perolehanLain" name="perolehan_lain_yang_sah" required value="{{$item->perolehan_lain_yang_sah}}">
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="kekayaanDesa" class="form-label">Kekayaan Asli Desa</label>
                                                        <input type="text" class="form-control" id="kekayaanDesa" name="aset_atau_kekayaan_asli_desa" required value="{{$item->aset_atau_kekayaan_asli_desa}}">
                                                    </div>
                                                </div>
                                                <div class="mb-2">
                                                    <label for="tgl" class="form-label">Tanggal Bulan Tahun Perolehan</label>
                                                    <input type="text" class="form-control" id="tgl" name="tanggal_bulan_tahun_perolehan" required value="{{$item->tanggal_bulan_tahun_perolehan}}">
                                                </div>
                                                <div class="mb-2">
                                                    <label for="nilaiPerolehan" class="form-label">Harga Nilai Perolehan</label>
                                                    <input type="text" class="form-control" id="nilaiPerolehan" name="harga_nilai_perolehan" required value="{{$item->harga_nilai_perolehan}}">
                                                </div>
                                                <div class="mb-2">
                                                    <label for="nilaiSekarang" class="form-label">Perkiraan Nilai Sekarang</label>
                                                    <input type="text" class="form-control" id="nilaiSekarang" name="perkiraan_harga_nilai_sekarang" required value="{{$item->perkiraan_harga_nilai_sekarang}}">
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
                    <form id="addDataForm" method="POST" action="{{ route('aset-tanah.store') }}">
                        @csrf
                        <div class="d-flex">
                            <div class="mb-2 me-2">
                                <label for="jenisBarang" class="form-label">Jenis Barang</label>
                                <input type="text" class="form-control" id="jenisBarang" name="jenis_barang" required>
                            </div>
                            <div class="mb-2">
                                <label for="identitasBarang" class="form-label">Identitas Barang</label>
                                <input type="text" class="form-control" id="identitasBarang" name="identitas_barang" required>
                            </div>
                        </div>
                        <div>Asal Usul Barang</div>
                        <div class="d-flex">
                            <div class="mb-2 me-2">
                                <label for="apbd" class="form-label">APBD</label>
                                <input type="text" class="form-control" id="apbd" name="apbd" required>
                            </div>
                            <div class="mb-2 me-2">
                                <label for="perolehanLain" class="form-label">Perolehan Lain</label>
                                <input type="text" class="form-control" id="perolehanLain" name="perolehan_lain_yang_sah" required>
                            </div>
                            <div class="mb-2">
                                <label for="kekayaanDesa" class="form-label">Kekayaan Asli Desa</label>
                                <input type="text" class="form-control" id="kekayaanDesa" name="aset_atau_kekayaan_asli_desa" required>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label for="tgl" class="form-label">Tanggal Bulan Tahun Perolehan</label>
                            <input type="text" class="form-control" id="tgl" name="tanggal_bulan_tahun_perolehan" required>
                        </div>
                        <div class="mb-2">
                            <label for="nilaiPerolehan" class="form-label">Harga Nilai Perolehan</label>
                            <input type="text" class="form-control" id="nilaiPerolehan" name="harga_nilai_perolehan" required>
                        </div>
                        <div class="mb-2">
                            <label for="nilaiSekarang" class="form-label">Perkiraan Nilai Sekarang</label>
                            <input type="text" class="form-control" id="nilaiSekarang" name="perkiraan_harga_nilai_sekarang" required>
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