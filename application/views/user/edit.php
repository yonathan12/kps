<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title;?></h1>
        <div class="row">
            <div class="col-lg-8">
                <!-- <?= form_open_multipart('user/edit');?>  -->
                <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message');?>"> </div>
                <?php $this->session->flashdata('message')?$this->session->flashdata('message'):''?>
                <form action="<?=base_url('user/edit')?>" method="post" onsubmit="return validasi(this)" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="email" placeholder="Email" name="email" value="<?=$user['email'];?>" readonly>
                        </div>
                    </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Nama Lengkap</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" value="<?=$user['nama'];?>" placeholder="Name" name="nama" >
                                <?= form_error('name','<small class="text-danger pl-3">','</small>'); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col sm-2">Picture</div>
                                <div class="col-sm-10">
                                    <div class="col-sm-3">
                                        <img src="<?= base_url()?>assets/img/profile/<?=$user['image'];?>" class="img-thumbnail">
                                    </div>
                                    <div class="col-sm-9">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="picture" name="image">
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Edit</button>    
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function validasi(form){
        var nama = form.name.value;

        if(!nama){
            Swal.fire(
                'Pesan',
                'Nama Tidak Boleh Kosong',
                'warning'
            )
            return false;
        }
        return true;
    }
</script>