
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800"><?= $title;?></h1>
        
        <div class="row">
        <div class="col-lg-12">        
       
        <?= $this->session->flashdata('message');?>
        <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#exampleModal">Add New Valas</a>

        <h3 text-align="center">Data Valas</h3>
        <table id="table2" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Valas</th>
                    <th>Description</th>
                    <th>Date Created</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $no = 1;
                            foreach($valas as $v){
                        ?>
                            <tr>
                                <td><?php echo $no++;?></td>
                                <td><?= $v['valas'];?></td>
                                <td><?= $v['description'];?></td>
                                <td><?php echo $v['date_created']; ?></td> 
                                <td><a href="<?= base_url(); ?>laporan/hapus/<?= $v['Id_valas']; ?>" class="fas fa-trash-alt" onclick="return confirm('Yakin');"></a></td>                           
                            </tr>
                            <?php }?>
            </tbody>
        </table>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Valas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url();?>admin/valas" method="POST">
      <div class="modal-body">
      <input type="text" value="<?= $kode; ?>" hidden name="kode">
      <input type="text" class="form-control" id="role" name="valas" placeholder="Valas">
      <?php echo form_error('valas', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
      </div>
      <div class="modal-body">
      <input type="text" class="form-control" id="role" name="description" placeholder="Description">
      <?php echo form_error('description', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>

     