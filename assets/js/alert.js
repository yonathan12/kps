const flashData = $('.flash-data').data('flashdata');
if(flashData){
    Swal.fire(
        'Pesan',
        flashData,
        'success'
      )
}

const flashError = $('.error_message').data('flashdata');
if(flashError){
    Swal.fire(
        'Pesan',
        flashError,
        'warning'
      )
}

$('.custom-file-input').on('change', function(){
  let fileName = $(this).val().split('\\').pop();
  $(this).next('.custom-file-label').addClass("selected").html(fileName);
});

$(document).ready(function() {
var tableUser = $('#tableUser').DataTable( {
    responsive: true
});
});

$(document).ready(function() {
var table = $('#table2').DataTable( {
    responsive: true
});
});


