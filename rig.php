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
$rigSettings = $rigsObj->getSettings();

//$rigData['config'] = $cryptoGlance->getMiners($rigId);
if (is_null($rigData)) {
    die('Rig is offline'); // this needs to be prettier.
}

?>
       
    <div id="rig-wrap" class="container sub-nav" data-rigId="<?php echo $rigId;?>">
    <?php
        foreach($rigDevices[0] as $devType => $devs) {
    ?>
        <div id="rigDeviceDetails" class="panel panel-primary panel-no-grid panel-rig">
            <h1><?php echo (!empty($rigData['config']['name']) ? $rigData['config']['name'] : $rigData['config']['host']); ?></h1>
            <div class="panel-heading">
                <h2 class="panel-title"><?php echo $devType; ?> Settings<i class="icon icon-pixelpickaxe"></i></h2>
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
                                <?php if ($devType == 'GPU') { ?>
                                    <th>Temperature</th>
                                    <th>Intensity</th>
                                    <th>Fan Percent</th>
                                    <th>Engine Clock</th>
                                    <th>Memory Clock</th>
                                    <th>Voltage</th>
                                    <th>Powertune</th>
                                <?php } else if ($devType == 'ASC') { ?>
                                    <th>Frequency</th>
                                <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($devs as $dev) {
                                $status = 'green'; // alive
                                $icon = 'cpu-processor';
                                if ($dev['enabled'] == 'N') {
                                    $status = 'grey';
                                    $icon = 'ban-circle';
                                } else if ($dev['health'] == 'Dead') {
                                    $status = 'red';
                                    $icon = 'danger';
                                } else if ($dev['health'] == 'Sick') {
                                    $status = 'orange';
                                    $icon = 'warning-sign';
                                } else if ($dev['health'] == 'Hot') {
                                    $status = 'red';
                                    $icon = 'hot';
                                } else if ($dev['health'] == 'Warm') {
                                    $status = 'orange';
                                    $icon = 'fire';
                                }
                            ?>
                                <tr data-devType="<?php echo $devType; ?>" data-devId="<?php echo $dev['id']; ?>" data-icon="<?php echo $icon; ?>" data-status="<?php echo $status; ?>">
                                  <td><i class="icon icon-<?php echo $icon; ?> <?php echo $status; ?>"></i></td>
                                  <td class="<?php echo $status; ?>"><?php echo $devType . $dev['id']; ?></td>
                                  <td><input type="checkbox" class="enableDev" name="enabledDev<?php echo $dev['id']; ?>" <?php echo (strtolower($dev['enabled']) == 'y' ? 'checked' : ''); ?> /></td>
                                  <td><?php
                                    if ($dev['hashrate_5s'] < 1) {
                                        $dev['hashrate_5s'] = ($dev['hashrate_5s']*1000) . ' KH/S';
                                    } else if (v > 1000) {
                                        $dev['hashrate_5s'] = floatval($dev['hashrate_5s']/1000).round(2) . ' GH/S';
                                    } else {
                                        $dev['hashrate_5s'] = $dev['hashrate_5s'] . ' MH/S';
                                    }
                                    
                                    echo $dev['hashrate_5s'];
                                  ?></td>
                                  <?php if ($devType == 'GPU') { ?>
                                  <td><?php echo (!empty($dev['temperature']) ? $dev['temperature'] . '&deg;C' : '--'); ?></td>
                                  <td><input type="text" class="form-control" value="<?php echo $dev['intensity']; ?>" /></td>
                                  <td><input type="text" class="form-control" value="<?php echo $dev['fan_percent']; ?>" /></td>
                                  <td><input type="text" class="form-control" value="<?php echo $dev['engine_clock']; ?>" /></td>
                                  <td><input type="text" class="form-control" value="<?php echo $dev['memory_clock']; ?>" /></td>
                                  <td><input type="text" class="form-control" value="<?php echo $dev['gpu_voltage']; ?>" /></td>
                                  <td><input type="text" class="form-control" value="<?php echo $dev['powertune']; ?>" /></td>
                                  <?php } else if ($devType == 'ASC') { ?>
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
        <?php
        }
        ?>
        
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
                        foreach ($rigData['pools'] as $pool) {
                            if ($rigData['active_pool']['id'] == $pool['POOL']) {
                                $active = true;
                            } else {
                                $active = false;
                            }
                        ?>
                            <tr data-poolId="<?php echo $pool['POOL']; ?>">
                              <td><input type="radio" name="enabledPool" class="form-control"  <?php echo ($active) ? 'checked' : ''; ?> /></td>
                              <td>---</td>
                              <td><?php echo $pool['URL']; ?></td>
                              <td><?php echo $pool['User']; ?></td>
                              <td>********</td>
                              <td class="priority"><?php echo $pool['Priority']; ?></td>
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
        
        <div id="rigDetails" class="panel panel-default panel-no-grid">
            <h1>Rig Details</h1>
            <div class="panel-heading">
                <h2 class="panel-title"><i class="icon icon-detailsalt"></i></h2>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" role="form">
                  <div class="form-group">
                    <label for="inputRigLabel" class="col-sm-5 control-label">Label</label>
                    <div class="col-sm-5">
                      <input type="text" class="form-control" id="inputRigLabel" name="label" placeholder="Name of this rig">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputRigIP" class="col-sm-5 control-label">Hostname / IP</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" id="inputRigIP" name="ip_address">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputRigPort" class="col-sm-5 control-label">API Port</label>
                    <div class="col-sm-2">
                      <input type="text" class="form-control" id="inputRigPort" maxLength="5" name="port" placeholder="4028">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputRigHashrate" class="col-sm-5 control-label">Desired Hashrate <small>(MH/s)</small></label>
                    <div class="col-sm-2">
                      <input type="text" class="form-control" id="inputRigHashrate" maxLength="5">
                    </div>
                  </div>
                   <button type="button" class="btn btn-lg btn-success" id="btnSaveRig"><i class="icon icon-save-floppy"></i> Save Rig Details</button>
                    <br>
                    <br>
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