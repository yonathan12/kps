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
        <a class="btn btn-primary" href="<?= base_url(); ?>auth/logout">Logout</a>
      </div>
    </div>
  </div>
</div>

<script src="<?= base_url(); ?>assets/js/alert.js"></script>

<script>
  var tableCustomer;
  $(document).ready(function() {
    table = $('#tableCustomer').DataTable({
      "processing": true,
      "serverSide": true,
      "responsive": true,
      "order": [],

      "ajax": {
        "url": "<?= base_url('/customer/get_data'); ?> ",
        "type": "POST"
      },

      "columnDefs": [{
        "targets": [0],
        "orderable": false,
      }, ],
    });
  });
</script>

</body>

</html>