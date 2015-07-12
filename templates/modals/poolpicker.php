<!-- Modal -->
<div class="modal fade" id="poolPicker" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="form-horizontal" role="form">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
           <h2 class="modal-title title-add" style="display: none;"><i class="icon icon-edit"></i> Add PoolPicker</h2>
           <h2 class="modal-title title-edit" style="display: none;"><i class="icon icon-edit"></i> Edit PoolPicker</h2>
         </div>
         <div class="modal-body">
           <div class="form-group">
             <label for="inputPoolLabel" class="col-sm-12 control-label">Enable Algorithms</label>
           </div>
           <div class="form-group form-left">
             <div class="col-sm-6">
               <label><input type="checkbox" class="form-control" name="algorithms[]" value="lyra2re" id="poolpickerLyra2re"> Lyra2RE</label><br />
               <label><input type="checkbox" class="form-control" name="algorithms[]" value="neoscrypt" id="poolpickerNeoScrypt"> NeoScrypt</label><br />
               <label><input type="checkbox" class="form-control" name="algorithms[]" value="nist5" id="poolpickerNist5"> Nist5</label><br />
               <label><input type="checkbox" class="form-control" name="algorithms[]" value="scrypt" id="poolpickerScrypt"> Scrypt</label><br />
               <label><input type="checkbox" class="form-control" name="algorithms[]" value="keccak" id="poolpickerKeccak"> Keccak</label><br />
             </div>
             <div class="col-sm-6">
               <label><input type="checkbox" class="form-control" name="algorithms[]" value="scryptn" id="poolpickerScryptN"> Scrypt-N</label><br />
               <label><input type="checkbox" class="form-control" name="algorithms[]" value="sha256" id="poolpickerSha256"> SHA-256</label><br />
               <label><input type="checkbox" class="form-control" name="algorithms[]" value="x11" id="poolpickerX11"> X11</label><br />
               <label><input type="checkbox" class="form-control" name="algorithms[]" value="x13" id="poolpickerX13"> X13</label><br />
               <label><input type="checkbox" class="form-control" name="algorithms[]" value="x15" id="poolpickerX15"> X15</label><br />
             </div>
           </div>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-lg btn-danger btn-cancelConfig" data-dismiss="modal"><i class="icon icon-undo"></i> Cancel</button>
           <button type="button" class="btn btn-lg btn-success btn-saveConfig" id="btnSavePoolPicker"><i class="icon icon-save-floppy"></i> Save</button>
         </div>
         <input type="hidden" name="type" value="pool-picker" />
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
