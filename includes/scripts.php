<script type="text/javascript" src="js/packages/jquery-ui-1.10.3.custom.min.js?v=<?php echo CURRENT_VERSION; ?>"></script>
<script type="text/javascript" src="js/packages/jquery.cookie.js?v=<?php echo CURRENT_VERSION; ?>"></script>
<script type="text/javascript" src="js/packages/jquery.scrollTo.min.js?v=<?php echo CURRENT_VERSION; ?>"></script>
<script type="text/javascript" src="js/packages/masonry.pkgd.min.js?v=<?php echo CURRENT_VERSION; ?>"></script>
<script type="text/javascript" src="js/packages/bootstrap.min.js?v=<?php echo CURRENT_VERSION; ?>"></script>
<script type="text/javascript" src="js/packages/jquery.toastmessage.js?v=<?php echo CURRENT_VERSION; ?>"></script>
<script type="text/javascript" src="js/packages/bootstrap-switch.min.js?v=<?php echo CURRENT_VERSION; ?>"></script>
<script type="text/javascript" src="js/cryptoglance-ui.js?v=<?php echo CURRENT_VERSION; ?>"></script>
<script type="text/javascript" src="js/version.js?v=<?php echo CURRENT_VERSION; ?>"></script>
<!--build:js scripts.js-->
<?php
    foreach ($jsArray as $js) {
        echo '<script type="text/javascript" src="js/'.$js.'.js?v='.CURRENT_VERSION.'"></script>';
    }
?>

<?php if ($generalSaveResult && !is_null($generalSaveResult)) { ?>
  <script type="text/javascript">$(document).ready(function() {
      showToastSettingsSaved();
    });</script>
<?php } elseif (!$generalSaveResult && !is_null($generalSaveResult)) { ?>
  <script type="text/javascript">$(document).ready(function() {
      showToastWriteError();
    });</script>
<?php } ?>
<!--/build-->