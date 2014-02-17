<!-- Modal -->
<div class="modal fade" id="switchPool" tabindex="-1" role="dialog" aria-labelledby="switchPoolLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form">
         <div class="modal-header">
            <h2><i class="icon icon-refreshalt"></i> Switch Active Mining Pool</h2>
         </div>
         <div class="modal-body">
           <div class="checkbox">
             <label for="pool1">
               <input type="radio" name="switchPoolList" class="pretty-input" id="pool1"> <span>CoinHuntr</span>
             </label>
             <label for="pool2">
               <input type="radio" name="switchPoolList" class="pretty-input" id="pool2"> <span>Hashco.ws</span>
             </label>
             <label for="pool3">
               <input type="radio" name="switchPoolList" class="pretty-input" id="pool3"> <span>MultiPool</span>
             </label>
           </div>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-lg btn-primary" data-dismiss="modal"><i class="icon icon-undo"></i> Cancel and stay in current pool</button>
           <button type="button" class="btn btn-lg btn-success" data-dismiss="modal"><i class="icon icon-refreshalt"></i> Switch to this pool</button>
         </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->