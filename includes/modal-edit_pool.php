<!-- Modal -->
<div class="modal fade" id="editPool" tabindex="-1" role="dialog" aria-labelledby="editPoolLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="form-horizontal" role="form">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
           <h2 class="modal-title" id="editPoolLabel"><i class="icon icon-edit"></i> Edit This Mining Pool</h2>
         </div>
         <div class="modal-body">
               <div id="alert-saved-pool" class="alert alert-success alert-dismissable">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <strong>Success!</strong> You've saved this pool.
               </div>         
              <div class="form-group">
                <label for="inputRigLabel" class="col-sm-3 control-label">Label</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="inputRigLabel">
                </div>
              </div>
              <div class="form-group">
                <label for="inputRigIP" class="col-sm-5 control-label">IP Address</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" id="inputRigIP">
                </div>
              </div>
              <div class="form-group">
                <label for="inputRigPort" class="col-sm-5 control-label">cgminer Port</label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" id="inputRigPort" maxLength="5">
                </div>
              </div>
              <div class="form-group">
                <label for="inputRigHashrate" class="col-sm-5 control-label">Desired Hashrate <small>(MH/s)</small></label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" id="inputRigHashrate" maxLength="5">
                </div>
              </div>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-lg btn-danger" data-dismiss="modal" data-toggle="modal" data-target="#deletePrompt" data-backdrop="static"><i class="icon icon-circledelete"></i> Delete</button> 
           <button type="button" class="btn btn-lg btn-primary" data-dismiss="modal"><i class="icon icon-undo"></i> Cancel</button>
           <button type="button" class="btn btn-lg btn-success" id="btnSavePool"><i class="icon icon-save-floppy"></i> Save</button>
         </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->