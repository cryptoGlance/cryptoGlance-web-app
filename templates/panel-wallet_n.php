
<?php require_once("templates/modal-edit_addresses.php"); ?>

<div id="wallet-1" class="panel panel-primary panel-wallet">
   <h1>Address</h1>
   <div class="panel-heading">
      <button type="button" class="panel-header-button" data-toggle="modal" data-target="#deletePrompt" data-backdrop="static" aria-hidden="true"><i class="icon icon-circledelete"></i></button> 
      <button type="button" class="panel-header-button toggle-panel-body"><i class="icon icon-chevron-up"></i></button> 
      <h2 class="panel-title"><i class="icon icon-walletalt"></i> Balances</h2>
   </div>
   <div class="panel-body panel-body-addresses">
      <div class="stat-pair" id="wallet-1-address-1">
         <div class="stat-value">
            <img src="images/icon-bitcoin.png" alt="Bitcoin" /> 
            <span class="green">0.17408192 BTC</span><span class="address-label">in Example BTC Receive</span>
         </div>
         <div class="stat-label">
            1HBY1cskYysa2in8zNVfLgPLpEYAoTsGyS
         </div>
      </div>
      <div class="stat-pair" id="wallet-1-address-2">
         <div class="stat-value">
            <img src="images/icon-litecoin.png" alt="Litecoin" />
            <span class="green">4.48508539 LTC</span><span class="address-label">in Test LTC Wallet</span>
         </div>
         <div class="stat-label">
            LUQ4GyjjDtopdGj3h8CvDEP4QCLd3FEhDT
         </div>
      </div>
      <div class="stat-pair" id="wallet-1-address-3">
         <div class="stat-value">
            <img src="images/icon-litecoin.png" alt="Litecoin" />
            <span class="green">1.48508539 LTC</span><span class="address-label">in Example LTC</span>
         </div>
         <div class="stat-label">
            LUQ4GyjjDtopdGj3h8CvDEP4QCLd3FEhDT
         </div>
      </div>
   </div><!-- / .panel-body -->
   <div class="panel-footer text-right">
      <button type="button" class="btn btn-default btn-updater"><i class="icon icon-refresh"></i> Update Now</button>
      <button type="button" class="btn btn-default" data-toggle="modal" data-target="#editAddresses" data-backdrop="static"><i class="icon icon-edit"></i> Edit Addresses</button>
   </div>
</div>