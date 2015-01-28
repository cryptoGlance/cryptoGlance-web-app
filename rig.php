<?php
include('includes/inc.php');

if (!$_SESSION['login_string']) {
    header('Location: login.php');
    exit();
}
session_write_close();

$id = intval($_GET['id']);
if ($id == 0) {
    header('Location: index.php');
    exit();
}

require_once('includes/autoloader.inc.php');

// Start our rig class
$rigsObj = new Rigs($id);

// Saving logic
if (!empty($_POST)) {
    echo $rigsObj->update();
    exit();
}

$jsArray = array(
    'rig/script',
);

require_once("includes/header.php");


// Fetch Page Information
$rigDevices = $rigsObj->getDevices();
$rigDevices = $rigDevices[0];

$rigPools = $rigsObj->getPools();
$rigPools = $rigPools[0];

$rigSettings = $rigsObj->getSettings();
$rigSettings = $rigSettings[0];

// If no devices are found, show some kind of warning
if (empty($rigDevices)) {
?>
<script type="text/javascript">
!function ($){
    setTimeout(function() {
        showToastRigOffline('<?php echo (!empty($rigSettings['name']) ? $rigSettings['name'] : $rigSettings['host'].':'.$rigSettings['port']); ?>');
    }, 1000);
}(window.jQuery)
</script>
<?php
}
?>

    <div id="rig-wrap" class="container sub-nav" data-rigId="<?php echo $id;?>">
        <div id="rigDetails" class="panel panel-primary panel-no-grid">
            <h1><?php echo (!empty($rigSettings['name']) ? $rigSettings['name'] : $rigSettings['host'].':'.$rigSettings['port']); ?></h1>
            <div class="panel-heading">
                <h2 class="panel-title">Rig Settings<i class="icon icon-pixelpickaxe"></i></h2>
            </div>
            <div class="panel-content">
                <ul class="nav nav-pills" role="tablist">
                    <li class="active"><a href="#details" data-toggle="tab" role="tab">Details <i class="icon icon-dotlist"></i></a></li>
                    <li><a href="#thresholds" data-toggle="tab" role="tab">Thresholds <i class="icon icon-speed"></i></a></li>
                    <li><a href="#devices" data-toggle="tab" role="tab">Devices <i class="icon icon-cpu-processor"></i></a></li>
                    <li><a href="#pools" data-toggle="tab" role="tab">Pools <i class="icon icon-communitysmall"></i></a></li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade in active" id="details">
                        <div class="panel-body">
                            <form class="form-horizontal" role="form">
                                <fieldset>
                                    <h3>Rig Details</h3>
                                    <div class="form-group">
                                        <label for="inputRigLabel" class="col-sm-5 control-label">Label</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="inputRigLabel" name="details[label]" placeholder="Name of this rig" value="<?php echo $rigSettings['name'];?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputRigIP" class="col-sm-5 control-label">Hostname / IP</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="inputRigIP" name="details[ip_address]" value="<?php echo $rigSettings['host'];?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputRigPort" class="col-sm-5 control-label">API Port</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" id="inputRigPort" maxLength="5" name="details[port]" placeholder="4028" value="<?php echo $rigSettings['port'];?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputRigAlgor" class="col-sm-5 control-label">Algorithm</label>
                                        <div class="col-sm-2">
                                            <select class="form-control" id="inputRigAlgor" name="details[algorithm]">
                                                <?php foreach($cryptoGlance->supportedAlgorithms() as $val => $name) { ?>
                                                <option value="<?php echo $val; ?>" <?php echo (strtolower($rigSettings['settings']['algorithm']) == strtolower($val)) ? 'selected' : '' ?>><?php echo $name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div><!-- / .panel-body -->
                    </div>
                    <div class="tab-pane fade" id="thresholds">
                        <div class="panel-body">
                            <form class="form-horizontal" role="form">
                                <fieldset class="floated">
                                    <h3>Temperature Thresholds</h3>
                                    <div class="form-group checkbox">
                                        <input id="threshold-temps" class="enabler" type="checkbox" name="thresholds[temps][enabled]" <?php echo ($rigSettings['settings']['temps']['enabled']) ? 'checked' : '' ?> value="1"> <label for="threshold-temps">Enable Temperature Warnings</label>
                                    </div>
                                    <div class="form-group setting-thresholds" <?php echo (!$rigSettings['settings']['temps']['enabled']) ? 'style="display: none;"' : '' ?>>
                                        <table class="table table-hover table-striped table-settings">
                                            <thead>
                                                <tr>
                                                    <th colspan="3">
                                                        <span class="help-block"><i class="icon icon-info-sign"></i> Set the points where <span class="orange">warning</span> and <span class="red">danger</span> labels will<br>appear (<span class="red">danger</span> must be greater than <span class="orange">warning</span>).</span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="2">
                                                        <label for="inputTempWarning" class="control-label orange">Warning</label>
                                                        <br><br>
                                                        <label for="inputTempDanger" class="control-label red">Danger</label>
                                                    </td>
                                                    <td>
                                                        <div class="form-group setting-hwerror hwErrorInt">
                                                            <div class="setting-temps setting-thresholds">
                                                                <div class="setting-warning orange">
                                                                    <input type="text" class="form-control warning" id="inputTempWarning" name="thresholds[temps][warning]" value="<?php echo $rigSettings['settings']['temps']['warning'] ?>" placeholder="<?php echo $rigSettings['settings']['temps']['warning'] ?>" maxlength="3">
                                                                    <span>&deg;C</span>
                                                                </div>
                                                                <div class="setting-danger red">
                                                                    <input type="text" class="form-control danger" id="inputTempDanger" name="thresholds[temps][danger]" value="<?php echo $rigSettings['settings']['temps']['danger'] ?>" placeholder="<?php echo $rigSettings['settings']['temps']['danger'] ?>" maxlength="3">
                                                                    <span>&deg;C</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </fieldset>
                                <fieldset class="floated">
                                    <h3>HW Error Thresholds</h3>
                                    <div class="form-group checkbox">
                                        <input id="threshold-hwerrors" class="enabler" type="checkbox" name="thresholds[hwErrors][enabled]" <?php echo ($rigSettings['settings']['hwErrors']['enabled']) ? 'checked' : '' ?> value="1"> <label for="threshold-hwerrors">Enable Hardware Error Warnings</label>
                                    </div>
                                    <div class="form-group setting-thresholds" <?php echo (!$rigSettings['settings']['hwErrors']['enabled']) ? 'style="display: none;"' : '' ?>>
                                        <table class="table table-hover table-striped table-settings">
                                            <thead>
                                                <tr>
                                                    <th colspan="3">
                                                        <span class="help-block"><i class="icon icon-info-sign"></i> Set the percentage OR count of hardware errors<br>that will trigger each status.</span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <label class="control-label"><small>Display Type</small></label>
                                                    </td>
                                                    <td>
                                                        <label>
                                                            Number (#)<br><input type="radio" name="thresholds[hwErrors][type]" <?php echo ($rigSettings['settings']['hwErrors']['type'] == 'int') ? 'checked' : '' ?> value="int">
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <label>
                                                            Percent (%)<br><input type="radio" name="thresholds[hwErrors][type]" <?php echo ($rigSettings['settings']['hwErrors']['type'] == 'percent') ? 'checked' : '' ?> value="percent">
                                                        </label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="inputHWErrWarning" class="control-label orange">Warning</label>
                                                        <br>
                                                        <br>
                                                        <label for="inputHWErrDanger" class="control-label red">Danger</label>
                                                    </td>
                                                    <td>
                                                        <div class="form-group setting-hwerror hwErrorInt">
                                                            <div class="setting-hw-errors-int setting-thresholds">
                                                                <div class="setting-warning orange">
                                                                    <input type="text" class="form-control warning" id="inputHWErrWarningInt" name="thresholds[hwErrors][warning][int]" value="<?php echo $rigSettings['settings']['hwErrors']['warning']['int'] ?>" placeholder="<?php echo $rigSettings['settings']['hwErrors']['warning']['int'] ?>">
                                                                </div>
                                                                <div class="setting-danger red">
                                                                    <input type="text" class="form-control danger" id="inputHWErrDangerInt" name="thresholds[hwErrors][danger][int]" value="<?php echo $rigSettings['settings']['hwErrors']['danger']['int'] ?>" placeholder="<?php echo $rigSettings['settings']['hwErrors']['danger']['int'] ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group setting-hwerror hwErrorPercent">
                                                            <div class="setting-hw-errors-percent setting-thresholds">
                                                                <div class="setting-warning orange">
                                                                    <input type="text" class="form-control warning" id="inputHWErrWarningPercent" name="thresholds[hwErrors][warning][percent]" value="<?php echo $rigSettings['settings']['hwErrors']['warning']['percent'] ?>%" placeholder="<?php echo $rigSettings['settings']['hwErrors']['warning']['percent'] ?>%">
                                                                </div>
                                                                <div class="setting-danger red">
                                                                    <input type="text" class="form-control danger" id="inputHWErrDangerPercent" name="thresholds[hwErrors][danger][percent]" value="<?php echo $rigSettings['settings']['hwErrors']['danger']['percent'] ?>%" placeholder="<?php echo $rigSettings['settings']['hwErrors']['danger']['percent'] ?>%">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </fieldset>
                            </form>
                        </div><!-- / .panel-body -->
                    </div>
                    <div class="tab-pane fade" id="devices">
                        <div class="panel-body">
                            <h3>Available Device(s)</h3>
                            <form class="form-horizontal" role="form">
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
                                        <tr data-type="<?php echo $dev['type']; ?>" data-id="<?php echo $dev['id']; ?>" data-icon="<?php echo $dev['status']['icon']; ?>" data-status="<?php echo $dev['status']['colour']; ?>">
                                          <td><i class="icon icon-<?php echo $dev['status']['icon']; ?> <?php echo $dev['status']['colour']; ?>"></i></td>
                                          <td class="<?php echo $dev['status']['colour']; ?>"><?php echo $dev['type'] . $dev['id']; ?></td>
                                          <td><input type="checkbox" class="devEnabled" <?php echo (strtolower($dev['enabled']) == 'y' ? 'checked' : ''); ?> /></td>
                                          <td><?php echo formatHashrate($dev['hashrate_5s']*1000); ?></td>
                                          <?php if ($dev['type'] == 'GPU') { ?>
                                          <td><?php echo $dev['temperature_c'] . '<span>&deg;C</span>/' . $dev['temperature_f'] . '<span>&deg;F</span>'; ?></td>
                                          <td><input name="devices[<?php echo $dev['id']; ?>][intensity]" type="text" class="form-control" value="<?php echo $dev['intensity']; ?>" /></td>
                                          <td><input name="devices[<?php echo $dev['id']; ?>][fan_percent]" type="text" class="form-control" value="<?php echo $dev['fan_percent']; ?>" /></td>
                                          <td><input name="devices[<?php echo $dev['id']; ?>][engine_clock]" type="text" class="form-control" value="<?php echo $dev['engine_clock']; ?>" /></td>
                                          <td><input name="devices[<?php echo $dev['id']; ?>][memory_clock]" type="text" class="form-control" value="<?php echo $dev['memory_clock']; ?>" /></td>
                                          <td><input name="devices[<?php echo $dev['id']; ?>][gpu_voltage]" type="text" class="form-control" value="<?php echo $dev['gpu_voltage']; ?>" /></td>
                                          <td><input name="devices[<?php echo $dev['id']; ?>][powertune]" type="text" class="form-control" value="<?php echo $dev['powertune']; ?>" /></td>
                                          <?php } else if ($dev['type'] == 'ASC' || $dev['type'] == 'PGA') { ?>
                                          <td>
                                            <?php if ($dev['frequency']) { ?>
                                              <input name="devices[<?php echo $dev['id']; ?>][frequency]" type="text" class="form-control" value="<?php echo $dev['frequency']; ?>" disabled="disabled" />
                                            <?php } else { ?>
                                                Unknown
                                            <?php } ?>
                                          </td>
                                          <?php } ?>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </form>
                        </div><!-- / .panel-body -->
                    </div>
                    <div class="tab-pane fade" id="pools">
                        <div class="panel-body">
                        <form class="form-horizontal" role="form">
                            <h3>Pool Management</h3>
                            <table class="table table-hover table-striped table-pools">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Active</th>
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
                                    <tr data-id="<?php echo $pool['id']; ?>">
                                        <td><a class="poolGrip"><span class="grey"><i class="icon icon-braillespace"></i></span></a></td>
                                        <td><input type="checkbox" class="form-control poolActive" <?php echo ($pool['status'] == 1) ? 'checked' : ''; ?> /></td>
                                        <td data-type="url">
                                            <span><?php echo $pool['url']; ?></span>
                                            <input type="hidden" name="pools[<?php echo $pool['id']; ?>][url]" class="form-control" value="<?php echo $pool['url']; ?>" />
                                        </td>
                                        <td data-type="user">
                                            <span><?php echo $pool['user']; ?></span>
                                            <input type="hidden" name="pools[<?php echo $pool['id']; ?>][user]" class="form-control" value="<?php echo $pool['user']; ?>" />
                                        </td>
                                        <td data-type="password">
                                            <span>********</span>
                                            <input type="hidden" name="pools[<?php echo $pool['id']; ?>][password]" class="form-control" value="<?php echo $pool['password']; ?>" />
                                        </td>
                                        <td data-type="priority">
                                            <span><?php echo $pool['priority']; ?></span>
                                            <input type="hidden" name="pools[<?php echo $pool['id']; ?>][priority]" class="form-control" value="<?php echo $pool['priority']; ?>" />
                                        </td>
                                        <td>
                                            <a class="editPoolConfig"><span class="green"><i class="icon icon-edit"></i></span></a> &nbsp; <a class="removePoolConfig"><span class="red"><i class="icon icon-remove"></i></span></a>
                                            <br />
                                        </td>
                                    </tr>
                                <?php } ?>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td data-type="url">
                                            <input type="text" placeholder="Pool URL" name="pools[new][url]" class="form-control" />
                                        </td>
                                        <td data-type="user">
                                            <input type="text" placeholder="Username" name="pools[new][user]" class="form-control" />
                                        </td>
                                        <td data-type="password">
                                            <input type="text" placeholder="Password" name="pools[new][password]" class="form-control" />
                                        </td>
                                        <td data-type="priority">
                                            <input type="text" placeholder="<?php echo count($rigPools); ?>" name="pools[new][priority]" class="form-control" />
                                        </td>
                                        <td>
                                            <a class="addPoolConfig"><span class="blue"><i class="icon icon-save-floppy"></i></span></a>
                                            <br />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                        </div><!-- / .panel-body -->
                    </div>
                </div>
            </div><!-- / .panel-content -->
            <hr />
            <div class="panel-body">
                <form class="form-horizontal" role="form">
                    <fieldset>
                        <button type="button" class="btn btn-lg btn-success" id="btnSaveRig"><i class="icon icon-save-floppy"></i> Save Rig Details</button>
                        <br /><br />
                    </fieldset>
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
