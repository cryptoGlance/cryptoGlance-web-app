<!--build:js scripts.js-->
<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/jquery.scrollTo.min.js"></script>
<script type="text/javascript" src="js/masonry.pkgd.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.toastmessage.js"></script>
<script type="text/javascript" src="js/bootstrap-switch.min.js"></script>
<script type="text/javascript" src="js/cryptoglance-ui.js"></script>
<script type="text/javascript" src="js/version.js"></script>
<?php
    foreach ($jsArray as $js) {
        echo '<script type="text/javascript" src="js/'.$js.'.js"></script>';
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