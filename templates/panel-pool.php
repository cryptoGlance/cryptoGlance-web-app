
<?php require_once("includes/modal-edit_pool.php"); ?>

<div id="pool-1" class="panel panel-primary panel-pool">
   <h1>Pool Stats</h1>
   <div class="panel-heading">
      <button type="button" class="panel-header-button" data-toggle="modal" data-target="#deletePrompt" data-backdrop="static" aria-hidden="true"><i class="icon icon-circledelete"></i></button> 
      <button type="button" class="panel-header-button toggle-panel-body"><i class="icon icon-chevron-up"></i></button> 
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
      <button type="button" class="btn btn-default btn-updater"><i class="icon icon-refresh"></i> Update Now</button>
      <button type="button" class="btn btn-default" data-toggle="modal" data-target="#editPool" data-backdrop="static"><i class="icon icon-edit"></i> Edit Pool</button>
   </div>
</div>        

