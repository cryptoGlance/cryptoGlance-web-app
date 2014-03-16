<?php
require_once('includes/inc.php');
$error = false;

if (!empty($_SESSION['login_string'])) {
    header('Location: index.php');
    exit();
} else if (!empty($_POST['username']) && !empty($_POST['password'])) {
    require_once('includes/classes/login.php');
    
    $loginObj = new Login();
    if ($loginObj->login(trim($_POST['username']), trim($_POST['password'])) !== FALSE) {
        $_SESSION['login_string'] = hash('sha512', $_POST['password'] . $_SERVER['HTTP_USER_AGENT']);
        
        session_regenerate_id(); // This hangs sometimes and we dont know why...
        
        header('Location: index.php');
        exit();
    } else {
        unset($_SESSION['login_string']);
        $error = true;
    }
}

include("includes/login-header.php");
?>
         
      <div id="dashboard-wrap" class="container sub-nav login-container">
      
         <div id="overview" class="panel panel-primary panel-overview">
            <h1>Login</h1>
            <div class="panel-heading">
               <h2 class="panel-title"><small><i class="icon icon-enteralt"></i></small></h2>
            </div>
            <div class="panel-body panel-body-overview">
               <div id="panel-login">
                  <?php
                  if ($error) {
                  ?>
                  <div id="login-failure">
                     <p><i class="icon icon-fbdislike"></i> <big>You shall <b>NOT</b> pass!</big> You've entered incorrect credentials. (If you're having trouble, read the notes below the login button.)</p>
                  </div>
                  <?php
                  }
                  ?>
                  <form action="" method="POST" class="form-horizontal" role="form">
                    <div class="form-group">
                      <label for="username" class="col-sm-offset-1 col-sm-3 control-label"><i class="icon icon-user"></i></label>
                      <div class="col-sm-4">
                        <input type="text" name="username" id="username" placeholder="Username" class="form-control">
                      </div>                   
                    </div>
                    <div class="form-group">
                      <label for="password" class="col-sm-offset-1 col-sm-3 control-label"><i class="icon icon-key"></i></label>
                      <div class="col-sm-4">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-offset-1 col-sm-10">
                        <button type="submit" class="btn btn-lg btn-warning"><b>Login now!</b></button>
                      </div>
                    </div>
                 </form>            
               </div>
            </div><!-- / .panel-body -->
            <div class="panel-footer">
               <p><b>Forgot your password?</b> Well then, you'll need to delete the file <em>/<?php echo DATA_FOLDER; ?>/configs/account.json</em>, then log in with a fresh account immediately.</p>
               <hr>
               <p><span>Still having trouble? Touch base with us on &nbsp;<a href="https://plus.google.com/u/0/b/110896112995796953409/communities/111042089628113521779" rel="external"><i class="icon icon-googleplus"></i></a> <a href="http://reddit.com/r/rigwatch" rel="external"><i class="icon icon-reddit"></i></a> <a href="http://twitter.com/rigwatch" rel="external"><i class="icon icon-twitter"></i></a> or <a href="http://webchat.freenode.net/?channels=%23RigWatch&uio=OT10cnVlJjExPTIwNQa5" rel="external">join our IRC chat</a>.</span></p>
            </div>
         </div>
      </div>
      <!-- /container -->
      <script src="js/jquery-1.10.2.min.js"></script>
      <script src="js/jquery-ui-1.10.3.custom.min.js"></script>
      <script src="js/jquery.cookie.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <script src="js/prettyCheckable.min.js"></script>
      <script src="js/cryptoglance-ui.js"></script>
   </body>
</html>