
<script type="text/javascript" src="js/jquery-1.10.2.min.js?v=<?php echo CURRENT_VERSION; ?>"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js?v=<?php echo CURRENT_VERSION; ?>"></script>
<script type="text/javascript" src="js/jquery.cookie.js?v=<?php echo CURRENT_VERSION; ?>"></script>
<script type="text/javascript" src="js/jquery.scrollTo.min.js?v=<?php echo CURRENT_VERSION; ?>"></script>
<script type="text/javascript" src="js/masonry.pkgd.min.js?v=<?php echo CURRENT_VERSION; ?>"></script>
<script type="text/javascript" src="js/bootstrap.min.js?v=<?php echo CURRENT_VERSION; ?>"></script>
<script type="text/javascript" src="js/jquery.toastmessage.js?v=<?php echo CURRENT_VERSION; ?>"></script>
<script type="text/javascript" src="js/bootstrap-switch.min.js?v=<?php echo CURRENT_VERSION; ?>"></script>
<script type="text/javascript" src="js/cryptoglance-ui.js?v=<?php echo CURRENT_VERSION; ?>"></script>
<script type="text/javascript" src="js/version.js?v=<?php echo CURRENT_VERSION; ?>"></script>
<!--build:js scripts.js-->
<?php
    foreach ($jsArray as $js) {
        echo '<script type="text/javascript" src="js/'.$js.'.js?v='.CURRENT_VERSION.'"></script>';
    }
?>

<?php if ($generalSaveResult) { ?>
  <script type="text/javascript">$(document).ready(function() {
      showToastSettingsSaved();
    });</script>
<?php } elseif (!$generalSaveResult && !is_null($generalSaveResult)) { ?>
  <script type="text/javascript">$(document).ready(function() {
      showToastWriteError();
    });</script>
<?php } ?>
<!--/build-->
