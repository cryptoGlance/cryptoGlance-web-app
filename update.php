<?php
include('includes/inc.php');

if (!$_SESSION['login_string']) {
    header('Location: login.php');
    exit();
} else if (!$_COOKIE['cryptoglance_version']) {
    header('Location: index.php');
    exit();
}

session_write_close();

if (isset($_POST['cryptoglance_version']) && 
    ($_POST['cryptoglance_version'] != CURRENT_VERSION) && 
    ($_SERVER['PHP_SELF'] == $_SERVER['REQUEST_URI'])
) {
    set_time_limit(0); // Downloading or unzipping might exceed this time limit
    error_reporting(-1); ini_set('display_errors', 0);
    $currentDir = realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR;
    $newVersion = strip_tags($_POST['cryptoglance_version']);
    $updateDir = 'update' . DIRECTORY_SEPARATOR . $newVersion;
    $extractedFolder = '';
    // get settings for update type to get
    $settings = $cryptoGlance->getSettings();
//    $settings['general']['updates']['enabled'] // 1 / 0
//    $settings['general']['updates']['type'] // release, beta, nightly

    // Need this late in the script
    function lensort($a,$b){
        return strlen($a)-strlen($b);
    }
    
    echo "<html>
    <head>
        <script type=\"text/javascript\" src=\"js/jquery-1.10.2.min.js\"></script>
        <script type=\"text/javascript\">
            var scrollUpdate = setInterval(function() {
                $('html, body').animate({ scrollTop: $(document).height() }, 0);
                if ($('#done').length != 0) {
                    clearInterval(scrollUpdate);
                    $('#done').remove();
                } 
            }, 50);
        </script>
        <style type=\"text/css\">
            body {
              background: #030;
              color: #090;
              display: block;
              font-size: 15px;
              line-height: 26px;
              padding: 0 10px;
              text-shadow: 0px 0px 1px rgba(0, 255, 0, 0.3);
              text-align: left;
              text-transform: none;
            }
        </style>
    </head>
    <body>
        <pre style=\"font-family: Menlo,Monaco,Consolas,Courier New,monospace;margin:0;white-space: pre-wrap;\">";
    if (ob_get_level() == 0) ob_start();
    if ($settings['general']['updates']['enabled'] == 1) {
        $updateType = $settings['general']['updates']['type'];
        
        echo '==> Starting Update...<br />'; ob_flush(); flush(); sleep(1);

        // MAKE FOLDERS -----------------------
        
        echo '==> Creating temporary directory to download update and unzip: '.$updateDir.'<br />'; ob_flush(); flush();
        
        if (!mkdir($currentDir . $updateDir, 0777, true)) {
            echo '==> ERROR: Failed to create the directory: ' . $updateDir . '<br />';  ob_flush(); flush(); sleep(1);
            exit;
        } else {
            echo '==> Successfully created temporary directory!<br />'; ob_flush(); flush(); sleep(1);
        }

        // DOWNLOADING -----------------------

        echo '==> Downloading: ' . $updateFeed[$updateType]['zip'] . '<br />'; ob_flush(); flush();
                
        $curl = curl_init();
        $fp = fopen($currentDir . $updateDir .'.zip', 'w');
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; cryptoGlance ' . CURRENT_VERSION . '; PHP/' . phpversion() . ')');
        curl_setopt($curl, CURLOPT_URL, $updateFeed[$updateType]['zip']);
        curl_setopt($curl, CURLOPT_FAILONERROR, true);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_TIMEOUT, 60);
        curl_setopt($curl, CURLOPT_FILE, $fp);
        $page = curl_exec($curl);
        if (!$page) {
            echo '==> ERROR: ' . curl_error($curl) . '<br />';
            exit;
        } else {
            echo '==> Download Successful!<br />';
        }
        curl_close($curl); ob_flush(); flush(); sleep(1);

        // UNZIP -----------------------
        
        echo '==> Starting unzip process...<br />'; ob_flush(); flush();
        
        $zip = new ZipArchive;  
        if (!$zip) {
            echo '==> ERROR: Could not create ZipArchive object...<br />'; ob_flush(); flush(); sleep(1);
            exit;
        } else if($zip->open($currentDir . $updateDir.'.zip') != "true") { 
            echo '==> ERROR: Could not open ' . $file_zip . '<br />'; ob_flush(); flush(); sleep(1);
            exit;
        }
        
        echo '==> Unzipping archive to: '.$updateDir.'<br />'; ob_flush(); flush(); sleep(1);
        
        $zip->extractTo($currentDir . $updateDir);
        $zip->close();
        
        echo '==> Update Unzipped!<br />'; ob_flush(); flush(); sleep(1);
        
        echo '==> Deleting update archive file!<br />'; ob_flush(); flush();
        
        unlink($currentDir . $updateDir.'.zip');
        
        echo '==> Update archive file deleted!<br />'; ob_flush(); flush(); sleep(1);
        
        foreach (new DirectoryIterator($currentDir . $updateDir) as $file) {
            if($file->isDot() || !$file->isDir()) continue;
            if($file->isDir()) $extractedFolder = $updateDir.DIRECTORY_SEPARATOR.$file->getFilename();
        }
        if (empty($extractedFolder)) {
            die('==> ERROR: Something bad happened. Extracted Folder is empty!');
        }
        
        // START UPDATE -----------------------
        
        echo '----------<br />';
        echo '==> Updating cryptoGlance... <br />'; ob_flush(); flush(); sleep(1);
        
        echo '==> Deleting old files:<br />'; ob_flush(); flush(); sleep(1);
        $it = new RecursiveDirectoryIterator('.', RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
        // first delete files
        foreach($files as $file) {
            if ($file->getFilename() === '.' || $file->getFilename() === '..' || strpos($file->getRealPath(), DIRECTORY_SEPARATOR . DATA_FOLDER) !== false) {
                continue;
            }
            $realFilePath = $file->getRealPath();
            if (!$file->isDir() && strpos($file->getRealPath(), DIRECTORY_SEPARATOR . 'update' . DIRECTORY_SEPARATOR) === false && strpos($file->getRealPath(), DIRECTORY_SEPARATOR . '.update') === false) {
                if (unlink($realFilePath)) {
                    echo '==> Deleted File: ' . $realFilePath . '<br />'; ob_flush(); flush();
                } else {
                    echo '==> Cannot Delete File: ' . $realFilePath . '<br />'; ob_flush(); flush();
                }
            }
        }
        // now delete folders
        $failedFolders = array();
        foreach($files as $file) {
            if ($file->getFilename() === '.' || $file->getFilename() === '..' || strpos($file->getRealPath(), DIRECTORY_SEPARATOR.'update') !== false || strpos($file->getRealPath(), DIRECTORY_SEPARATOR.'.update') !== false || strpos($file->getRealPath(), DIRECTORY_SEPARATOR . DATA_FOLDER) !== false) {
                continue;
            }
            $realFilePath = $file->getRealPath();
            if ($file->isDir()){
                if (rmdir($realFilePath)) {
                    echo '==> Deleted Folder: ' . $realFilePath . '<br />'; ob_flush(); flush();
                } else {
                    $failedFolders[] = $realFilePath;
                    echo '==> Cannot Delete Folder: ' . $realFilePath . '<br />'; ob_flush(); flush();
                }
            }
        }
        // sort all failedFolders and do this process again
        usort($failedFolders,'lensort');
        foreach($failedFolders as $folderPath) {
            if (rmdir($folderPath)) {
                echo '==> Deleted Folder: ' . $folderPath . '<br />'; ob_flush(); flush();
            } else {
                echo '==> Cannot Delete Folder: ' . $folderPath . '<br />'; ob_flush(); flush();
            }
        }
        echo '==> Done deleting old files...<br />'; ob_flush(); flush(); sleep(1);
        
        echo '<br />==> Copying new files: ' . $extractedFolder . '<br />'; ob_flush(); flush();
        $it = new RecursiveDirectoryIterator($currentDir . $extractedFolder, RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
        // first make folders
        foreach($files as $file) {
            if ($file->getFilename() === '.' || $file->getFilename() === '..' || strpos($file->getRealPath(), DIRECTORY_SEPARATOR . DATA_FOLDER) !== false) {
                continue;
            }
            $realPath = str_replace(DIRECTORY_SEPARATOR.$extractedFolder, '', $file->getRealPath());
            if ($file->isDir() && !file_exists($realPath)){
                if (mkdir($realPath, 755, true)) {
                    echo '==> Created Directory: ' . $realPath . '<br />'; ob_flush(); flush();
                } else {
                    echo '==> Cannot Create Directory: ' . $realPath . '<br />'; ob_flush(); flush();
                }
            }
        }
        // now copy files
        foreach($files as $file) {
            if ($file->getFilename() === '.' || $file->getFilename() === '..' || strpos($file->getRealPath(), DIRECTORY_SEPARATOR . DATA_FOLDER) !== false) {
                continue;
            }
            if (!$file->isDir()){
                if (copy($file->getRealPath(), str_replace(DIRECTORY_SEPARATOR.$extractedFolder, '', $file->getRealPath()))) {
                    echo '==> Copied File: ' . str_replace(DIRECTORY_SEPARATOR.$extractedFolder, '', $file->getRealPath()) . '<br />'; ob_flush(); flush();
                } else {
                    echo '==> Cannot Copy File: ' . str_replace(DIRECTORY_SEPARATOR.$extractedFolder, '', $file->getRealPath()) . '<br />'; ob_flush(); flush();
                }
            }
        }
        echo '==> Done copying new files...<br />'; ob_flush(); flush(); sleep(1);
        
        // START Cleanup -----------------------
        
        echo '----------<br />';
        echo '==> Cleaning up... <br />'; ob_flush(); flush(); sleep(1);
        echo '==> Deleting update files:<br />'; ob_flush(); flush(); sleep(1);
        $it = new RecursiveDirectoryIterator($currentDir . 'update', RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
        // first delete files
        foreach($files as $file) {
            if ($file->getFilename() === '.' || $file->getFilename() === '..') {
                continue;
            }
            $realFilePath = $file->getRealPath();
            if (!$file->isDir()) {
                if (unlink($realFilePath)) {
                    echo '==> Deleted File: ' . $realFilePath . '<br />'; ob_flush(); flush();
                } else {
                    echo '==> Cannot Delete File: ' . $realFilePath . '<br />'; ob_flush(); flush();
                }
            }
        }
        // now delete folders
        $failedFolders = array();
        foreach($files as $file) {
            if ($file->getFilename() === '.' || $file->getFilename() === '..') {
                continue;
            }
            $realFilePath = $file->getRealPath();
            if ($file->isDir()) {
                if (rmdir($realFilePath)) {
                    echo '==> Deleted Folder: ' . $realFilePath . '<br />'; ob_flush(); flush();
                } else {
                    $failedFolders[] = $realFilePath;
                    echo '==> Cannot Delete Folder: ' . $realFilePath . '<br />'; ob_flush(); flush();
                }
            }
        }
        // sort all failedFolders and do this process again
        usort($failedFolders,'lensort');
        foreach($failedFolders as $folderPath) {
            if (rmdir($folderPath)) {
                echo '==> Deleted Folder: ' . $folderPath . '<br />'; ob_flush(); flush();
            } else {
                echo '==> Cannot Delete Folder: ' . $folderPath . '<br />'; ob_flush(); flush();
            }
        }
        if (rmdir(getcwd().'/update')) {
            echo '==> Deleted Folder: ' . $currentDir.'update' . '<br />'; ob_flush(); flush();
        } else {
            echo '==> Cannot Delete Folder: ' . $currentDir.'update' . '<br />'; ob_flush(); flush();
        }
        echo '==> Done cleaning up...<br />'; ob_flush(); flush(); sleep(1);
        
        // FINISHED -----------------------
                    
        echo '----------<br />';
        echo 'Update Done!';
        echo '<div id="done"></div>'; // this is purely for JS to stop scrolling down
        ob_flush();
        flush();
    } else {
        echo "==> ERROR: Updates not enabled!";
        ob_flush();
        flush();
    }
    ob_end_flush();
    echo "</pre>
    </body>
</html>";
    exit;
}


$jsArray = array();
require_once("includes/header.php");
?>
       
    <div id="auto-update-wrap" class="container sub-nav">
        <div id="AutoUpdate" class="panel panel-primary panel-no-grid panel-auto-update">
            <h1>Auto-Updater</h1>
            <div class="panel-heading">
                <h2 class="panel-title"><i class="icon icon-refresh"></i></h2>
            </div>
            <div class="panel-body">
              <div class="stat-pair">
                <div class="stat-label">
                  <form method="POST" target="cg_update">
                    <h3>Update Available!</h3>
                    <p>The version of cryptoGlance that you're running <span class="orange">(<?php echo CURRENT_VERSION ?>)</span> can be updated to <span class="green"><?php echo $_COOKIE['cryptoglance_version'] ?></span>.</p>
                    <p>It is advised that you backup your <span class="blue">/<?php echo DATA_FOLDER; ?></span> folder prior to running the update process.</p>
                    <button type="button" class="btn btn-primary" id="btn-update-process" onClick="submit()"><i class="icon icon-restart"></i> Start Update Process</button>
                    <input type="hidden" name="cryptoglance_version" value="<?php echo $_COOKIE['cryptoglance_version'] ?>" />
                    <iframe name="cg_update" src="#" style="display:none;overflow:hidden;" scrolling="auto"></iframe>
                  </form>
                    
<!--                  <pre style="display: none;">-->
<!--==> Starting-->
<!--==> Target_url: https://github.com/cryptoGlance/cryptoGlance-web-app/archive/development.zip-->
<!--==> Headers stripped out-->
<!--==> Downloaded file: https://github.com/cryptoGlance/cryptoGlancecryptoGlance/cryptoGlancecryptoGlance/cryptoGlance-web-app/archive/development.zip-->
<!--==> Saved as file: downloads/update.zip-->
<!--==> About to unzip ...-->
<!--==> Unzipped file to: downloads/update-->
<!--                  </pre>-->
                </div>
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