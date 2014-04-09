<?php
include('includes/inc.php');

if (!$_SESSION['login_string']) {
    header('Location: login.php');
    exit();
}

$jsArray = array();
require_once("includes/header.php");
require_once('includes/autoloader.inc.php');
require_once('includes/cryptoglance.php');
$cryptoGlance = new CryptoGlance();
$wallets = $cryptoGlance->getWallets();
$walletId = intval($_GET['id']);
if ($walletId != 0) {
    $wallet = $wallets[$walletId-1];
    
    if (!empty($wallet)) {
        $walletObj = new Class_Wallets();
        $walletData = $walletObj->update($walletId);
        $wallet['data'] = $walletData[0];
    }
}
?>
       
<!-- ### Below is the Wallet page which contains wallet balances for children addresses, and allows for adding new addresses, and editing/deleting the entire wallet-->
    <div id="wallet-wrap" class="container sub-nav">
        <?php if ($walletId != 0) { ?>
        <div id="wallet-details" class="panel panel-primary panel-no-grid panel-wallet" data-walletId="<?php echo $walletId ?>">
            <h1>Wallet</h1>
            <div class="panel-heading">
                <button type="button" class="panel-header-button btn-updater" data-type="all"><i class="icon icon-refresh"></i> Update</button>
                <h2 class="panel-title"><?php echo $wallet['label'] ?></h2>
            </div>
            <div class="panel-body">
                <div class="total-wallet-balance">
                <span class="green"><?php echo $wallet['data']['balance'] ?> <img src="images/icon-<?php echo $wallet['currency'] ?>.png" /> <?php echo $wallet['data']['currency_code'] ?></span>
                </div>
                <div class="table-responsive">
                    <form role="form">
                        <table class="table table-hover table-striped table-wallet">
                            <thead>
                                <tr>
                                    <th>Address Name</th>
                                    <th>Public Key</th>
                                    <th>Balance</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($wallet['addresses'] as $addressKey => $address) { ?>
                                <tr data-key="<?php echo ($addressKey+1); ?>">
                                    <td data-name="label"><?php echo $address['label']?></td>
                                    <td data-name="address"><?php echo $address['address']?></td>
                                    <td><?php echo $wallet['data']['addresses'][$address['address']] ?> <?php echo $wallet['data']['currency_code'] ?></td>
                                    <td><a href="#editAddress" class="editAddress"><span class="green"><i class="icon icon-edit"></i></span></a> &nbsp; <a href="#removeAddress" class="removeAddress"><span class="red"><i class="icon icon-remove"></i></span></a></td>
                                </tr>
                                <?php } ?>
                                <tr class="wallet-inline-edit">
                                    <td><input type="text" name="label" class="form-control"></td>
                                    <td><input type="text" name="address" class="form-control"></td>
                                    <td><em>new address</em></td>
                                    <td><a href="#saveAddress" class="saveAddress"><span class="blue"><i class="icon icon-save-floppy"></i></span></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div><!-- / .panel-body -->
        </div>
        <?php } ?>
        
        <div id="walletDetails" class="panel panel-default panel-no-grid">
            <h1>Wallet Details</h1>
            <div class="panel-heading">
                <h2 class="panel-title"><i class="icon icon-walletalt"></i></h2>
            </div>
            <div class="panel-body">
            
            <!-- Bootstrap Alert docs here: http://getbootstrap.com/components/#alerts -->
            
                <div id="alert-saved-wallet" class="alert alert-success alert-dismissable" style="display: none;">
                    <button type="button" class="close fade in" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Success!</strong> You've updated your wallet.
                </div>
                <div id="alert-save-fail-wallet" class="alert alert-danger alert-dismissable" style="display: none;">
                    <button type="button" class="close fade in" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Failed!</strong> Could not save the wallet info for some reason.
                </div>  
                <form class="form-horizontal" role="form">
                    <input type="hidden" name="type" value="wallet" />
                    <input type="hidden" name="walletId" value="<?php echo $walletId ?>" />
                    <div class="form-group">
                        <label for="inputWalletName" class="control-label col-sm-4">Wallet Name:</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="inputWalletName" name="label" value="<?php echo $wallet['label'] ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputWalletCurrency" class="control-label col-sm-4">Currency:</label>
                        <div class="col-sm-2">
                            <select class="form-control" name="currency" <?php echo ($walletId != 0 ? 'disabled' : '') ?>>
                                <?php foreach ($cryptoGlance->getCurrencies() as $currency => $code) { ?>
                                <option value="<?php echo $currency ?>" <?php echo ($wallet['currency'] == $currency ? 'selected' : '') ?>><?php echo ucwords($currency) ?> (<?php echo $code ?>)</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-4">
                            <button type="button" class="btn btn-lg btn-success" id="btnSaveWallets"><i class="icon icon-save-floppy"></i> Save Wallet</button>
                            <?php if ($walletId != 0) { ?>
                            <button type="button" class="btn btn-lg btn-danger" id="btnDeleteWallet"><i class="icon icon-circledelete"></i> Remove Wallet</button>
                            <?php } ?>
                        </div>
                    </div>
                </form>
                <br />
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