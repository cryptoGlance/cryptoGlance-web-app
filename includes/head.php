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
    <?php echo ($currentPage == 'wallet') ? 'Wallet Details' : '' ?>
    <?php echo ($currentPage == 'rig') ? 'Rig Details' : '' ?>
    <?php echo ($currentPage == 'update') ? 'Updating cryptoGlance...' : '' ?>
    :: cryptoGlance</title>
    
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
    <link href="css/cryptoglance-base.css" rel="stylesheet">
      
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    
    <?php
    $settings = $cryptoGlance->getSettings();
    ?>

    <script type="text/javascript">
        var documentTitle = document.title;
        var DATA_FOLDER = '<?php echo DATA_FOLDER; ?>';
        var CURRENT_VERSION = '<?php echo CURRENT_VERSION?>';
        <?php echo ($settings['general']['updates']['enabled'] == '1') ? 'var updateType = "' . $updateFeed[$settings['general']['updates']['type']]['feed'] . '";' : '' ?>
        var devHeatWarning = <?php echo (!empty($settings['general']['temps']['warning']) ? $settings['general']['temps']['warning'] : 75) ?>;
        var devHeatDanger = <?php echo (!empty($settings['general']['temps']['danger']) ? $settings['general']['temps']['danger'] : 85) ?>;
        var devHWWarning = <?php echo (!empty($settings['general']['hardwareErrors']['warning']) ? $settings['general']['hardwareErrors']['warning'] : 3) ?>;
        var devHWDanger = <?php echo (!empty($settings['general']['hardwareErrors']['danger']) ? $settings['general']['hardwareErrors']['danger'] : 10) ?>;
        var rigUpdateTime = <?php echo (!empty($settings['general']['updateTimes']['rig']) ? $settings['general']['updateTimes']['rig'] : 3000) ?>;
        var poolUpdateTime = <?php echo (!empty($settings['general']['updateTimes']['pool']) ? $settings['general']['updateTimes']['pool'] : 120000) ?>;
        var walletUpdateTime = <?php echo (!empty($settings['general']['updateTimes']['wallet']) ? $settings['general']['updateTimes']['wallet'] : 600000) ?>;
    </script>     
</head>