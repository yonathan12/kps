<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="row">
        <div class="col-lg-12">
            <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"> </div>
            <?php $this->session->flashdata('message') ? $this->session->flashdata('message') : '' ?>
            <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#exampleModal">Tambah Valas</a>
            <h3 text-align="center">Data Valas</h3>
            <table id="table2" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Valas</th>
                        <th>Deskripsi</th>
                        <th>Tanggal Dibuat</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($valas as $v) {
                    ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?= $v['valas']; ?></td>
                            <td><?= $v['description']; ?></td>
                            <td><?= $v['date_created']; ?></td>
                            <td>
                                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#editValas<?= $v['Id']; ?>">Edit Valas</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Valas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url(); ?>master/valas" method="POST" onsubmit="return validasi(this)">
                <div class="modal-body">
                    <input type="text" value="<?= $kode; ?>" hidden name="kode">
                    <input type="text" class="form-control" id="valas" name="valas" placeholder="Valas">
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control" id="deskripsi" name="description" placeholder="Description">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php foreach ($valas as $v) : ?>
    <!-- Modal Edit-->
    <div class="modal fade" id="editValas<?= $v['Id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Valas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url(); ?>master/editValas" method="POST" onsubmit="return validasi(this)">
                    <div class="modal-body">
                        <input type="text" value="<?= $kode; ?>" hidden name="kode">
                        <input type="text" class="form-control" id="valas" name="valas" placeholder="Valas" value="<?= $v['valas']; ?>">
                        <input type="text" name="id" value="<?= $v['Id']; ?>" hidden>
                    </div>
                    <div class="modal-body">
                        <input type="text" class="form-control" id="deskripsi" name="description" placeholder="Description" value="<?= $v['description']; ?>">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script type="text/javascript">
    function validasi(form) {
        var valas = form.valas.value;
        var deskripsi = form.deskripsi.value;
        if (!valas) {
            Swal.fire(
                'Pesan',
                'Valas Wajib Diisi',
                'warning'
            )
            return false;
        } else if (!deskripsi) {
            Swal.fire(
                'Pesan',
                'Deskripsi Wajib Diisi',
                'warning'
            )
            return false;
        }
        return true;
    }
</script>