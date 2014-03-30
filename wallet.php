<?php
$jsArray = array();

require_once("includes/header.php");
?>
       
<!-- ### Below is the Wallet page which contains wallet balances for children addresses, and allows for adding new addresses, and editing/deleting the entire wallet
      
-->
         
      <div id="wallet-wrap" class="container sub-nav">

        <div id="wallet-details" class="panel panel-primary panel-no-grid panel-wallet">
           <h1>Wallet</h1>
           <div class="panel-heading">
              <button type="button" class="panel-header-button btn-updater" data-type="all"><i class="icon icon-refresh"></i> Update</button>
              <h2 class="panel-title">{{WALLET_NAME}}</h2>
           </div>
           <div class="panel-body">
              <div class="total-wallet-balance">
                <span class="green">3.48970242 <img src="images/icon-bitcoin.png" /> BTC</span>
              </div>
              <div class="table-responsive">
                <form role="form">
                  <table class="table table-hover table-striped table-wallet">
                   <thead>
                      <tr>
                         <th>Address Name</th>
                         <th>Public Key</th>
                         <th>Total Tx</th>
                         <th>Balance</th>
                         <th></th>
                      </tr>
                   </thead>
                   <tbody>
                      <tr>
                        <td>Middlecoin Receiver</td>
                        <td>9a898fg9gf98aggfs9dfg9gsd9dgf9sag</td>
                        <td>19</td>
                        <td>2.00234974 BTC</td>
                        <td><a href="#editAddress"><span class="green"><i class="icon icon-edit"></i></span></a> &nbsp; <a href="#removeAddress"><span class="red"><i class="icon icon-remove"></i></span></a></td>
                      </tr>
                      <tr>
                        <td>CleverMining Receiver</td>
                        <td>0d0d7f0a70f70s9a7f070320kl23j4lkh</td>
                        <td>6</td>
                        <td>1.39495933 BTC</td>
                        <td><a href="#editAddress"><span class="green"><i class="icon icon-edit"></i></span></a> &nbsp; <a href="#removeAddress"><span class="red"><i class="icon icon-remove"></i></span></a></td>
                      </tr>
                      <tr>
                        <td>TradeMyBit Receiver</td>
                        <td>32ihoih50hsd8fy98y203h5ih08sdf8hn</td>
                        <td>4</td>
                        <td>0.37349673 BTC</td>
                        <td><a href="#editAddress"><span class="green"><i class="icon icon-edit"></i></span></a> &nbsp; <a href="#removeAddress"><span class="red"><i class="icon icon-remove"></i></span></a></td>
                      </tr>
                      <tr class="wallet-inline-edit">
                        <td><input type="text" class="form-control"></td>
                        <td><input type="text" class="form-control"></td>
                        <td colspan="2"><em>new address</em></td>
                        <td><a href="#saveAddress"><span class="blue"><i class="icon icon-save-floppy"></i></span></a></td>
                      </tr>
                   </tbody>
                  </table>
                </form>
              </div>
           </div><!-- / .panel-body -->
        </div>
        
        <div id="readme" class="panel panel-default panel-no-grid">
          <h1>Wallet Details</h1>
          <div class="panel-heading">
              <h2 class="panel-title"><i class="icon icon-walletalt"></i></h2>
          </div>
          <div class="panel-body">
          
            <!-- Bootstrap Alert docs here: http://getbootstrap.com/components/#alerts -->
            
            <div id="alert-saved-wallet" class="alert alert-success alert-dismissable">
              <button type="button" class="close fade in" data-dismiss="alert" aria-hidden="true">&times;</button>
              <strong>Success!</strong> You've updated your wallet.
            </div>  
            <div id="alert-save-fail-wallet" class="alert alert-danger alert-dismissable">
              <button type="button" class="close fade in" data-dismiss="alert" aria-hidden="true">&times;</button>
              <strong>Failed!</strong> Could not save the wallet info for some reason.
            </div>  
            <form class="form-horizontal" role="form">       
             <div class="form-group">
               <label for="inputWalletName" class="control-label col-sm-4">Wallet Name:</label>
               <div class="col-sm-7">
                 <input type="text" class="form-control" id="inputWalletName">
               </div>
             </div>
             <div class="form-group">
               <label for="inputWalletCurrency" class="control-label col-sm-4">Currency:</label>
               <div class="col-sm-5">
                 <select class="form-control">
                   <option>Bitcoin (BTC)</option>
                   <option>Litecoin (LTC)</option>
                   <option>Dogecoin (DOGE)</option>
                 </select>
               </div>
             </div>
             <div class="form-group">
               <div class="col-sm-offset-4 col-sm-5">
                 <button type="button" class="btn btn-lg btn-success" id="btnSaveWallets"><i class="icon icon-save-floppy"></i> Save Wallet</button>
                 <button type="button" class="btn btn-lg btn-danger" id="btnDeleteWallet"><i class="icon icon-circledelete"></i> Remove Wallet</button>
               </div>
             </div>
            </form>
            <br>
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