<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
  <div class="row">
    <div class="col-lg-6">
      <?= $this->session->flashdata('message'); ?>
      <h5>Role : <?= $role['role']; ?></h5>
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Menu</th>
            <th scope="col">Access</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; ?>
          <?php foreach ($menu as $m) : ?>
            <tr>
              <th scope="row"><?= $i; ?></th>
              <td><?= $m['menu']; ?></td>
              <td>
                <div class="form-check">
                  <input class="form-check-input" id="role" type="checkbox" <?= check_access($role['Id'], $m['Id']); ?> data-role="<?= $role['Id']; ?>" data-menu="<?= $m['Id']; ?>" onclick="return role(this)">
                </div>
              </td>
            </tr>
            <?php $i++; ?>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</div>
<script type="text/javascript">

function role(e) {
  const menuId = e.dataset.menu;
  const roleId = e.dataset.role;

  $.ajax({
    url: "<?= base_url('admin/changeAccess'); ?>",
    type: 'POST',
    data: {
      menuId: menuId,
      roleId : roleId
    },
    success: function(){
      document.location.href ="<?= base_url('admin/roleAccess/'); ?>" + roleId;
    }
  });
}
</script>