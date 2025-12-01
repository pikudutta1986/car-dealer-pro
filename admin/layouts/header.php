<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <link rel="icon" href="<?php echo $SITE_LOGO;?>" type="image/png">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title><?php echo $SITE_NAME;?> | Dashboard</title>
        <link href="<?php echo $SITE_URL; ?>/admin/assets/css/styles.css" rel="stylesheet" />
        <link href="<?php echo $SITE_URL; ?>/admin/assets/custom.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <script src="<?php echo $SITE_URL; ?>/theme-template/theme1/js/jquery-3.3.1.min.js"></script>
        <script>
        if (typeof window.jQuery === 'undefined') {
            var s = document.createElement('script');
            s.src = 'https://code.jquery.com/jquery-3.6.0.min.js';
            s.crossOrigin = 'anonymous';
            document.head.appendChild(s);
        }
        </script>
        <script src="<?php echo $SITE_URL; ?>/admin/assets/js/ckeditor.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
        <link href="<?php echo $SITE_URL; ?>/admin/assets/image-uploader.css" rel="stylesheet" />
        <!-- Form Validation Script -->
        <script src="<?php echo $SITE_URL; ?>/js/form-validation.js"></script>
    </head>
    <body class="sb-nav-fixed">
