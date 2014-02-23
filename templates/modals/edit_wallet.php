<!-- Modal -->
<div class="modal fade" id="editWallet" tabindex="-1" role="dialog" aria-labelledby="editWalletLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="form-horizontal" role="form">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
           <h2 class="modal-title" id="editWalletLabel"><i class="icon icon-walletalt"></i> Wallet Management</h2>
         </div>
         <div class="modal-body">
            <div id="alert-saved-wallet" class="alert alert-success alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <strong>Success!</strong> You've updated your wallets.
            </div>         
           <div class="form-group">
             <label for="inputWalletName" class="control-label col-sm-4">Wallet Name</label>
             <div class="col-sm-8">
               <input type="text" class="form-control" id="inputWalletName">
             </div>
           </div>
           <div class="form-group">
             <label for="inputWalletCurrency" class="control-label col-sm-4">Currency</label>
             <div class="col-sm-5">
               <select class="form-control">
                 <option>Bitcoin (BTC)</option>
                 <option>Litecoin (LTC)</option>
                 <option>Dogecoin (DGC)</option>
               </select>
             </div>
           </div>
           <div class="form-group">
             <label class="control-label col-sm-4">Addresses</label>
             <div class="col-sm-7 addressInputs">
               <input type="text" class="form-control" id="Address1" value="1HBY1cskYysa2in8zNVfLgPLpEYAoTsGyS">
             </div>
             <div class="col-sm-1">
               <i class="icon icon-keyboarddelete"></i>
             </div>
           </div>
           <div class="form-group">
             <label class="control-label col-sm-4"></label>
             <div class="col-sm-7 addressInputs">
               <input type="text" class="form-control" id="Address2" value="12PqYifLLTHuU2jRxTtbbJBFjkuww3zeeE">
             </div>
             <div class="col-sm-1">
               <i class="icon icon-keyboarddelete"></i>
             </div>
           </div>
           <div class="form-group">
             <label class="control-label col-sm-4"></label>
             <div class="col-sm-7 addressInputs">
               <input type="text" class="form-control" id="Address3" value="1J7Zut7u3NM7BiJa8ZoMgoQJvb2BifkrpP">
             </div>
             <div class="col-sm-1">
               <i class="icon icon-keyboarddelete"></i>
             </div>
           </div>
           <div class="form-group">
             <label for="inputNewAddress" class="control-label col-sm-4"></label>
             <div class="col-sm-8 addressInputs">
               <input type="text" class="form-control" id="inputNewAddress" placeholder="Add new address...">
             </div>
           </div>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-lg btn-primary" data-dismiss="modal"><i class="icon icon-undo"></i> Close</button>
           <button type="button" class="btn btn-lg btn-success" id="btnSaveWallets"><i class="icon icon-save-floppy"></i> Save</button>
         </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->