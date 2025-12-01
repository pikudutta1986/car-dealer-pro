<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$socialLinks = $carsClassObject->getAllSocialLinks();
$socialLinks['fb_page_link'] = $socialLinks['fb_page_link'] ? $socialLinks['fb_page_link'] : '#';
$socialLinks['twitter_page_link'] = $socialLinks['twitter_page_link'] ? $socialLinks['twitter_page_link'] : '#';
$socialLinks['yt_page_link'] = $socialLinks['yt_page_link'] ? $socialLinks['yt_page_link'] : '#';
$socialLinks['insta_page_link'] = $socialLinks['insta_page_link'] ? $socialLinks['insta_page_link'] : '#';
$menupages = $pageClassObject->getAllMenuPages();
?>
<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="<?php echo $SITE_LOGO;?>" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $seoClassObject->meta_title;?></title>
    <meta name="description" content="<?php echo $seoClassObject->meta_description;?>">
    <meta name="keywords" content="<?php echo $seoClassObject->meta_keywords;?>">
    <?php echo $seoClassObject->schema;?>
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="<?php echo $SITE_URL?>/theme-template/theme1/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo $SITE_URL?>/theme-template/theme1/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo $SITE_URL?>/theme-template/theme1/css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="<?php echo $SITE_URL?>/theme-template/theme1/css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="<?php echo $SITE_URL?>/theme-template/theme1/css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="<?php echo $SITE_URL?>/theme-template/theme1/css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo $SITE_URL?>/theme-template/theme1/css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo $SITE_URL?>/theme-template/theme1/css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo $SITE_URL?>/theme-template/theme1/css/style.css" type="text/css">
    
