<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="">
        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"> </div>
        <div class="flash-data1" data-flashdata="<?= $this->session->flashdata('error'); ?>"> </div>
        <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#exampleModal">Tambah Pelanggaran</a>
        <div class="form-group">
            <label class="col-form-label">NISN : <?= $student['nisn']; ?></label>
            <br />
            <label class="col-form-label">Nama : <?= $student['fullnm']; ?></label>
            <br />
            <label class="col-form-label">Kelas : <?= $student['kelas']; ?></label>
            <br />
            <label class="col-form-label">Total Pelanggaran : <?= $total_pelanggaran; ?></label>
        </div>
        <table class="table table-striped table-bordered" id="tableKPS" style="width:100%">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Pelanggaran</th>
                    <th scope="col">Tanggal Pelanggaran</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($datakps as $key => $value) : ?>
                    <tr>
                        <th scope="row"><?= $key + 1; ?></th>
                        <td><?= $value['descr']; ?></td>
                        <td><?= $value['tanggal']; ?></td>
                        <td>
                            <a href="#" data-toggle="modal" data-target="#editKPS<?= $value['id']; ?>" class="badge badge-primary" id="<?= $value['id'] ?>" onclick="return detailData(this)">Edit</a>
                            <a href="kps001/destroy/<?= $value['id']; ?>" class="badge badge-danger delete">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pelanggaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url(); ?>kps001/create" method="POST" onsubmit="return validasi(this)">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="Kelas" class="col-form-label">Jenis Pelanggaran:</label>
                        <select name="kps_id" class="form-control" id="kps_id">
                            <option value="">Select Jenis Pelanggaran</option>
                            <?php foreach ($kps as $key => $value) : ?>
                                <option value="<?= $value['id'] ?>"><?= $value['descr'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="text" name="user_id" hidden value="<?= $this->session->userdata('id'); ?>">
                        <input type="text" name="id" hidden value="<?= $student['id']; ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Menu -->
<div class="modal fade" id="editKPS" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Kelas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url(); ?>kps001/update" method="POST" onsubmit="return validasiedit(this)">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="Kode" class="col-form-label">Kode:</label>
                        <input type="text" class="form-control" id="codeedit" name="code" placeholder="Kode">
                    </div>
                    <div class="form-group">
                        <label for="Kelas" class="col-form-label">Kelas:</label>
                        <input type="text" class="form-control" id="editdescr" name="descr" placeholder="Kelas">
                        <input type="text" hidden name="id" id="id">
                        <input type="text" name="user_id" hidden value="<?= $this->session->userdata('id'); ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    function validasi(form) {
        var kps_id = form.kps_id.value;
        var descr = form.descr.value;
        if (!kps_id) {
            Swal.fire(
                'Pesan',
                'Jenis Pelanggaran Wajib Diisi',
                'warning'
            )
            return false;
        }
        return true;
    }

    function validasiedit(form) {
        var code = form.codeedit.value;
        var descr = form.editdescr.value;
        if (!code) {
            Swal.fire(
                'Pesan',
                'Kode Wajib Diisi',
                'warning'
            )
            return false;
        } else if (!descr) {
            Swal.fire(
                'Pesan',
                'Kelas Wajib Diisi',
                'warning'
            )
            return false;
        }
        return true;
    }

    function detailData(e) {
        $('#editKPS').modal('hide');
        var id = e.id;
        $.ajax({
            url: "<?= base_url('kps001/show/'); ?>" + id,
            type: 'GET',
            success: function(res) {
                var data = res.data;
                if (data.status === true) {
                    document.getElementById("codeedit").value = data.data.code;
                    document.getElementById("editdescr").value = data.data.descr;
                    document.getElementById("id").value = data.data.id;
                    $('#editKPS').modal('show');
                } else {
                    Swal.fire(
                        'Pesan',
                        data.message,
                        'warning'
                    )
                }
            }
        });
    }

    $('.delete').on('click', function(e) {
        e.preventDefault();
        var href = $(this).attr('href');
        Swal.fire({
            title: 'Pesan',
            text: "Data Akan Di Hapus ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.value) {
                document.location.href = href;
            }
        })
    });

    var table = $('#tableKPS');
    table.DataTable({
        responsive: true
    });
</script>