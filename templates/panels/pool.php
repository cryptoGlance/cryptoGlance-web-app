<?php $minimized = ($pool['panel']['state'] === 'close');  ?>
<div id="pool-<?php echo $poolId?>" class="panel panel-primary panel-pool" data-type="pools" data-id="<?php echo $poolId?>">
   <h1><?php echo (empty($pool['name'])) ? $pool['apiurl'] : $pool['name']?></h1>
   <div class="panel-heading">
        <button type="button" class="panel-header-button btn-delete" data-toggle="modal" data-target="#deletePrompt" data-backdrop="static" aria-hidden="true"><i class="icon icon-circledelete"></i></button>
        <button type="button" class="panel-header-button btn-edit-pool" data-type="pool" data-toggle="modal" data-target="#addPool" data-attr="<?php echo $poolId?>"><i class="icon icon-edit"></i> Edit</button>
        <button type="button" class="panel-header-button toggle-panel-body"><i class="icon icon-chevron-<?php echo ($minimized?'down':'up') ?>"></i></button>
      <h2 class="panel-title"><i class="icon icon-communitysmall"></i> <span class="pool-label">Pool Stats</span></h2>
   </div>
   <div class="panel-body panel-body-stats" <?php echo ($minimized?'style="display:none;"':'') ?>><img src="images/ajax-loader.gif" alt="loading" /></div>
</div>
