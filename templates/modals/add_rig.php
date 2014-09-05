<!-- Modal -->
<div class="modal fade" id="addRig" tabindex="-1" role="dialog" aria-labelledby="addRigLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="form-horizontal" role="form">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
           <h2 class="modal-title" id="addRigLabel"><i class="icon icon-circleadd"></i> Add a New Rig</h2>
         </div>
         <div class="modal-body">
              <div class="form-group">
                <label for="inputRigLabel" class="col-sm-4 control-label">Label</label>
                <div class="col-sm-7">
                  <input type="text" class="form-control" id="inputRigLabel" name="label" placeholder="Name of this rig">
                </div>
              </div>
              <div class="form-group">
                <label for="inputRigIP" class="col-sm-4 control-label">Hostname / IP</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="inputRigIP" name="ip_address">
                </div>
              </div>
              <div class="form-group">
                <label for="inputRigPort" class="col-sm-4 control-label">API Port</label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" id="inputRigPort" maxLength="5" name="port" placeholder="4028" value="4028">
                </div>
              </div>
              <div class="form-group">
                <label for="inputRigAlgo" class="col-sm-4 control-label">Algorithm</label>
                <div class="col-sm-5">
                  <select class="form-control" id="selectRigAlgo" name="algorithm">
                    <?php foreach($cryptoGlance->supportedAlgorithms() as $val => $name) { ?>
                    <option value="<?php echo $val; ?>"><?php echo $name; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-12">
                    <span class="error"></span>
                </div>
              </div>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-lg btn-danger btn-cancelConfig" data-dismiss="modal"><i class="icon icon-undo"></i> Cancel</button>
           <button type="button" class="btn btn-lg btn-success btn-saveConfig" id="btnAddHost"><i class="icon icon-save-floppy"></i> Save</button>
         </div>
         <input type="hidden" name="type" value="rigs" />
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
