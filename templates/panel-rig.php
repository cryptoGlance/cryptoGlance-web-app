<div id="rig<?php echo $minerId?>" class="panel panel-primary panel-rig">
    <h1><?php echo (empty($miner['name'])) ? $miner['host'] : $miner['name']?></h1>
    
    <div class="panel-heading">
        <button type="button" class="panel-header-button" data-toggle="modal" data-target="#deletePrompt" data-backdrop="static" aria-hidden="true"><i class="icon icon-circledelete"></i></button> 
        <a href="#goDirectlyToHelpPageAnchor"><button type="button" class="panel-header-button"><i class="icon icon-question-sign"></i></button></a>
        <button type="button" class="panel-header-button toggle-panel-body"><i class="icon icon-chevron-up"></i></button> 
        <h2 class="panel-title"><i class="icon icon-server"></i> <span class="value">Mining Rig Stats</span></h2>
    </div>
    
    <ul class="nav nav-pills"></ul>
    
    <div class="tab-content">
        <div class="tab-pane fade in active" id="rig<?php echo $minerId?>-summary">
            <div class="panel-body panel-body-stats">
                <div class="panel-body-summary">
                
                </div>
                <div class="table-summary table-responsive">
                    <table class="table table-hover table-striped">
                        <thead></thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div><!-- / .panel-body -->
        </div>     
    </div>
    
    <div class="panel-footer">
        <div class="text-right">
            <button type="button" class="btn btn-default btn-manage-rig" data-type="rig" data-toggle="modal" data-target="#manageRig" data-attr="<?php echo $minerId?>"><i class="icon icon-server"></i> Manage Rig</button>
<!--            <button type="button" class="btn btn-default btn-updater" data-type="rig" data-attr="<?php echo $minerId?>"><i class="icon icon-refresh"></i> Update Now</button>-->
            <!-- <button type="button" class="btn btn-default"><i class="icon icon-statistics"></i> View All Stats</button> -->
        </div>
    </div>
    
</div>