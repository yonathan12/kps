<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="">
        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"> </div>
        <div class="flash-data1" data-flashdata="<?= $this->session->flashdata('error'); ?>"> </div>
        <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#exampleModal">Tambah User</a>
        <table class="table table-striped table-bordered" id="tableUserSiswa" style="width:100%">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">NISN</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($user_data as $key => $value) : ?>
                    <tr>
                        <th scope="row"><?= $key + 1; ?></th>
                        <td><?= $value['nisn']; ?></td>
                        <td>
                            <a href="#" data-toggle="modal" data-target="#editUser<?= $value['id']; ?>" class="badge badge-primary" id="<?= $value['id'] ?>" onclick="return detailData(this)">Ganti Password</a>
                            <a href="pm0009/destroy/<?= $value['id']; ?>" class="badge badge-danger delete">Hapus</a>
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
                <h5 class="modal-title" id="exampleModalLabel">Tambah User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url(); ?>pm0009/create" method="POST" onsubmit="return validasi(this)">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="NISN" class="col-form-label">NISN:</label>
                        <input type="text" class="form-control" id="nisn" name="nisn" placeholder="NISN">
                        <input type="text" name="user_id" hidden value="<?= $this->session->userdata('id'); ?>">
                    </div>
                    <div class="form-group">
                        <label for="Password" class="col-form-label">Password:</label>
                        <input type="password" class="form-control" id="password" name="password">
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
<div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url(); ?>pm0009/update" method="POST" onsubmit="return validasiedit(this)">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="NISN" class="col-form-label">NISN:</label>
                        <input type="text" class="form-control" id="nisnedit" name="nisn" placeholder="NISN" disabled>
                        <input type="text" hidden name="id" id="id">
                        <input type="text" name="user_id" hidden value="<?= $this->session->userdata('id'); ?>">
                    </div>
                    <div class="form-group">
                        <label for="Password" class="col-form-label">Password:</label>
                        <input type="password" class="form-control" id="passwordedit" name="password">
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
        var nisn = form.nisn.value;
        var password = form.password.value;
        if (!nisn) {
            Swal.fire(
                'Pesan',
                'NISN Wajib Diisi',
                'warning'
            )
            return false;
        } else if (!password) {
            Swal.fire(
                'Pesan',
                'Password Wajib Diisi',
                'warning'
            )
            return false;
        } else if (password.length < 6) {
            Swal.fire(
                'Pesan',
                'Password Minimal 6 Karakter',
                'warning'
            )
            return false;
        }
        return true;
    }

    function validasiedit(form) {
        var nisn = form.nisnedit.value;
        var password = form.passwordedit.value;
        if (!nisn) {
            Swal.fire(
                'Pesan',
                'NISN Wajib Diisi',
                'warning'
            )
            return false;
        } else if (password) {
            if (password.length < 6) {
                Swal.fire(
                    'Pesan',
                    'Password Minimal 6 Karakter',
                    'warning'
                )
                return false;
            }
        }
        return true;
    }

    function detailData(e) {
        $('#editUser').modal('hide');
        var id = e.id;
        $.ajax({
            url: "<?= base_url('pm0009/show/'); ?>" + id,
            type: 'GET',
            success: function(res) {
                var data = res.data;
                if (data.status === true) {
                    document.getElementById("nisnedit").value = data.data.nisn;
                    document.getElementById("id").value = data.data.id;
                    $('#editUser').modal('show');
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

    var table = $('#tableUserSiswa');
    table.DataTable({
        responsive: true
    });
</script>