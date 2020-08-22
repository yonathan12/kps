<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="">
        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"> </div>
        <div class="error_message" data-flashdata="<?= $this->session->flashdata('error'); ?>"> </div>
        <div class="form-group">
            <label class="col-form-label">Kelas : <?= $class; ?> - <?= $subclass; ?></label>
            <br />
            <label class="col-form-label">Semester / Tahun Ajaran : <?= $semester; ?> - <?= $scholl_year; ?></label>
        </div>
        <table class="table table-striped table-bordered" id="tableKPS" style="width:100%">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">NISN</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Total Pelanggaran</th>
                    <!-- <th scope="col">Aksi</th> -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($datakps as $key => $value) : ?>
                    <tr>
                        <th scope="row"><?= $key + 1; ?></th>
                        <td><?= $value['nisn']; ?></td>
                        <td><?= $value['fullnm']; ?></td>
                        <td><?= $value['total']; ?></td>
                        <!-- <td>
                            <a href="<?= base_url(); ?>MS0002/detail/<?= $value['id']; ?>" class="badge badge-warning">Detail</a>
                        </td> -->
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</div>
<script>
    var table = $('#tableKPS');
    table.DataTable({
        responsive: true
    });
</script>