<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800"><?= $title;?></h1>
  <div class="row">
    <div class="col-lg">
      <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message');?>"> </div>
        <?php $this->session->flashdata('message')?$this->session->flashdata('message'):''?>
        <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#exampleModal">Tambah Submenu</a>
        <table id="tableSubmenu" class="table table-striped table-bordered" style="width:100%">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Title</th>
              <th scope="col">Menu</th>
              <th scope="col">Url</th>
              <th scope="col">Icon</th>
              <th scope="col">Active</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
        <tbody>
          <?php 
            $no = 1;
            foreach($subMenu as $sm){
          ?>
          <tr>
            <th scope="row"><?= $no++;?></th>
            <td><?= $sm['title']; ?></td>
            <td><?= $sm['menu']; ?></td>
            <td><?= $sm['url']; ?></td>
            <td><?= $sm['icon']; ?></td>
            <td>
                <?php if ($sm['is_active'] == 1) {
                echo 'Active';
                } else {
                echo 'Not Active';
                }
                ?>
            </td>
            <td>
              <a href="#" data-toggle="modal" data-target="#editSubMenu<?= $sm['Id']; ?>" class="badge badge-success" >Edit</a>
              <a href="<?= base_url(); ?>menu/deleteSubmenu/<?= $sm['Id']; ?>" onclick="return confirm('Yakin');" class="badge badge-danger">Delete</a>
            </td>
          </tr>
          <?php }?>
        </tbody>
        </table>
        </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Sub Menu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url();?>menu/submenu" method="POST" onsubmit="return validasi(this);">
        <div class="form-group">
            <input type="text" class="form-control" id="title" name="title" placeholder="Submenu">
            <input type="text" name="user_id" value="<?= $this->session->userdata('id'); ?>" hidden>
        </div>
        <div class="form-group">
            <select name="menu_id" class="form-control" id="menu_id">
            <option value="">Select Menu</option>
            <?php foreach ($menu as $m) : ?> 
            <option value="<?= $m['Id'] ?>"><?= $m['menu'] ?></option>
            <?php endforeach; ?>
            </select>
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

<!-- Modal Edit-->
<?php foreach($subMenu as $key => $value): ?>
<div class="modal fade" id="editSubMenu<?= $value['Id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Sub Menu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url();?>menu/editSubmenu" method="POST" onsubmit="return validasi(this);">
        <div class="form-group">
            <input type="text" class="form-control" id="menu" name="title" placeholder="Submenu" value="<?= $value['title']; ?>">
            <input type="text" hidden="" name="Id" value="<?= $value['Id'] ?>">
            <input type="text" name="user_id" value="<?= $this->session->userdata('id'); ?>" hidden>
        </div>
        <div class="form-group">
            <select name="menu_id" class="form-control" id="menu_id">
            <?php foreach ($menu as $m) : ?> 
                <?php if ($m['Id'] == $value['menu_id']) : ?>
            <option value="<?= $m['Id'] ?>" selected ><?= $m['menu'] ?></option>
                <?php else : ?>
            <option value="<?= $m['Id'] ?>"><?= $m['menu'] ?></option>
                <?php endif; ?>            
            <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="url" name="url" placeholder="Sub Menu URL" value="<?= $value['url']; ?>">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="icon" name="icon" placeholder="Sub Menu Icon" value="<?= $value['icon'];?>">
        </div>
        <div class="form-group">
        <div class="form-check">
            <?php if ($value['is_active'] == 1) : ?>
            <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active" checked>
            <?php else :  ?>
            <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active">
            <?php endif;  ?>   
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
<?php endforeach; ?>

<script type="text/javascript">

function validasi(form){
    var title = form.title.value;
    var url = form.url.value;
    var menu_id = dform.menu_id.value;
    alert('test');
    if(!title){
      Swal.fire(
          'Pesan',
          'Sub Menu Wajib Diisi',
          'warning'
        )
        return false;
    }else if(!url){
      Swal.fire(
          'Pesan',
          'Url Wajib Diisi',
          'warning'
        )
        return false;
    }else if(!menu_id){
      Swal.fire(
          'Pesan',
          'Menu Wajib Dipilih',
          'warning'
        )
        return false;
    }
    return true;
  }

  $('#tableSubmenu').DataTable({
    responsive:true
  });

  
</script>