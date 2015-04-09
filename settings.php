<?php
include('includes/inc.php');

if (!$_SESSION['login_string']) {
    header('Location: login.php');
    exit();
}

session_write_close();

$errors = array();
$generalSaveResult = null;
$emailSaveResult = null;

if (isset($_POST) && !empty($_POST)) {
    $updatesEnabled = ($_POST['update'] == 'on') ? 1 : 0;
    $mobileminerEnabled = ($_POST['mobileminer'] == 'on') ? 1 : 0;

    $data = array();
    $data = array(
        'update' => intval($updatesEnabled),
        'updateType' => $_POST['updateType'],
        'rigUpdateTime' => intval($_POST['rigUpdateTime']),
        'poolUpdateTime' => intval($_POST['poolUpdateTime']),
        'walletUpdateTime' => intval($_POST['walletUpdateTime']),
        'mobileminer' => intval($mobileminerEnabled),
        'mobileminerUsername' => $_POST['mobileminerUsername'],
        'mobileminerAppKey' => $_POST['mobileminerAppKey'],
    );

    $generalSaveResult = $cryptoGlance->saveSettings(array('general' => $data));
    $cryptoGlance = new CryptoGlance();
    $settings = $cryptoGlance->getSettings();
}

$jsArray = array('settings');

require_once("includes/header.php");
?>

      <div id="settings-wrap" class="container sub-nav full-content">
        <div id="settings" class="panel panel-default panel-no-grid no-icon">
          <h1>CryptoGlance Settings</h1>
          <div class="panel-heading">
              <h2 class="panel-title"><i class="icon icon-settingsandroid"></i> General</h2>
          </div>
          <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST">
              <fieldset>
                <div id="appUpdates">
                    <h3>App Updates:</h3>
                    <div class="form-group">
                      <div class="checkbox">
                        <input id="enableUpdates" type="checkbox" name="update" <?php echo ($settings['general']['updates']['enabled']) ? 'checked' : '' ?>>
                        <label for="enableUpdates">Enable cryptoGlance Updates</label>
                      </div>
                    </div>
                    <div class="form-group app-update-types" style="display: <?php echo ($settings['general']['updates']['enabled']) ? 'block' : 'none' ?>;">
                    <?php if ($settings['general']['updates']['enabled']) { ?>
                      <span class="help-block checkForUpdates" style="  margin: 0 0 10px 0;"><a href="#" onclick="versionCheck(true)" style="color: #33b5e5;"><i class="icon icon-uploadalt"></i> Check for updates now</a></span>
                    <?php } ?>
                      <span class="help-block"><i class="icon icon-info-sign"></i> Choose which type of updates you would like to be notified for:</span>
                      <div class="col-sm-4">
                        <label>
                          <input type="radio" name="updateType" value="release" <?php echo ($settings['general']['updates']['type'] == 'release') ? 'checked' : '' ?>> Release
                        </label>
                        <span class="help-block">Stable builds suitable for every-day use</span>
                      </div>
                      <div class="col-sm-4">
                        <label>
                          <input type="radio" name="updateType" value="beta" <?php echo ($settings['general']['updates']['type'] == 'beta') ? 'checked' : '' ?>/> Beta
                        </label>
                        <span class="help-block">New features and bug fixes, but not fully tested</span>
                      </div>
                      <div class="col-sm-4">
                        <label>
                          <input type="radio" name="updateType" value="nightly" <?php echo ($settings['general']['updates']['type'] == 'nightly') ? 'checked' : '' ?>> Nightly
                        </label>
                        <span class="help-block">Bleeding-edge code updates, may contain bugs</span>
                      </div>
                    </div>
                </div>
                <hr />
                <div id="updateIntervals">
                    <h3>Update Intervals:</h3>
                    <div class="form-group">
                      <label class="col-sm-5 control-label">Rigs:</label>
                      <div class="col-sm-3 refresh-interval">
                        <select class="form-control" name="rigUpdateTime">
                          <option <?php echo ($settings['general']['updateTimes']['rig'] == 1000) ? 'selected="selected"' : '' ?> value="1">1 second</option>
                          <option <?php echo ($settings['general']['updateTimes']['rig'] == 2000) ? 'selected="selected"' : '' ?> value="2">2 seconds</option>
                          <option <?php echo ($settings['general']['updateTimes']['rig'] == 3000) ? 'selected="selected"' : '' ?> value="3">3 seconds</option>
                          <option <?php echo ($settings['general']['updateTimes']['rig'] == 5000) ? 'selected="selected"' : '' ?> value="5">5 seconds</option>
                          <option <?php echo ($settings['general']['updateTimes']['rig'] == 7000) ? 'selected="selected"' : '' ?> value="3">7 seconds</option>
                          <option <?php echo ($settings['general']['updateTimes']['rig'] == 10000) ? 'selected="selected"' : '' ?> value="10">10 seconds</option>
                          <option <?php echo ($settings['general']['updateTimes']['rig'] == 15000) ? 'selected="selected"' : '' ?> value="15">15 seconds</option>
                          <option <?php echo ($settings['general']['updateTimes']['rig'] == 30000) ? 'selected="selected"' : '' ?> value="30">30 seconds</option>
                          <option <?php echo ($settings['general']['updateTimes']['rig'] == 60000) ? 'selected="selected"' : '' ?> value="60">1 minute</option>
                          <option <?php echo ($settings['general']['updateTimes']['rig'] == 120000) ? 'selected="selected"' : '' ?> value="120">2 minutes</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-5 control-label">Pools:</label>
                      <div class="col-sm-3 refresh-interval">
                        <select class="form-control" name="poolUpdateTime">
                          <option <?php echo ($settings['general']['updateTimes']['pool'] == 60000) ? 'selected="selected"' : '' ?> value="60">1 minute</option>
                          <option <?php echo ($settings['general']['updateTimes']['pool'] == 120000) ? 'selected="selected"' : '' ?> value="120">2 minutes</option>
                          <option <?php echo ($settings['general']['updateTimes']['pool'] == 300000) ? 'selected="selected"' : '' ?> value="300">5 minutes</option>
                          <option <?php echo ($settings['general']['updateTimes']['pool'] == 600000) ? 'selected="selected"' : '' ?> value="600">10 minutes</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-5 control-label">Wallets:</label>
                      <div class="col-sm-3 refresh-interval">
                        <select class="form-control" name="walletUpdateTime">
                          <option <?php echo ($settings['general']['updateTimes']['wallet'] == 300000) ? 'selected="selected"' : '' ?> value="300">5 minutes</option>
                          <option <?php echo ($settings['general']['updateTimes']['wallet'] == 600000) ? 'selected="selected"' : '' ?> value="600">10 minutes</option>
                          <option <?php echo ($settings['general']['updateTimes']['wallet'] == 1800000) ? 'selected="selected"' : '' ?> value="1800">30 minutes</option>
                          <option <?php echo ($settings['general']['updateTimes']['wallet'] == 2700000) ? 'selected="selected"' : '' ?> value="2700">45 minutes</option>
                          <option <?php echo ($settings['general']['updateTimes']['wallet'] == 3600000) ? 'selected="selected"' : '' ?> value="3600">1 hour</option>
                          <option <?php echo ($settings['general']['updateTimes']['wallet'] == 7200000) ? 'selected="selected"' : '' ?> value="7200">2 hours</option>
                        </select>
                      </div>
                    </div>
                </div>
                <hr />
                <div id="mobileMiner">
                    <h3>Mobile Miner:</h3>
                    <div class="form-group">
                      <div class="checkbox">
                        <input id="enableMobileMiner" type="checkbox" name="mobileminer" <?php echo ($settings['general']['mobileminer']['enabled']) ? 'checked' : '' ?>>
                        <label for="enableMobileMiner">Enable Mobile Miner Reporting</label>
                      </div>
                    </div>
                    <div class="form-group mobileminer-settings" style="display: <?php echo ($settings['general']['mobileminer']['enabled']) ? 'block' : 'none' ?>;">
                        <div class="form-group">
                          <label class="col-sm-5 control-label">Username:</label>
                          <div class="col-sm-4 refresh-interval">
                            <input type="text" class="form-control" name="mobileminerUsername" placeholder="your@email.com" value="<?php echo $settings['general']['mobileminer']['username']; ?>" />
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-5 control-label">App Key:</label>
                          <div class="col-sm-4 refresh-interval">
                            <input type="text" class="form-control" name="mobileminerAppKey" placeholder="xxxx-xxxx-xxxx" value="<?php echo $settings['general']['mobileminer']['appkey']; ?>" />
                          </div>
                        </div>
                    </div>
                </div>
                <hr />
                <div class="form-group">
                  <div class="col-sm-12">
                    <button type="submit" name="general" value="general" class="btn btn-lg btn-success"><i class="icon icon-save-floppy"></i> Save General Settings</button>
                  </div>
                </div>
              </fieldset>
            </form>
          </div>
        </div>

        <div id="cookies" class="panel panel-default panel-no-grid no-icon">
            <h1>Browser Settings</h1>
            <div class="panel-heading">
                <h2 class="panel-title"><i class="icon icon-settingsandroid"></i> Cookies</h2>
            </div>
          <div class="panel-body">
            <form class="form-horizontal" role="form">
              <fieldset>
                <div class="form-group">
                  <div class="col-sm-12">
                    <span class="help-block"><i class="icon icon-info-sign"></i> cryptoGlance cookies save preferences like panel width/positioning, and are safe to clear. Your important settings are always within the /user_data folder.<br><br><b>* YOU WILL BE LOGGED OUT AFTER CLEARING COOKIES!</b></span>
                    <button name="clearCookies" class="btn btn-lg btn-danger"><i class="icon icon-programclose"></i> Clear Cookies</button>
                  </div>
                </div>
              </fieldset>
            </form>
            <br>
          </div>
        </div>
      </div>
      <!-- /container -->

      <?php require_once("includes/footer.php"); ?>
      <!-- /page-container -->

      <?php require_once("includes/scripts.php"); ?>
   </body>
</html>
