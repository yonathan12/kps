<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <a href="<?= base_url() ?>PM0004" class="btn btn-primary mb-3">Kembali</a>
    <?= $this->session->flashdata('message'); ?>
    <h5>Role : <?= $role['descr']; ?></h5>
    <table class="table table-hover" id="tableAccess">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Menu</th>
                <th scope="col">Access</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            <?php foreach ($menu as $key => $value) : ?>
                <tr>
                    <th scope="row"><?= $i; ?></th>
                    <td><?= $value['descr']; ?></td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" <?= check_access($role['id'], $value['id']); ?> data-role="<?= $role['id']; ?>" data-menu="<?= $value['id']; ?>" onclick="return role(this)">
                        </div>
                    </td>
                </tr>
                <?php $i++; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</div>
<script type="text/javascript">
    var table = $('#tableAccess');
    table.DataTable({
        responsive: true
    });

    function role(e) {
        const menuId = e.dataset.menu;
        const roleId = e.dataset.role;

        $.ajax({
            url: "<?= base_url('PM0004/create'); ?>",
            type: 'POST',
            data: {
                menu_id: menuId,
                role_id: roleId
            },
            success: function() {
                // document.location.href = "<?= base_url('PM/roleAccess/'); ?>" + roleId;
            }
        });
    }
</script>