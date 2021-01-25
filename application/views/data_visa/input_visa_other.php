<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">PT. Guangzhou Industrial Steel
                <button class="mb-2 mr-2 mb-2 mr-2 btn btn-success btn btn-actions-pane-right" id="addRow">Tambah Tabel
                </button>

            </div>
            <div class="table-responsive" style="padding: 10px;">
                <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="example">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Nama Mandarin</th>
                            <th class="text-center">No Paspor</th>
                            <th class="text-center">Jenis Proses</th>
                            <th class="text-center">Harga</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <div class="card-header"> Detail
                    <button class="mb-2 mr-2 border-0 btn-transition btn btn-outline-link btn-actions-pane-right" style="color:white;">link
                    </button>
                    <form action="#">
                        <input class="btn-actions-pane-right mb-2 mr-2 btn btn-success" type="submit" value="Masukan" />
                    </form>

                </div>
                <table class="align-middle mb-0 table table-borderless table-hover table-striped text-left">
                    <tbody>
                        <tr>
                            <th>Mata Uang</th>
                            <td>
                                <form>
                                    <select class="form-control-sm form-control" onchange="location = this.value;">
                                        <option>Pilih ... </option>
                                        <option value="Data PT-Dashboard.html">Detail</option>
                                        <option>Tambah</option>
                                        <option>Hapus</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <th>Staff OP</th>
                            <td class="text-center">
                                <input name="jumlah" id="jum" type="text" class="form-control-sm form-control">
                            </td>
                        </tr>
                        <tr>
                            <th>Lokasi</th>
                            <td class="text-center">
                                <input name="jumlah" id="jum" type="text" class="form-control-sm form-control">
                            </td>
                        </tr>
                        <tr>
                            <th>Note</th>
                            <td class="text-center">
                                <input name="jumlah" id="jum" type="text" class="form-control-sm form-control">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>