</head>
<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Offcanvas Menu Begin -->
    <div class="offcanvas-menu-overlay"></div>
    <div class="offcanvas-menu-wrapper">
        <div class="offcanvas__logo">
            <a href="<?php echo $SITE_URL;?>"><img src="<?php echo $SITE_LOGO;?>" alt="<?php echo $SITE_NAME;?>"></a>
        </div>
        <div id="mobile-menu-wrap"></div>
        <ul class="offcanvas__widget__add">
            <li><i class="fa fa-envelope-o"></i> <?php echo $SITE_INFO['email'];?></li>
        </ul>
        <div class="offcanvas__phone__num">
            <i class="fa fa-phone"></i>
            <span><?php echo $SITE_INFO['phone'];?></span>
        </div>
        <div class="offcanvas__social">
            <a target="_blank" href="<?php echo $socialLinks['fb_page_link'];?>"><i class="fa fa-facebook"></i></a>
            <a target="_blank" href="<?php echo $socialLinks['twitter_page_link'];?>"><i class="fa fa-twitter"></i></a>
            <a target="_blank" href="<?php echo $socialLinks['yt_page_link'];?>"><i class="fa fa-youtube"></i></a>
            <a target="_blank" href="<?php echo $socialLinks['insta_page_link'];?>"><i class="fa fa-instagram"></i></a>
        </div>
    </div>
    <!-- Offcanvas Menu End -->

    <!-- Header Section Begin -->
    <header class="header">
        <div class="header__top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7">
                        <ul class="header__top__widget">
                            <li><i class="fa fa-envelope-o"></i> <?php echo $SITE_INFO['email'];?></li>
                        </ul>
                    </div>
                    <div class="col-lg-5">
                        <div class="header__top__right">
                            
                            <div class="header__top__phone">
                                <i class="fa fa-phone"></i>
                                <span><?php echo $SITE_INFO['phone'];?></span>
                            </div>
                            <div class="header__top__social">
                                <a target="_blank" href="<?php echo $socialLinks['fb_page_link'];?>"><i class="fa fa-facebook"></i></a>
                                <a target="_blank" href="<?php echo $socialLinks['twitter_page_link'];?>"><i class="fa fa-twitter"></i></a>
                                <a target="_blank" href="<?php echo $socialLinks['yt_page_link'];?>"><i class="fa fa-youtube"></i></a>
                                <a target="_blank" href="<?php echo $socialLinks['insta_page_link'];?>"><i class="fa fa-instagram"></i></a>
                            </div>
                            <?php 
                            // Check if agent is logged in
                            $agentLoggedIn = (isset($_SESSION['agent_id']) && $_SESSION['agent_id'] != '');
                            ?>
                            <div class="header__top__agent-btn">
                                <?php if ($agentLoggedIn): ?>
                                    <a href="<?php echo $SITE_URL;?>/agent/dashboard.php" class="site-btn">Dashboard</a>
                                <?php else: ?>
                                <a href="<?php echo $SITE_URL;?>/login" class="site-btn">LOGIN</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-2">
                    <div class="header__logo">
                        <a href="<?php echo $SITE_URL;?>"><img src="<?php echo $SITE_LOGO;?>" alt="<?php echo $SITE_NAME;?>"></a>
                    </div>
                </div>
                <div class="col-lg-10">
                    <div class="header__nav">
                        <nav class="header__menu">
                            <ul>
                                <li class="<?php echo ($_REQUEST['mod'] == 'home') ? 'active' : '';?>"><a href="<?php echo $SITE_URL;?>">Home</a></li>
                                <li class="<?php echo ($_REQUEST['mod'] == 'search') ? 'active' : '';?>"><a href="<?php echo $SITE_URL;?>/cars">Cars</a></li>
								<?php foreach($menupages as $item){?>
									<li class="<?php echo (isset($_REQUEST['slug']) && $_REQUEST['slug'] == $item['slug']) ? 'active' : '';?>"><a href="<?php echo $SITE_URL;?>/page/<?php echo $item['slug'];?>"><?php echo $item['title'];?></a></li>
								<?php } ?>
                                <li class="header__add-cars-btn">   
                                    <?php 
                                    // Check if agent is logged in
                                    $agentLoggedIn = (isset($_SESSION['agent_id']) && $_SESSION['agent_id'] != '');
                                    $addCarsLink = $agentLoggedIn ? $SITE_URL.'/agent/add-car.php' : $SITE_URL.'/register';
                                    ?>
                                    <a href="<?php echo $addCarsLink;?>" class="site-btn" style="padding: 10px 25px; font-size: 14px; text-decoration: none; margin-left: 10px;">Sell my car</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="canvas__open">
                <span class="fa fa-bars"></span>
            </div>
        </div>
    </header>
    <!-- Header Section End -->
    
<style>
.header__add-cars-btn {
    margin-left: 15px;
}

.header__add-cars-btn a.site-btn {
    display: inline-block;
    padding: 10px 25px !important;
    font-size: 14px !important;
    font-weight: 700;
    color: #ffffff !important;
    background: #db2d2e !important;
    border-radius: 2px;
    text-decoration: none !important;
    transition: background 0.3s ease;
    border: none;
}

.header__add-cars-btn a.site-btn:hover {
    background: #c02526 !important;
    color: #ffffff !important;
    text-decoration: none !important;
}

.header__menu ul li.header__add-cars-btn a:after {
    display: none !important;
}

.header__menu ul li.header__add-cars-btn.active a {
    background: #c02526 !important;
}

.header__top__agent-btn {
    display: inline-block;
}

.header__top__agent-btn a.site-btn {
    display: inline-block;
    padding: 3px 25px !important;
    font-size: 14px !important;
    font-weight: 700;
    color: #ffffff !important;
    background: #db2d2e !important;
    border-radius: 2px;
    text-decoration: none !important;
    transition: background 0.3s ease;
    border: none;
    margin-left: 15px;
}

.header__top__agent-btn a.site-btn:hover {
    background: #c02526 !important;
    color: #ffffff !important;
    text-decoration: none !important;
}
</style>
