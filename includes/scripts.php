<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/jquery.scrollTo.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/messenger.min.js"></script>
<script type="text/javascript" src="js/messenger-theme-flat.js"></script>
<script type="text/javascript" src="js/prettyCheckable.min.js"></script>
<script type="text/javascript" src="js/ajax.js"></script> 
<script type="text/javascript" src="js/rigwatch-ui.js"></script>
<script type="text/javascript" src="js/version.js"></script> 
<?php
    foreach ($jsArray as $js) {
        echo '<script type="text/javascript" src="js/'.$js.'.js"></script>';
    }
?>