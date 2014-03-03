<?php require_once("includes/header.php"); ?>
       
<!-- ### Below is the Settings page which contains common/site-wide preferences
      
-->
         
      <div id="settings-wrap" class="container sub-nav full-content">
        <div id="readme" class="panel panel-default no-icon">
          <h1>RigWatch Settings</h1>
          <div class="panel-heading">
              <h2 class="panel-title"><i class="icon icon-settingsandroid"></i> General</h2>
          </div>
          <div class="panel-body">
            <form class="form-horizontal" role="form">
              <fieldset>
                <h3>Stat Refresh Intervals:</h3>                
                <div class="form-group">
                  <label class="col-sm-5 control-label">Rigs:</label>
                  <div class="col-sm-3 refresh-interval">
                    <select class="form-control">
                      <option>2 seconds</option>
                      <option>3 seconds</option>
                      <option>5 seconds</option>
                      <option>10 seconds</option>
                      <option>30 seconds</option>
                      <option>1 minute</option>
                      <option>2 minutes</option>
                      <option>5 minutes</option>
                      <option>10 minutes</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-5 control-label">Pools:</label>
                  <div class="col-sm-3 refresh-interval">
                    <select class="form-control">
                      <option>15 seconds</option>
                      <option>30 seconds</option>
                      <option>1 minute</option>
                      <option>2 minutes</option>
                      <option>5 minutes</option>
                      <option>10 minutes</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-5 control-label">Wallets:</label>
                  <div class="col-sm-3 refresh-interval">
                    <select class="form-control">
                      <option>10 minutes</option>
                      <option>30 minutes</option>
                      <option>45 minutes</option>
                      <option>1 hour</option>
                      <option>2 hours</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-5 col-sm-2">
                    <button type="submit" class="btn btn-lg btn-success"><i class="icon icon-save-floppy"></i> Save General Settings</button>
                  </div>
                </div>
              </fieldset>
            </form>
            <br>
          </div>
          <div class="panel-heading">
              <h2 class="panel-title"><i class="icon icon-emailforwarders"></i> E-Mail Settings</h2>
          </div>
          <div class="panel-body">
            <form class="form-horizontal" role="form">
              <fieldset>
                <h3>Notify these e-mail addresses:</h3>
                <div class="form-group">
                  <label for="inputYourEmail" class="col-sm-4 control-label">E-mail Address:</label>
                  <div class="col-sm-6">
                    <input type="email" class="form-control" id="inputYourEmail" placeholder="your e-mail address">
                    <span class="help-block">Comma-separated list of e-mail addresses above where RigWatch will send alerts.</span>
                  </div>
                </div>
              </fieldset>
              <fieldset>
                <h3>SMTP/Outgoing Server Settings:</h3>
                <div class="form-group">
                  <label for="inputSendingAddress" class="col-sm-4 control-label">From Address:</label>
                  <div class="col-sm-6">
                    <input type="email" class="form-control" id="inputSendingAddress" placeholder="rigwatch-alerts@my.domain">
                    <span class="help-block">Notifications will be sent FROM this address (can be anything most times).</span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputMailServer" class="col-sm-4 control-label">SMTP Server Address:</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="inputMailServer" placeholder="smtp.gmail.com">
                    <span class="help-block">IP or hostname of your outgoing mail server (e.g. <em>smtp.gmail.com</em>).</span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputMailPort" class="col-sm-4 control-label">Port:</label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control" id="inputMailPort" placeholder="587">
                    <span class="help-block">Common SMTP ports are 25, 587, and for SSL, 465.</span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputMailUser" class="col-sm-4 control-label">Username:</label>
                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="inputMailUser" placeholder="e-mail/username">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputSMTPpassword" class="col-sm-4 control-label">Password:</label>
                  <div class="col-sm-5">
                    <input type="password" class="form-control" id="inputSMTPpassword" placeholder="account password">
                  </div>
                </div>
                <div class="form-group">
                  <label for="tls-checkbox" class="col-sm-4 control-label">Requires TLS?</label>
                  <div class="col-sm-7">
                    <div class="checkbox">
                      <input type="checkbox" id="tls-checkbox">
                    </div>
                    <span class="help-block">Some servers require TLS. Try toggling this if your test doesn't work.</span>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-4 col-sm-8">
                    <button type="submit" class="btn btn-lg btn-success"><i class="icon icon-save-floppy"></i> Save E-Mail Settings</button> <button type="submit" class="btn btn-lg btn-primary"><i class="icon icon-websitebuilder"></i> Send Test E-Mail</button> 
                  </div>
                </div>
              </fieldset>
            </form>
            <br>
          </div>
          <div class="panel-heading">
              <h2 class="panel-title"><i class="icon icon-settingsandroid"></i> Cookies</h2>
          </div>
          <div class="panel-body">
            <form class="form-horizontal" role="form">
              <fieldset>
                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-6">
                    <span class="help-block">RigWatch cookies save preferences like panel width/positioning, and are safe to clear. Your important settings are always within the /user_data folder.</span>
                  </div>
                  <label class="col-sm-2 control-label"><button type="submit" class="btn btn-lg btn-success"><i class="icon icon-programclose"></i> Clear Cookies</button></label>
                </div>
              </fieldset>
            </form>
            <br>
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