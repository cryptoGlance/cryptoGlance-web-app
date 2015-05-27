<?php
include('includes/inc.php');

if (!$_SESSION['login_string']) {
    header('Location: login.php');
    exit();
}
session_write_close();

$jsArray = array(
    'Util',
    'dashboard/RigCollection',
    'dashboard/Rig',
    'dashboard/DeviceCollection',
    'dashboard/Device',
    'dashboard/PoolCollection',
    'dashboard/Pool',
    'dashboard/WalletCollection',
    'dashboard/Wallet'
);
// If MobileMiner is enabled, load the JS
if (isset($settings['general']['mobileminer']['enabled']) && $settings['general']['mobileminer']['enabled'] == 1) {
    $jsArray[] = 'dashboard/MobileMiner';
}

// Load Last
$jsArray[] = 'dashboard/script';

include("includes/header.php");
?>


    <?php if (count($cryptoGlance->getMiners()) == 0 && count($cryptoGlance->getPools()) == 0 && count($cryptoGlance->getWallets()) == 0) { ?>
    <div id="first-run-notice"><b>Start by adding a panel.</b><br>The Dashboard is comprised of a variety of panels, each showing a certain type of info.<span><a href="#add-panel" id="flash-add-panel"><button type="button" class="btn btn-lg btn-warning" data-type="all"><i class="icon icon-newtab"></i> Add Panel</button></a></span></div>
    <?php } ?>
   <div id="dashboard-wrap" class="container sub-nav">
    <?php
    // Overview
    if (count($cryptoGlance->getMiners()) > 0) {
        include("templates/modals/manage_rig.php");

        include("templates/panels/overview.php");

        // Miners
        foreach ($cryptoGlance->getMiners() as $minerId => $miner) {
            $minerId++; // Doing this because minerID 0 means all devices in ajax calls
            include("templates/panels/rig.php");
        }
        include("templates/modals/switch-pool.php");
    }
    ?>

      <?php
      foreach ($cryptoGlance->getPools() as $poolId => $pool) {
        $poolId++;
        include("templates/panels/pool.php");
      }
      ?>

      <?php //require_once("templates/panels/news_feed.php"); ?>

      <?php //require_once("templates/panels/subreddit_feed.php"); ?>

      <?php //require_once("templates/panels/coinwatcher.php"); ?>

      <?php
      if (count($cryptoGlance->getWallets()) > 0) {
        include("templates/panels/wallet.php");
      }

      if (count($cryptoGlance->getMiners()) > 0 || count($cryptoGlance->getPools()) > 0) {
        include("templates/modals/delete_prompt.php");
      }

        include("templates/modals/add_rig.php");
        include("templates/modals/add_pool.php");
      ?>

   </div>
   <!-- /container -->

   <?php require_once("includes/footer.php"); ?>
   </div>
   <!-- /page-container -->

    <?php require_once("includes/scripts.php"); ?>
</body>
</html>
