
<?php require_once("templates/modals/edit_addresses.php"); ?>

<div id="wallet" class="panel panel-primary panel-wallet">
   <h1>Address</h1>
   <div class="panel-heading">
      <button type="button" class="panel-header-button" data-toggle="modal" data-target="#deletePrompt" data-backdrop="static" aria-hidden="true"><i class="icon icon-circledelete"></i></button> 
      <button type="button" class="panel-header-button toggle-panel-body"><i class="icon icon-chevron-up"></i></button> 
      <h2 class="panel-title"><i class="icon icon-walletalt"></i> Balances</h2>
   </div>
   <div class="panel-body panel-body-addresses"></div>
   <div class="panel-footer text-right">
      <button type="button" class="btn btn-default btn-updater" data-type="wallet" data-attr="false"><i class="icon icon-refresh"></i> Update Now</button>
<!--      <button type="button" class="btn btn-default" data-toggle="modal" data-target="#editAddresses" data-backdrop="static"><i class="icon icon-edit"></i> Edit Addresses</button>-->
   </div>
</div>