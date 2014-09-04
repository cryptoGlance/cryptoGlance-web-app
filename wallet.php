<?php
include('includes/inc.php');

if (!$_SESSION['login_string']) {
    header('Location: login.php');
    exit();
}
session_write_close();

$id = intval($_GET['id']);

require_once('includes/autoloader.inc.php');

// Start our wallet class
$walletObj = new Wallets($id);

// Saving logic
if (!empty($_POST)) {
    echo $walletObj->update();
    exit();
}

$jsArray = array(
    'wallet/script',
);

require_once("includes/header.php");

// Wallet data
$wallet = array();
if ($id != 0) {
    $wallet = $walletObj->getUpdate();
    $wallet = $wallet[0];
}
?>

<!-- ### Below is the Wallet page which contains wallet balances for children addresses, and allows for adding new addresses, and editing/deleting the entire wallet-->
    <div id="wallet-wrap" class="container sub-nav">
        <?php if ($id != 0) { ?>
        <div id="walletAddresses" class="panel panel-primary panel-no-grid panel-wallet" data-walletId="<?php echo $id ?>">
            <h1>Wallet</h1>
            <div class="panel-heading">
                <button type="button" class="panel-header-button btn-updater" onClick="location.reload(true);"><i class="icon icon-refresh"></i> Update</button>
                <h2 class="panel-title"><?php echo $wallet['label'] ?></h2>
            </div>
            <div class="panel-body">
                <div class="total-wallet-balance">
                    <span class="green"><?php echo $wallet['currency_balance'] ?> <img src="images/coin/<?php echo $wallet['currency'] ?>.png" /> <?php echo $wallet['currency_code'] ?></span> <span>//</span> <span class="blue"><?php echo $wallet['fiat_balance'] ?> <img src="images/coin/fiat.png" /> <?php echo $wallet['fiat_code'] ?></span> <span>//</span>  <span class="blue"><?php echo $wallet['coin_balance'] ?> <img src="images/coin/bitcoin.png" /> <?php echo $wallet['coin_code'] ?></span>
                </div>
                <div class="table-responsive">
                    <form role="form">
                        <table class="table table-hover table-striped table-wallet">
                            <thead>
                                <tr>
                                    <th>Address Name</th>
                                    <th>Balance</th>
                                    <th>Fiat ( <?php echo $wallet['fiat_code'] ?> )</th>
                                    <th>Coin ( <?php echo $wallet['coin_code'] ?> )</th>
                                    <th>Address / Public Key</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($wallet['addresses'] as $addressKey => $addressData) { ?>
                                <tr data-key="<?php echo ($addressKey+1); ?>">
                                    <td data-name="label"><?php echo $addressData['label']?></td>
                                    <td><?php echo $addressData['balance'] ?> <img src="images/coin/<?php echo $wallet['currency'] ?>.png" /> <?php echo $wallet['currency_code'] ?></td>
                                    <td><?php echo $addressData['fiat_balance'] ?> <img src="images/coin/fiat.png" /> <?php echo $wallet['fiat_code'] ?></td>
                                    <td><?php echo $addressData['coin_balance'] ?> <img src="images/coin/bitcoin.png" /> <?php echo $wallet['coin_code'] ?></td>
                                    <td data-name="address"><?php echo $addressKey ?></td>
                                    <td><a href="#editAddress" class="editAddress"><span class="green"><i class="icon icon-edit"></i></span></a> &nbsp; <a href="#removeAddress" class="removeAddress"><span class="red"><i class="icon icon-remove"></i></span></a></td>
                                </tr>
                                <?php } ?>
                                <tr class="wallet-inline-edit">
                                    <td colspan="2"><input type="text" name="label" class="form-control" placeholder="enter new name"></td>
                                    <td>0.00 <img src="images/coin/fiat.png" /> <?php echo $wallet['fiat_code'] ?></td>
                                    <td>0 <img src="images/coin/bitcoin.png" /> <?php echo $wallet['coin_code'] ?></td>
                                    <td><input type="text" name="address" class="form-control" placeholder="enter new address"></td>
                                    <td><a href="#saveAddress" class="saveNewAddress"><span class="blue"><i class="icon icon-save-floppy"></i></span></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div><!-- / .panel-body -->
        </div>
        <?php } ?>

        <div id="walletDetails" class="panel panel-default panel-no-grid panel-narrow">
            <h1>Wallet Details</h1>
            <div class="panel-heading">
                <h2 class="panel-title"><i class="icon icon-walletalt"></i></h2>
            </div>
            <div class="panel-body">
              <form class="form-horizontal" role="form">
                    <input type="hidden" name="type" value="wallet" />
                    <input type="hidden" name="walletId" value="<?php echo $id ?>" />
                    <div class="form-group">
                        <label for="inputWalletName" class="control-label col-sm-4">Wallet Name:</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="inputWalletName" name="label" value="<?php echo $wallet['label'] ?>">
                        </div>
                    </div>
                    <div class="form-group">

                        <!-- TODO: in the line below, only show the icon after the (crypto)currency has been saved and condense empty lines -->

                        <label for="inputWalletCurrency" class="control-label col-sm-4">Currency:</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="currency" <?php echo ($id != 0 ? 'disabled' : '') ?>>
                                <?php foreach ($walletObj->getCurrencies() as $currency => $code) { ?>
                                <option value="<?php echo $currency ?>" <?php echo ($wallet['currency'] == $currency ? 'selected' : '') ?>>(<?php echo $code ?>) <?php echo ucwords($currency) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-2 col-has-icon">
                            <img src="images/coin/<?php echo $wallet['currency'] ?>.png" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputFiatCurrency" class="control-label col-sm-4">Fiat Conversion:</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="fiatcurrency">

                                <!-- TODO: get proper fiat names from xe.com // use API for conversions from base BTC? and condense empty lines -->

                                 <option value="USD">(USD) US Dollar</option>
                                 <option value="CAD">(CAD) Canadian Dollar</option>
                                 <option value="EUR">(EUR) Euro</option>
                                 <option value="EUR">(GBP) British Pound</option>
                            </select>
                        </div>
                        <div class="col-sm-1 col-has-icon">
                            <img src="images/coin/fiat.png" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <br>
                            <button type="button" class="btn btn-lg btn-success" id="btnSaveWallets"><i class="icon icon-save-floppy"></i> Save Wallet</button>
                            <?php if ($id != 0) { ?> &nbsp;
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
