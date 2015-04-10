<?php $currentPage = preg_replace('/\.php$/', '', basename($_SERVER['PHP_SELF'])); ?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="shortcut icon" href="favicon.png">

    <!-- TODO: ONLY show the total-hashrate in <title> when on index.php / Dashboard -->
    <title>
    <?php echo ($currentPage == 'index') ? 'Dashboard' : '' ?>
    <?php echo ($currentPage == 'settings') ? 'Settings' : '' ?>
    <?php echo ($currentPage == 'help') ? 'README.md' : '' ?>
    <?php echo ($currentPage == 'changelog') ? 'CHANGELOG.md' : '' ?>
    <?php echo ($currentPage == 'wallet') ? 'Wallet Details' : '' ?>
    <?php echo ($currentPage == 'rig') ? 'Rig Details' : '' ?>
    <?php echo ($currentPage == 'update') ? 'Updating cryptoGlance...' : '' ?>
    :: cryptoGlance</title>
    <!--build:css styles.css-->
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery Toast Message Plugin (https://github.com/akquinet/jquery-toastmessage-plugin) styles -->
    <link href="css/jquery.toastmessage.css" rel="stylesheet">
    <!-- jQuery Slider styles -->
    <link href="css/slider.css" rel="stylesheet">
    <!-- Glyph Icon Font from WebHostingHub (http://www.webhostinghub.com/glyphs/) styles -->
    <link href="css/whhg.css" rel="stylesheet">
    <!-- extend Bootstrap styles -->
    <link href="css/bootstrap-switch.min.css" rel="stylesheet">
    <!-- Custom cryptoGlance styles -->
    <link href="css/cryptoglance-base.css?v=<?php echo CURRENT_VERSION; ?>" rel="stylesheet">
    <!--/build-->

    <script type="text/javascript" src="js/packages/jquery-1.10.2.min.js?v=<?php echo CURRENT_VERSION; ?>"></script>
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <script type="text/javascript">
        var documentTitle = document.title;
        var DATA_FOLDER = '<?php echo DATA_FOLDER; ?>';
        var CURRENT_VERSION = '<?php echo CURRENT_VERSION?>';
        <?php if ($settings['general']['updates']['enabled'] == '1') {
            echo 'var updateType = "' . $updateFeed[$settings['general']['updates']['type']]['feed'] . '";';
        } ?>
        var rigUpdateTime = <?php echo $settings['general']['updateTimes']['rig'] ?>;
        var poolUpdateTime = <?php echo $settings['general']['updateTimes']['pool'] ?>;
        var walletUpdateTime = <?php echo $settings['general']['updateTimes']['wallet'] ?>;

        <?php if (isset($_SERVER['PHPDESKTOP_VERSION']) && floatval($_SERVER['PHPDESKTOP_VERSION']) < 31.9) { ?>
        $(document).ready(function() {
            $().toastmessage('showToast', {
              sticky  : true,
              text    : 'App Update!<br />There is a critical update for the Windows application. Please update your app to the latest version:<br /> <a href="http://sourceforge.net/projects/cryptoglance/files/latest/download?source=files" target="_blank" rel="external" style="word-wrap: break-word;">http://sourceforge.net/projects/cryptoglance/files/latest/download?source=files</a>',
              type    : 'error',
              position: 'top-center'
            });
        });
        <?php } ?>
    </script>
</head>
