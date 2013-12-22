<?php require_once("includes/header.php"); ?>
       
<!-- ### Below is where the modals are defined for adding or editing a host. 
         There are two modals/include files now, but this can be changed to a single one, 
         as the EDIT would have the information pre-populated. The only other 
         difference is the <h3> label at the top!
            
      ### Same goes for the POOL ones below
      
-->
              
<?php require_once("includes/modal-add_pool.php"); ?>
<?php require_once("includes/modal-edit_pool.php"); ?>

<?php require_once("includes/modal-delete_prompt.php"); ?>

         
      <div class="container sub-nav">

         <h1>Your Pools:</h1>
         
         [[ TABLE? ]]

         <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addPool" data-backdrop="static"><i class="icon icon-circleadd"></i> Add Pool</button>
      
      </div>
      <!-- /container -->

      <div class="container">
         <?php require_once("includes/footer.php"); ?>
      </div>
      
