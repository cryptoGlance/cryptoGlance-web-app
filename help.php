<?php
include('includes/inc.php');

# This file passes the content of the Readme.md file in the same directory
# through the Markdown filter. You can adapt this sample code in any way
# you like.

# PHP Markdown Lib Copyright © 2004-2013 Michel Fortin http://michelf.ca/
# All rights reserved.

# Install PSR-0-compatible class autoloader
spl_autoload_register(function($class){
	require preg_replace('{\\\\|_(?!.*\\\\)}', DIRECTORY_SEPARATOR, ltrim($class, '\\')).'.php';
});

# Get Markdown class
use \Michelf\Markdown;

# Read file and pass content through the Markdown parser
$text = file_get_contents('README.md');
$html = Markdown::defaultTransform($text);

$jsArray = array();

require_once("includes/header.php");
?>
       
<!-- ### Below is the Settings page which contains common/site-wide preferences
      
-->
         
      <div id="help-wrap" class="container sub-nav full-content">
        <div class="markdown-body">
           <div id="readme" class="panel panel-default panel-no-grid">
             <h1>Help + FAQs</h1>
             <div class="panel-heading">
                 <h2 class="panel-title"><i class="icon icon-document"></i> README.md</h2>
              </div>
              <div class="panel-body panel-body-markdown">
              <?php
                 # Put rendered README markdown in the document
                 echo $html;
              ?>
              </div>
           </div>
        </div>
      </div>
      <!-- /container -->

      <?php require_once("includes/footer.php"); ?>
      </div>
      <!-- /page-container -->
      
      <?php require_once("includes/scripts.php"); ?>
   </body>
</html>