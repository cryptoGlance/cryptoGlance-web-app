<?php
include('includes/inc.php');

if (!$_SESSION['login_string']) {
    header('Location: login.php');
    exit();
}

session_write_close();

$jsArray = array();
require_once("includes/header.php");
require_once('includes/autoloader.inc.php');
require_once('includes/cryptoglance.php');
$cryptoGlance = new CryptoGlance();

?>
       
    <div id="rig-wrap" class="container sub-nav">
        <div id="rigDetails" class="panel panel-primary panel-no-grid panel-rig">
            <h1>{{ RIG_NAME }}</h1>
            <div class="panel-heading">
                <h2 class="panel-title">Device Settings<i class="icon icon-pixelpickaxe"></i></h2>
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
                                    <th>Temperature</th>
                                    <th>Intensity</th>
                                    <th>Fan Percent</th>
                                    <th>Engine Clock</th>
                                    <th>Memory Clock</th>
                                    <th>Voltage</th>
                                    <th>Powertune</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                  <td><i class="icon icon-cpu-processor green"></i></td>
                                  <td>gpu1</td>
                                  <td><input type="checkbox" /></td>
                                  <td>420 kh/s</td>
                                  <td>69&deg;C</td>
                                  <td><input type="text" class="form-control" value="17" /></td>
                                  <td><input type="text" class="form-control" value="70" /></td>
                                  <td><input type="text" class="form-control" value="1080" /></td>
                                  <td><input type="text" class="form-control" value="1350" /></td>
                                  <td><input type="text" class="form-control" value="1.175" /></td>
                                  <td><input type="text" class="form-control" value="+20" /></td>
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
                            <tr>
                              <td><input type="radio" name="gpu-enabled" class="form-control" /></td>
                              <td>Example Pool Label</td>
                              <td>scrypt.pool.url:3333</td>
                              <td>scar45.worker</td>
                              <td>password</td>
                              <td>3</td>
                              <td><a href="#editPoolConfig" class="editPoolConfig"><span class="green"><i class="icon icon-edit"></i></span></a> &nbsp; <a href="#removePoolConfig" class="removePoolConfig"><span class="red"><i class="icon icon-remove"></i></span></a>
                              <br>
                              </td>
                            </tr>
                            <tr>
                              <td><input type="radio" name="gpu-enabled" class="form-control" /></td>
                              <td>Example Pool Label</td>
                              <td>scrypt.pool.url:3333</td>
                              <td>scar45.worker</td>
                              <td>password</td>
                              <td>3</td>
                              <td><a href="#editPoolConfig" class="editPoolConfig"><span class="green"><i class="icon icon-edit"></i></span></a> &nbsp; <a href="#removePoolConfig" class="removePoolConfig"><span class="red"><i class="icon icon-remove"></i></span></a>
                              <br>
                              </td>
                            </tr>
                            <tr>
                              <td><input type="radio" name="gpu-enabled" class="form-control" /></td>
                              <td>Example Pool Label</td>
                              <td>scrypt.pool.url:3333</td>
                              <td>scar45.worker</td>
                              <td>password</td>
                              <td>3</td>
                              <td><a href="#editPoolConfig" class="editPoolConfig"><span class="green"><i class="icon icon-edit"></i></span></a> &nbsp; <a href="#removePoolConfig" class="removePoolConfig"><span class="red"><i class="icon icon-remove"></i></span></a>
                              <br>
                              </td>
                            </tr>
                            <tr>
                              <td><input type="radio" name="gpu-enabled" class="form-control" /></td>
                              <td><input type="text" class="form-control" value="EDITING EXAMPLE" /></td>
                              <td><input type="text" class="form-control" value="scrypt.pool.url:3333" /></td>
                              <td><input type="text" class="form-control" value="scar45.worker" /></td>
                              <td><input type="text" class="form-control" value="password" /></td>
                              <td><input type="text" class="form-control" maxlength="3" value="3" style="width: 50px;" /></td>
                              <td><a href="#editPoolConfig" class="editPoolConfig"><span title="Save this pool" class="blue"><i class="icon icon-save-floppy"></i></span></a> &nbsp; <a href="#removePoolConfig" class="removePoolConfig"><span title="Cancel changes" class="orange"><i class="icon icon-undo"></i></span></a>
                              <br>
                              </td>
                            </tr>
                            <tr>
                              <td><input type="radio" name="gpu-enabled" class="form-control" /></td>
                              <td>Example Pool Label</td>
                              <td>scrypt.pool.url:3333</td>
                              <td>scar45.worker</td>
                              <td>password</td>
                              <td>3</td>
                              <td><a href="#editPoolConfig" class="editPoolConfig"><span class="green"><i class="icon icon-edit"></i></span></a> &nbsp; <a href="#removePoolConfig" class="removePoolConfig"><span class="red"><i class="icon icon-remove"></i></span></a>
                              <br>
                              </td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-primary btn-space" id="btnAddPool"><i class="icon icon-plus-sign"></i> Add New Pool</button>
                    <div class="add-new-wrapper">
                      <h3>Add a new pool:</h3>                
                      <div class="form-group">
                        <label for="inputPoolLabel" class="col-sm-5 control-label">Pool Label</label>
                        <div class="col-sm-5">
                          <input type="text" class="form-control" id="inputPoolLabel" name="label" placeholder="Name of this pool">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputPoolURL" class="col-sm-5 control-label">URL</label>
                        <div class="col-sm-5">
                          <input type="text" class="form-control" id="inputPoolURL" name="label" placeholder="Pool URL (including port #)">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputPoolWorker" class="col-sm-5 control-label">Worker</label>
                        <div class="col-sm-4">
                          <input type="text" class="form-control" id="inputPoolWorker" name="label">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputPoolPassword" class="col-sm-5 control-label">Password</label>
                        <div class="col-sm-4">
                          <input type="text" class="form-control" id="inputPoolPassword" name="label">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputPoolPriority" class="col-sm-5 control-label">Priority</label>
                        <div class="col-sm-2">
                          <input type="text" class="form-control" maxlength="3" id="inputPoolPriority" name="label">
                        </div>
                      </div>
                      <button type="button" class="btn btn-lg btn-success" id="btnAddPool"><i class="icon icon-save-floppy"></i> Save New Pool</button>
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
                   <button type="button" class="btn btn-lg btn-success" id="btnAddPool"><i class="icon icon-save-floppy"></i> Save Rig Details</button>
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