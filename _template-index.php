<?php require_once("includes/header.php"); ?>

      
      <div class="container sub-nav">
      
         <h1><img id="icon-litecoin" src="images/icon-litecoin.png" alt="" /> Litecoin Rates &amp; Network</h1>
         
         <div class="panel panel-primary">
            <div class="panel-body panel-body-stats">
               <div class="stat-pair" id="ltc-usd">
                  <div class="stat-label">
                     LTC &raquo; USD
                  </div>
                  <div class="stat-value">
                     29.4 USD
                  </div>
               </div>
               <div class="stat-pair" id="ltc-btc">
                  <div class="stat-label">
                     LTC &raquo; BTC
                  </div>
                  <div class="stat-value">
                     0.0148 BTC
                  </div>
               </div>
               <div class="stat-pair" id="ltc-hashrate">
                  <div class="stat-label">
                     Network Hashrate
                  </div>
                  <div class="stat-value">
                     109.67 GH/s
                  </div>
               </div>
               <div class="stat-pair" id="ltc-difficulty">
                  <div class="stat-label">
                     Difficulty
                  </div>
                  <div class="stat-value">
                     2926.50971494
                  </div>
               </div>
               <div class="stat-pair" id="ltc-next-difficulty">
                  <div class="stat-label">
                     Next (est.) Difficulty
                  </div>
                  <div class="stat-value">
                     3037 (<span class="red">+3.80%</span>)
                  </div>
               </div>
            </div>
         </div>

               
         <br><br>
         

         <h1>Mining Rig Stats</h1>
         
         <div class="panel panel-primary">
            <div class="panel-heading">
               <h2 class="panel-title"><i class="icon icon-server"></i> HOSTNAME-ONE</h2>
            </div>
            <div class="panel-body panel-body-stats">
               <div class="stat-pair" id="stat-health">
                  <div class="stat-label">
                     Health
                  </div>
                  <div class="stat-value">
                     <i class="icon icon-check health-good"></i> 
                     <i class="icon icon-warning-sign health-warn"></i> 
                     <i class="icon icon-danger health-danger"></i>
                  </div>
                  <div class="progress progress-striped active">
                     <div class="progress-bar progress-bar-success" style="width: 100%"></div>
                  </div>
               </div>
               <div class="stat-pair" id="stat-hashrate-avg">
                  <div class="stat-label">
                     Hashrate (avg)
                  </div>
                  <div class="stat-value">
                     450 KH/s
                  </div>
                  <div class="progress progress-striped active">
                     <div class="progress-bar progress-bar-success" style="width: 85%"></div>
                  </div>
               </div>
               <div class="stat-pair" id="stat-hashrate-5s">
                  <div class="stat-label">
                     Hashrate (5s)
                  </div>
                  <div class="stat-value">
                     440 KH/s
                  </div>
                  <div class="progress progress-striped active">
                     <div class="progress-bar progress-bar-success" style="width: 80%"></div>
                  </div>
               </div>
               <div class="stat-pair" id="stat-temperature">
                  <div class="stat-label">
                     Temperature
                  </div>
                  <div class="stat-value">
                     78.00 &deg;C
                  </div>
                  <div class="progress progress-striped active">
                     <div class="progress-bar progress-bar-warning" style="width: 78%"></div>
                  </div>
               </div>
               <div class="stat-pair" id="stat-fan-speed">
                  <div class="stat-label">
                     Fan Speed
                  </div>
                  <div class="stat-value">
                     4248 rpm
                  </div>
                  <div class="progress progress-striped active">
                     <div class="progress-bar" style="width: 85%"></div>
                  </div>
               </div>
               <div class="stat-pair" id="stat-fan-percent">
                  <div class="stat-label">
                     Fan Percent
                  </div>
                  <div class="stat-value">
                     90%
                  </div>
                  <div class="progress progress-striped active">
                     <div class="progress-bar" style="width: 90%"></div>
                  </div>
               </div>
               <div class="stat-pair" id="stat-gpu-clock">
                  <div class="stat-label">
                     GPU clock
                  </div>
                  <div class="stat-value">
                     930 mhz
                  </div>
                  <div class="progress progress-striped active">
                     <div class="progress-bar progress-bar-success" style="width: 65%"></div>
                  </div>
               </div>
               <div class="stat-pair" id="stat-mem-clock">
                  <div class="stat-label">
                     Memory Clock
                  </div>
                  <div class="stat-value">
                     1375 mhz
                  </div>
                  <div class="progress progress-striped active">
                     <div class="progress-bar-success" style="width: 85%"></div>
                  </div>
               </div>
               <div class="stat-pair" id="stat-gpu-voltage">
                  <div class="stat-label">
                     GPU Voltage
                  </div>
                  <div class="stat-value">
                     1.15v
                  </div>
                  <div class="progress progress-striped active">
                     <div class="progress-bar-success" style="width: 85%"></div>
                  </div>
               </div>
               <div class="stat-pair" id="stat-blocks-found">
                  <div class="stat-label">
                     Blocks Found
                  </div>
                  <div class="stat-value">
                     1
                  </div>
                  <div class="progress progress-striped active">
                     <div class="progress-bar progress-bar-danger" style="width: 10%"></div>
                  </div>
               </div>
               <div class="stat-pair" id="stat-accepted">
                  <div class="stat-label">
                     Accepted
                  </div>
                  <div class="stat-value">
                     4,520
                  </div>
                  <div class="progress progress-striped active">
                     <div class="progress-bar progress-bar-warning" style="width: 45%"></div>
                  </div>
               </div>
               <div class="stat-pair" id="stat-rejected">
                  <div class="stat-label">
                     Rejected
                  </div>
                  <div class="stat-value">
                     342
                  </div>
                  <div class="progress progress-striped active">
                     <div class="progress-bar progress-bar-success" style="width: 15%"></div>
                  </div>
               </div>
               <div class="stat-pair" id="stat-stale">
                  <div class="stat-label">
                     Stale
                  </div>
                  <div class="stat-value">
                     3
                  </div>
                  <div class="progress progress-striped active">
                     <div class="progress-bar progress-bar-success" style="width: 3%"></div>
                  </div>
               </div>
               <div class="stat-pair" id="stat-blocks-found">
                  <div class="stat-label">
                     Blocks Found
                  </div>
                  <div class="stat-value">
                     1
                  </div>
                  <div class="progress progress-striped active">
                     <div class="progress-bar progress-bar-danger" style="width: 5%"></div>
                  </div>
               </div>
               <div class="stat-pair" id="stat-hardware-errors">
                  <div class="stat-label">
                    HW Errors
                  </div>
                  <div class="stat-value">
                     0
                  </div>
                  <div class="progress progress-striped active">
                     <div class="progress-bar progress-bar-success" style="width: 1%"></div>
                  </div>
               </div>
               <div class="stat-pair" id="stat-worker-utility">
                  <div class="stat-label">
                    Utility
                  </div>
                  <div class="stat-value">
                     4.76/m
                  </div>
                  <div class="progress progress-striped active">
                     <div class="progress-bar progress-bar-warning" style="width: 60%"></div>
                  </div>
               </div>
            </div><!-- / .panel-body -->
            <div class="panel-footer">
               <div class="pull-left">
                  <span class="label label-success"><i class="icon icon-ok"></i> Healthy</span> 
                  <h3><i class="icon icon-uptime"></i> Uptime: 7m 01s</h3>
               </div>
               <div class="pull-right">
                  <button type="button" class="btn btn-default"><i class="icon icon-statistics"></i> View All Stats &raquo;</button>
                  <button type="button" class="btn btn-default"><i class="icon icon-edit"></i> Edit Host &raquo;</button>
               </div>
            </div>
        </div>         
         
         
         <br><br>
         
         
         <h1>Pool Statistics</h1>
         
         <div class="panel panel-primary">
            <div class="panel-heading">
               <h2 class="panel-title"><i class="icon icon-groups-friends"></i> CoinHuntr</h2>
            </div>
            <div class="panel-body panel-body-stats">
               <div class="stat-pair" id="pool-conf-payout">
                  <div class="stat-label">
                     LTC Balance
                  </div>
                  <div class="stat-value">
                     <span class="green">3.77081172</span>
                  </div>
               </div>
               <div class="stat-pair" id="pool-unconf-payout">
                  <div class="stat-label">
                     Unconfirmed Balance
                  </div>
                  <div class="stat-value">
                     <span class="orange">0.07821302</span>
                  </div>
               </div>
               <div class="stat-pair" id="pool-hashrate">
                  <div class="stat-label">
                     Pool Hashrate
                  </div>
                  <div class="stat-value">
                     587 MH/s
                  </div>
               </div>
               <div class="stat-pair" id="pool-workers">
                  <div class="stat-label">
                     Pool Workers
                  </div>
                  <div class="stat-value">
                     1325
                  </div>
               </div>
               <div class="stat-pair" id="pool-efficiency">
                  <div class="stat-label">
                     Efficiency
                  </div>
                  <div class="stat-value">
                     98.7%
                  </div>
               </div>
               <div class="stat-pair" id="pool-time-last">
                  <div class="stat-label">
                     Time Since Last Block
                  </div>
                  <div class="stat-value">
                     14h 48m 16s
                  </div>
               </div>
               <div class="stat-pair" id="pool-estimate-next">
                  <div class="stat-label">
                     Est. Time of Next Block
                  </div>
                  <div class="stat-value">
                     1h 23m 54s
                  </div>
               </div>
               <div class="stat-pair" id="pool-current-block">
                  <div class="stat-label">
                     Current Block
                  </div>
                  <div class="stat-value">
                     478358
                  </div>
               </div>
               <div class="stat-pair" id="pool-last-block">
                  <div class="stat-label">
                     Last Block Found
                  </div>
                  <div class="stat-value">
                     478299
                  </div>
               </div>
               <div class="stat-pair" id="pool-url">
                  <div class="stat-label">
                     URL
                  </div>
                  <div class="stat-value">
                     http://primary.coinhuntr.com:3333
                  </div>
               </div>
               <div class="stat-pair" id="pool-user">
                  <div class="stat-label">
                     Worker (User)
                  </div>
                  <div class="stat-value">
                     scar45.dev_laptop
                  </div>
               </div>
               <div class="stat-pair" id="pool-id">
                  <div class="stat-label">
                     Pool ID
                  </div>
                  <div class="stat-value">
                     1
                  </div>
               </div>
               <div class="stat-pair" id="pool-status">
                  <div class="stat-label">
                     Status
                  </div>
                  <div class="stat-value">
                     <i class="icon icon-check health-good"></i> Alive
                  </div>
               </div>
               <div class="stat-pair" id="pool-priority">
                  <div class="stat-label">
                     Priority
                  </div>
                  <div class="stat-value">
                     0
                  </div>
               </div>
               <div class="stat-pair" id="pool-accepted">
                  <div class="stat-label">
                     Accepted
                  </div>
                  <div class="stat-value">
                     87,402
                  </div>
               </div>
               <div class="stat-pair" id="pool-rejected">
                  <div class="stat-label">
                     Rejected
                  </div>
                  <div class="stat-value">
                     347
                  </div>
               </div>
            </div><!-- / .panel-body -->
            <div class="panel-footer">
               <div class="pull-right">
                  <button type="button" class="btn btn-default"><i class="icon icon-edit"></i> Edit Pool &raquo;</button>
               </div>
            </div>
        </div>         
      </div>
      <!-- /container -->
      
      <?php require_once("includes/footer.php"); ?>
