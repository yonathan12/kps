<div class="container-fluid">

<div class="col-lg-3">
    <?= $this->session->flashdata('message');?>
    <?= form_error('stock','<div class="alert alert-danger" role="alert">','</div>'); ?>
    </div>
    <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#exampleModal">Add Stock</a>
<table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Valas</th>
                <th>Stock</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php 
                        $no = 1;
                        foreach($valas as $stock){
                    ?>
                        <tr>
                            <td><?php echo $no++;?></td>
                            <td><?php echo $stock['valas']; ?></td>
                            <td><?php echo $stock['sa'];?>
                            <td>                          
                                <a href="<?= base_url(); ?>admin/ubah/<?= $stock['Id_valas']; ?>" class="fas fa-edit" ></a>
                            </td>
                        </tr>
                    <?php }?>
        </tbody>
    </table>
    
</div>


    <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Stock</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url()?>admin/stock" method="POST" name="stock">
      <input type="text" class="form-control" id="kdaddstock" name="kdaddstock" hidden value="<?=$kode;?>">
        <div class="form-group">
            <label for="exampleFormControlInput1">Valas</label>
            <select name="valas" class="form-control">
            <option value="">Select Valas</option>
            <?php foreach ($valas as $v) : ?> 
            <option value="<?= $v['Id_valas'] ?>"><?= $v['valas'] ?></option>
            <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Stock</label>
            <input type="number" class="form-control" id="stock" name="stock" placeholder="Qty Stock">
            <?= form_error('stock','<small class="text-danger pl-3">','</small>'); ?>
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Rate</label>
            <input type="number" class="form-control" id="rate" name="rate" placeholder="Rate">
            <?= form_error('rate','<small class="text-danger pl-3">','</small>'); ?>
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Total</label>
            <input type="number" class="form-control" id="total" name="total" placeholder="Total" readonly>
            <?= form_error('total','<small class="text-danger pl-3">','</small>'); ?>
        </div>
        <input type=button name=submit onClick="hitungTotalTambahStock()" class="btn btn-primary" value="Hitung">
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    </div>
  </div>
</div>