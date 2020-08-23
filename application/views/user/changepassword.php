<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"> </div>
  <div class="error_message" data-flashdata="<?= $this->session->flashdata('error'); ?>"> </div>
  <div class="row">
    <div class="col-lg-6">
      <form action="<?= base_url('User/changepassword') ?>" method="post" onsubmit="return validasi(this)">
        <div class="form-group">
          <label for="current_password">Password Lama</label>
          <input type="password" class="form-control" id="current_password" aria-describedby="emailHelp" name="current_password">
          <?= form_error('current_password', '<small class="text-danger pl-3">', '</small>'); ?>
        </div>
        <div class="form-group">
          <label for="new_password1">Password Baru</label>
          <input type="password" class="form-control" id="new_password1" aria-describedby="emailHelp" name="new_password1">
          <?= form_error('new_password1', '<small class="text-danger pl-3">', '</small>'); ?>
        </div>
        <div class="form-group">
          <label for="new_password2">Ulangi Password Baru</label>
          <input type="password" class="form-control" id="new_password2" aria-describedby="emailHelp" name="new_password2">
          <?= form_error('new_password2', '<small class="text-danger pl-3">', '</small>'); ?>
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-primary">Ganti Password</button>
        </div>
      </form>
    </div>
  </div>
</div>
</div>

<script type="text/javascript">
  function validasi(form) {
    var current_password = form.current_password.value;
    var new_password1 = form.new_password1.value;
    var new_password2 = form.new_password2.value;

    if (!current_password) {
      Swal.fire(
        'Pesan',
        'Password Lama Tidak Boleh Kosong',
        'warning'
      )
      return false;
    } else if (!new_password1) {
      Swal.fire(
        'Pesan',
        'Password Baru Tidak Boleh Kosong',
        'warning'
      )
      return false;
    } else if (!new_password2) {
      Swal.fire(
        'Pesan',
        'Ulangi Password Baru Tidak Boleh Kosong',
        'warning'
      )
      return false;
    } else if (new_password1 !== new_password2) {
      Swal.fire(
        'Pesan',
        'Password Baru Tidak Sama',
        'warning'
      )
      return false;
    }
    return true;
  }
</script>