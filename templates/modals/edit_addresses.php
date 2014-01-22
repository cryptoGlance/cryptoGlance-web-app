<!-- Modal -->
<div class="modal fade" id="editAddresses" tabindex="-1" role="dialog" aria-labelledby="editAddressesLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="form-inline" role="form">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
           <h2 class="modal-title" id="editAddressesLabel"><i class="icon icon-edit"></i> Address Management</h2>
         </div>
         <div class="modal-body">
            <div id="alert-saved-pool" class="alert alert-success alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <strong>Success!</strong> You've saved this pool.
            </div>         
           <div class="form-group">
             <label for="inputPoolLabel" class="control-label">Label</label>
             <div class="col-sm-9">
               <input type="text" class="form-control" id="inputPoolLabel">
             </div>
           </div>
           <div class="form-group">
             <label for="inputPoolIP" class="control-label">Pool URL</label>
             <div class="col-sm-9">
               <input type="text" class="form-control" id="inputPoolIP">
             </div>
           </div>
           <div class="form-group">
             <label for="inputPoolPort" class="control-label">API Key</label>
             <div class="col-sm-9">
               <input type="text" class="form-control" id="inputPoolPort" maxLength="5">
             </div>
           </div>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-lg btn-primary" data-dismiss="modal"><i class="icon icon-undo"></i> Cancel</button>
           <button type="button" class="btn btn-lg btn-success" id="btnSaveAddresses"><i class="icon icon-save-floppy"></i> Save</button>
         </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->