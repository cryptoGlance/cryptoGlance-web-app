
<?php require_once("templates/modals/edit_host.php"); ?>

<div id="rig1" class="panel panel-primary panel-rig">
   <h1>Mining Rig Stats</h1>
   <div class="panel-heading">
      <button type="button" class="panel-header-button" data-toggle="modal" data-target="#deletePrompt" data-backdrop="static" aria-hidden="true"><i class="icon icon-circledelete"></i></button> 
      <button type="button" class="panel-header-button toggle-panel-body"><i class="icon icon-chevron-up"></i></button> 
      <h2 class="panel-title"><i class="icon icon-server"></i> <span class="value">192.168.0.10</span></h2>
   </div>
   <ul class="nav nav-pills">
      
      <!-- ### Set certain classes for 'sick'/inactive GPUs 
      
         Notice the special classes of 'pill-warning/danger', if there is a problem with the GPU
         
         Also, the HREF must be set to link to the proper RIG ++ GPUn
         
      -->
      
     <li class="active"><a class="blue" href="#rig1-summary" data-toggle="tab">Summary <i class="icon icon-dotlist"></i></a></li>
   </ul>
   
   <div class="tab-content">
      
      <!-- ### Define the content area for Summary / GPU N 
      
         Here, Summary should show the 'accumulated'/total values from ALL GPUs, added into one 
         
      -->
      
     <div class="tab-pane fade in active" id="rig1-summary">
      <div class="panel-body panel-body-stats">
        <div class="panel-body-summary">
         <div class="stat-pair stat-uptime">
            <div class="stat-value">
               --h --m --s
            </div>
            <div class="stat-label">
               Uptime
            </div>
            <div class="progress progress-striped">
               <div class="progress-bar progress-bar-success" style="width: 100%"></div>
            </div>
         </div>
         <div class="stat-pair stat-hashrate-avg">
            <div class="stat-value">
               -- KH/s
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
               -- KH/s
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
               -
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
               --
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
               --
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
               --
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
               --
            </div>
            <div class="stat-label">
              HW Errors
            </div>
            <div class="progress progress-striped">
               <div class="progress-bar progress-bar-success" style="width: 1%"></div>
            </div>
         </div>
         <div class="stat-pair stat-active-pool">
            <div class="stat-value">
               ---
            </div>
            <div class="stat-label">
              Active Mining Pool
            </div>
            <div class="progress progress-striped">
               <div class="progress-bar progress-bar-success" style="width: 100%"></div>
            </div>
         </div>
         <div class="stat-pair stat-ip-address">
            <div class="stat-value">
               ---.---.---.---
            </div>
            <div class="stat-label">
              IP
            </div>
            <div class="progress progress-striped">
               <div class="progress-bar progress-bar-default" style="width: 0%"></div>
            </div>
         </div>
         </div>
         <div class="table-summary table-responsive">
           <table class="table table-hover table-striped">
            <thead>
               <tr>
                  <th></th>
                  <th>GPU #</th>
                  <th>Temperature</th>
                  <th>Fan Speed</th>
                  <th>Fan %</th>
                  <th>Hashrate (5s)</th>
                  <th>Utility</th>
               </tr>
            </thead>
            <tbody>
               <tr>
                  <td><i class="icon icon-cpu-processor green"></i></td>
                  <td class="green">gpu0</td>
                  <td>-- &deg;C</td>
                  <td>-- RPM</td>
                  <td>--%</td>
                  <td>-- KH/s</td>
                  <td>--/m</td>
               </tr>
               <tr>
                  <td><i class="icon icon-cpu-processor orange"></i></td>
                  <td class="orange">gpu1</td>
                  <td>-- &deg;C</td>
                  <td>-- RPM</td>
                  <td>--%</td>
                  <td>-- KH/s</td>
                  <td>--/m</td>
               </tr>
               <tr>
                  <td><i class="icon icon-cpu-processor red"></i></td>
                  <td class="red">gpu2</td>
                  <td>-- &deg;C</td>
                  <td>-- RPM</td>
                  <td>--%</td>
                  <td>-- KH/s</td>
                  <td>--/m</td>
               </tr>
            </tbody>
           </table>
         </div>
       </div><!-- / .panel-body -->
     </div>     
   </div>

   <div class="panel-footer">
      <div class="text-right">
         <button type="button" class="btn btn-default btn-updater" data-type="miner" data-attr="1"><i class="icon icon-refresh"></i> Update Now</button>
<!--         <button type="button" class="btn btn-default" data-toggle="modal" data-target="#editRig" data-backdrop="static" data-id="1"><i class="icon icon-edit"></i> Edit Rig</button>-->
<!--         <button type="button" class="btn btn-default" data-toggle="modal" data-target="#switchPool" data-backdrop="static" data-id="1"><i class="icon icon-refreshalt"></i> Switch Pool</button>-->
         <!-- <button type="button" class="btn btn-default"><i class="icon icon-statistics"></i> View All Stats</button> -->
      </div>
   </div>
</div>

