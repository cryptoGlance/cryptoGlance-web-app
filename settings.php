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

if (isset($_POST['general'])) {
    $updatesEnabled = ($_POST['update'] == 'on') ? 1 : 0;
    $hwErrorsEnabled = ($_POST['hwErrorsEnabled'] == 'on') ? 1 : 0;
    $data = array();
    $data = array(
        'update' => intval($updatesEnabled),
        'updateType' => $_POST['updateType'],
        'tempWarning' => intval($_POST['tempWarning']),
        'tempDanger' => intval($_POST['tempDanger']),
        'hwErrorsEnabled' => intval($hwErrorsEnabled),
        'hwWarning' => intval($_POST['hwWarning']),
        'hwDanger' => intval($_POST['hwDanger']),
        'rigUpdateTime' => intval($_POST['rigUpdateTime']),
        'poolUpdateTime' => intval($_POST['poolUpdateTime']),
        'walletUpdateTime' => intval($_POST['walletUpdateTime']),
    );
    
// not ready
//    if ($data['tempWarning'] <= 0) {
//        $errors['tempWarning'] = true;
//    }
//    if ($data['tempDanger'] <= 0 && $data['tempDanger'] <= $data['tempWarning']) {
//        $errors['tempDanger'] = true;
//    }
//    if ($data['hwWarning'] <= 0) {
//        $errors['hwWarning'] = true;
//    }
//    if ($data['hwDanger'] <= 0 && $data['hwDanger'] <= $data['hwWarning']) {
//        $errors['hwDanger'] = true;
//    }
//    if ($data['rigUpdateTime'] < 2) {
//        $errors['rigUpdateTime'] = true;
//    }
//    if ($data['poolUpdateTime'] < 120) {
//        $errors['poolUpdateTime'] = true;
//    }
//    if ($data['walletUpdateTime'] < 600) {
//        $errors['walletUpdateTime'] = true;
//    }
// end not ready
    
    $generalSaveResult = $cryptoGlance->saveSettings(array('general' => $data));
    $cryptoGlance = new CryptoGlance();
    $settings = $cryptoGlance->getSettings();
} else if (isset($_POST['email'])) {
    $data = array();
    
    // do stuff

    $emailSaveResult = $cryptoGlance->saveSettings(array('email' => $data));
}

$jsArray = array('settings');

require_once("includes/header.php");
?>
       
<!-- ### Below is the Settings page which contains common/site-wide preferences
      
-->
         
      <div id="settings-wrap" class="container sub-nav full-content">
        <div id="settings" class="panel panel-default panel-no-grid no-icon">
          <h1>Settings</h1>
          <div class="panel-heading">
              <h2 class="panel-title"><i class="icon icon-settingsandroid"></i> General</h2>
          </div>
          <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST">
              <fieldset>
                <h3>Temperature Thresholds:</h3>                
                <div class="form-group setting-thresholds setting-temperature">
                  <div class="setting-warning orange">
                    <input type="text" class="form-control" id="inputTempWarning" name="tempWarning" value="<?php echo $settings['general']['temps']['warning'] ?>" placeholder="<?php echo $settings['general']['temps']['warning'] ?>" maxlength="3">
                    <span>&deg;C</span>
                    <label for="inputTempWarning" class="control-label">Warning</label>
                  </div>
                  <div class="setting-danger red">
                    <input type="text" class="form-control" id="inputTempDanger" name="tempDanger" value="<?php echo $settings['general']['temps']['danger'] ?>" placeholder="<?php echo $settings['general']['temps']['danger'] ?>" maxlength="3">
                    <span>&deg;C</span>
                    <label for="inputTempDanger" class="control-label">Danger</label>
                  </div>
                </div>
                <span class="help-block"><i class="icon icon-info-sign"></i> Set the points where <span class="orange">warning</span> and <span class="red">danger</span> labels will appear (<span class="red">danger</span> must be greater than <span class="orange">warning</span>).</span>
                <h3>HW Error Thresholds:</h3>               
                <div class="form-group checkbox">
                  <label>
                    <input type="checkbox" name="hwErrorsEnabled" <?php echo ($settings['general']['hardwareErrors']['enabled']) ? 'checked' : '' ?>>
                    Enable Hardware Error Reporting
                  </label>
                </div>
                <div class="form-group setting-hwerror">
                  <div class="setting-hw-errors setting-thresholds">
                    <div class="setting-warning orange">
                      <input type="text" class="form-control" id="inputHWErrWarning" name="hwWarning" value="<?php echo $settings['general']['hardwareErrors']['warning'] ?>" placeholder="<?php echo $settings['general']['hardwareErrors']['warning'] ?>" maxlength="10">
                      <label for="inputHWErrWarning" class="control-label">Warning</label>
                    </div>
                    <div class="setting-danger red">
                      <input type="text" class="form-control" id="inputHWErrDanger" name="hwDanger" value="<?php echo $settings['general']['hardwareErrors']['danger'] ?>" placeholder="<?php echo $settings['general']['hardwareErrors']['danger'] ?>" maxlength="10">
                      <label for="inputHWErrDanger" class="control-label">Danger</label>
                    </div>
                  </div>
                  <span class="help-block"><i class="icon icon-info-sign"></i> Set the count of hardware errors that will trigger each status.</span>
                </div>
                <h3>Stat Refresh Intervals:</h3>                
                <div class="form-group">
                  <label class="col-sm-5 control-label">Rigs:</label>
                  <div class="col-sm-3 refresh-interval">
                    <select class="form-control" name="rigUpdateTime">
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
                <h3>App Updates:</h3>                
                <div class="form-group">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="update" <?php echo ($settings['general']['updates']['enabled']) ? 'checked' : '' ?>>
                      Enable cryptoGlance Updates
                    </label>
                  </div>
                </div>
                <div class="form-group app-update-types" style="display: <?php echo ($settings['general']['updates']['enabled']) ? 'block' : 'none' ?>;">
                  <span class="help-block"><i class="icon icon-info-sign"></i> Choose which type of updates you would like to be notified for:</span>
                  <div class="col-sm-4">
                    <label>
                      <input type="radio" name="updateType" value="release" <?php echo ($settings['general']['updates']['type'] == 'release') ? 'checked' : '' ?>>
                      Release
                    </label>
                    <span class="help-block">Stable builds suitable for every-day use</span>
                  </div>
                  <div class="col-sm-4">
                    <label>
                      <input type="radio" name="updateType" value="beta" <?php echo ($settings['general']['updates']['type'] == 'beta') ? 'checked' : '' ?>/>
                      Beta
                    </label>
                    <span class="help-block">New features and bug fixes, but not fully tested</span>
                  </div>
                  <div class="col-sm-4">
                    <label>
                      <input type="radio" name="updateType" value="nightly" <?php echo ($settings['general']['updates']['type'] == 'nightly') ? 'checked' : '' ?>>
                      Nightly
                    </label>
                    <span class="help-block">Bleeding-edge code updates, may contain bugs</span>
                  </div>
                </div>
                <div class="form-group"></div>
                <div class="form-group">
                  <div class="col-sm-12">
                    <button type="submit" name="general" value="general" class="btn btn-lg btn-success"><i class="icon icon-save-floppy"></i> Save General Settings</button>
                  </div>
                </div>
              </fieldset>
            </form>
            <br>
          </div>
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
