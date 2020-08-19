</div>
  </div>
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Yakin Akan Keluar ?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Pastikan Data Sudah Tersimpan</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
          <a class="btn btn-primary" href="<?= base_url();?>auth/logout">Logout</a>
        </div>
      </div>
    </div>
  </div>


  <!-- Import Data Customer-->
  <div class="modal fade" id="upload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document" style="margin-top:100px;">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" id="myModalLabel">Import Data Customer</h4>

			</div>
        	<div>
			<?php echo form_open_multipart("customer/upload",'class="form-horizontal"'); ?>
				<div class="modal-body">
					<div class="form-group row">
					<div class="col-md-12">
						<label for="exampleInputFile">Pilih File Excel</label>
							<?= form_upload(array('id' => 'txtFileImport', 'name' => 'file'))?>
							<small id="fileImport" class="form-text text-muted">Import Data Customer Via Excel, Format File Harus .XLS (Excel 2003-2007).</small>
					</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
					<button type="submit" value="Upload" name="btnSubmit" class="btn btn-primary"><i class="fa fa-upload"></i> Import Data</button>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<script src="<?= base_url();?>assets/js/alert.js"></script>

<script>
var tableCustomer;
$(document).ready(function() { 
    table = $('#tableCustomer').DataTable({ 
        "processing": true, 
        "serverSide": true,
        "responsive": true,
        "order": [], 
         
        "ajax": {
            "url": "<?= base_url('/customer/get_data');?> ",
            "type": "POST"
        },
         
        "columnDefs": [
        { 
            "targets": [ 0 ], 
            "orderable": false, 
        },
        ], 
    }); 
});


$(document).ready(function(){
    $( "#customer" ).autocomplete({
      source: "<?= base_url('transaksi/get_autocomplete/?');?>"
    });
});    

$(document).ready(function(){
    $( "#kd_trx_beli" ).autocomplete({
      source: "<?= base_url('void/get_autocomplete/?');?>"
    });
});    

$(document).ready(function(){
    $( "#kd_trx_jual" ).autocomplete({
      source: "<?= base_url('void/get_autocompleteJual/?');?>"
    });
});

  function hitungBeli(){

    var myForm = document.hitungRateBeli;
    var x=eval(myForm.rate_valas.value);
    var y=eval(myForm.jumlah.value);
    var z= x * y;
    myForm.total.value =  z.toFixed(0);
  }

  function hitungJual(){

  var myForm = document.hitungRateJual;
  var x=eval(myForm.rate_valas.value);
  var y=eval(myForm.jumlah.value);
  var z= y * x;
  myForm.total.value = z.toFixed(0);
  }

  function hitungTotalTambahStock(){

  var myForm = document.stock;
  var x=eval(myForm.stock.value);
  var y=eval(myForm.rate.value);
  var z= y * x;
  myForm.total.value = z.toFixed(0);
  }
  </script>

</body>

</html>
