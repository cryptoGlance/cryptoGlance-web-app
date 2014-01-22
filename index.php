<?php require_once("includes/header.php"); ?>
       
<!-- ### Below is where the modals are defined for adding or editing a host. 
         There are two modals/include files now, but this can be changed to a single one, 
         as the EDIT would have the information pre-populated. The only other 
         difference is the <h3> label at the top!
            
      ### Same goes for the POOL ones below
      
-->

<?php require_once("templates/modals/switch_pool.php"); ?>

<?php require_once("templates/modals/delete_prompt.php"); ?>

         
   <div id="dashboard-wrap" class="container sub-nav">

      <?php require_once("templates/panel-overview.php"); ?>
      
      <?php require_once("templates/panel-wallet_n.php"); ?>
      
      <?php require_once("templates/panel-rig.php"); ?>

      <?php require_once("templates/panel-pool.php"); ?>

      <?php require_once("templates/panel-news_feed.php"); ?>
      
      <?php require_once("templates/panel-subreddit_feed.php"); ?>
                           
      <?php require_once("templates/panel-coinwatcher.php"); ?>

   </div>
   <!-- /container -->

   <div class="container">
      <?php require_once("includes/footer.php"); ?>
   </div>
      
