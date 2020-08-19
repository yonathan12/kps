<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title;?></h1>
    <div class="col-md-3">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message');?>"> </div>
      <?php $this->session->flashdata('message')?$this->session->flashdata('message'):''?>
    </div>
  <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahUser">Tambah User</a>
  <table id="tableUser" class="table table-striped table-bordered" style="width:100%">
  <thead>
      <tr>
          <th>No</th>
          <th>Name</th>
          <th>Email</th>
          <th>Level</th>
          <th>Status</th>
          <th>Tanggal Di Buat</th>
          <th>Aksi</th>
      </tr>
  </thead>
  <tbody>
  <?php 
    $no = 1;
    foreach($AllData as $usr){
  ?>
    <tr>
        <td><?php echo $no++;?></td>
        <td><?php echo $usr['nama']; ?></td>
        <td><?php echo $usr['email'];?></td>
        <td>
            <?php
                if ($usr['role_id'] == 1) {
                    echo 'Admin';
                } elseif ($usr['role_id'] == 5) {
                    echo 'Direktur';
                }else {
                  echo 'Staff';
          }
            ?>
        </td>
        <td>
            <?php
            if ($usr['is_active'] == 1) {
                echo "Aktif";
            } else {
                echo "Tidak Aktif";
            }
            ?>
        </td>
        <td><?= date('d F Y',$usr['date_created']);?></td>
        <td style="text-align: center;">
            <a href="#" data-toggle="modal" data-target="#detailUser<?= $usr['Id']; ?>" class="glyphicon glyphicon-pencil btn btn-sm btn-success" ></a>
            <a href="#" data-toggle="modal" data-target="#editUser<?= $usr['Id']; ?>" class="glyphicon glyphicon-pencil btn btn-sm btn-primary" ></a>
            <a href="<?= base_url('admin/hapusUser/'.$usr['Id']); ?>" id="hapusUser" onclick="hapus(event)" class="btn btn-sm btn-danger glyphicon glyphicon-trash" ></a>
        </td>
    </tr>
    <?php }?>
  </tbody>
  </table>
</div>

<!-- Modal Tambah User -->
<div class="modal fade" id="tambahUser" tabindex="-1" role="dialog" aria-labelledby="tambahUserLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahUserLabel">Tambah User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url();?>admin/user" method="POST" onsubmit="return validasi(this)">
      <div class="modal-body">
      <input type="text" class="form-control" id="name" name="name" placeholder="Nama">
      <input type="text" hidden name="user_id" value="<?= $this->session->userdata('id'); ?>">
      </div>
      <div class="modal-body">
      <input type="text" class="form-control" id="email" name="email" placeholder="Email">
      </div>
      <div class="modal-body">
      <input type="password" class="form-control" id="password" name="password" placeholder="Password">
      </div>
      <div class="modal-body">
        <select class="custom-select" name="role_id"  id="role">        
        <option selected value="">Pilih Level</option>
          <?php foreach ($role as $r) {         
          ?>
          <option value="<?= $r['Id']; ?>"><?= $r['role']; ?></option>        
          <?php } ?>
      </select>
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
<?php
    foreach($AllData as $key => $user):
    $id = $user['Id'];
    $nama = $user['nama'];
    $email = $user['email'];
    $role_id = $user['role_id'];
?>
<div class="modal fade" id="editUser<?= $id; ?>" tabindex="-1" role="dialog" aria-labelledby="editUserLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editUserLabel">Edit User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('admin/editUser');?>" method="POST" onsubmit="return validasiEdit(this)">
      <div class="modal-body">
        <input type="text" class="form-control" id="nameEdit" name="name" placeholder="Nama" value="<?= $nama; ?>">
        <input type="text" hidden="" name="id" value="<?= $id; ?>">
        <input type="text" hidden name="user_id" value="<?= $this->session->userdata('id'); ?>">
      </div>
      <div class="modal-body">
        <input type="text" class="form-control" id="emailEdit" name="email" placeholder="Email" value="<?= $email; ?>">
      </div>
      <div class="modal-body">
        <select class="custom-select" name="role_id"  id="roleEdit">        
        <option selected value="">Pilih Level</option>
          <?php foreach ($role as $r) {?>
              <?php if ($r['Id'] == $role_id) : ?>
                <option value="<?= $r['Id'] ?>" selected ><?= $r['role'] ?></option>    
              <?php else : ?>
                <option value="<?= $r['Id']; ?>"><?= $r['role']; ?></option>        
              <?php endif; ?>
          <?php } ?>
      </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>
<?php endforeach;?>

<script type="text/javascript">
  function validasi(form){
    var name = form.name.value;
    var email = form.email.value;
    var password = form.password.value;
    var role = form.role.value;

    if(!name){
      Swal.fire(
        'Pesan',
        'Kolom Nama Tidak Boleh Kosong',
        'warning'
      )
      return false;
    }else if(!email){
      Swal.fire(
        'Pesan',
        'Kolom Email Tidak Boleh Kosong',
        'warning'
      )
      return false;
    }else if(!password){
      Swal.fire(
        'Pesan',
        'Kolom Password Tidak Boleh Kosong',
        'warning'
      )
      return false;
    }else if(!role){
      Swal.fire(
        'Pesan',
        'Kolom Level Tidak Boleh Kosong',
        'warning'
      )
      return false;
    }
    return true;
  }

  function validasiEdit(form){
    var name = form.nameEdit.value;
    var email = form.emailEdit.value;
    var role = form.roleEdit.value;

    if(!name){
      Swal.fire(
        'Pesan',
        'Kolom Nama Tidak Boleh Kosong',
        'warning'
      )
      return false;
    }else if(!email){
      Swal.fire(
        'Pesan',
        'Kolom Email Tidak Boleh Kosong',
        'warning'
      )
      return false;
    }else if(!role){
      Swal.fire(
        'Pesan',
        'Kolom Level Tidak Boleh Kosong',
        'warning'
      )
      return false;
    }
    return true;
  }

  function hapus(e){
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
        cancelButtonText : 'Tidak'
      }).then((result) => {
        if (result.value) {
          document.location.href = href;
        }
      })
  }
</script>