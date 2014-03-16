<?php
include('includes/inc.php');

if (!$_SESSION['login_string']) {
    header('Location: login.php');
    exit();
}

require_once('includes/cryptoglance.php');
$cryptoGlance = new CryptoGlance();

$jsArray = array(
    'ajax',
    'rigs',
    'pools',
    'wallets',
);

include("includes/header.php");
?>
         
   <div id="dashboard-wrap" class="container sub-nav">
   
    <?php
    
    // Overview
    if (count($cryptoGlance->getMiners()) > 0) {
        include("templates/panel-overview.php");
    
        // Miners
        foreach ($cryptoGlance->getMiners() as $minerId => $miner) {
            $minerId++; // Doing this because minerID 0 means all devices in ajax calls
            include("templates/panel-rig.php");
        }
        include("templates/modals/switch-pool.php");
        include("templates/modals/add_rig.php");
    }
   
    ?>

      <?php
      foreach ($cryptoGlance->getPools() as $poolId => $pool) {
        $poolId++;
        include("templates/panel-pool.php");
      }
      ?>

      <?php //require_once("templates/panel-news_feed.php"); ?>
      
      <?php //require_once("templates/panel-subreddit_feed.php"); ?>
                           
      <?php //require_once("templates/panel-coinwatcher.php"); ?>

      <?php
      if (count($cryptoGlance->getWallets()) > 0) {
        include("templates/panel-wallet.php");
      }
      ?>
      
   </div>
   <!-- /container -->

   <?php require_once("includes/footer.php"); ?>
   </div>
   <!-- /page-container -->


<?php //require_once("templates/modals/switch_pool.php"); ?>

<?php //require_once("templates/modals/delete_prompt.php"); ?>

    <?php require_once("includes/scripts.php"); ?>
</body>
</html>
