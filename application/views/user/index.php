<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title;?></h1>
    <div class="row">
      <div class="col-lg-6">
      <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message');?>"> </div>
      <div class="error_message" data-flashdata="<?= $this->session->flashdata('error'); ?>"> </div>
      </div>
    </div>
    <div class="card mb-3" style="max-width: 540px;">
      <div class="row no-gutters">
        <div class="col-md-4">
          <img src="<?= base_url()?>assets/img/profile/<?=$user['image'];?>" class="card-img" alt="...">
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <h5 class="card-title"><?= $user['fullnm'] ?></h5>
            <p class="card-text"><?= $user['username'] ?></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>