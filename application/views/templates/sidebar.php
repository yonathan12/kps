<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url(); ?>user">
    <div class="sidebar-brand-icon rotate-n-15">
      <i class="fas fa-mountain"></i>
    </div>
    <div class="sidebar-brand-text mx-3">KPS</div>
  </a>
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url(); ?>user">
    <div class="sidebar-brand-text">SMK Bisa</div>
</a>

  <hr class="sidebar-divider">
  <?php
  $role_id = $this->session->userdata('role_id');
  $queryMenu = "SELECT param_menu.id, param_menu.descr
                    FROM param_menu JOIN param_access
                    ON param_menu.id = param_access.param_menu_id
                    WHERE param_access.param_role_id = $role_id
                    ORDER BY param_menu.descr ASC
                    ";
  $menu = $this->db->query($queryMenu)->result_array();
  ?>

  <?php foreach ($menu as $m) : ?>
    <div class="sidebar-heading">
      <?= $m['descr']; ?>
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse<?= $m['id']; ?>" aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-fw fa-cog"></i>
        <span><?= $m['descr']; ?></span>
      </a>
      <div id="collapse<?= $m['id']; ?>" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header"><?= $m['descr']; ?></h6>
          <?php
          $menuId = $m['id'];
          $querySubMenu = "SELECT param_submenu.url, param_submenu.icon, param_submenu.descr
                          FROM param_submenu JOIN param_menu
                          ON param_submenu.param_menu_id = param_menu.id
                          WHERE param_submenu.param_menu_id = $menuId
                          AND param_submenu.is_active = 1 
                          ORDER BY param_submenu.descr ASC
          ";
          $subMenu = $this->db->query($querySubMenu)->result_array();
          ?>
          <?php foreach ($subMenu as $sm) : ?>
            <a class="collapse-item" href="<?= base_url($sm['url']); ?>"> <i class="<?= $sm['icon']; ?>"></i> <?= $sm['descr']; ?> </a>
          <?php endforeach; ?>
        </div>
      </div>
    </li>
    <hr class="sidebar-divider mt-3">
  <?php endforeach; ?>

  <li class="nav-item">
    <a class="nav-link pb-0" href="<?= base_url(); ?>auth/logout">
      <i class="fas fa-fw fa-fw fa-sign-out-alt"></i>
      <span>Logout</span></a>
  </li>
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>
</ul>