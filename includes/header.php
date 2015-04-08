<!DOCTYPE html>
<html lang="en">
<?php require_once("includes/head.php"); ?>
   <body>
      <?php require_once("templates/modals/add_panel.php"); ?>

      <!-- -->
      <?php require_once("templates/modals/qrcode-donate-btc.php"); ?>
      <!-- -->

      <div class="page-container">
      <div class="dark-overlay"></div>
      <!-- Fixed navbar -->
      <div class="navbar navbar-default navbar-fixed-top" role="navigation">
         <div class="container">
            <div class="navbar-header">
               <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
               <span class="sr-only">Toggle navigation</span>
               <i class="icon icon-dropmenu"></i>
               </button>
               <a class="navbar-brand" href="index.php"><img src="images/logo-landscape.png" alt="cryptoGlance" /></a>
            </div>
            <div class="navbar-collapse collapse">
               <ul class="nav nav-pills navbar-nav<?php echo ($currentPage != 'index') ? ' no-dash' : '' ?>">
                  <li class="<?php echo ($currentPage == 'index') ? 'active ' : '' ?>topnav topnav-icon"><a id="dash-link" href="index.php"><i class="icon icon-speed"></i> Dashboard</a>
                    <?php if ($currentPage == 'index') { ?><a id="dash-add-panel" class="grad-green" title="Add Panel" data-toggle="modal" data-target="#addPanel"><i class="icon icon-newtab"></i></a><?php } ?>
                  </li>
                  <li class="<?php echo ($currentPage == 'settings') ? 'active ' : '' ?>dropdown">
                     <a href="#" class="dropdown-toggle"><i class="icon icon-settingsthree-gears mobile-icon"></i> Tools <b class="caret"></b></a>
                     <ul class="dropdown-menu">
                        <li class="dropdown-header site-layout">Site Layout</li>
                        <li class="site-layout-btns">
                          <div class="btn-group">
                            <button type="button" id="layout-list" class="btn btn-primary"><i class="icon icon-menu"></i></button>
                            <button type="button" id="layout-grid" class="btn btn-primary"><i class="icon icon-th"></i></button>
                          </div>
                        </li>
                        <li class="dropdown-header site-width-slider">Panel Width</li>
                        <li class="site-width-slider">
                           <span class="width-reading">90%</span> <!-- width-reading -->
                           <div id="slider"></div> <!-- the Slider -->
                        </li>
                        <?php if ($currentPage == 'index') { ?>
                        <li class="dropdown-header chk-hashrate">
                            <label for="show-total-hashrate">Show Total Hashrate(s)</label><input type="checkbox" id="showTotalHashrate" name="show-total-hashrate" <?php echo ($_COOKIE['show_total_hashrate'] === 'false') ? '' : 'checked="checked"'; ?> />
                        </li>
                        <?php } ?>
                        <li><a href="settings.php"><i class="icon icon-settingsandroid"></i> cryptoGlance Settings</a></li>
                        <!-- <div class="divider"></div> -->
                        <?php //require_once("includes/menu-active_panels.php"); ?>
                     </ul>
                  </li>
                  <li class="<?php echo ($currentPage == 'help') ? 'active ' : '' ?>dropdown topnav">
                     <a href="#" class="dropdown-toggle"><i class="icon icon-question-sign mobile-icon"></i> Help <b class="caret"></b></a>
                     <ul class="dropdown-menu">
                        <li class="dropdown-header">Learn more</li>
                        <li><a href="help.php"><i class="icon icon-preview"></i> View the README</a></li>
                        <li><a href="changelog.php"><i class="icon icon-notes"></i> View the CHANGELOG</a></li>
                        <li class="divider"></li>
                        <li class="dropdown-header">Official Links</li>
                        <li><a href="https://play.google.com/store/apps/details?id=com.scar45.cryptoGlance" rel="external"><i class="icon icon-playstore"></i> Android Companion App</a></li>
                        <li><a href="https://github.com/cryptoGlance/cryptoGlance-web-app" rel="external"><i class="icon icon-github"></i> Source on Github</a></li>
                        <li><a href="http://cryptoglance.info" rel="external"><i class="icon icon-glasses"></i> cryptoGlance Homepage</a></li>
                     </ul>
                  </li>
                  <li id="nav-login-button" class="topnav topnav-icon"><a href="logout.php"><i class="icon icon-exitalt"></i> Logout</a></li>
               </ul>
            </div>
            <!--/.nav-collapse -->
         </div>
      </div>

      <?php if ($currentPage == 'index') { ?>
      <ul id="total-hashrates"<?php echo ($_COOKIE['show_total_hashrate'] === 'false') ? 'style="display: none;"' : ''; ?>><li></li></ul>
      <?php } ?>
