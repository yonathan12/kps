<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="">
        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"> </div>
        <div class="flash-data1" data-flashdata="<?= $this->session->flashdata('error'); ?>"> </div>
        <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#exampleModal">Tambah Siswa</a>
        <a href="#" class="btn btn-success mb-3" data-toggle="modal" data-target="#upload">Upload Data Siswa</a>
        <a href="#" class="btn btn-warning mb-3" data-toggle="modal" data-target="#upload">Download Template Upload Data Siswa</a>
        <table class="table table-striped table-bordered" id="tableSiswa" style="width:100%">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">NISN</th>
                    <th scope="col">Nama Lengkap</th>
                    <th scope="col">Kelas</th>
                    <th scope="col">Tahun Ajaran</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($student as $key => $value) : ?>
                    <tr>
                        <th scope="row"><?= $key + 1; ?></th>
                        <td><?= $value['nisn']; ?></td>
                        <td><?= $value['fullnm']; ?></td>
                        <td><?= $value['kelas']; ?></td>
                        <td><?= $value['tahun_ajaran']; ?></td>
                        <td>
                            <a href="#" data-toggle="modal" data-target="#editSiswa<?= $value['id']; ?>" class="badge badge-primary" id="<?= $value['id'] ?>" onclick="return detailData(this)">Edit</a>
                            <a href="MS0001/destroy/<?= $value['id']; ?>" class="badge badge-danger delete">Hapus</a>
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
                <h5 class="modal-title" id="exampleModalLabel">Tambah Siswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url(); ?>MS0001/create" method="POST" onsubmit="return validasi(this);">
                <div class="form-group">
                    <input type="number" class="form-control" id="nisn" name="nisn" placeholder="NISN">
                    <?= form_error('nisn', '<small class="text-danger pl-3">', '</small>'); ?>
                    <input type="text" name="user_id" value="<?= $this->session->userdata('id'); ?>" hidden>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="fullnm" name="fullnm" placeholder="Nama Lengkap">
                    <?= form_error('fullnm', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <input type="date" class="form-control" id="brthdt" name="brthdt">
                    <?= form_error('brthdt', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <select name="class" class="form-control" id="kelas" onchange="return getsubclass(this)">
                        <option value="">Pilih Kelas</option>
                        <?php foreach ($class as $key => $value) : ?>
                            <option value="<?= $value['id'] ?>"><?= $value['descr'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?= form_error('class', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <select name="subclass" class="form-control" id="subclass">
                        <option value="">Pilih SubKelas</option>
                    </select>
                    <?= form_error('subclass', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <select name="semester" class="form-control" id="semester">
                        <option value="">Pilih Semester</option>
                        <?php foreach ($semester as $key => $value) : ?>
                            <option value="<?= $value['id'] ?>"><?= $value['descr'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?= form_error('semester', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <select name="scholl_year" class="form-control" id="scholl_year">
                        <option value="">Pilih Tahun Ajaran</option>
                        <?php foreach ($scholl_year as $key => $value) : ?>
                            <option value="<?= $value['id'] ?>"><?= $value['descr'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?= form_error('scholl_year', '<small class="text-danger pl-3">', '</small>'); ?>
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
<div class="modal fade" id="editSiswa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Siswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url(); ?>MS0001/update" method="POST" onsubmit="return validasiedit(this);">
                <div class="form-group">
                    <input type="number" class="form-control" id="nisnedit" name="nisn" placeholder="NISN">
                    <input type="text" hidden="" name="id" id="idedit">
                    <?= form_error('nisn', '<small class="text-danger pl-3">', '</small>'); ?>
                    <input type="text" name="user_id" value="<?= $this->session->userdata('id'); ?>" hidden>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="fullnmedit" name="fullnm" placeholder="Nama Lengkap">
                    <?= form_error('fullnm', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <input type="date" class="form-control" id="brthdtedit" name="brthdt">
                    <?= form_error('brthdt', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <select name="class" class="form-control" id="kelasedit" onchange="return getsubclass(this)">
                        <option value="">Pilih Kelas</option>
                        <?php foreach ($class as $key => $value) : ?>
                            <option value="<?= $value['id'] ?>"><?= $value['descr'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?= form_error('class', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <select name="subclass" class="form-control" id="subclassedit">
                        <option value="">Pilih SubKelas</option>
                    </select>
                    <?= form_error('subclass', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <select name="semester" class="form-control" id="semesteredit">
                        <option value="">Pilih Semester</option>
                        <?php foreach ($semester as $key => $value) : ?>
                            <option value="<?= $value['id'] ?>"><?= $value['descr'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?= form_error('semester', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <select name="scholl_year" class="form-control" id="scholl_yearedit">
                        <option value="">Pilih Tahun Ajaran</option>
                        <?php foreach ($scholl_year as $key => $value) : ?>
                            <option value="<?= $value['id'] ?>"><?= $value['descr'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?= form_error('scholl_year', '<small class="text-danger pl-3">', '</small>'); ?>
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
        var nisn = form.nisn.value;
        var fullnm = form.fullnm.value;
        var brthdt = form.brthdt.value;
        var kelas = form.kelas.value;
        var subclass = form.subclass.value;
        var semester = form.semester.value;
        var scholl_year = form.scholl_year.value;
        if (!nisn) {
            Swal.fire(
                'Pesan',
                'NISN Wajib Diisi',
                'warning'
            )
            return false;
        } else if (!fullnm) {
            Swal.fire(
                'Pesan',
                'Nama Lengkap Wajib Diisi',
                'warning'
            )
            return false;
        } else if (!brthdt) {
            Swal.fire(
                'Pesan',
                'Tanggal Lahir Wajib Diisi',
                'warning'
            )
            return false;
        } else if (!kelas) {
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
        } else if (!semester) {
            Swal.fire(
                'Pesan',
                'Tahun Ajaran Wajib Diisi',
                'warning'
            )
            return false;
        }
        return true;
    }

    function validasiedit(form) {
        var nisn = form.nisnedit.value;
        var fullnm = form.fullnmedit.value;
        var brthdt = form.brthdtedit.value;
        var kelas = form.kelasedit.value;
        var subclass = form.subclassedit.value;
        var semester = form.semesteredit.value;
        var scholl_year = form.scholl_yearedit.value;
        if (!nisn) {
            Swal.fire(
                'Pesan',
                'NISN Wajib Diisi',
                'warning'
            )
            return false;
        } else if (!fullnm) {
            Swal.fire(
                'Pesan',
                'Nama Lengkap Wajib Diisi',
                'warning'
            )
            return false;
        } else if (!brthdt) {
            Swal.fire(
                'Pesan',
                'Tanggal Lahir Wajib Diisi',
                'warning'
            )
            return false;
        } else if (!kelas) {
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
        } else if (!semester) {
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
        var kelasedit = document.getElementById("kelasedit").value;
        var url = '';
        var attr = '';
        if (kelas) {
            url = "<?= base_url('MS0001/subclass/'); ?>" + kelas;
            attr = '#subclass';
        } else {
            url = "<?= base_url('MS0001/subclass/'); ?>" + kelasedit;
            attr = '#subclassedit';
        }
        if (kelas || kelasedit) {
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

    function detailData(e) {
        $('#editSiswa').modal('hide');
        var id = e.id;
        $.ajax({
            url: "<?= base_url('MS0001/show/'); ?>" + id,
            type: 'GET',
            success: function(res) {
                var data = res.data;
                if (data.status === true) {
                    document.getElementById("nisnedit").value = data.data.nisn;
                    document.getElementById("idedit").value = data.data.id;
                    document.getElementById("fullnmedit").value = data.data.fullnm;
                    document.getElementById("brthdtedit").value = data.data.brthdt;
                    document.getElementById("kelasedit").value = data.data.param_class_id;
                    document.getElementById("semesteredit").value = data.data.param_semester_id;
                    document.getElementById("scholl_yearedit").value = data.data.param_scholl_year_id;
                    const subclass_id = data.data.param_subclass_id;
                    fetch("<?= base_url('MS0001/subclass/'); ?>" + data.data.param_class_id)
                        .then(res => res.json())
                        .then(response => {
                            const data = response.data;
                            if (data.status === true) {
                                $('#subclassedit')
                                    .find('option')
                                    .remove()
                                    .end()
                                    .append('<option value="">Pilih SubKelas</option>')
                                    .val('');
                                data.data.map((value, key) => {
                                    $('#subclassedit')
                                        .append($("<option>" + value.descr + "</option>")
                                            .attr("value", value.id)
                                            .text(value.descr)).val(subclass_id);
                                });
                                $('#editSiswa').modal('show');
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

    var table = $('#tableSiswa');
    table.DataTable({
        responsive: true
    });
</script>