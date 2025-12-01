
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <!-- desktop logo-->
            <a href="<?php echo $SITE_URL;?>" target="_blank" style="display: contents;"><img class="navbar-brand desktop-logo" src="<?php echo $SITE_LOGO; ?>" alt="<?php echo $SITE_NAME;?>" /></a>
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <a class="nav-link <?php echo (strpos($_SERVER['REQUEST_URI'], 'dashboard.php') !== false) ? 'activemenu': '';?>" href="<?php echo $SITE_URL; ?>/admin/dashboard.php">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-pie-chart"></i></div>
                        Dashboard
                    </a>
                    <a class="nav-link <?php echo (strpos($_SERVER['REQUEST_URI'], 'pages.php') !== false || strpos($_SERVER['REQUEST_URI'], 'page-creator.php') !== false) ? 'activemenu': '';?>" href="<?php echo $SITE_URL; ?>/admin/pages.php">
                        <div class="sb-nav-link-icon"><i class="fa fa-file-text"></i></div>
                        Pages
                    </a>
                    <a class="nav-link <?php echo (strpos($_SERVER['REQUEST_URI'], 'cars.php') !== false || strpos($_SERVER['REQUEST_URI'], 'car-addedit.php') !== false || strpos($_SERVER['REQUEST_URI'], 'car-sale.php') !== false || strpos($_SERVER['REQUEST_URI'], 'sale_info.php') !== false) ? 'activemenu': '';?>" href="<?php echo $SITE_URL; ?>/admin/cars.php">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-car"></i></div>
                        Cars
                    </a>
                    <a class="nav-link <?php echo (strpos($_SERVER['REQUEST_URI'], 'makes.php') !== false || strpos($_SERVER['REQUEST_URI'], 'make-addedit.php') !== false) ? 'activemenu': '';?>" href="<?php echo $SITE_URL; ?>/admin/makes.php">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-taxi"></i></div>
                        Makes
                    </a>
                    <a class="nav-link <?php echo (strpos($_SERVER['REQUEST_URI'], 'models.php') !== false || strpos($_SERVER['REQUEST_URI'], 'model-addedit.php') !== false) ? 'activemenu': '';?>" href="<?php echo $SITE_URL; ?>/admin/models.php">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-bus"></i></div>
                        Models
                    </a>
                    <a class="nav-link <?php echo (strpos($_SERVER['REQUEST_URI'], 'bodystyles.php') !== false || strpos($_SERVER['REQUEST_URI'], 'bodystyle-addedit.php') !== false) ? 'activemenu': '';?>" href="<?php echo $SITE_URL; ?>/admin/bodystyles.php">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-truck"></i></div>
                        Body Styles
                    </a>
                    <a class="nav-link <?php echo (strpos($_SERVER['REQUEST_URI'], 'customers.php') !== false || strpos($_SERVER['REQUEST_URI'], 'customers.php') !== false) ? 'activemenu': '';?>" href="<?php echo $SITE_URL; ?>/admin/customers.php">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-users"></i></div>
                        Customers
                    </a>
                    <a class="nav-link <?php echo (strpos($_SERVER['REQUEST_URI'], 'leads.php') !== false || strpos($_SERVER['REQUEST_URI'], 'leads-addedit.php') !== false) ? 'activemenu': '';?>" href="<?php echo $SITE_URL; ?>/admin/leads.php">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-book"></i></div>
                        Leads
                    </a>
                    <a class="nav-link <?php echo (strpos($_SERVER['REQUEST_URI'], 'settings.php') !== false) ? 'activemenu': '';?>" href="<?php echo $SITE_URL; ?>/admin/settings.php">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-gear"></i></div>
                        Settings
                    </a>
                </div>
            </div>
            <div class="logout-container">
                <a class="dropdown-item" href="<?php echo $SITE_URL; ?>/admin/logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
            </div>
        </nav>
    </div>
    <div id="layoutSidenav_content">