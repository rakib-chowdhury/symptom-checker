<div class="sidebar-menu-inner">

    <header class="logo-env">

        <!-- logo -->
        <div class="logo">
            <a href="<?= site_url('dashboard') ?>">
                <img src="<?= base_url() ?>/public/assets/backend/images/logo@2x.png" width="120" alt="" />
            </a>
        </div>

        <!-- logo collapse icon -->
        <div class="sidebar-collapse">
            <a href="#" class="sidebar-collapse-icon"><!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition -->
                <i class="entypo-menu"></i>
            </a>
        </div>


        <!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
        <div class="sidebar-mobile-menu visible-xs">
            <a href="#" class="with-animation"><!-- add class "with-animation" to support animation -->
                <i class="entypo-menu"></i>
            </a>
        </div>

    </header>


    <ul id="main-menu" class="main-menu">
        <!-- add class "multiple-expanded" to allow multiple submenus to open -->
        <!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->
        <li <?php
        if (strcasecmp($active_page, "Dashboard") == 0)
            echo "class='active'";
        ?>>
            <a href="<?= site_url('dashboard') ?>">
                <i class="entypo-gauge"></i>
                <span class="title">Dashboard</span>
            </a>
        </li>
		<?php if($this->basic_lib->check_permission('add_users') || $this->basic_lib->check_permission('edit_user') ||
		$this->basic_lib->check_permission('change_user_status') || $this->basic_lib->check_permission('delete_user') ||
		$this->basic_lib->check_permission('reset_user_password') || $this->basic_lib->check_permission('view_user_list')
		) : ?>
        <li
            <?php
            if (strcasecmp($active_page, "Add User") == 0)
                echo "class='opened has-sub active'";
            else if (strcasecmp($active_page, "Manage Users") == 0)
                echo "class='opened has-sub active'";
            else
                echo "class='has-sub'";
            ?>

        >
            <a href="">
                <i class="entypo-users"></i>
                <span class="title" style="margin-left: 5px">Users</span>
            </a>
            <ul>
				<?php if($this->basic_lib->check_permission('add_users')) : ?>
                <li
                    <?php
                    if (strcasecmp($active_page, "Add User") == 0)
                        echo "class='active'";
                    ?>
                >
                    <a href="<?= site_url('add_new_user') ?>">
                        <span class="title">Add User</span>
                    </a>
                </li>
				<?php endif; ?>
				<?php if($this->basic_lib->check_permission('view_user_list') ||
					$this->basic_lib->check_permission('edit_user') || $this->basic_lib->check_permission('change_user_status') ||
					$this->basic_lib->check_permission('delete_user') || $this->basic_lib->check_permission('reset_user_password')
				) : ?>
                <li
                    <?php
                    if (strcasecmp($active_page, "Manage Users") == 0)
                        echo "class='active'";
                    ?>
                >
                    <a href="<?= site_url('manage_users') ?>">
                        <span class="title">Manage Users</span>
                    </a>
                </li>
				<?php endif; ?>
            </ul>
        </li>
		<?php endif; ?>
		<?php if(($_SESSION['is_super_user'] == SUPER_ADMIN) || $this->basic_lib->check_permission('manage_user_groups')): ?>
        <li
            <?php
            if (strcasecmp($active_page, "User Permissions") == 0)
                echo "class='opened has-sub active'";
            else if (strcasecmp($active_page, "Manage User Groups") == 0)
                echo "class='opened has-sub active'";
            else
                echo "class='has-sub'";
            ?>

        >
            <a href="">
                <i class="entypo-tools"></i>
                <span class="title" style="margin-left: 5px">Admin Console</span>
            </a>
            <ul>
                <?php if($_SESSION['is_super_user'] == SUPER_ADMIN): ?>
                    <li
                        <?php
                        if (strcasecmp($active_page, "User Permissions") == 0)
                            echo "class='active'";
                        ?>
                    >
                        <a href="<?= site_url('manage_user_permissions') ?>">
                            <span class="title">User Permission</span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if(($_SESSION['is_super_user'] == SUPER_ADMIN) || $this->basic_lib->check_permission('manage_user_groups')): ?>
                    <li
                        <?php
                        if (strcasecmp($active_page, "Manage User Groups") == 0)
                            echo "class='active'";
                        ?>
                    >
                        <a href="<?= site_url('manage_user_types') ?>">
                            <span class="title">User Groups</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </li>
		<?php endif; ?>
    </ul>

</div>
