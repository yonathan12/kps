<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="">
        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"> </div>
        <div class="error_message" data-flashdata="<?= $this->session->flashdata('error'); ?>"> </div>
        <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#exampleModal">Tambah User</a>
        <table class="table table-striped table-bordered" id="tableRole" style="width:100%">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Username</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($user_data as $key => $value) : ?>
                    <tr>
                        <th scope="row"><?= $key + 1; ?></th>
                        <td><?= $value['fullnm']; ?></td>
                        <td><?= $value['username']; ?></td>
                        <td>
                            <a href="#" data-toggle="modal" data-target="#editUser<?= $value['id']; ?>" class="badge badge-primary" id="<?= $value['id'] ?>" onclick="return detailData(this)">Edit</a>
                            <a href="PM0008/destroy/<?= $value['id']; ?>" class="badge badge-danger delete">Hapus</a>
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
            <form action="<?= base_url(); ?>PM0008/create" method="POST" onsubmit="return validasi(this)">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="Nama" class="col-form-label">Nama:</label>
                        <input type="text" class="form-control" id="fullnm" name="fullnm" placeholder="Nama">
                        <input type="text" name="user_id" hidden value="<?= $this->session->userdata('id'); ?>">
                    </div>
                    <div class="form-group">
                        <label for="Username" class="col-form-label">Username:</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <label for="Password" class="col-form-label">Password:</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="form-group">
                        <label for="Role" class="col-form-label">Role:</label>
                        <select name="role" class="form-control" id="role">
                            <option value="">Select Role</option>
                            <?php foreach ($role as $key => $value) : ?>
                                <option value="<?= $value['id'] ?>"><?= $value['descr'] ?></option>
                            <?php endforeach; ?>
                        </select>
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
            <form action="<?= base_url(); ?>PM0008/update" method="POST" onsubmit="return validasiedit(this)">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="Nama" class="col-form-label">Nama:</label>
                        <input type="text" class="form-control" id="fullnmedit" name="fullnm" placeholder="Nama">
                        <input type="text" hidden name="id" id="id">
                        <input type="text" name="user_id" hidden value="<?= $this->session->userdata('id'); ?>">
                    </div>
                    <div class="form-group">
                        <label for="Username" class="col-form-label">Username:</label>
                        <input type="text" class="form-control" id="usernameedit" name="username" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <label for="Password" class="col-form-label">Password:</label>
                        <input type="password" class="form-control" id="passwordedit" name="password">
                    </div>
                    <div class="form-group">
                        <label for="Role" class="col-form-label">Role:</label>
                        <select name="role" class="form-control" id="roleedit">
                            <option value="">Select Role</option>
                            <?php foreach ($role as $key => $value) : ?>
                                <option value="<?= $value['id'] ?>"><?= $value['descr'] ?></option>
                            <?php endforeach; ?>
                        </select>
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
        var fullnm = form.fullnm.value;
        var username = form.username.value;
        var password = form.password.value;
        var role = form.role.value;
        if (!fullnm) {
            Swal.fire(
                'Pesan',
                'Nama Wajib Diisi',
                'warning'
            )
            return false;
        } else if (!username) {
            Swal.fire(
                'Pesan',
                'Username Wajib Diisi',
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
        } else if (!role) {
            Swal.fire(
                'Pesan',
                'Role Wajib Diisi',
                'warning'
            )
            return false;
        }
        return true;
    }

    function validasiedit(form) {
        var fullnm = form.fullnmedit.value;
        var username = form.usernameedit.value;
        var password = form.passwordedit.value;
        var role = form.roleedit.value;
        if (!fullnm) {
            Swal.fire(
                'Pesan',
                'Nama Wajib Diisi',
                'warning'
            )
            return false;
        } else if (!username) {
            Swal.fire(
                'Pesan',
                'Username Wajib Diisi',
                'warning'
            )
            return false;
        } else if (!role) {
            Swal.fire(
                'Pesan',
                'Role Wajib Diisi',
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
            url: "<?= base_url('PM0008/show/'); ?>" + id,
            type: 'GET',
            success: function(res) {
                var data = res.data;
                if (data.status === true) {
                    document.getElementById("fullnmedit").value = data.data.fullnm;
                    document.getElementById("usernameedit").value = data.data.username;
                    document.getElementById("roleedit").value = data.data.param_role_id;
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

    var table = $('#tableRole');
    table.DataTable({
        responsive: true
    });
</script>