
<?php require_once("includes/modal-edit_host.php"); ?>

<div id="rig-hostname-1" class="panel panel-primary panel-rig">
   <h1>Mining Rig Stats</h1>
   <div class="panel-heading">
      <button type="button" class="panel-header-button" data-toggle="modal" data-target="#deletePrompt" data-backdrop="static" aria-hidden="true"><i class="icon icon-circledelete"></i></button> 
      <button type="button" class="panel-header-button toggle-panel-body"><i class="icon icon-chevron-up"></i></button> 
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
         <div class="stat-pair stat-uptime" id="rig-hostname-1-summary-stat-uptime">
            <div class="stat-value">
               32h 7m 01s
            </div>
            <div class="stat-label">
               Uptime
            </div>
            <div class="progress progress-striped">
               <div class="progress-bar progress-bar-success" style="width: 100%"></div>
            </div>
         </div>
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
         <div class="stat-pair stat-ip-address" id="rig-hostname-1-summary-stat-ip-address">
            <div class="stat-value">
               192.168.1.32
            </div>
            <div class="stat-label">
              IP
            </div>
            <div class="progress progress-striped">
               <div class="progress-bar progress-bar-default" style="width: 0%"></div>
            </div>
         </div>
         <div class="table-summary table-responsive">
           <table class="table table-hover table-striped">
            <thead>
               <tr>
                  <th></th>
                  <th>GPU #</th>
                  <th>Load</th>
                  <th>Hashrate (5s)</th>
                  <th>Temperature</th>
                  <th>Fan %</th>
                  <th>GPU Clock</th>
                  <th>Memory Clock</th>
               </tr>
            </thead>
            <tbody>
               <tr>
                  <td><i class="icon icon-cpu-processor green"></i></td>
                  <td class="green">gpu0</td>
                  <td>99%</td>
                  <td>440 KH/s</td>
                  <td>76 &deg;C</td>
                  <td>100%</td>
                  <td>950 mhz</td>
                  <td>1375 mhz</td>
               </tr>
               <tr>
                  <td><i class="icon icon-cpu-processor green"></i></td>
                  <td class="green">gpu1</td>
                  <td>99%</td>
                  <td>390 KH/s</td>
                  <td>76 &deg;C</td>
                  <td>100%</td>
                  <td>950 mhz</td>
                  <td>1375 mhz</td>
               </tr>
               <tr>
                  <td><i class="icon icon-cpu-processor orange"></i></td>
                  <td class="orange">gpu2</td>
                  <td>99%</td>
                  <td>40 KH/s</td>
                  <td>76 &deg;C</td>
                  <td>100%</td>
                  <td>950 mhz</td>
                  <td>1375 mhz</td>
               </tr>
               <tr>
                  <td><i class="icon icon-cpu-processor green"></i></td>
                  <td class="green">gpu3</td>
                  <td>99%</td>
                  <td>430 KH/s</td>
                  <td>76 &deg;C</td>
                  <td>100%</td>
                  <td>950 mhz</td>
                  <td>1375 mhz</td>
               </tr>
               <tr>
                  <td><i class="icon icon-cpu-processor red"></i></td>
                  <td class="red">gpu4</td>
                  <td>99%</td>
                  <td>30 KH/s</td>
                  <td>76 &deg;C</td>
                  <td>100%</td>
                  <td>950 mhz</td>
                  <td>1375 mhz</td>
               </tr>
            </tbody>
           </table>
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
      <div class="text-right">
         <button type="button" class="btn btn-default btn-updater"><i class="icon icon-refresh"></i> Update Now</button>
         <button type="button" class="btn btn-default" data-toggle="modal" data-target="#editRig" data-backdrop="static"><i class="icon icon-edit"></i> Edit Rig</button>
         <button type="button" class="btn btn-default" data-toggle="modal" data-target="#switchPool" data-backdrop="static"><i class="icon icon-refreshalt"></i> Switch Pool</button>
         <!-- <button type="button" class="btn btn-default"><i class="icon icon-statistics"></i> View All Stats</button> -->
      </div>
   </div>
</div>

