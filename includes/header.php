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
                  <li id="dash-add-panel" class="grad-green"><a data-toggle="modal" data-target="#editPool" data-backdrop="static"><i class="icon icon-newwindow"></i></a> </li>
                  <li class="dropdown">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon icon-settingsandroid"></i> Settings <b class="caret"></b></a>
                     <ul class="dropdown-menu">
                        <li><a href="settings-general.php"><i class="icon icon-settingsthree-gears"></i> General</a></li>
                        <li><a href="settings-rigs.php"><i class="icon icon-servers"></i> Rigs/Miners <span class="badge">3</span></a></li>
                        <li><a href="settings-pools.php"><i class="icon icon-groups-friends"></i> Pools <span class="badge">2</span></a></li>
                        <li><a href="settings-addresses.php"><i class="icon icon-walletalt"></i> Addresses <span class="badge">12</span></a></li>
                        <li><a href="settings-feeds.php"><i class="icon icon-rss"></i> News Feeds <span class="badge">4</span></a></li>
                     </ul>
                  </li>
                  <li class="dropdown">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon icon-lifepreserver"></i> Help <b class="caret"></b></a>
                     <ul class="dropdown-menu">
                        <li class="dropdown-header">RigWatch</li>
                        <li><a href="help.php" rel="external">Help using RigWatch</a></li>
                        <li><a href="https://github.com/scar45/rigwatch" rel="external">Source on Github</a></li>
                        <li class="divider"></li>
                        <li class="dropdown-header">RigWatch Discussion</li>
                        <li><a href="help.php" rel="external">Bitcointalk.org Forum Thread</a></li>
                        <li><a href="https://github.com/scar45/rigwatch" rel="external">Reddit Post</a></li>
                        <li class="divider"></li>
                        <li class="dropdown-header">Litecoin Resources</li>
                        <li><a href="https://litecoin.org/" rel="external">Litecoin.org</a></li>
                        <li><a href="https://litecoin.info/Mining_hardware_comparison" rel="external">Mining Hardware Comparison</a></li>
                        <li><a href="https://litecoin.info/Mining_pool_comparison" rel="external">Pool Comparison</a></li>
                        <li><a href="http://bitcoinwisdom.com/litecoin/calculator" rel="external">Litecoin Calculator</a></li>
                        <li><a href="http://www.ltc-charts.com/" rel="external">LTC Charts</a></li>
                        <li><a href="http://www.reddit.com/r/litecoin/" rel="external">/r/litecoin (Reddit)</a></li>
                        <li><a href="http://www.reddit.com/r/litecoinmining/" rel="external">/r/litecoinmining (Reddit)</a></li>
                     </ul>
                  </li>
                  <li id="nav-login-button"><a href="login.php"><i class="icon icon-enteralt"></i> Login</a></li>
                  <li id="nav-logout-button"><a href="logout.php"><i class="icon icon-exitalt"></i> Logout</a></li>
               </ul>
            </div>
            <!--/.nav-collapse -->
         </div>
      </div>