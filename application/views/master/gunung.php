<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="col-md-3">
        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"> </div>
        <?php $this->session->flashdata('message') ? $this->session->flashdata('message') : '' ?>
    </div>
    <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahGunung">Tambah Gunung</a>
    <table id="tableUser" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Gunung</th>
                <th>Status</th>
                <th>Tanggal Di Buat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($AllData as $gunung) {
            ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $gunung['gunung']; ?></td>
                    <td>Aktif</td>
                    <td><?= $gunung['date_created']; ?></td>
                    <td style="text-align: center;">
                        <a href="#" data-toggle="modal" data-target="#detailGunung" class="glyphicon glyphicon-pencil btn btn-sm btn-success" id="<?= $gunung['Id'] ?>" onclick="return detailData(this)"></a>
                        <a href="#" data-toggle="modal" data-target="#editGunung<?= $gunung['Id']; ?>" class="glyphicon glyphicon-pencil btn btn-sm btn-primary" id="<?= $gunung['Id'] ?>" onclick="return editData(this)"></a>
                        <a href="<?= base_url('gunung/hapus/'.$gunung['Id']); ?>" class="btn btn-sm btn-danger glyphicon glyphicon-trash hapusGunung"></a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Modal Tambah User -->
<div class="modal fade" id="tambahGunung" tabindex="-1" role="dialog" aria-labelledby="tambahGunungLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahGunungLabel">Tambah Gunung</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url(); ?>gunung/simpan" method="POST" onsubmit="return validasi(this)" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="text" class="form-control" id="gunung" name="gunung" placeholder="Nama Gunung">
                    <input type="text" hidden name="user_id" value="<?= $this->session->userdata('id'); ?>">
                </div>
                <div class="modal-body">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="urlorno" onclick="return urlFoto(this)">
                        <label class="form-check-label" for="inlineCheckbox1">Url Foto?</label>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="picture" name="image">
                        <label class="custom-file-label" for="customFile">Pilih Foto</label>
                    </div>
                </div>
                <div class="modal-body">
                    <input type="input" class="form-control" id="url" name="url" placeholder="Url Foto">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit User -->

<div class="modal fade" id="editGunung" tabindex="-1" role="dialog" aria-labelledby="tambahGunungLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editGunung">Edit Gunung</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url(); ?>gunung/edit" method="POST" onsubmit="return validasi(this)" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="text" class="form-control" id="gunungEdit" name="gunung">
                    <input type="text" id="idEdit" name="idEdit" hidden>
                    <input type="text" hidden name="user_id" value="<?= $this->session->userdata('id'); ?>">
                </div>
                <div class="modal-body">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="urlornoEdit" onclick="return urlFotoEdit(this)">
                        <label class="form-check-label" for="inlineCheckbox1">Url Foto?</label>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="pictureEdit" name="image">
                        <label class="custom-file-label" for="customFile">Pilih Foto</label>
                    </div>
                </div>
                <div class="modal-body">
                    <input type="input" class="form-control" id="urlEdit" name="url" placeholder="Url Foto">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="detailGunung" tabindex="-1" role="dialog" aria-labelledby="tambahGunungLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahGunungLabel">View Gunung</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label class="form-check-label" id="nmgunung" for="inlineCheckbox1"></label>
            </div>
            <div class="modal-body">
                <img src="" id="viewImage" alt="..." class="img-thumbnail">
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        document.getElementById("picture").disabled = false;
        document.getElementById("url").disabled = true;
    });

    function urlFoto(form) {
        if (form.checked === false) {
            document.getElementById("picture").disabled = false;
            document.getElementById("url").disabled = true;
            $('#url').val('');
        } else {
            document.getElementById("picture").disabled = true;
            document.getElementById("url").disabled = false;
            $('#picture').val('');
        }
    }

    function urlFotoEdit(form) {
        if (form.checked === false) {
            document.getElementById("pictureEdit").disabled = false;
            document.getElementById("urlEdit").disabled = true;
            $('#urlEdit').val('');
        } else {
            document.getElementById("pictureEdit").disabled = true;
            document.getElementById("urlEdit").disabled = false;
            $('#pictureEdit').val('');
        }
    }

    function validasi(form) {
        var gunung = form.gunung.value;
        var picture = form.picture.value;
        var url = form.url.value;
        var checkUrl = form.urlorno.checked;

        if (!gunung) {
            Swal.fire(
                'Pesan',
                'Kolom Nama Gunung Tidak Boleh Kosong',
                'warning'
            )
            return false;
        }

        if (checkUrl === false) {
            if (!picture) {
                Swal.fire(
                    'Pesan',
                    'Kolom Foto Tidak Boleh Kosong',
                    'warning'
                )
                return false;
            }
        } else {
            if (!url) {
                Swal.fire(
                    'Pesan',
                    'Kolom URL Tidak Boleh Kosong',
                    'warning'
                )
                return false;
            }
        }
        return true;
    }

    function validasiEdit(form) {
        var gunungEdit = form.gunungEdit.value;
        var pictureEdit = form.pictureEdit.value;
        var urlEdit = form.urlEdit.value;
        var checkUrlEdit = form.urlornoEdit.checked;

        if (!gunungEdit) {
            Swal.fire(
                'Pesan',
                'Kolom Nama Gunung Tidak Boleh Kosong',
                'warning'
            )
            return false;
        }

        if (checkUrlEdit === false) {
            if (!pictureEdit) {
                Swal.fire(
                    'Pesan',
                    'Kolom Foto Tidak Boleh Kosong',
                    'warning'
                )
                return false;
            }
        } else {
            if (!urlEdit) {
                Swal.fire(
                    'Pesan',
                    'Kolom URL Tidak Boleh Kosong',
                    'warning'
                )
                return false;
            }
        }
        return true;
    }

    function hapus(e) {
        e.preventDefault();
        var href = document.getElementById("hapusUser").getAttribute("href");

        Swal.fire({
            title: 'Pesan',
            text: "User Akan Di Nonaktifkan ?",
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
    }

    function detailData(e) {
        $('#detailGunung').modal('hide');
        var id = e.id;
        $.ajax({
            url: "<?= base_url('gunung/getDetail/'); ?>"+id,
            type: 'GET',
            data: {
                id: id
            },
            success: function(rsp) {
                var data = rsp.data;
                var image;
                if(rsp.data[0].foto){
                    image = rsp.data[0].foto;
                    image = "<?= base_url("/assets/img/gunung/") ?>"+image;
                }else{
                    image = rsp.data[0].url;
                }
                if(data.status === true){
                    document.getElementById("nmgunung").innerHTML = data[0].gunung;
                    $("#viewImage").attr("src",image);
                    $('#detailGunung').modal('show');
                }
            }
        });
    }

    function editData(e) {
        
        $('#editGunung').modal('hide');
        var id = e.id;
        $.ajax({
            url: "<?= base_url('gunung/getDetail/'); ?>"+id,
            type: 'GET',
            data: {
                id: id
            },
            success: function(rsp) {
                var data = rsp.data;
                $('#form').trigger("reset");
                if(data.status === true){
                    $('#idEdit').val(data[0].Id);
                    $('#gunungEdit').val(data[0].gunung);
                    if(data[0].url){
                        $('#urlEdit').val(data[0].url);
                        $('#urlornoEdit').attr('checked',true);
                        $('#pictureEdit').attr('disabled',true);
                        $('#urlEdit').attr('disabled',false);
                    }else{
                        $('#urlEdit').val('');
                        $('#urlornoEdit').attr('checked',false);
                        // $('#pictureEdit').val(data[0].foto);
                        $('#pictureEdit').attr('disabled',false);
                        $('#urlEdit').attr('disabled',true);
                    }
                    
                    $('#editGunung').modal('show');
                }
            }
        });
    }

    $('.hapusGunung').on('click',function(e){
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
        cancelButtonText : 'Tidak'
      }).then((result) => {
        if (result.value) {
          document.location.href = href;
        }
      })
  });
</script>