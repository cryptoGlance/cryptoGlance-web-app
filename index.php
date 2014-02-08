<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
      <meta name="description" content="">
      <meta name="author" content="">
      <link rel="shortcut icon" href="favicon.png">
      <title>RigWatch - Dashboard</title>
      <!-- Bootstrap core CSS -->
      <link href="css/bootstrap.min.css" rel="stylesheet">
      <!-- Glyph Icon Font from WebHostingHub (http://www.webhostinghub.com/glyphs/) styles -->
      <link href="css/whhg.css" rel="stylesheet">
      <!-- Custom RigWatch styles -->
      <link href="css/rigwatch-base.css" rel="stylesheet">
      
      <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
      <![endif]-->
   </head>
   <body>
      <a href="https://plus.google.com/110896112995796953409" rel="publisher"></a>
      <div class="page-container">
      <!-- Fixed navbar -->
      <div class="navbar navbar-default navbar-fixed-top" role="navigation">
         <div class="container">
            <div class="navbar-header">
               <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
               <span class="sr-only">Toggle navigation</span>
               <i class="icon icon-dropmenu"></i>
               </button>
               <a class="navbar-brand" href="index.php"><img src="images/rigwatch-logo-landscape.png" alt="RigWatch" /></a>
            </div>
            <div class="navbar-collapse collapse">
               <ul class="nav nav-pills navbar-nav">
                  <li class="active"><a href="index.php"><i class="icon icon-speed"></i> Dashboard</a></li>
                  <li id="dash-add-panel" class="grad-green"><a title="Add Panel" data-toggle="modal" data-target="#editPool" data-backdrop="static"><i class="icon icon-newwindow"></i></a> </li>
                  <li class="dropdown">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown">Tools <b class="caret"></b></a>
                     <ul class="dropdown-menu">
                        <li class="dropdown-header site-width-slider">Panel Width</li>
                        <li class="site-width-slider">
                           <span class="tooltip"></span> <!-- Tooltip -->
                           <span class="width-reading">90%</span> <!-- width-reading -->
                           <div id="slider"></div> <!-- the Slider -->
                        </li>
                        <li><a href="settings.php"><i class="icon icon-settingsandroid"></i> RigWatch Settings</a></li>
                        <div class="divider"></div> <!-- the Slider -->
                     </ul>
                  </li>
                  <li class="dropdown">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown">Help <b class="caret"></b></a>
                     <ul class="dropdown-menu">
                        <li class="dropdown-header">RigWatch</li>
                        <li><a href="help.php">Help using RigWatch</a></li>
                        <li><a href="https://github.com/scar45/rigwatch" rel="external">Source on Github</a></li>
                        <li class="divider"></li>
                        <li class="dropdown-header">RigWatch Discussion</li>
                        <li><a href="help.php" rel="external">Bitcointalk.org Forum Thread</a></li>
                        <li><a href="https://github.com/scar45/rigwatch" rel="external">Reddit Post</a></li>
                     </ul>
                  </li>
                  <li id="nav-login-button"><a href="login.php">Login</a></li>
                  <li id="nav-logout-button"><a href="logout.php">Logout</a></li>
                  <li class="panel-controls"><a id="collapse-all-panels" href="#" title="Collapse ALL Panels"><i class="icon icon-fastup"></i><span>Collapse All</span></a><a id="expand-all-panels" href="#" title="Expand ALL Panels"><i class="icon icon-fastdown"></i><span>Expand All</span></a></li>
               </ul>
            </div>
            <!--/.nav-collapse -->
         </div>
      </div>
         <div class="panel panel-primary panel-in-footer">
            <div class="panel-body">
               <div class="stat-pair stat-pair-devs">
                  <h1>RigWatch is coming soon!</h1>
                  <div class="stat-label">
                     Made with <i class="icon icon-pixelheart"></i> by:
                  </div>
                  <div class="stat-value">
                     <a href="http://github.com/scar45" rel="external"><img class="avatar" src="https://2.gravatar.com/avatar/75ef5c7e71725a216433547ad93fbc0c?d=https%3A%2F%2Fidenticons.github.com%2Fc78bf60d254e1947a636d8152e588691.png"><br>scar45</a> / <a href="http://github.com/Stoyvo" rel="external"><img class="avatar" src="https://2.gravatar.com/avatar/12885e27b0f7be03e5d398d0f4ad3b5c?d=https%3A%2F%2Fidenticons.github.com%2F97711c22cd4fe16127b6c1bf98c926a3.png"><br>Stoyvo</a> / <a href="http://github.com/DChaykas" rel="external"><img class="avatar" src="https://2.gravatar.com/avatar/76517ae0a2c5ded3f7365d13b849eaab?d=https%3A%2F%2Fidenticons.github.com%2Fc858c1bf532f19e2f976c6233a3be279.png"><br>DChaykas</a>
                  </div>
                  <div class="stat-label">
                     Long live crypto-currency!
                  </div>
               </div>
               <div class="stat-pair stat-pair-qr">
                  <div class="stat-label">
                     Donations make us feel like champs <i class="icon icon-medal"></i>
                  </div>
                  <div class="stat-value">
                     <a href="images/LUQ4GyjjDtopdGj3h8CvDEP4QCLd3FEhDT.png" rel="external"><img src="images/icon-litecoin.png" alt="Litecoin" /></a> LUQ4GyjjDtopdGj3h8CvDEP4QCLd3FEhDT
                     <br>
                     <a href="images/1HBY1cskYysa2in8zNVfLgPLpEYAoTsGyS.png" rel="external"><img src="images/icon-bitcoin.png" alt="Bitcoin" /></a> 1HBY1cskYysa2in8zNVfLgPLpEYAoTsGyS
                  </div>
               </div>               
            </div><!-- / .panel-body -->

            <div class="panel-footer">
               <div class="pull-left">
                  <!-- <span class="label label-success"><i class="icon icon-ok"></i> Healthy</span> -->
                  <h3>Licensed under GPLv2</h3>
               </div>
               <div class="pull-right">
                  <a href="https://github.com/scar45/rigwatch" rel="external"><button type="button" class="btn btn-default"><i class="icon icon-github"></i> Source on Github</button></a>
               </div>
            </div>
         </div>
      </div>      
      <script src="js/jquery-1.10.2.min.js"></script>
      <script src="js/jquery-ui-1.10.3.custom.min.js"></script>
      <script src="js/jquery.scrollTo.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <script src="js/rigwatch-ui.js"></script>
   </body>
</html>