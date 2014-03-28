<!-- Modal -->
<div class="modal fade" id="addPool" tabindex="-1" role="dialog" aria-labelledby="addPoolLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="form-horizontal" role="form">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
           <h2 class="modal-title" id="addPoolLabel"><i class="icon icon-circleadd"></i> Add a Mining Pool</h2>
         </div>
         <div class="modal-body">
            <div id="alert-added-pool" class="alert alert-success alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <strong>Success!</strong> You've saved this pool.
            </div>         
            <div id="alert-saved-pool" class="alert alert-success alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <strong>Success!</strong> You've saved this pool.
            </div>         
           <div class="form-group">
             <label for="inputPoolLabel" class="col-sm-3 control-label">Label</label>
             <div class="col-sm-9">
               <input type="text" class="form-control" id="inputPoolLabel">
             </div>
           </div>
           <div class="form-group">
             <label for="inputPoolIP" class="col-sm-3 control-label">Pool URL</label>
             <div class="col-sm-9">
               <input type="text" class="form-control" id="inputPoolIP">
             </div>
           </div>
           <div class="form-group">
             <label for="inputPoolPort" class="col-sm-3 control-label">API Key</label>
             <div class="col-sm-9">
               <input type="text" class="form-control" id="inputPoolPort" maxLength="5">
             </div>
           </div>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-lg btn-danger" data-dismiss="modal"><i class="icon icon-undo"></i> Cancel</button>
           <button type="button" class="btn btn-lg btn-success submitAddConfig" id="btnAddPool"><i class="icon icon-save-floppy"></i> Save</button>
         </div>
         <input type="hidden" name="type" value="pool" />
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->