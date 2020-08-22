<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="">
        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"> </div>
        <div class="error_message" data-flashdata="<?= $this->session->flashdata('error'); ?>"> </div>
        <form action="<?= base_url(); ?>KPS001/show" method="POST" onsubmit="return validasi(this)">
            <div class="modal-body">
                <div class="form-group">
                    <label for="NISN" class="col-form-label">NISN:</label>
                    <input type="number" class="form-control" id="nisn" name="nisn" placeholder="NISN">
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
        var code = form.code.value;
        var descr = form.descr.value;
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
        $('#editKelas').modal('hide');
        var id = e.id;
        $.ajax({
            url: "<?= base_url('pm0001/show/'); ?>" + id,
            type: 'GET',
            success: function(res) {
                var data = res.data;
                if (data.status === true) {
                    document.getElementById("codeedit").value = data.data.code;
                    document.getElementById("editdescr").value = data.data.descr;
                    document.getElementById("id").value = data.data.id;
                    $('#editKelas').modal('show');
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

    var table = $('#tableKelas');
    table.DataTable({
        responsive: true
    });
</script>