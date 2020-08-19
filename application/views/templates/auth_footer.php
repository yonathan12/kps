<script src="<?= base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url();?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="<?= base_url(); ?>assets/js/sb-admin-2.min.js"></script>
<script src="<?= base_url();?>assets/js/sweetalert2.all.min.js"></script>
<script type="text/javascript">

    function validasi(form) {
      var email = form.email.value;
      var password = form.password.value;
      
      if(!email){
        Swal.fire(
          'Pesan',
          'Email Wajib Diisi',
          'warning'
        )
        return false;
      }else if(!validateEmail(email)){
          Swal.fire(
          'Pesan',
          'Email Tidak Sesuai',
          'warning'
        )
        return false;
      }else if(!password){
          Swal.fire(
          'Pesan',
          'Password Wajib Diisi',
          'warning'
        )
        return false;
      }
      return true;
    }

    function validateEmail(email) {
      var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(email);
    }

    const flashData = $('.flash-data').data('flashdata');
      if(flashData){
          Swal.fire(
            'Pesan',
            'Gagal '+flashData,
            'warning'
            )
      }
  </script>
</body>
</html>
