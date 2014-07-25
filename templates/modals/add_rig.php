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
<!--              <div class="form-group">-->
<!--                <label for="inputRigType" class="col-sm-5 control-label">Type</label>-->
<!--                <div class="col-sm-5">-->
<!--                  <select class="form-control" id="selectRigType" name="minerType" readonly>-->
<!--                     <option value="cgminer">cgminer</option>-->
<!--                  </select>-->
<!--                </div>-->
<!--              </div>-->
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
                  <select class="form-control" id="selectRigAlgo" name="minerAlgo">
                    <option value="blake-256">blake-256</option>
                    <option value="keccak">keccak</option>
                    <option value="nist5">nist5</option>
                    <option value="sha256">sha256</option>
                    <option value="scrypt">scrypt</option>
                    <option value="scrypt-n">scrypt-n</option>
                    <option value="x11">x11</option>
                    <option value="x13">x13</option>
                    <option value="x15">x15</option>
                  </select>
                </div>
              </div>
<!--              <div class="form-group">-->
<!--                <label for="inputRigHashrate" class="col-sm-5 control-label">Desired Hashrate <small>(MH/s)</small></label>-->
<!--                <div class="col-sm-3">-->
<!--                  <input type="text" class="form-control" id="inputRigHashrate" maxLength="5">-->
<!--                </div>-->
<!--              </div>-->
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-lg btn-danger" data-dismiss="modal"><i class="icon icon-undo"></i> Cancel</button>
           <button type="button" class="btn btn-lg btn-success submitAddConfig" id="btnAddHost"><i class="icon icon-save-floppy"></i> Save</button>
         </div>
         <input type="hidden" name="type" value="rig" />
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->