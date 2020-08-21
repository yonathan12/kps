<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="">
        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"> </div>
        <div class="flash-data1" data-flashdata="<?= $this->session->flashdata('error'); ?>"> </div>
        <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#exampleModal">Tambah Sub Kelas</a>
        <table class="table table-striped table-bordered" id="tableSubKelas" style="width:100%">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Sub Kelas</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($subkelas as $key => $value) : ?>
                    <tr>
                        <th scope="row"><?= $key + 1; ?></th>
                        <td><?= $value['kelas']; ?> - <?= $value['descr']; ?></td>
                        <td>
                            <a href="#" data-toggle="modal" data-target="#editSubKelas<?= $value['id']; ?>" class="badge badge-primary" id="<?= $value['id'] ?>" onclick="return detailData(this)">Edit</a>
                            <a href="pm0002/destroy/<?= $value['id']; ?>" class="badge badge-danger delete">Hapus</a>
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
                <h5 class="modal-title" id="exampleModalLabel">Tambah Sub Kelas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url(); ?>pm0002/create" method="POST" onsubmit="return validasi(this)">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="Sub Kelas" class="col-form-label">Kelas:</label>
                        <select name="kelas" class="form-control" id="kelas">
                            <option value="">Select Kelas</option>
                            <?php foreach ($kelas as $key => $value) : ?>
                                <option value="<?= $value['id'] ?>"><?= $value['descr'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Sub Kelas" class="col-form-label">Sub Kelas:</label>
                        <input type="text" class="form-control" id="descr" name="descr" placeholder="Sub Kelas">
                        <input type="text" name="user_id" hidden value="<?= $this->session->userdata('id'); ?>">
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
<div class="modal fade" id="editSubKelas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Sub Kelas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url(); ?>pm0002/update" method="POST" onsubmit="return validasiedit(this)">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="Sub Kelas" class="col-form-label">Kelas:</label>
                        <select name="kelas" class="form-control" id="kelasedit">
                            <option value="">Select Kelas</option>
                            <?php foreach ($kelas as $key => $value) : ?>
                                <option value="<?= $value['id'] ?>"><?= $value['descr'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Sub Kelas" class="col-form-label">Sub Kelas:</label>
                        <input type="text" class="form-control" id="editdescr" name="descr" placeholder="Sub Kelas">
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
        var param_class_id = form.kelas.value;
        var descr = form.descr.value;
        if (!param_class_id) {
            Swal.fire(
                'Pesan',
                'Kelas Wajib Diisi',
                'warning'
            )
            return false;
        } else if (!descr) {
            Swal.fire(
                'Pesan',
                'Sub Kelas Wajib Diisi',
                'warning'
            )
            return false;
        }
        return true;
    }

    function validasiedit(form) {
        var param_class_id = form.kelasedit.value;
        var descr = form.editdescr.value;
        if (!param_class_id) {
            Swal.fire(
                'Pesan',
                'Kelas Wajib Diisi',
                'warning'
            )
            return false;
        } else if (!descr) {
            Swal.fire(
                'Pesan',
                'Sub Kelas Wajib Diisi',
                'warning'
            )
            return false;
        }
        return true;
    }

    function detailData(e) {
        $('#editSubKelas').modal('hide');
        var id = e.id;
        $.ajax({
            url: "<?= base_url('pm0002/show/'); ?>" + id,
            type: 'GET',
            success: function(res) {
                var data = res.data;
                if (data.status === true) {
                    document.getElementById("kelasedit").value = data.data.param_class_id;
                    document.getElementById("editdescr").value = data.data.descr;
                    document.getElementById("id").value = data.data.id;
                    $('#editSubKelas').modal('show');
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

    var table = $('#tableSubKelas');
    table.DataTable({
        responsive: true
    });
</script>