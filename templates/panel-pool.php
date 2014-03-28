<div id="pool-<?php echo $poolId?>" class="panel panel-primary panel-pool" data-type="pool" data-id="<?php echo $poolId?>">
   <h1><?php echo (empty($pool['name'])) ? $pool['apiurl'] : $pool['name']?></h1>
   <div class="panel-heading">
      <button type="button" class="panel-header-button btn-delete" data-toggle="modal" data-target="#deletePrompt" data-backdrop="static" aria-hidden="true"><i class="icon icon-circledelete"></i></button> 
      <a href="#goDirectlyToHelpPageAnchor"><button type="button" class="panel-header-button"><i class="icon icon-question-sign"></i></button></a>
      <button type="button" class="panel-header-button toggle-panel-body"><i class="icon icon-chevron-up"></i></button> 
      <h2 class="panel-title"><i class="icon icon-communitysmall"></i> Pool Stats</h2>
   </div>
   <div class="panel-body panel-body-stats"><img src="images/ajax-loader.gif" alt="loading" /></div>
   <div class="panel-footer text-right" style="display: none;">
<!--      <button type="button" class="btn btn-default btn-updater"><i class="icon icon-refresh"></i> Update Now</button>-->
<!--      <button type="button" class="btn btn-default" data-toggle="modal" data-target="#editPool" data-backdrop="static"><i class="icon icon-edit"></i> Edit Pool</button>-->
   </div>
</div>