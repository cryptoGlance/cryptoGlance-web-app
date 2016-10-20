<?php $minimized = ($wallet['panel']['state'] === 'close'); require_once('includes/autoloader.inc.php');?>
<div id="wallet" class="panel panel-primary panel-wallet" data-type="wallets">
<div id="wallet" class="panel panel-primary panel-wallet">
   <h1>Wallet</h1>
   <div class="panel-heading">
      <button type="button" class="panel-header-button btn-updater" data-type="wallet"><i class="icon icon-refresh"></i> Update</button>
      <a href="wallet.php" title="Add a new collection of addresses to this panel"><button type="button" class="panel-header-button btn-manage-rig"><i class="icon icon-googleplusold"></i> Add Wallet</button></a>
      <button type="button" class="panel-header-button" data-toggle="modal" data-target="#deletePrompt" data-backdrop="static" aria-hidden="true" style="display: none;"><i class="icon icon-circledelete"></i></button>
      <button type="button" class="panel-header-button toggle-panel-body"><i class="icon icon-chevron-<?php echo ($minimized?'down':'up') ?>"></i></button>
      <h2 class="panel-title"><i class="icon icon-walletalt"></i> Balances</h2>
   </div>
   <div class="panel-body" <?php echo ($minimized?'style="display:none;"':'') ?>>
      <div class="panel-body-addresses"><img src="images/ajax-loader.gif" alt="loading" style="position: relative; float:none; opacity: 1; bottom: 0; left: 0;" /></div>
   </div>
</div>
