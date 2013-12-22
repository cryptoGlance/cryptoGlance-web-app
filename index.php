<?php require_once("includes/header.php"); ?>
       
<!-- ### Below is where the modals are defined for adding or editing a host. 
         There are two modals/include files now, but this can be changed to a single one, 
         as the EDIT would have the information pre-populated. The only other 
         difference is the <h3> label at the top!
            
      ### Same goes for the POOL ones below
      
-->

<?php require_once("includes/modal-edit_host.php"); ?>

<?php require_once("includes/modal-edit_pool.php"); ?>

<?php require_once("includes/modal-switch_pool.php"); ?>

<?php require_once("includes/modal-delete_prompt.php"); ?>

         
      <div class="container sub-nav">

         
         <div id="coin-watcher" class="panel panel-primary">
           <h1>CoinWatcher</h1>
           <div class="panel-heading">
               <h2 class="panel-title"><i class="icon icon-value-coins"></i> Realtime Conversion Rates</h2>
            </div>
            <div class="panel-body panel-body-coins">
               <div class="stat-pair ltc-usd" id="coin-compare-1">
                  <form class="form" role="form">
                     <div class="stat-value">
                        <input type="text" value="0.00" />
                        <select>
                           <option value="BTC" selected>BTC</option>
                           <option value="dBTC">dBTC</option>
                           <option value="cBTC">cBTC</option>
                           <option value="mBTC">mBTC</option>
                           <option value="uBTC">uBTC</option>
                           <option value="satoshi">satoshi</option>
                           <option value="LTC">LTC</option>
                           <option value="FTC">FTC</option>
                           <option value="CNC">CNC</option>
                           <option value="DVC">DVC</option>
                           <option value="FRC">FRC</option>
                           <option value="IXC">IXC</option>
                           <option value="NMC">NMC</option>
                           <option value="FTC">FTC</option>
                           <option value="PPC">PPC</option>
                           <option value="SC">SC</option>
                           <option value="TRC">TRC</option>
                           <option disabled>---</option>
                           <option value="USD">USD</option>
                           <option value="EUR">EUR</option>
                           <option value="PLN">PLN</option>
                           <option value="GBP">GBP</option>
                           <option value="CNY">CNY</option>
                           <option value="CAD">CAD</option>
                           <option value="CHF">CHF</option>
                           <option value="DKK">DKK</option>
                           <option value="JPY">JPY</option>
                           <option value="SEK">SEK</option>
                           <option value="RUB">RUB</option>                       
                        </select>
                        
                        <i class="icon icon-chevron-down"></i>
                        
                        <input type="text" value="0.00" />
                        <select>
                           <option value="BTC" selected>BTC</option>
                           <option value="dBTC">dBTC</option>
                           <option value="cBTC">cBTC</option>
                           <option value="mBTC">mBTC</option>
                           <option value="uBTC">uBTC</option>
                           <option value="satoshi">satoshi</option>
                           <option value="LTC">LTC</option>
                           <option value="FTC">FTC</option>
                           <option value="CNC">CNC</option>
                           <option value="DVC">DVC</option>
                           <option value="FRC">FRC</option>
                           <option value="IXC">IXC</option>
                           <option value="NMC">NMC</option>
                           <option value="FTC">FTC</option>
                           <option value="PPC">PPC</option>
                           <option value="SC">SC</option>
                           <option value="TRC">TRC</option>
                           <option disabled>---</option>
                           <option value="USD">USD</option>
                           <option value="EUR">EUR</option>
                           <option value="PLN">PLN</option>
                           <option value="GBP">GBP</option>
                           <option value="CNY">CNY</option>
                           <option value="CAD">CAD</option>
                           <option value="CHF">CHF</option>
                           <option value="DKK">DKK</option>
                           <option value="JPY">JPY</option>
                           <option value="SEK">SEK</option>
                           <option value="RUB">RUB</option>                       
                        </select>
                     </div>
                     <div class="stat-label">
                        Source:
                        <select>
                           <option value="mtgox">Mt.Gox</option>
                           <option value="vircurex">Vircurex</option>
                           <option value="btce"  selected>BTC-E</option>
                        </select>
                     </div>
                  </form>
               </div>               
                              
               <div class="stat-pair ltc-usd" id="coin-compare-1">
                  <form class="form" role="form">
                     <div class="stat-value">
                        <input type="text" value="0.00" />
                        <select>
                           <option value="BTC" selected>BTC</option>
                           <option value="dBTC">dBTC</option>
                           <option value="cBTC">cBTC</option>
                           <option value="mBTC">mBTC</option>
                           <option value="uBTC">uBTC</option>
                           <option value="satoshi">satoshi</option>
                           <option value="LTC">LTC</option>
                           <option value="FTC">FTC</option>
                           <option value="CNC">CNC</option>
                           <option value="DVC">DVC</option>
                           <option value="FRC">FRC</option>
                           <option value="IXC">IXC</option>
                           <option value="NMC">NMC</option>
                           <option value="FTC">FTC</option>
                           <option value="PPC">PPC</option>
                           <option value="SC">SC</option>
                           <option value="TRC">TRC</option>
                           <option disabled>---</option>
                           <option value="USD">USD</option>
                           <option value="EUR">EUR</option>
                           <option value="PLN">PLN</option>
                           <option value="GBP">GBP</option>
                           <option value="CNY">CNY</option>
                           <option value="CAD">CAD</option>
                           <option value="CHF">CHF</option>
                           <option value="DKK">DKK</option>
                           <option value="JPY">JPY</option>
                           <option value="SEK">SEK</option>
                           <option value="RUB">RUB</option>                       
                        </select>
                        
                        <i class="icon icon-chevron-down"></i>
                        
                        <input type="text" value="0.00" />
                        <select>
                           <option value="BTC" selected>BTC</option>
                           <option value="dBTC">dBTC</option>
                           <option value="cBTC">cBTC</option>
                           <option value="mBTC">mBTC</option>
                           <option value="uBTC">uBTC</option>
                           <option value="satoshi">satoshi</option>
                           <option value="LTC">LTC</option>
                           <option value="FTC">FTC</option>
                           <option value="CNC">CNC</option>
                           <option value="DVC">DVC</option>
                           <option value="FRC">FRC</option>
                           <option value="IXC">IXC</option>
                           <option value="NMC">NMC</option>
                           <option value="FTC">FTC</option>
                           <option value="PPC">PPC</option>
                           <option value="SC">SC</option>
                           <option value="TRC">TRC</option>
                           <option disabled>---</option>
                           <option value="USD">USD</option>
                           <option value="EUR">EUR</option>
                           <option value="PLN">PLN</option>
                           <option value="GBP">GBP</option>
                           <option value="CNY">CNY</option>
                           <option value="CAD">CAD</option>
                           <option value="CHF">CHF</option>
                           <option value="DKK">DKK</option>
                           <option value="JPY">JPY</option>
                           <option value="SEK">SEK</option>
                           <option value="RUB">RUB</option>                       
                        </select>
                     </div>
                     <div class="stat-label">
                        Source:
                        <select>
                           <option value="mtgox">Mt.Gox</option>
                           <option value="vircurex">Vircurex</option>
                           <option value="btce"  selected>BTC-E</option>
                        </select>
                     </div>
                  </form>
               </div>               
                              
               <div class="stat-pair ltc-usd" id="coin-compare-1">
                  <form class="form" role="form">
                     <div class="stat-value">
                        <input type="text" value="0.00" />
                        <select>
                           <option value="BTC" selected>BTC</option>
                           <option value="dBTC">dBTC</option>
                           <option value="cBTC">cBTC</option>
                           <option value="mBTC">mBTC</option>
                           <option value="uBTC">uBTC</option>
                           <option value="satoshi">satoshi</option>
                           <option value="LTC">LTC</option>
                           <option value="FTC">FTC</option>
                           <option value="CNC">CNC</option>
                           <option value="DVC">DVC</option>
                           <option value="FRC">FRC</option>
                           <option value="IXC">IXC</option>
                           <option value="NMC">NMC</option>
                           <option value="FTC">FTC</option>
                           <option value="PPC">PPC</option>
                           <option value="SC">SC</option>
                           <option value="TRC">TRC</option>
                           <option disabled>---</option>
                           <option value="USD">USD</option>
                           <option value="EUR">EUR</option>
                           <option value="PLN">PLN</option>
                           <option value="GBP">GBP</option>
                           <option value="CNY">CNY</option>
                           <option value="CAD">CAD</option>
                           <option value="CHF">CHF</option>
                           <option value="DKK">DKK</option>
                           <option value="JPY">JPY</option>
                           <option value="SEK">SEK</option>
                           <option value="RUB">RUB</option>                       
                        </select>
                        
                        <i class="icon icon-chevron-down"></i>
                        
                        <input type="text" value="0.00" />
                        <select>
                           <option value="BTC" selected>BTC</option>
                           <option value="dBTC">dBTC</option>
                           <option value="cBTC">cBTC</option>
                           <option value="mBTC">mBTC</option>
                           <option value="uBTC">uBTC</option>
                           <option value="satoshi">satoshi</option>
                           <option value="LTC">LTC</option>
                           <option value="FTC">FTC</option>
                           <option value="CNC">CNC</option>
                           <option value="DVC">DVC</option>
                           <option value="FRC">FRC</option>
                           <option value="IXC">IXC</option>
                           <option value="NMC">NMC</option>
                           <option value="FTC">FTC</option>
                           <option value="PPC">PPC</option>
                           <option value="SC">SC</option>
                           <option value="TRC">TRC</option>
                           <option disabled>---</option>
                           <option value="USD">USD</option>
                           <option value="EUR">EUR</option>
                           <option value="PLN">PLN</option>
                           <option value="GBP">GBP</option>
                           <option value="CNY">CNY</option>
                           <option value="CAD">CAD</option>
                           <option value="CHF">CHF</option>
                           <option value="DKK">DKK</option>
                           <option value="JPY">JPY</option>
                           <option value="SEK">SEK</option>
                           <option value="RUB">RUB</option>                       
                        </select>
                     </div>
                     <div class="stat-label">
                        Source:
                        <select>
                           <option value="mtgox">Mt.Gox</option>
                           <option value="vircurex">Vircurex</option>
                           <option value="btce"  selected>BTC-E</option>
                        </select>
                     </div>
                  </form>
               </div>
            </div>
            <div class="panel-footer text-right">
               <button type="button" class="btn btn-default"><i class="icon icon-refresh"></i> Update All</button>
               <button type="button" class="btn btn-default" data-toggle="modal" data-target="#editPool" data-backdrop="static"><i class="icon icon-selectionadd"></i> Add Comparison</button>
            </div>
         </div>

         
         <div class="clearfix"></div>
            

         <div id="rig-hostname-1" class="panel panel-primary panel-rig">
            <h1>Mining Rig Stats</h1>
            <div class="panel-heading">
               <button type="button" class="close" data-toggle="modal" data-target="#deletePrompt" data-backdrop="static" aria-hidden="true"><i class="icon icon-circledelete"></i></button>
               <h2 class="panel-title"><i class="icon icon-server"></i> HOSTNAME-ONE</h2>
            </div>
            <ul class="nav nav-pills">
               
               <!-- ### Set certain classes for 'sick'/inactive GPUs 
               
                  Notice the special classes of 'pill-warning/danger', if there is a problem with the GPU
                  
                  Also, the HREF must be set to link to the proper RIG ++ GPUn
                  
               -->
               
              <li class="active"><a class="blue" href="#rig-hostname-1-summary" data-toggle="tab">Summary <i class="icon icon-dotlist"></i></a></li>
              <li><a class="green" href="#rig-hostname-1-gpu0" data-toggle="tab">GPU 0 <i class="icon icon-cpu-processor"></i></a></li>
              <li><a class="green" href="#rig-hostname-1-gpu1" data-toggle="tab">GPU 1<i class="icon icon-cpu-processor"></i></a></li>
              <li><a class="orange" href="#rig-hostname-1-gpu2" data-toggle="tab">GPU 2<i class="icon icon-cpu-processor"></i></a></li>
              <li><a class="green" href="#rig-hostname-1-gpu3" data-toggle="tab">GPU 3<i class="icon icon-cpu-processor"></i></a></li>
              <li><a class="red" href="#rig-hostname-1-gpu4" data-toggle="tab">GPU 4<i class="icon icon-cpu-processor"></i></a></li>
            </ul>
            
            <div class="tab-content">
               
               <!-- ### Define the content area for Summary / GPU N 
               
                  Here, Summary should show the 'accumulated'/total values from ALL GPUs, added into one 
                  
               -->
               
              <div class="tab-pane fade in active" id="rig-hostname-1-summary">
               <div class="panel-body panel-body-stats">
                  <div class="stat-pair stat-hashrate-avg" id="rig-hostname-1-summary-stat-hashrate-avg">
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
                  <div class="stat-pair stat-hashrate-5s" id="rig-hostname-1-summary-stat-hashrate-avg">
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
                  <div class="stat-pair stat-blocks-found" id="rig-hostname-1-summary-stat-hashrate-avg">
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
                  <div class="stat-pair stat-accepted" id="rig-hostname-1-summary-stat-hashrate-avg">
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
                  <div class="stat-pair stat-rejected" id="rig-hostname-1-summary-stat-hashrate-avg">
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
                  <div class="stat-pair stat-stale" id="rig-hostname-1-summary-stat-hashrate-avg">
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
                  <div class="stat-pair stat-hardware-errors" id="rig-hostname-1-summary-stat-hashrate-avg">
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
                  <div class="stat-pair stat-active-pool" id="rig-hostname-1-summary-stat-hashrate-avg">
                     <div class="stat-value">
                        primary.coinhuntr.com:3333
                     </div>
                     <div class="stat-label">
                       Active Mining Pool
                     </div>
                     <div class="progress progress-striped">
                        <div class="progress-bar progress-bar-success" style="width: 100%"></div>
                     </div>
                  </div>
                </div><!-- / .panel-body -->
              </div>
              
              
               <!-- ### Define the content area for Summary / GPU N 
               
                  Here, GPU 0 should show ONLY stats for the first GPU 
                  
               -->
               
              <div class="tab-pane fade in" id="rig-hostname-1-gpu0">
               <div class="panel-body panel-body-stats">
                  <div class="stat-pair stat-health" id="rig-hostname-1-gpu0-stat-hashrate-avg">
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
                  <div class="stat-pair stat-hashrate-avg" id="rig-hostname-1-gpu0-stat-hashrate-avg">
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
                  <div class="stat-pair stat-hashrate-5s" id="rig-hostname-1-gpu0-stat-hashrate-5s">
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
                  <div class="stat-pair stat-load" id="rig-hostname-1-gpu0-stat-load">
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
                  <div class="stat-pair stat-temperature" id="rig-hostname-1-gpu0-stat-temperature">
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
                  <div class="stat-pair stat-fan-speed" id="rig-hostname-1-gpu0-stat-fan-speed">
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
                  <div class="stat-pair stat-fan-percent" id="rig-hostname-1-gpu0-stat-fan-percent">
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
                  <div class="stat-pair stat-gpu-clock" id="rig-hostname-1-gpu0-stat-gpu-clock">
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
                  <div class="stat-pair stat-mem-clock" id="rig-hostname-1-gpu0-stat-mem-clock">
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
                  <div class="stat-pair stat-gpu-voltage" id="rig-hostname-1-gpu0-stat-gpu-voltage">
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
                  <div class="stat-pair stat-blocks-found" id="rig-hostname-1-gpu0-stat-blocks-found">
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
                  <div class="stat-pair stat-accepted" id="rig-hostname-1-gpu0-stat-accepted">
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
                  <div class="stat-pair stat-rejected" id="rig-hostname-1-gpu0-stat-rejected">
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
                  <div class="stat-pair stat-stale" id="rig-hostname-1-gpu0-stat-stale">
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
                  <div class="stat-pair stat-blocks-found" id="rig-hostname-1-gpu0-stat-blocks-found">
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
                  <div class="stat-pair stat-hardware-errors" id="rig-hostname-1-gpu0-stat-hardware-errors">
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
                  <div class="stat-pair stat-worker-utility" id="rig-hostname-1-gpu0-stat-worker-utility">
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
              
              
              
              
              <div class="tab-pane fade" id="rig-hostname-1-gpu1">
               <div class="panel-body panel-body-stats">
                  <div class="stat-pair stat-health" id="rig-hostname-1-gpu1-stat-hashrate-avg">
                     <div class="stat-value">
                        <i class="icon icon-warning-sign health-warn"></i> 
                     </div>
                     <div class="stat-label">
                        Health
                     </div>
                     <div class="progress progress-striped">
                        <div class="progress-bar progress-bar-success" style="width: 100%"></div>
                     </div>
                  </div>
                  <div class="stat-pair stat-hashrate-avg" id="rig-hostname-1-gpu1-stat-hashrate-avg">
                     <div class="stat-value">
                        550 KH/s
                     </div>
                     <div class="stat-label">
                        Hashrate (avg)
                     </div>
                     <div class="progress progress-striped">
                        <div class="progress-bar progress-bar-success" style="width: 85%"></div>
                     </div>
                  </div>
                  <div class="stat-pair stat-hashrate-5s" id="rig-hostname-1-gpu1-stat-hashrate-5s">
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
                  <div class="stat-pair stat-load" id="rig-hostname-1-gpu1-stat-load">
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
                  <div class="stat-pair stat-temperature" id="rig-hostname-1-gpu1-stat-temperature">
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
                  <div class="stat-pair stat-fan-speed" id="rig-hostname-1-gpu1-stat-fan-speed">
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
                  <div class="stat-pair stat-fan-percent" id="rig-hostname-1-gpu1-stat-fan-percent">
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
                  <div class="stat-pair stat-gpu-clock" id="rig-hostname-1-gpu1-stat-gpu-clock">
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
                  <div class="stat-pair stat-mem-clock" id="rig-hostname-1-gpu1-stat-mem-clock">
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
                  <div class="stat-pair stat-gpu-voltage" id="rig-hostname-1-gpu1-stat-gpu-voltage">
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
                  <div class="stat-pair stat-blocks-found" id="rig-hostname-1-gpu1-stat-blocks-found">
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
                  <div class="stat-pair stat-accepted" id="rig-hostname-1-gpu1-stat-accepted">
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
                  <div class="stat-pair stat-rejected" id="rig-hostname-1-gpu1-stat-rejected">
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
                  <div class="stat-pair stat-stale" id="rig-hostname-1-gpu1-stat-stale">
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
                  <div class="stat-pair stat-blocks-found" id="rig-hostname-1-gpu1-stat-blocks-found">
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
                  <div class="stat-pair stat-hardware-errors" id="rig-hostname-1-gpu1-stat-hardware-errors">
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
                  <div class="stat-pair stat-worker-utility" id="rig-hostname-1-gpu1-stat-worker-utility">
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
              
              
              
              
              <div class="tab-pane fade" id="rig-hostname-1-gpu2">
               <div class="panel-body panel-body-stats">
                  <div class="stat-pair stat-health" id="rig-hostname-1-gpu2-stat-hashrate-avg">
                     <div class="stat-value">
                        <i class="icon icon-danger health-danger"></i>
                     </div>
                     <div class="stat-label">
                        Health
                     </div>
                     <div class="progress progress-striped">
                        <div class="progress-bar progress-bar-success" style="width: 100%"></div>
                     </div>
                  </div>
                  <div class="stat-pair stat-hashrate-avg" id="rig-hostname-1-gpu2-stat-hashrate-avg">
                     <div class="stat-value">
                        650 KH/s
                     </div>
                     <div class="stat-label">
                        Hashrate (avg)
                     </div>
                     <div class="progress progress-striped">
                        <div class="progress-bar progress-bar-success" style="width: 85%"></div>
                     </div>
                  </div>
                  <div class="stat-pair stat-hashrate-5s" id="rig-hostname-1-gpu2-stat-hashrate-5s">
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
                  <div class="stat-pair stat-load" id="rig-hostname-1-gpu2-stat-load">
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
                  <div class="stat-pair stat-temperature" id="rig-hostname-1-gpu2-stat-temperature">
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
                  <div class="stat-pair stat-fan-speed" id="rig-hostname-1-gpu2-stat-fan-speed">
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
                  <div class="stat-pair stat-fan-percent" id="rig-hostname-1-gpu2-stat-fan-percent">
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
                  <div class="stat-pair stat-gpu-clock" id="rig-hostname-1-gpu2-stat-gpu-clock">
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
                  <div class="stat-pair stat-mem-clock" id="rig-hostname-1-gpu2-stat-mem-clock">
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
                  <div class="stat-pair stat-gpu-voltage" id="rig-hostname-1-gpu2-stat-gpu-voltage">
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
                  <div class="stat-pair stat-blocks-found" id="rig-hostname-1-gpu2-stat-blocks-found">
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
                  <div class="stat-pair stat-accepted" id="rig-hostname-1-gpu2-stat-accepted">
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
                  <div class="stat-pair stat-rejected" id="rig-hostname-1-gpu2-stat-rejected">
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
                  <div class="stat-pair stat-stale" id="rig-hostname-1-gpu2-stat-stale">
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
                  <div class="stat-pair stat-blocks-found" id="rig-hostname-1-gpu2-stat-blocks-found">
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
                  <div class="stat-pair stat-hardware-errors" id="rig-hostname-1-gpu2-stat-hardware-errors">
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
                  <div class="stat-pair stat-worker-utility" id="rig-hostname-1-gpu2-stat-worker-utility">
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



              <div class="tab-pane fade" id="rig-hostname-1-gpu3">
               <div class="panel-body panel-body-stats">
                  <div class="stat-pair stat-health" id="rig-hostname-1-gpu3-stat-hashrate-avg">
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
                  <div class="stat-pair stat-hashrate-avg" id="rig-hostname-1-gpu3-stat-hashrate-avg">
                     <div class="stat-value">
                        750 KH/s
                     </div>
                     <div class="stat-label">
                        Hashrate (avg)
                     </div>
                     <div class="progress progress-striped">
                        <div class="progress-bar progress-bar-success" style="width: 85%"></div>
                     </div>
                  </div>
                  <div class="stat-pair stat-hashrate-5s" id="rig-hostname-1-gpu3-stat-hashrate-5s">
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
                  <div class="stat-pair stat-load" id="rig-hostname-1-gpu3-stat-load">
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
                  <div class="stat-pair stat-temperature" id="rig-hostname-1-gpu3-stat-temperature">
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
                  <div class="stat-pair stat-fan-speed" id="rig-hostname-1-gpu3-stat-fan-speed">
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
                  <div class="stat-pair stat-fan-percent" id="rig-hostname-1-gpu3-stat-fan-percent">
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
                  <div class="stat-pair stat-gpu-clock" id="rig-hostname-1-gpu3-stat-gpu-clock">
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
                  <div class="stat-pair stat-mem-clock" id="rig-hostname-1-gpu3-stat-mem-clock">
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
                  <div class="stat-pair stat-gpu-voltage" id="rig-hostname-1-gpu3-stat-gpu-voltage">
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
                  <div class="stat-pair stat-blocks-found" id="rig-hostname-1-gpu3-stat-blocks-found">
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
                  <div class="stat-pair stat-accepted" id="rig-hostname-1-gpu3-stat-accepted">
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
                  <div class="stat-pair stat-rejected" id="rig-hostname-1-gpu3-stat-rejected">
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
                  <div class="stat-pair stat-stale" id="rig-hostname-1-gpu3-stat-stale">
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
                  <div class="stat-pair stat-blocks-found" id="rig-hostname-1-gpu3-stat-blocks-found">
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
                  <div class="stat-pair stat-hardware-errors" id="rig-hostname-1-gpu3-stat-hardware-errors">
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
                  <div class="stat-pair stat-worker-utility" id="rig-hostname-1-gpu3-stat-worker-utility">
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
              
              
              <div class="tab-pane fade" id="rig-hostname-1-gpu4">
               <div class="panel-body panel-body-stats">
                  <div class="stat-pair stat-health" id="rig-hostname-1-gpu4-stat-hashrate-avg">
                     <div class="stat-value">
                        <i class="icon icon-warning-sign health-warn"></i> 
                     </div>
                     <div class="stat-label">
                        Health
                     </div>
                     <div class="progress progress-striped">
                        <div class="progress-bar progress-bar-success" style="width: 100%"></div>
                     </div>
                  </div>
                  <div class="stat-pair stat-hashrate-avg" id="rig-hostname-1-gpu4-stat-hashrate-avg">
                     <div class="stat-value">
                        850 KH/s
                     </div>
                     <div class="stat-label">
                        Hashrate (avg)
                     </div>
                     <div class="progress progress-striped">
                        <div class="progress-bar progress-bar-success" style="width: 85%"></div>
                     </div>
                  </div>
                  <div class="stat-pair stat-hashrate-5s" id="rig-hostname-1-gpu4-stat-hashrate-5s">
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
                  <div class="stat-pair stat-load" id="rig-hostname-1-gpu4-stat-load">
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
                  <div class="stat-pair stat-temperature" id="rig-hostname-1-gpu4-stat-temperature">
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
                  <div class="stat-pair stat-fan-speed" id="rig-hostname-1-gpu4-stat-fan-speed">
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
                  <div class="stat-pair stat-fan-percent" id="rig-hostname-1-gpu4-stat-fan-percent">
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
                  <div class="stat-pair stat-gpu-clock" id="rig-hostname-1-gpu4-stat-gpu-clock">
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
                  <div class="stat-pair stat-mem-clock" id="rig-hostname-1-gpu4-stat-mem-clock">
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
                  <div class="stat-pair stat-gpu-voltage" id="rig-hostname-1-gpu4-stat-gpu-voltage">
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
                  <div class="stat-pair stat-blocks-found" id="rig-hostname-1-gpu4-stat-blocks-found">
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
                  <div class="stat-pair stat-accepted" id="rig-hostname-1-gpu4-stat-accepted">
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
                  <div class="stat-pair stat-rejected" id="rig-hostname-1-gpu4-stat-rejected">
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
                  <div class="stat-pair stat-stale" id="rig-hostname-1-gpu4-stat-stale">
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
                  <div class="stat-pair stat-blocks-found" id="rig-hostname-1-gpu4-stat-blocks-found">
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
                  <div class="stat-pair stat-hardware-errors" id="rig-hostname-1-gpu4-stat-hardware-errors">
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
                  <div class="stat-pair stat-worker-utility" id="rig-hostname-1-gpu4-stat-worker-utility">
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

            <div class="panel-footer">
               <div class="pull-left">
                  <!-- <span class="label label-success"><i class="icon icon-ok"></i> Healthy</span> -->
                  <h3><i class="icon icon-uptime"></i> Uptime: 7m 01s</h3>
               </div>
               <div class="pull-right">
                  <button type="button" class="btn btn-default" data-toggle="modal" data-target="#editRig" data-backdrop="static"><i class="icon icon-edit"></i> Edit Rig</button>
                  <button type="button" class="btn btn-default" data-toggle="modal" data-target="#switchPool" data-backdrop="static"><i class="icon icon-refreshalt"></i> Switch Pool</button>
                  <!-- <button type="button" class="btn btn-default"><i class="icon icon-statistics"></i> View All Stats</button> -->
               </div>
            </div>
        </div>

         
         <div id="pool-1" class="panel panel-primary panel-pool">
            <h1>Pool Stats</h1>
            <div class="panel-heading">
               <button type="button" class="close" data-toggle="modal" data-target="#deletePrompt" data-backdrop="static" aria-hidden="true"><i class="icon icon-circledelete"></i></button>
               <h2 class="panel-title"><i class="icon icon-groups-friends"></i> CoinHuntr</h2>
            </div>
            <div class="panel-body panel-body-stats">
               <div class="stat-pair pool-conf-payout" id="pool-1-pool-conf-payout">
                  <div class="stat-value">
                     <span class="green">3.77081172</span>
                  </div>
                  <div class="stat-label">
                     Balance
                  </div>
               </div>
               <div class="stat-pair pool-unconf-payout" id="pool-1-pool-unconf-payout">
                  <div class="stat-value">
                     <span class="orange">0.07821302</span>
                  </div>
                  <div class="stat-label">
                     Unconfirmed Balance
                  </div>
               </div>
               <div class="stat-pair pool-hashrate" id="pool-1-pool-hashrate">
                  <div class="stat-value">
                     587 MH/s
                  </div>
                  <div class="stat-label">
                     Pool Hashrate
                  </div>
               </div>
               <div class="stat-pair pool-workers" id="pool-1-pool-workers">
                  <div class="stat-value">
                     1325
                  </div>
                  <div class="stat-label">
                     Pool Workers
                  </div>
               </div>
               <div class="stat-pair pool-efficiency" id="pool-1-pool-efficiency">
                  <div class="stat-value">
                     98.7%
                  </div>
                  <div class="stat-label">
                     Efficiency
                  </div>
               </div>
               <div class="stat-pair ltc-hashrate" id="ltc-hashrate">
                  <div class="stat-value">
                     109.67 GH/s
                  </div>
                  <div class="stat-label">
                     Network Hashrate
                  </div>
               </div>
               <div class="stat-pair ltc-difficulty" id="ltc-difficulty">
                  <div class="stat-value">
                     2926.50971494
                  </div>
                  <div class="stat-label">
                     Difficulty
                  </div>
               </div>
               <div class="stat-pair ltc-next-difficulty" id="ltc-next-difficulty">
                  <div class="stat-value">
                     3037 (<span class="red">+3.80%</span>)
                  </div>
                  <div class="stat-label">
                     Next (est.) Difficulty
                  </div>
               </div>
               <div class="stat-pair pool-time-last" id="pool-1-pool-time-last">
                  <div class="stat-value">
                     14h 48m 16s
                  </div>
                  <div class="stat-label">
                     Time Since Last Block
                  </div>
               </div>
               <div class="stat-pair pool-estimate-next" id="pool-1-pool-estimate-next">
                  <div class="stat-value">
                     1h 23m 54s
                  </div>
                  <div class="stat-label">
                     Est. Time of Next Block
                  </div>
               </div>
               <div class="stat-pair pool-current-block" id="pool-1-pool-current-block">
                  <div class="stat-value">
                     478358
                  </div>
                  <div class="stat-label">
                     Current Block
                  </div>
               </div>
               <div class="stat-pair pool-last-block" id="pool-1-pool-last-block">
                  <div class="stat-value">
                     478299
                  </div>
                  <div class="stat-label">
                     Last Block Found
                  </div>
               </div>
               <div class="stat-pair pool-status" id="pool-1-pool-status">
                  <div class="stat-value">
                     <i class="icon icon-check health-good"></i> Alive
                  </div>
                  <div class="stat-label">
                     Status
                  </div>
               </div>
               <div class="stat-pair pool-id" id="pool-1-pool-id">
                  <div class="stat-value">
                     1
                  </div>
                  <div class="stat-label">
                     Pool ID
                  </div>
               </div>
               <div class="stat-pair pool-priority" id="pool-1-pool-priority">
                  <div class="stat-value">
                     0
                  </div>
                  <div class="stat-label">
                     Priority
                  </div>
               </div>
               <div class="stat-pair pool-accepted" id="pool-1-pool-accepted">
                  <div class="stat-value">
                     87,402
                  </div>
                  <div class="stat-label">
                     Accepted
                  </div>
               </div>
               <div class="stat-pair pool-rejected" id="pool-1-pool-rejected">
                  <div class="stat-value">
                     347
                  </div>
                  <div class="stat-label">
                     Rejected
                  </div>
               </div>
               <div class="stat-pair pool-url" id="pool-1-pool-url">
                  <div class="stat-value">
                     http://primary.coinhuntr.com:3333
                  </div>
                  <div class="stat-label">
                     URL
                  </div>
               </div>
               <div class="stat-pair pool-user" id="pool-1-pool-user">
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
            </div>
         </div>        
         
         <div id="wallet-1" class="panel panel-primary panel-wallet">
            <h1>Addresses</h1>
            <div class="panel-heading">
               <button type="button" class="close" data-toggle="modal" data-target="#deletePrompt" data-backdrop="static" aria-hidden="true"><i class="icon icon-circledelete"></i></button>
               <h2 class="panel-title"><i class="icon icon-walletalt"></i> Balances</h2>
            </div>
            <div class="panel-body panel-body-addresses">
               <div class="stat-pair pool-conf-payout" id="pool-1-pool-conf-payout">
                  <div class="stat-value">
                     4.48508539 LTC in %ADDRESS_LABEL%
                  </div>
                  <div class="stat-label">
                     <img src="images/icon-litecoin.png" alt="Litecoin" /> LUQ4GyjjDtopdGj3h8CvDEP4QCLd3FEhDT
                  </div>
               </div>
               <div class="stat-pair pool-conf-payout" id="pool-1-pool-conf-payout">
                  <div class="stat-value">
                     4.48508539 LTC in %ADDRESS_LABEL%
                  </div>
                  <div class="stat-label">
                     <img src="images/icon-litecoin.png" alt="Litecoin" /> LUQ4GyjjDtopdGj3h8CvDEP4QCLd3FEhDT
                  </div>
               </div>
               <div class="stat-pair pool-conf-payout" id="pool-1-pool-conf-payout">
                  <div class="stat-value">
                     4.48508539 LTC in %ADDRESS_LABEL%
                  </div>
                  <div class="stat-label">
                     <img src="images/icon-litecoin.png" alt="Litecoin" /> LUQ4GyjjDtopdGj3h8CvDEP4QCLd3FEhDT
                  </div>
               </div>
            </div><!-- / .panel-body -->
            <div class="panel-footer text-right">
               <button type="button" class="btn btn-default" data-toggle="modal" data-target="#editPool" data-backdrop="static"><i class="icon icon-edit"></i> Edit Addresses</button>
            </div>
         </div>
                     
         
         <div id="news-feed-1" class="panel panel-primary panel-news-feed">
            <h1>News Feed Headlines</h1>
            <div class="panel-heading">
               <button type="button" class="close" data-toggle="modal" data-target="#deletePrompt" data-backdrop="static" aria-hidden="true"><i class="icon icon-circledelete"></i></button>
               <h2 class="panel-title"><i class="icon icon-rss"></i><a href="http://coindesk.com" rel="external">CoinDesk.com</a></h2>
            </div>
            <div class="panel-body panel-body-coins">
               <ul class="feed-headlines">
                  <li><a href="#" rel="external"><span>December 10, 2013</span> - Chinese Bitcoin Exchange OKCoin Accused of Faking Trading Data</a></li>
                  <li><a href="#" rel="external"><span>December 9, 2013</span> - Bitcoin Exchange Startup Bex.io Recieves $525,000 in Funding</a></li>
                  <li><a href="#" rel="external"><span>December 7, 2013</span> - Overstock.com CEO Unveils More Details About Bitcoin Adoption</a></li>
                  <li><a href="#" rel="external"><span>December 4, 2013</span> - Polish Finance Official: Bitcoin is Not Illegal</a></li>
                  <li><a href="#" rel="external"><span>December 10, 2013</span> - Chinese Bitcoin Exchange OKCoin Accused of Faking Trading Data</a></li>
                  <li><a href="#" rel="external"><span>December 9, 2013</span> - Bitcoin Exchange Startup Bex.io Recieves $525,000 in Funding</a></li>
                  <li><a href="#" rel="external"><span>December 7, 2013</span> - Overstock.com CEO Unveils More Details About Bitcoin Adoption</a></li>
                  <li><a href="#" rel="external"><span>December 4, 2013</span> - Polish Finance Official: Bitcoin is Not Illegal</a></li>
                  <li><a href="#" rel="external"><span>December 10, 2013</span> - Chinese Bitcoin Exchange OKCoin Accused of Faking Trading Data</a></li>
                  <li><a href="#" rel="external"><span>December 9, 2013</span> - Bitcoin Exchange Startup Bex.io Recieves $525,000 in Funding</a></li>
                  <li><a href="#" rel="external"><span>December 7, 2013</span> - Overstock.com CEO Unveils More Details About Bitcoin Adoption</a></li>
                  <li><a href="#" rel="external"><span>December 4, 2013</span> - Polish Finance Official: Bitcoin is Not Illegal</a></li>
               </ul>
            </div>
            <div class="panel-footer text-right">
               <button type="button" class="btn btn-default"><i class="icon icon-refresh"></i> Update Feed</button>
               <button type="button" class="btn btn-default" data-toggle="modal" data-target="#editPool" data-backdrop="static"><i class="icon icon-rss"></i> Edit Feed</button>
            </div>
         </div>
                     
         
         <div id="subreddit-feed-1" class="panel panel-primary panel-news-feed">
            <h1>Subreddit Reader</h1>
            <div class="panel-heading">
               <button type="button" class="close" data-toggle="modal" data-target="#deletePrompt" data-backdrop="static" aria-hidden="true"><i class="icon icon-circledelete"></i></button>
               <h2 class="panel-title"><i class="icon icon-reddit"></i><a href="http://reddit.com/r/litecoinmining" rel="external">/r/litecoinmining</a></h2>
            </div>
            <div class="panel-body panel-body-coins">
               <ul class="feed-headlines">
                  <li><a href="#" rel="external"><span>December 10, 2013</span> - Chinese Bitcoin Exchange OKCoin Accused of Faking Trading Data</a></li>
                  <li><a href="#" rel="external"><span>December 9, 2013</span> - Bitcoin Exchange Startup Bex.io Recieves $525,000 in Funding</a></li>
                  <li><a href="#" rel="external"><span>December 7, 2013</span> - Overstock.com CEO Unveils More Details About Bitcoin Adoption</a></li>
                  <li><a href="#" rel="external"><span>December 4, 2013</span> - Polish Finance Official: Bitcoin is Not Illegal</a></li>
                  <li><a href="#" rel="external"><span>December 10, 2013</span> - Chinese Bitcoin Exchange OKCoin Accused of Faking Trading Data</a></li>
                  <li><a href="#" rel="external"><span>December 9, 2013</span> - Bitcoin Exchange Startup Bex.io Recieves $525,000 in Funding</a></li>
                  <li><a href="#" rel="external"><span>December 7, 2013</span> - Overstock.com CEO Unveils More Details About Bitcoin Adoption</a></li>
                  <li><a href="#" rel="external"><span>December 4, 2013</span> - Polish Finance Official: Bitcoin is Not Illegal</a></li>
                  <li><a href="#" rel="external"><span>December 10, 2013</span> - Chinese Bitcoin Exchange OKCoin Accused of Faking Trading Data</a></li>
                  <li><a href="#" rel="external"><span>December 9, 2013</span> - Bitcoin Exchange Startup Bex.io Recieves $525,000 in Funding</a></li>
                  <li><a href="#" rel="external"><span>December 7, 2013</span> - Overstock.com CEO Unveils More Details About Bitcoin Adoption</a></li>
                  <li><a href="#" rel="external"><span>December 4, 2013</span> - Polish Finance Official: Bitcoin is Not Illegal</a></li>
               </ul>
            </div>
            <div class="panel-footer text-right">
               <button type="button" class="btn btn-default"><i class="icon icon-refresh"></i> Update Feed</button>
               <button type="button" class="btn btn-default" data-toggle="modal" data-target="#editPool" data-backdrop="static"><i class="icon icon-rss"></i> Edit Feed</button>
            </div>
         </div>
         
          
         <div id="subreddit-feed-2" class="panel panel-primary panel-news-feed">
            <h1>Subreddit Reader</h1>
            <div class="panel-heading">
               <button type="button" class="close" data-toggle="modal" data-target="#deletePrompt" data-backdrop="static" aria-hidden="true"><i class="icon icon-circledelete"></i></button>
               <h2 class="panel-title"><i class="icon icon-reddit"></i><a href="http://reddit.com/r/litecoin" rel="external">/r/litecoin</a></h2>
            </div>
            <div class="panel-body panel-body-coins">
               <ul class="feed-headlines">
                  <li><a href="#" rel="external"><span>December 10, 2013</span> - Chinese Bitcoin Exchange OKCoin Accused of Faking Trading Data</a></li>
                  <li><a href="#" rel="external"><span>December 9, 2013</span> - Bitcoin Exchange Startup Bex.io Recieves $525,000 in Funding</a></li>
                  <li><a href="#" rel="external"><span>December 7, 2013</span> - Overstock.com CEO Unveils More Details About Bitcoin Adoption</a></li>
                  <li><a href="#" rel="external"><span>December 4, 2013</span> - Polish Finance Official: Bitcoin is Not Illegal</a></li>
                  <li><a href="#" rel="external"><span>December 10, 2013</span> - Chinese Bitcoin Exchange OKCoin Accused of Faking Trading Data</a></li>
                  <li><a href="#" rel="external"><span>December 9, 2013</span> - Bitcoin Exchange Startup Bex.io Recieves $525,000 in Funding</a></li>
                  <li><a href="#" rel="external"><span>December 7, 2013</span> - Overstock.com CEO Unveils More Details About Bitcoin Adoption</a></li>
                  <li><a href="#" rel="external"><span>December 4, 2013</span> - Polish Finance Official: Bitcoin is Not Illegal</a></li>
                  <li><a href="#" rel="external"><span>December 10, 2013</span> - Chinese Bitcoin Exchange OKCoin Accused of Faking Trading Data</a></li>
                  <li><a href="#" rel="external"><span>December 9, 2013</span> - Bitcoin Exchange Startup Bex.io Recieves $525,000 in Funding</a></li>
                  <li><a href="#" rel="external"><span>December 7, 2013</span> - Overstock.com CEO Unveils More Details About Bitcoin Adoption</a></li>
                  <li><a href="#" rel="external"><span>December 4, 2013</span> - Polish Finance Official: Bitcoin is Not Illegal</a></li>
               </ul>
            </div>
            <div class="panel-footer text-right">
               <button type="button" class="btn btn-default"><i class="icon icon-refresh"></i> Update Feed</button>
               <button type="button" class="btn btn-default" data-toggle="modal" data-target="#editPool" data-backdrop="static"><i class="icon icon-rss"></i> Edit Feed</button>
            </div>
         </div>


      </div>
      <!-- /container -->

      <div class="container">
         <?php require_once("includes/footer.php"); ?>
      </div>
      
