<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="">
        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"> </div>
        <?php $this->session->flashdata('message') ? $this->session->flashdata('message') : '' ?>
        <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#exampleModal">Tambah SubMenu</a>
        <table class="table table-striped table-bordered" id="tableMenu" style="width:100%">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Menu</th>
                    <th scope="col">Sub Menu</th>
                    <th scope="col">Url</th>
                    <th scope="col">Icon</th>
                    <th scope="col">Active</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sub_menu as $key => $value) : ?>
                    <tr>
                        <th scope="row"><?= $key + 1; ?></th>
                        <td><?= $value['menu']; ?></td>
                        <td><?= $value['descr']; ?></td>
                        <td><?= $value['url']; ?></td>
                        <td><?= $value['icon']; ?></td>
                        <td><?= $value['is_active'] == 1 ? 'Aktif' : 'Tidak Aktif'; ?></td>

                        <td>
                            <a href="#" data-toggle="modal" data-target="#editSubMenu<?= $value['id']; ?>" class="badge badge-primary" id="<?= $value['id'] ?>" onclick="return detailData(this)">Edit</a>
                            <a href="submenu/destroy/<?= $value['id']; ?>" class="badge badge-danger delete">Hapus</a>
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
                <h5 class="modal-title" id="exampleModalLabel">Tambah Sub Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url(); ?>submenu/create" method="POST" onsubmit="return validasi(this);">
                <div class="form-group">
                    <input type="text" class="form-control" id="descr" name="descr" placeholder="Submenu">
                    <?= form_error('descr', '<small class="text-danger pl-3">', '</small>'); ?>
                    <input type="text" name="user_id" value="<?= $this->session->userdata('id'); ?>" hidden>
                </div>
                <div class="form-group">
                    <select name="menu_id" class="form-control" id="menu_id">
                        <option value="">Select Menu</option>
                        <?php foreach ($menu as $key => $value) : ?>
                            <option value="<?= $value['id'] ?>"><?= $value['descr'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?= form_error('menu_id', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="url" name="url" placeholder="Sub Menu URL">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="icon" name="icon" placeholder="Sub Menu Icon">
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active" checked>
                        <label class="form-check-label" for="is_active">
                            Active ?
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Menu -->
<div class="modal fade" id="editSubMenu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Sub Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url(); ?>submenu/update" method="POST" onsubmit="return validasiedit(this);">
                <div class="form-group">
                    <input type="text" class="form-control" id="editsubmenu" name="descr" placeholder="Submenu">
                    <input type="text" hidden="" name="id" id="idedit">
                    <input type="text" name="user_id" value="<?= $this->session->userdata('id'); ?>" hidden>
                </div>
                <div class="form-group">
                    <select name="menu_id" class="form-control" id="editmenu_id">
                        <option value="">Select Menu</option>
                        <?php foreach ($menu as $key => $value) : ?>
                            <option value="<?= $value['id'] ?>"><?= $value['descr'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="editurl" name="url" placeholder="Sub Menu URL">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="editicon" name="icon" placeholder="Sub Menu Icon">
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="edit_is_active" name="is_active">
                        <label class="form-check-label" for="is_active">
                            Active ?
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    function validasi(form) {
        var descr = form.descr.value;
        var url = form.url.value;
        var menu_id = form.menu_id.value;
        if (!descr) {
            Swal.fire(
                'Pesan',
                'Sub Menu Wajib Diisi',
                'warning'
            )
            return false;
        } else if (!menu_id) {
            Swal.fire(
                'Pesan',
                'Menu Wajib Dipilih',
                'warning'
            )
            return false;
        } else if (!url) {
            Swal.fire(
                'Pesan',
                'Url Wajib Diisi',
                'warning'
            )
            return false;
        }
        return true;
    }

    function validasiedit(form) {
        var id = form.idedit.value;
        var descr_edit = form.editsubmenu.value;
        var url_edit = form.editurl.value;
        var menu_id_edit = form.editmenu_id.value;
        if (!descr_edit) {
            Swal.fire(
                'Pesan',
                'Sub Menu Wajib Diisi',
                'warning'
            )
            return false;
        } else if (!url_edit) {
            Swal.fire(
                'Pesan',
                'Menu Wajib Dipilih',
                'warning'
            )
            return false;
        } else if (!menu_id_edit) {
            Swal.fire(
                'Pesan',
                'Url Wajib Diisi',
                'warning'
            )
            return false;
        }
    }

    function detailData(e) {
        $('#editSubMenu').modal('hide');
        var id = e.id;
        $.ajax({
            url: "<?= base_url('submenu/show/'); ?>" + id,
            type: 'GET',
            success: function(res) {
                var data = res.data;
                if (data.status === true) {
                    document.getElementById("editsubmenu").value = data.data.descr;
                    document.getElementById("idedit").value = data.data.id;
                    document.getElementById("editmenu_id").value = data.data.param_menu_id;
                    document.getElementById("editurl").value = data.data.url;
                    document.getElementById("editicon").value = data.data.icon;
                    if(data.data.is_active == "1"){
                        $('#edit_is_active').attr('checked',true);
                    }else{
                        $('#edit_is_active').attr('checked',false);
                    }
                    

                    $('#editSubMenu').modal('show');
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

    var table = $('#tableMenu');
    table.DataTable({
        responsive: true
    });
</script>