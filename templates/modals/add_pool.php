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
           <div class="form-group all">
             <label for="inputPoolLabel" class="col-sm-3 control-label">Label</label>
             <div class="col-sm-7">
               <input type="text" class="form-control" id="inputPoolLabel" name="label" placeholder="Name of this pool">
             </div>
           </div>
          <div class="form-group all">
            <label for="selectPoolType" class="col-sm-3 control-label">Type</label>
            <div class="col-sm-4">
              <select class="form-control" id="selectPoolType" name="poolType">
                 <option disabled selected>Select A Pool</option>
                 <option value="btcguild">BTC Guild</option>
                 <option value="eclipse">Eclipse</option>
                 <option value="mpos">MPOS</option>
                 <option value="simplecoin">SimpleCoin</option>
                 <option value="trademybit">TradeMyBit</option>
                 <option value="wafflepool">WafflePool</option>
              </select>
            </div>
          </div>
           <div class="form-group mpos simplecoin" style="display: none;">
             <label for="inputPoolURL" class="col-sm-3 control-label">Pool URL</label>
             <div class="col-sm-7">
               <input type="text" class="form-control" id="inputPoolURL" name="url" placeholder="http://vertsquad.com/">
             </div>
           </div>
           <div class="form-group mpos btcguild simplecoin eclipse trademybit" style="display: none;">
             <label for="inputPoolAPI" class="col-sm-3 control-label">API Key</label>
             <div class="col-sm-7">
               <input type="text" class="form-control" id="inputPoolAPI" name="api">
             </div>
           </div>
           <div class="form-group mpos" style="display: none;">
             <label for="inputPoolUserId" class="col-sm-3 control-label">User ID</label>
             <div class="col-sm-3">
               <input type="text" class="form-control" id="inputPoolUserId" name="userid">
             </div>
           </div>
           <div class="form-group wafflepool" style="display: none;">
             <label for="inputAddress" class="col-sm-3 control-label">BTC Address</label>
             <div class="col-sm-7">
               <input type="text" class="form-control" id="inputAddress" name="address">
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
