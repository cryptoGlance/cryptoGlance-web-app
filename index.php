<?php
require_once('includes/inc.php');

if (!$_SESSION['login_string']) {
    header('Location: login.php');
    exit();
}
session_write_close();

$jsArray = array(
    'Util'
);
// NOTICE: Removed due to service shutting down
// If MobileMiner is enabled, load the JS
// if (isset($settings['general']['mobileminer']['enabled']) && $settings['general']['mobileminer']['enabled'] == 1) {
//     $jsArray[] = 'dashboard/MobileMiner';
// }

require_once("includes/header.php");

    if ($cryptoGlance->isNoPanels()) {
?>
    <div id="first-run-notice"><b>Start by adding a panel.</b><br>The Dashboard is comprised of a variety of panels, each showing a certain type of info.<span><a href="#add-panel" id="flash-add-panel"><button type="button" class="btn btn-lg btn-warning" data-type="all"><i class="icon icon-newtab"></i> Add Panel</button></a></span></div>
<?php } ?>
   <div id="dashboard-wrap" class="container sub-nav">
<?php

    /* Overview + Rigs */
    if ($cryptoGlance->isConfigAvailable('miners')) {
        // Load specific JS for this panel
        $jsArray[] = 'dashboard/rigs/RigCollection';
        $jsArray[] = 'dashboard/rigs/Rig';
        $jsArray[] = 'dashboard/rigs/DeviceCollection';
        $jsArray[] = 'dashboard/rigs/Device';
        $jsArray[] = 'dashboard/rigs';

        require_once("templates/modals/manage_rig.php");

        $overview = $cryptoGlance->getOverview();
        require_once("templates/panels/overview.php");

        // Miners
        foreach ($cryptoGlance->getMiners() as $minerId => $miner) {
            $minerId++; // Doing this because minerID 0 means all devices in ajax calls
            include("templates/panels/rig.php");
        }
        require_once("templates/modals/switch-pool.php");
    }

    if (true || $cryptoGlance->isConfigAvailable('messages')) {
    	// Load specific JS for this panel
    	$jsArray[] = 'dashboard/messages/Messages';
    	$jsArray[] = 'dashboard/messages';

    	$messages = $cryptoGlance->getMessages();
    	include("templates/panels/messages.php");
    }
    
    
    /* Pools */
    if ($cryptoGlance->isConfigAvailable('pools')) {
        // Load specific JS for this panel
        $jsArray[] = 'dashboard/pools/PoolCollection';
        $jsArray[] = 'dashboard/pools/Pool';
        $jsArray[] = 'dashboard/pools';

        foreach ($cryptoGlance->getPools() as $poolId => $pool) {
            $poolId++;
            include("templates/panels/pool.php");
        }
    }

    /* PoolPicker */
    if ($cryptoGlance->isConfigAvailable('poolpicker')) {
        // Load specific JS for this panel
        $jsArray[] = 'dashboard/PoolPicker';

        $poolPicker = $cryptoGlance->getPoolPicker();
        require_once("templates/panels/poolpicker.php");
    }

    /* Wallets */
      if ($cryptoGlance->isConfigAvailable('wallets')) {
          // Load specific JS for this panel
          $jsArray[] = 'dashboard/wallets/WalletCollection';
          $jsArray[] = 'dashboard/wallets/Wallet';
          $jsArray[] = 'dashboard/wallets';

          $wallet = $cryptoGlance->getWallets();
          require_once("templates/panels/wallet.php");
      }

    /* Misc Modals */
      if (count($cryptoGlance->getMiners()) > 0 || count($cryptoGlance->getPools()) > 0) {
          require_once("templates/modals/delete_prompt.php");
      }

      require_once("templates/modals/add_rig.php");
      require_once("templates/modals/add_pool.php");
      require_once("templates/modals/poolpicker.php");
?>
   </div>
   <!-- /container -->

<?php require_once("includes/footer.php"); ?>
   </div>
   <!-- /page-container -->

<?php
    // Load Last
    $jsArray[] = 'dashboard/script';
    require_once("includes/scripts.php");
?>
</body>
</html>
