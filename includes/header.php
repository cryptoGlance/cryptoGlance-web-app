<!DOCTYPE html>
<html lang="en">
<?php require_once("includes/head.php"); ?>
   <body>
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
                        <?php require_once("includes/menu-active_panels.php"); ?>
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