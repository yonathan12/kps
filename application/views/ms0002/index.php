<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="">
        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"> </div>
        <div class="error_message" data-flashdata="<?= $this->session->flashdata('error'); ?>"> </div>
        <form action="<?= base_url(); ?>MS0002/show" method="POST" onsubmit="return validasi(this)" autocomplete="off">
            <div class="modal-body">
                <div class="form-group">
                    <label for="Kelas" class="col-form-label">Kelas:</label>
                    <select name="class" class="form-control" id="kelas" onchange="return getsubclass(this)">
                        <option value="">Pilih Kelas</option>
                        <?php foreach ($class as $key => $value) : ?>
                            <option value="<?= $value['id'] ?>"><?= $value['descr'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?= form_error('class', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label for="Sub Kelas" class="col-form-label">Sub Kelas:</label>
                    <select name="subclass" class="form-control" id="subclass">
                        <option value="">Pilih SubKelas</option>
                    </select>
                    <?= form_error('subclass', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label for="Semester" class="col-form-label">Semester:</label>
                    <select name="semester" class="form-control" id="semester">
                        <option value="">Pilih Semester</option>
                        <?php foreach ($semester as $key => $value) : ?>
                            <option value="<?= $value['id'] ?>"><?= $value['descr'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?= form_error('semester', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label for="Tahun Ajaran" class="col-form-label">Tahun Ajaran:</label>
                    <select name="scholl_year" class="form-control" id="scholl_year">
                        <option value="">Pilih Tahun Ajaran</option>
                        <?php foreach ($scholl_year as $key => $value) : ?>
                            <option value="<?= $value['id'] ?>"><?= $value['descr'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?= form_error('scholl_year', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success">Cari</button>
            </div>
        </form>
    </div>
</div>
</div>

<script type="text/javascript">
    function validasi(form) {
        var kelas = form.kelas.value;
        var subclass = form.subclass.value;
        var semester = form.semester.value;
        var scholl_year = form.scholl_year.value;
        if (!kelas) {
            Swal.fire(
                'Pesan',
                'Kelas Wajib Diisi',
                'warning'
            )
            return false;
        } else if (!subclass) {
            Swal.fire(
                'Pesan',
                'Sub Kelas Wajib Diisi',
                'warning'
            )
            return false;
        } else if (!semester) {
            Swal.fire(
                'Pesan',
                'Semester Wajib Diisi',
                'warning'
            )
            return false;
        } else if (!scholl_year) {
            Swal.fire(
                'Pesan',
                'Tahun Ajaran Wajib Diisi',
                'warning'
            )
            return false;
        }
        return true;
    }

    function getsubclass(e) {
        var kelas = document.getElementById("kelas").value;
        var url = "<?= base_url('MS0002/subclass/'); ?>" + kelas;
        var attr = '#subclass';
        if (kelas) {
            fetch(url)
                .then(res => res.json())
                .then(response => {
                    const data = response.data;
                    if (data.status === true) {
                        $(attr)
                            .find('option')
                            .remove()
                            .end()
                            .append('<option value="">Pilih SubKelas</option>')
                            .val('');
                        data.data.map((value, key) => {
                            $(attr)
                                .append($("<option>" + value.descr + "</option>")
                                    .attr("value", value.id)
                                    .text(value.descr));
                        });
                    } else {
                        Swal.fire(
                            'Pesan',
                            data.message,
                            'warning'
                        )
                    }
                })
                .catch(error => console.log(error));
        } else {
            $(attr)
                .find('option')
                .remove()
                .end()
                .append('<option value="">Pilih SubKelas</option>')
                .val('');
        }
    }
</script>