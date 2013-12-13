<!DOCTYPE html>
<html lang="en">
<?php require_once("includes/head.php"); ?>
   <body>
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
                  <li class="active"><a href="#"><i class="icon icon-speed"></i> Dashboard</a></li>
                  <li class="dropdown">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon icon-settingsandroid"></i> Settings <b class="caret"></b></a>
                     <ul class="dropdown-menu">
                        <li><a href="#"><i class="icon icon-settingsthree-gears"></i> General</a></li>
                        <li><a href="#"><i class="icon icon-servers"></i> Rigs/Miners <span class="badge">3</span></a></li>
                        <li><a href="#"><i class="icon icon-groups-friends"></i> Pools <span class="badge">2</span></a></li>
                     </ul>
                  </li>
                  <li class="dropdown">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon icon-lifepreserver"></i> Help <b class="caret"></b></a>
                     <ul class="dropdown-menu">
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
                  <li class="dropdown">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon icon-question-sign"></i> About <b class="caret"></b></a>
                     <ul class="dropdown-menu">
                        <li class="dropdown-header">RigWatch Source</li>
                        <li><a href="https://github.com/scar45/rigwatch" rel="external"><i class="icon icon-github"></i> RigWatch on Github</a></li>
                        <li class="divider"></li>
                        <li class="dropdown-header">Developers</li>
                        <li><a href="https://github.com/scar45" rel="external">scar45</a></li>
                        <li><a href="https://github.com/stoyvo" rel="external">Stoyvo</a></li>
                        <li><a href="https://github.com/dchaykas" rel="external">DChaykas</a></li>
                     </ul>
                  </li>
               </ul>
            </div>
            <!--/.nav-collapse -->
         </div>
      </div>