<?php $minimized = ($messages['state'] === 'close'); ?>
<div id="messages" class="panel panel-primary panel-messages" data-type="messages">
   <h1>Messages</h1>
   <div class="panel-heading">
      <button type="button" class="panel-header-button btn-updater" data-type="messages"><i class="icon icon-refresh"></i> Update</button>
      <button type="button" class="panel-header-button toggle-panel-body"><i class="icon icon-chevron-<?php echo ($minimized?'down':'up') ?>"></i></button>
      <h2 class="panel-title"><i class="icon icon-eye-view"></i> Messages</h2>
   </div>
   <div class="panel-body panel-body-messages" <?php echo ($minimized?'style="display:none;"':'') ?>>
      <div class="table-responsive">
        <table class="table table-hover table-striped">
         <thead>
            <tr>
               <th>Severity</th>
               <th>Time</th>
               <th>Message</th>
               <th></th>
            </tr>
         </thead>
         <tbody></tbody>
        </table>
      </div>
   </div><!-- / .panel-body -->
</div>
