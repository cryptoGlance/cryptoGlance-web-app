<?php
include('includes/inc.php');

if (!$_SESSION['login_string']) {
    header('Location: login.php');
    exit();
}

$rigId = intval($_GET['id']);
if ($rigId == 0) {
    header('Location: index.php');
    exit();
}

session_write_close();

$jsArray = array(
    'rig/script',
);

require_once('includes/autoloader.inc.php');
require_once("includes/header.php");

$cryptoGlance = new CryptoGlance();

$rigsObj = new Rigs($rigId);
$rigDevices = $rigsObj->getDevices();
$rigDevices = $rigDevices[0];
$rigPools = $rigsObj->getPools();
$rigPools = $rigPools[0];
$rigSettings = $rigsObj->getSettings();
$rigSettings = $rigSettings[0];

if (is_null($rigDevices)) {
    die('Rig is offline'); // this needs to be prettier.
}

?>
       
    <div id="rig-wrap" class="container sub-nav" data-rigId="<?php echo $rigId;?>">
        <div id="rigDetails" class="panel panel-default panel-no-grid">
            <h1>Rig Details</h1>
            <div class="panel-heading">
                <h2 class="panel-title"><i class="icon icon-detailsalt"></i></h2>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" role="form">
                    <fieldset>
                        <div class="form-group">
                            <label for="inputRigLabel" class="col-sm-5 control-label">Label</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="inputRigLabel" name="label" placeholder="Name of this rig" value="<?php echo $rigSettings['name'];?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputRigIP" class="col-sm-5 control-label">Hostname / IP</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="inputRigIP" name="ip_address" value="<?php echo $rigSettings['host'];?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputRigPort" class="col-sm-5 control-label">API Port</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="inputRigPort" maxLength="5" name="port" placeholder="4028" value="<?php echo $rigSettings['port'];?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputRigAlgor" class="col-sm-5 control-label">Algorithm</label>
                            <div class="col-sm-2">
                                <select class="form-control" id="inputRigAlgor" name="algorithm">
                                    <option value="sha256" <?php echo ($rigSettings['settings']['algorithm'] == 'sha256') ? 'selected' : '';?>>sha256</option>
                                    <option value="scrypt" <?php echo ($rigSettings['settings']['algorithm'] == 'scrypt') ? 'selected' : '';?>>scrypt</option>
                                    <option value="scrypt-n" <?php echo ($rigSettings['settings']['algorithm'] == 'scrypt-n') ? 'selected' : '';?>>scrypt-n</option>
                                    <option value="x11" <?php echo ($rigSettings['settings']['algorithm'] == 'x11') ? 'selected' : '';?>>x11</option>
                                </select>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <h3>Temperature Thresholds:</h3>      
                        <div class="form-group checkbox">
                            <label>
                                <input type="checkbox" name="temperatureEnabled" <?php echo ($rigSettings['settings']['temps']['enabled']) ? 'checked' : '' ?>> Enable Temperature Warnings
                            </label>
                        </div>
                        <div class="form-group setting-thresholds setting-temperature">
                            <div class="setting-warning orange">
                                <input type="text" class="form-control" id="inputTempWarning" name="tempWarning" value="<?php echo $rigSettings['settings']['temps']['warning'] ?>" placeholder="<?php echo $rigSettings['settings']['temps']['warning'] ?>" maxlength="3">
                                <span>&deg;C</span>
                                <label for="inputTempWarning" class="control-label">Warning</label>
                            </div>
                            <div class="setting-danger red">
                                <input type="text" class="form-control" id="inputTempDanger" name="tempDanger" value="<?php echo $rigSettings['settings']['temps']['danger'] ?>" placeholder="<?php echo $rigSettings['settings']['temps']['danger'] ?>" maxlength="3">
                                <span>&deg;C</span>
                                <label for="inputTempDanger" class="control-label">Danger</label>
                            </div>
                        </div>
                        <span class="help-block"><i class="icon icon-info-sign"></i> Set the points where <span class="orange">warning</span> and <span class="red">danger</span> labels will appear (<span class="red">danger</span> must be greater than <span class="orange">warning</span>).</span>
                        <h3>HW Error Thresholds:</h3>
                        <div class="form-group checkbox">
                            <label>
                                <input type="checkbox" name="hwErrorsEnabled" <?php echo ($rigSettings['settings']['hwErrors']['enabled']) ? 'checked' : '' ?>> Enable Hardware Error Warnings
                            </label>
                        </div>
                        <div class="form-group checkbox">
                            <label>
                                <input type="checkbox" name="hwErrorsEnabled" <?php echo ($rigSettings['settings']['hwErrors']['type'] == 'percent') ? 'checked' : '' ?>> Percent
                            </label>&nbsp;&nbsp;&nbsp;
                            <label>
                                <input type="checkbox" name="hwErrorsEnabled" <?php echo ($rigSettings['settings']['hwErrors']['type'] == 'int') ? 'checked' : '' ?>> Number
                            </label>
                        </div>
                        <div class="form-group setting-hwerror hwErrorInt">
                            <div class="setting-hw-errors setting-thresholds">
                                <div class="setting-warning orange">
                                    <input type="text" class="form-control" id="inputHWErrWarning" name="hwWarning" value="<?php echo $rigSettings['settings']['hwErrors']['warning']['int'] ?>" placeholder="<?php echo $rigSettings['settings']['hwErrors']['warning']['int'] ?>">
                                    <label for="inputHWErrWarning" class="control-label">Warning</label>
                                </div>
                                <div class="setting-danger red">
                                    <input type="text" class="form-control" id="inputHWErrDanger" name="hwDanger" value="<?php echo $rigSettings['settings']['hwErrors']['danger']['int'] ?>" placeholder="<?php echo $rigSettings['settings']['hwErrors']['danger']['int'] ?>">
                                    <label for="inputHWErrDanger" class="control-label">Danger</label>
                                </div>
                            </div>
                            <span class="help-block"><i class="icon icon-info-sign"></i> Set the count of hardware errors that will trigger each status.</span>
                        </div>
                        <div class="form-group setting-hwerror hwErrorPercent">
                            <div class="setting-hw-errors setting-thresholds">
                                <div class="setting-warning orange">
                                    <input type="text" class="form-control" id="inputHWErrWarning" name="hwWarning" value="<?php echo $rigSettings['settings']['hwErrors']['warning']['percent'] ?>%" placeholder="<?php echo $rigSettings['settings']['hwErrors']['warning']['percent'] ?>%">
                                    <label for="inputHWErrWarning" class="control-label">Warning</label>
                                </div>
                                <div class="setting-danger red">
                                    <input type="text" class="form-control" id="inputHWErrDanger" name="hwDanger" value="<?php echo $rigSettings['settings']['hwErrors']['danger']['percent'] ?>%" placeholder="<?php echo $rigSettings['settings']['hwErrors']['danger']['percent'] ?>%">
                                    <label for="inputHWErrDanger" class="control-label">Danger</label>
                                </div>
                            </div>
                            <span class="help-block"><i class="icon icon-info-sign"></i> Set the percent of hardware errors that will trigger each status.</span>
                        </div>
                    </fieldset>
                    <button type="button" class="btn btn-lg btn-success" id="btnSaveRig"><i class="icon icon-save-floppy"></i> Save Rig Details</button>
                    <br /><br />
                </form>
            </div>
        </div>
        
        <div id="rigDeviceDetails" class="panel panel-primary panel-no-grid panel-rig">
            <h1><?php echo (!empty($rigSettings['name']) ? $rigSettings['name'] : $rigSettings['host'].':'.$rigSettings['port']); ?></h1>
            <div class="panel-heading">
                <h2 class="panel-title"><?php echo $rigDevices[0]['type']; ?> Settings<i class="icon icon-pixelpickaxe"></i></h2>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <form role="form">
                        <table class="table table-hover table-striped table-devices">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Device</th>
                                    <th>Enabled</th>
                                    <th>Hashrate (5s)</th>
                                <?php if ($rigDevices[0]['type'] == 'GPU') { ?>
                                    <th>Temperature</th>
                                    <th>Intensity</th>
                                    <th>Fan Percent</th>
                                    <th>Engine Clock</th>
                                    <th>Memory Clock</th>
                                    <th>Voltage</th>
                                    <th>Powertune</th>
                                <?php } else if ($rigDevices[0]['type'] == 'ASC' || $rigDevices[0]['type'] == 'PGA') { ?>
                                    <th>Frequency</th>
                                <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($rigDevices as $dev) {
                            ?>
                                <tr data-devType="<?php echo $dev['type']; ?>" data-devId="<?php echo $dev['id']; ?>" data-icon="<?php echo $dev['status']['icon']; ?>" data-status="<?php echo $dev['status']['colour']; ?>">
                                  <td><i class="icon icon-<?php echo $dev['status']['icon']; ?> <?php echo $dev['status']['colour']; ?>"></i></td>
                                  <td class="<?php echo $dev['status']['colour']; ?>"><?php echo $dev['type'] . $dev['id']; ?></td>
                                  <td><input type="checkbox" class="enableDev" name="enabledDev<?php echo $dev['id']; ?>" <?php echo (strtolower($dev['enabled']) == 'y' ? 'checked' : ''); ?> /></td>
                                  <td><?php echo $dev['hashrate_5s']; ?></td>
                                  <?php if ($dev['type'] == 'GPU') { ?>
                                  <td><?php echo $dev['temperature_c'] . '<span>&deg;C</span>/' . $dev['temperature_f'] . '<span>&deg;F</span>'; ?></td>
                                  <td><input type="text" class="form-control" value="<?php echo $dev['intensity']; ?>" /></td>
                                  <td><input type="text" class="form-control" value="<?php echo $dev['fan_percent']; ?>" /></td>
                                  <td><input type="text" class="form-control" value="<?php echo $dev['engine_clock']; ?>" /></td>
                                  <td><input type="text" class="form-control" value="<?php echo $dev['memory_clock']; ?>" /></td>
                                  <td><input type="text" class="form-control" value="<?php echo $dev['gpu_voltage']; ?>" /></td>
                                  <td><input type="text" class="form-control" value="<?php echo $dev['powertune']; ?>" /></td>
                                  <?php } else if ($dev['type'] == 'ASC' || $dev['type'] == 'PGA') { ?>
                                  <td><input type="text" class="form-control" value="<?php echo $dev['frequency']; ?>" /></td>
                                  <?php } ?>
                                </tr>
                            <?php
                            }
                            ?>
                            </tbody>
                        </table>
                        
                        <!-- TODO: Remove the 'disabled' state on the revert button below once the user has changed ANY value in the table above -->
                        <div class="inline-edit-control">
                          <button type="button" disabled class="btn btn-warning btn-space" id="btnRevertDevices"><i class="icon icon-undo"></i> Revert Changes</button> &nbsp; 
                          <button type="button" class="btn btn-success btn-space" id="btnSaveDevices"><i class="icon icon-save-floppy"></i> Save Device Settings</button> 
                        </div>
                    </form>
                </div>
            </div><!-- / .panel-body -->
        </div>
        
        <div id="rigPoolDetails" class="panel panel-default panel-no-grid">
            <h1>Available Pools</h1>
            <div class="panel-heading">
                <h2 class="panel-title"><i class="icon icon-communitysmall"></i></h2>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" role="form">
                
                  <!-- TODO: Replace with same output as switch-pool-modal -->
                  <table class="table table-hover table-striped table-devices">
                        <thead>
                            <tr>
                                <th>Active</th>
                                <th>Name</th>
                                <th>Pool URL</th>
                                <th>Worker</th>
                                <th>Password</th>
                                <th>Priority</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($rigPools as $pool) {
                        ?>
                            <tr data-poolId="<?php echo $pool['id']; ?>">
                              <td><input type="radio" name="enabledPool" class="form-control"  <?php echo ($pool['active'] == 1) ? 'checked' : ''; ?> /></td>
                              <td>---</td>
                              <td><?php echo $pool['url']; ?></td>
                              <td><?php echo $pool['user']; ?></td>
                              <td>********</td>
                              <td class="priority"><?php echo $pool['priority']; ?></td>
                              <td><a href="#editPoolConfig" class="editPoolConfig"><span class="green"><i class="icon icon-edit"></i></span></a> &nbsp; <a href="#removePoolConfig" class="removePoolConfig"><span class="red"><i class="icon icon-remove"></i></span></a>
                              <br>
                              </td>
                            </tr>
                        <?php } ?>
<!--                            <tr>-->
<!--                              <td><input type="radio" name="gpu-enabled" class="form-control" /></td>-->
<!--                              <td><input type="text" class="form-control" value="EDITING EXAMPLE" /></td>-->
<!--                              <td><input type="text" class="form-control" value="scrypt.pool.url:3333" /></td>-->
<!--                              <td><input type="text" class="form-control" value="scar45.worker" /></td>-->
<!--                              <td><input type="text" class="form-control" value="password" /></td>-->
<!--                              <td><input type="text" class="form-control" maxlength="3" value="3" style="width: 50px;" /></td>-->
<!--                              <td><a href="#editPoolConfig" class="editPoolConfig"><span title="Save this pool" class="blue"><i class="icon icon-save-floppy"></i></span></a> &nbsp; <a href="#removePoolConfig" class="removePoolConfig"><span title="Cancel changes" class="orange"><i class="icon icon-undo"></i></span></a>-->
<!--                              <br>-->
<!--                              </td>-->
<!--                            </tr>-->
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-primary btn-space" id="btnAddPool"><i class="icon icon-plus-sign"></i> Add New Pool</button>
                    <div id="addNewPool" class="add-new-wrapper">
                      <h3>Add a new pool:</h3>                
                      <div class="form-group">
                        <label for="inputPoolLabel" class="col-sm-5 control-label">Pool Label</label>
                        <div class="col-sm-5">
                          <input type="text" class="form-control poolLabel" name="poolLabel" placeholder="Name of this pool">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputPoolURL" class="col-sm-5 control-label">URL</label>
                        <div class="col-sm-5">
                          <input type="text" class="form-control poolUrl" name="poolUrl" placeholder="Pool URL (including port #)">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputPoolWorker" class="col-sm-5 control-label">Username/Worker</label>
                        <div class="col-sm-4">
                          <input type="text" class="form-control poolUser" name="poolUser">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputPoolPassword" class="col-sm-5 control-label">Password</label>
                        <div class="col-sm-4">
                          <input type="password" class="form-control poolPassword" name="poolPassword" placeholder="password">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputPoolPriority" class="col-sm-5 control-label">Priority</label>
                        <div class="col-sm-2">
                          <input type="text" class="form-control poolPriority" maxlength="3" name="poolPriority">
                        </div>
                      </div>
                      <button type="button" class="btn btn-lg btn-primary" id="btnCancelPool"><i class="icon icon-undo"></i> Cancel</button>
                      <button type="button" class="btn btn-lg btn-success" id="btnSavePool"><i class="icon icon-save-floppy"></i> Save New Pool</button>
                      <br>
                      <br>
                    </div><!-- end add-new-pool-wrapper -->
                </form>
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