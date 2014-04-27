<?php
include('includes/inc.php');

if (!$_SESSION['login_string']) {
    header('Location: login.php');
    exit();
}

$jsArray = array();
require_once("includes/header.php");
require_once('includes/autoloader.inc.php');
require_once('includes/cryptoglance.php');
$cryptoGlance = new CryptoGlance();

?>
       
    <div id="auto-update-wrap" class="container sub-nav">
        <div id="AutoUpdate" class="panel panel-primary panel-no-grid panel-auto-update">
            <h1>Auto-Updater</h1>
            <div class="panel-heading">
                <h2 class="panel-title"><i class="icon icon-refresh"></i></h2>
            </div>
            <div class="panel-body">
              <div class="stat-pair">
                <div class="stat-label">
                  <h3>Update Available!</h3>
                  <p>The version of cryptoGlance that you're running <span class="orange">(<?php echo CURRENT_VERSION ?>)</span> can be updated to <span class="green">vTAG.NAME</span>.</p>
                  <p>It is advised that you backup your <span class="blue">/<?php echo DATA_FOLDER; ?></span> folder prior to running the update process.</p>
                  <button type="button" class="btn btn-primary" id="btn-update-process"><i class="icon icon-restart"></i> Start Update Process</button>
                  <pre style="display: none">
==> Starting
==> Target_url: https://github.com/cryptoGlance/cryptoGlance-web-app/archive/development.zip
==> Headers stripped out
==> Downloaded file: https://github.com/cryptoGlance/cryptoGlancecryptoGlance/cryptoGlancecryptoGlance/cryptoGlance-web-app/archive/development.zip
==> Saved as file: downloads/update.zip
==> About to unzip ...
==> Unzipped file to: downloads/update
                  </pre>
                </div>
              </div>
            </div>
        </div>
    </div>
      <!-- /container -->

      <?php require_once("includes/footer.php"); ?>
      </div>
      <!-- /page-container -->
      
      <?php require_once("includes/scripts.php"); ?>
   </body>
</html>