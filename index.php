<?php require_once("includes/header.php"); ?>

      
      <div class="container sub-nav">

         <h1>Litecoin <img id="icon-litecoin" src="images/icon-litecoin.png" alt="" /> Stats</h1>
         
         <div id="top-ltc-panel" class="panel panel-primary panel-nobg">
            <div class="panel-body panel-body-stats">
               <div class="stat-pair ltc-usd">
                  <div class="stat-value">
                     $00.00
                  </div>
                  <div class="stat-label">
                     LTC &raquo; USD
                  </div>
               </div>
               <div class="stat-pair ltc-btc">
                  <div class="stat-value">
                     0.00000
                  </div>
                  <div class="stat-label">
                     LTC &raquo; BTC
                  </div>
               </div>
               <div class="stat-pair ltc-hashrate">
                  <div class="stat-value">
                     109.67 GH/s
                  </div>
                  <div class="stat-label">
                     Network Hashrate
                  </div>
               </div>
               <div class="stat-pair ltc-difficulty">
                  <div class="stat-value">
                     2926.50971494
                  </div>
                  <div class="stat-label">
                     Difficulty
                  </div>
               </div>
               <div class="stat-pair ltc-next-difficulty">
                  <div class="stat-value">
                     3037 (<span class="red">+3.80%</span>)
                  </div>
                  <div class="stat-label">
                     Next (est.) Difficulty
                  </div>
               </div>
            </div>
         </div>
   
         <br>

         <h1>Mining Rig Stats</h1>
                
         <!-- ### Below is where the modals are defined for adding or editing a host. 
                  There are two modals/include files now, but this can be changed to a single one, 
                  as the EDIT would have the information pre-populated. The only other 
                  difference is the <h3> label at the top!
                     
               ### Same goes for the POOL ones below
               
         -->
                       
         <?php require_once("includes/modal-add_host.php"); ?>
         <?php require_once("includes/modal-edit_host.php"); ?>

         <?php require_once("includes/modal-add_pool.php"); ?>
         <?php require_once("includes/modal-edit_pool.php"); ?>

         <?php require_once("includes/modal-switch_pool.php"); ?>
         
         <?php require_once("includes/modal-delete_prompt.php"); ?>

         <div id="rig-hostname-1" class="panel panel-primary panel-rig">
            <div class="panel-heading">
               <button type="button" class="close" data-toggle="modal" data-target="#deletePrompt" data-backdrop="static" aria-hidden="true"><i class="icon icon-circledelete"></i></button>
               <h2 class="panel-title"><i class="icon icon-server"></i> HOSTNAME-ONE</h2>
            </div>
            <ul class="nav nav-pills">
               
               <!-- ### Set certain classes for 'sick'/inactive GPUs 
               
                  Notice the special classes of 'pill-warning/danger', if there is a problem with the GPU
                  
               -->
               
              <li class="active"><a class="blue" href="#rig-hostname-1-summary" data-toggle="tab">Summary <i class="icon icon-dotlist"></i></a></li>
              <li><a class="green" href="#rig-hostname-1-gpu0" data-toggle="tab">GPU 0 <i class="icon icon-cpu-processor"></i></a></li>
              <li><a class="green" href="#rig-hostname-1-gpu1" data-toggle="tab">GPU 1<i class="icon icon-cpu-processor"></i></a></li>
              <li><a class="orange" href="#rig-hostname-1-gpu2" data-toggle="tab">GPU 2<i class="icon icon-cpu-processor"></i></a></li>
              <li><a class="green" href="#rig-hostname-1-gpu2" data-toggle="tab">GPU 3<i class="icon icon-cpu-processor"></i></a></li>
              <li><a class="red" href="#rig-hostname-1-gpu2" data-toggle="tab">GPU 4<i class="icon icon-cpu-processor"></i></a></li>
            </ul>
            
            <div class="tab-content">
               
               <!-- ### Define the content area for Summary / GPU N 
               
                  Here, Summary should show the 'accumulated'/total values from ALL GPUs, added into one 
                  
               -->
               
              <div class="tab-pane fade in active" id="rig-hostname-1-summary">
               <div class="panel-body panel-body-stats">
                  <div class="stat-pair stat-hashrate-avg">
                     <div class="stat-value">
                        450 KH/s
                     </div>
                     <div class="stat-label">
                        Hashrate (avg)
                     </div>
                     <div class="progress progress-striped">
                        <div class="progress-bar progress-bar-success" style="width: 85%"></div>
                     </div>
                  </div>
                  <div class="stat-pair stat-hashrate-5s">
                     <div class="stat-value">
                        440 KH/s
                     </div>
                     <div class="stat-label">
                        Hashrate (5s)
                     </div>
                     <div class="progress progress-striped">
                        <div class="progress-bar progress-bar-success" style="width: 80%"></div>
                     </div>
                  </div>
                  <div class="stat-pair stat-blocks-found">
                     <div class="stat-value">
                        1
                     </div>
                     <div class="stat-label">
                        Blocks Found
                     </div>
                     <div class="progress progress-striped">
                        <div class="progress-bar progress-bar-danger" style="width: 10%"></div>
                     </div>
                  </div>
                  <div class="stat-pair stat-accepted">
                     <div class="stat-value">
                        4,520
                     </div>
                     <div class="stat-label">
                        Accepted
                     </div>
                     <div class="progress progress-striped">
                        <div class="progress-bar progress-bar-warning" style="width: 45%"></div>
                     </div>
                  </div>
                  <div class="stat-pair stat-rejected">
                     <div class="stat-value">
                        342
                     </div>
                     <div class="stat-label">
                        Rejected
                     </div>
                     <div class="progress progress-striped">
                        <div class="progress-bar progress-bar-success" style="width: 15%"></div>
                     </div>
                  </div>
                  <div class="stat-pair stat-stale">
                     <div class="stat-value">
                        124
                     </div>
                     <div class="stat-label">
                        Stale
                     </div>
                     <div class="progress progress-striped">
                        <div class="progress-bar progress-bar-danger" style="width: 10%"></div>
                     </div>
                  </div>
                  <div class="stat-pair stat-hardware-errors">
                     <div class="stat-value">
                        0
                     </div>
                     <div class="stat-label">
                       HW Errors
                     </div>
                     <div class="progress progress-striped">
                        <div class="progress-bar progress-bar-success" style="width: 1%"></div>
                     </div>
                  </div>
                </div><!-- / .panel-body -->
              </div>
              
              <div class="tab-pane fade" id="rig-hostname-1-gpu0">
              
               <!-- ### Define the content area for Summary / GPU N 
               
                  Here, GPU 0 should show ONLY stats for the first GPU 
                  
               -->
               
              <div class="tab-pane fade in active" id="rig-hostname-1-summary">
               <div class="panel-body panel-body-stats">
                  <div class="stat-pair stat-health">
                     <div class="stat-value">
                        <i class="icon icon-check health-good"></i> 
                        <!--
                        <i class="icon icon-warning-sign health-warn"></i> 
                        <i class="icon icon-danger health-danger"></i>
                        -->
                     </div>
                     <div class="stat-label">
                        Health
                     </div>
                     <div class="progress progress-striped">
                        <div class="progress-bar progress-bar-success" style="width: 100%"></div>
                     </div>
                  </div>
                  <div class="stat-pair stat-hashrate-avg">
                     <div class="stat-value">
                        450 KH/s
                     </div>
                     <div class="stat-label">
                        Hashrate (avg)
                     </div>
                     <div class="progress progress-striped">
                        <div class="progress-bar progress-bar-success" style="width: 85%"></div>
                     </div>
                  </div>
                  <div class="stat-pair stat-hashrate-5s">
                     <div class="stat-value">
                        440 KH/s
                     </div>
                     <div class="stat-label">
                        Hashrate (5s)
                     </div>
                     <div class="progress progress-striped">
                        <div class="progress-bar progress-bar-success" style="width: 80%"></div>
                     </div>
                  </div>
                  <div class="stat-pair stat-load">
                     <div class="stat-value">
                        99%
                     </div>
                     <div class="stat-label">
                        Load
                     </div>
                     <div class="progress progress-striped">
                        <div class="progress-bar progress-bar" style="width: 99%"></div>
                     </div>
                  </div>
                  <div class="stat-pair stat-temperature">
                     <div class="stat-value">
                        78.00 &deg;C
                     </div>
                     <div class="stat-label">
                        Temperature
                     </div>
                     <div class="progress progress-striped">
                        <div class="progress-bar progress-bar-warning" style="width: 78%"></div>
                     </div>
                  </div>
                  <div class="stat-pair stat-fan-speed">
                     <div class="stat-value">
                        4248 rpm
                     </div>
                     <div class="stat-label">
                        Fan Speed
                     </div>
                     <div class="progress progress-striped">
                        <div class="progress-bar" style="width: 85%"></div>
                     </div>
                  </div>
                  <div class="stat-pair stat-fan-percent">
                     <div class="stat-value">
                        90%
                     </div>
                     <div class="stat-label">
                        Fan Percent
                     </div>
                     <div class="progress progress-striped">
                        <div class="progress-bar" style="width: 90%"></div>
                     </div>
                  </div>
                  <div class="stat-pair stat-gpu-clock">
                     <div class="stat-value">
                        930 mhz
                     </div>
                     <div class="stat-label">
                        GPU clock
                     </div>
                     <div class="progress progress-striped">
                        <div class="progress-bar progress-bar-success" style="width: 65%"></div>
                     </div>
                  </div>
                  <div class="stat-pair stat-mem-clock">
                     <div class="stat-value">
                        1375 mhz
                     </div>
                     <div class="stat-label">
                        Memory Clock
                     </div>
                     <div class="progress progress-striped">
                        <div class="progress-bar-success" style="width: 85%"></div>
                     </div>
                  </div>
                  <div class="stat-pair stat-gpu-voltage">
                     <div class="stat-value">
                        1.15v
                     </div>
                     <div class="stat-label">
                        GPU Voltage
                     </div>
                     <div class="progress progress-striped">
                        <div class="progress-bar-success" style="width: 85%"></div>
                     </div>
                  </div>
                  <div class="stat-pair stat-blocks-found">
                     <div class="stat-value">
                        1
                     </div>
                     <div class="stat-label">
                        Blocks Found
                     </div>
                     <div class="progress progress-striped">
                        <div class="progress-bar progress-bar-danger" style="width: 10%"></div>
                     </div>
                  </div>
                  <div class="stat-pair stat-accepted">
                     <div class="stat-value">
                        4,520
                     </div>
                     <div class="stat-label">
                        Accepted
                     </div>
                     <div class="progress progress-striped">
                        <div class="progress-bar progress-bar-warning" style="width: 45%"></div>
                     </div>
                  </div>
                  <div class="stat-pair stat-rejected">
                     <div class="stat-value">
                        342
                     </div>
                     <div class="stat-label">
                        Rejected
                     </div>
                     <div class="progress progress-striped">
                        <div class="progress-bar progress-bar-success" style="width: 15%"></div>
                     </div>
                  </div>
                  <div class="stat-pair stat-stale">
                     <div class="stat-value">
                        3
                     </div>
                     <div class="stat-label">
                        Stale
                     </div>
                     <div class="progress progress-striped">
                        <div class="progress-bar progress-bar-success" style="width: 3%"></div>
                     </div>
                  </div>
                  <div class="stat-pair stat-blocks-found">
                     <div class="stat-value">
                        1
                     </div>
                     <div class="stat-label">
                        Blocks Found
                     </div>
                     <div class="progress progress-striped">
                        <div class="progress-bar progress-bar-danger" style="width: 5%"></div>
                     </div>
                  </div>
                  <div class="stat-pair stat-hardware-errors">
                     <div class="stat-value">
                        0
                     </div>
                     <div class="stat-label">
                       HW Errors
                     </div>
                     <div class="progress progress-striped">
                        <div class="progress-bar progress-bar-success" style="width: 1%"></div>
                     </div>
                  </div>
                  <div class="stat-pair stat-worker-utility">
                     <div class="stat-value">
                        4.76/m
                     </div>
                     <div class="stat-label">
                       Utility
                     </div>
                     <div class="progress progress-striped">
                        <div class="progress-bar progress-bar-warning" style="width: 60%"></div>
                     </div>
                  </div>
                </div><!-- / .panel-body -->
               </div>
              </div>
              
              <div class="tab-pane fade" id="rig-hostname-1-gpu1">
              
              MESSAGES
              
              </div>
              
              <div class="tab-pane fade" id="rig-hostname-1-gpu2">
              
              SETTINGS
              
              </div>
            </div>

            <div class="panel-footer">
               <div class="pull-left">
                  <!-- <span class="label label-success"><i class="icon icon-ok"></i> Healthy</span> -->
                  <h3><i class="icon icon-uptime"></i> Uptime: 7m 01s</h3>
               </div>
               <div class="pull-right">
                  <button type="button" class="btn btn-default" data-toggle="modal" data-target="#editRig" data-backdrop="static"><i class="icon icon-edit"></i> Edit Rig</button>
                  <!-- <button type="button" class="btn btn-default"><i class="icon icon-statistics"></i> View All Stats</button> -->
               </div>
            </div>
        </div>
        <h1><button type="button" class="btn btn-success" data-toggle="modal" data-target="#addRig" data-backdrop="static"><i class="icon icon-circleadd"></i> Add Rig &raquo;</button></h1>

        <br><br>

        <h1>Pool Stats</h1>
         
         <div class="panel panel-primary panel-pool">
            <div class="panel-heading">
               <button type="button" class="close" data-toggle="modal" data-target="#deletePrompt" data-backdrop="static" aria-hidden="true"><i class="icon icon-circledelete"></i></button>
               <h2 class="panel-title"><i class="icon icon-groups-friends"></i> CoinHuntr</h2>
            </div>
            <div class="panel-body panel-body-stats">
               <div class="stat-pair pool-conf-payout">
                  <div class="stat-value">
                     <span class="green">3.77081172</span>
                  </div>
                  <div class="stat-label">
                     Balance
                  </div>
               </div>
               <div class="stat-pair pool-unconf-payout">
                  <div class="stat-value">
                     <span class="orange">0.07821302</span>
                  </div>
                  <div class="stat-label">
                     Unconfirmed Balance
                  </div>
               </div>
               <div class="stat-pair pool-hashrate">
                  <div class="stat-value">
                     587 MH/s
                  </div>
                  <div class="stat-label">
                     Pool Hashrate
                  </div>
               </div>
               <div class="stat-pair pool-workers">
                  <div class="stat-value">
                     1325
                  </div>
                  <div class="stat-label">
                     Pool Workers
                  </div>
               </div>
               <div class="stat-pair pool-efficiency">
                  <div class="stat-value">
                     98.7%
                  </div>
                  <div class="stat-label">
                     Efficiency
                  </div>
               </div>
               <div class="stat-pair pool-time-last">
                  <div class="stat-value">
                     14h 48m 16s
                  </div>
                  <div class="stat-label">
                     Time Since Last Block
                  </div>
               </div>
               <div class="stat-pair pool-estimate-next">
                  <div class="stat-value">
                     1h 23m 54s
                  </div>
                  <div class="stat-label">
                     Est. Time of Next Block
                  </div>
               </div>
               <div class="stat-pair pool-current-block">
                  <div class="stat-value">
                     478358
                  </div>
                  <div class="stat-label">
                     Current Block
                  </div>
               </div>
               <div class="stat-pair pool-last-block">
                  <div class="stat-value">
                     478299
                  </div>
                  <div class="stat-label">
                     Last Block Found
                  </div>
               </div>
               <div class="stat-pair pool-status">
                  <div class="stat-value">
                     <i class="icon icon-check health-good"></i> Alive
                  </div>
                  <div class="stat-label">
                     Status
                  </div>
               </div>
               <div class="stat-pair pool-id">
                  <div class="stat-value">
                     1
                  </div>
                  <div class="stat-label">
                     Pool ID
                  </div>
               </div>
               <div class="stat-pair pool-priority">
                  <div class="stat-value">
                     0
                  </div>
                  <div class="stat-label">
                     Priority
                  </div>
               </div>
               <div class="stat-pair pool-accepted">
                  <div class="stat-value">
                     87,402
                  </div>
                  <div class="stat-label">
                     Accepted
                  </div>
               </div>
               <div class="stat-pair pool-rejected">
                  <div class="stat-value">
                     347
                  </div>
                  <div class="stat-label">
                     Rejected
                  </div>
               </div>
               <div class="stat-pair pool-url">
                  <div class="stat-value">
                     http://primary.coinhuntr.com:3333
                  </div>
                  <div class="stat-label">
                     URL
                  </div>
               </div>
               <div class="stat-pair pool-user">
                  <div class="stat-value">
                     scar45.dev_laptop
                  </div>
                  <div class="stat-label">
                     Worker (User)
                  </div>
               </div>
            </div><!-- / .panel-body -->
            <div class="panel-footer text-right">
               <button type="button" class="btn btn-default" data-toggle="modal" data-target="#editPool" data-backdrop="static"><i class="icon icon-edit"></i> Edit Pool</button>
               <button type="button" class="btn btn-default" data-toggle="modal" data-target="#switchPool" data-backdrop="static"><i class="icon icon-refreshalt"></i> Switch Pool</button>
            </div>
         </div>
         <h1><button type="button" class="btn btn-success" data-toggle="modal" data-target="#addPool" data-backdrop="static"><i class="icon icon-circleadd"></i> Add Pool &raquo;</button></h1>
      </div>
      <!-- /container -->
      
      <?php require_once("includes/footer.php"); ?>
