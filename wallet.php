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
                    <span class="green"><?php echo $wallet['currency_balance'] ?> <img src="images/coin/<?php echo $wallet['currency'] ?>.png" /> <?php echo $wallet['currency_code'] ?></span> <span>//</span> <span class="blue"><?php echo $wallet['fiat_balance'] ?> <img src="images/coin/fiat.png" /> <?php echo $wallet['fiat_code'] ?></span> <?php if (strtolower($wallet['currency_code']) !== 'btc') { ?><span>//</span>  <span class="blue"><?php echo $wallet['coin_balance'] ?> <img src="images/coin/bitcoin.png" /> <?php echo $wallet['coin_code'] ?></span> <?php } ?>
                </div>
                <div class="table-responsive">
                    <form role="form">
                        <table class="table table-hover table-striped table-wallet">
                            <thead>
                                <tr>
                                    <th>Address Name</th>
                                    <th>Balance</th>
                                    <th>Fiat ( <?php echo $wallet['fiat_code'] ?> )</th>
<?php if ($wallet['currency_code'] != $wallet['coin_code']) { ?><th>Coin ( <?php echo $wallet['coin_code'] ?> )</th><?php } ?>
                                    <th>Address / Public Key</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($wallet['addresses'] as $addressKey => $addressData) { ?>
                                <tr data-id="<?php echo $addressData['id']; ?>">
                                    <td data-type="label">
                                        <span><?php echo $addressData['label']?></span>
                                        <input type="hidden" name="address[<?php echo $addressData['id']; ?>][label]" class="form-control" value="<?php echo $addressData['label']; ?>" placeholder="Label" />
                                    </td>
                                    <td><?php echo $addressData['balance']; ?> <img src="images/coin/<?php echo $wallet['currency'] ?>.png" /> <?php echo $wallet['currency_code'] ?></td>
                                    <td><?php echo $addressData['fiat_balance']; ?> <img src="images/coin/fiat.png" /> <?php echo $wallet['fiat_code']; ?></td>
<?php if ($wallet['currency_code'] != $wallet['coin_code']) { ?><td><?php echo $addressData['coin_balance']; ?> <img src="images/coin/bitcoin.png" /> <?php echo $wallet['coin_code']; ?></td><?php } ?>
                                    <td data-type="address">
                                        <span><?php echo $addressKey; ?></span>
                                        <input type="hidden" name="address[<?php echo $addressData['id']; ?>][address]" class="form-control" value="<?php echo $addressKey; ?>" placeholder="Address" />
                                    </td>
                                    <td><a class="editAddress"><span class="green"><i class="icon icon-edit"></i></span></a> &nbsp; <a class="removeAddress"><span class="red"><i class="icon icon-remove"></i></span></a></td>
                                </tr>
                                <?php } ?>
                                <tr>
                                    <td colspan="2" data-type="label"><input type="text" name="label" class="form-control" placeholder="Label"></td>
                                    <td>0.00 <img src="images/coin/fiat.png" /> <?php echo $wallet['fiat_code']; ?></td>
<?php if ($wallet['currency_code'] != $wallet['coin_code']) { ?><td>0 <img src="images/coin/bitcoin.png" /> <?php echo $wallet['coin_code']; ?></td><?php } ?>
                                    <td data-type="address"><input type="text" name="address" class="form-control" placeholder="Address"></td>
                                    <td><a class="addAddress"><span class="blue"><i class="icon icon-save-floppy"></i></span></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
        <?php } ?>

        <div id="walletDetails" data-id="<?php echo $id ?>" class="panel panel-default panel-no-grid panel-narrow">
            <h1>Wallet Details</h1>
            <div class="panel-heading">
                <h2 class="panel-title"><i class="icon icon-walletalt"></i></h2>
            </div>
            <div class="panel-body">
              <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="inputWalletName" class="control-label col-sm-4">Wallet Name:</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="walletName" placeholder="Donation Addresses" name="label" value="<?php echo $wallet['label'] ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputWalletCurrency" class="control-label col-sm-4">Currency:</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="currency" id="walletCurrency" <?php echo ($id != 0 ? 'disabled' : '') ?>>
                                <?php foreach ($walletObj->getCurrencies() as $code => $currency) { ?>
                                <option value="<?php echo $code ?>" <?php echo ($wallet['currency'] == $code ? 'selected' : '') ?>><?php echo $code ?> - <?php echo ucwords($currency) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-2 col-has-icon">
                            <img id="currencyImage" src="images/coin/<?php echo ($wallet['currency']) ? $wallet['currency'] : 'bitcoin' ?>.png" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputFiatCurrency" class="control-label col-sm-4">Fiat Conversion:</label>
                        <div class="col-sm-6">
                            <select class="form-control" id="walletFiat" name="fiat">
                                 <?php foreach ($walletObj->getFiat() as $code => $fiat) { ?>
                                     <option value="<?php echo $code ?>" <?php echo ($wallet['fiat_code'] == $code ? 'selected' : '') ?>><?php echo $code ?> - <?php echo $fiat; ?></option>
                                     <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-1 col-has-icon">
                            <img src="images/coin/fiat.png" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <br>
                            <button type="button" class="btn btn-lg btn-success" id="btnSaveWallet"><i class="icon icon-save-floppy"></i> Save Wallet</button>
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
