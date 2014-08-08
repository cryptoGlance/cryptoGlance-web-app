<!-- Modal -->
<div class="modal fade" id="deletePrompt" tabindex="-1" role="dialog" aria-labelledby="deletePromptLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="form-horizontal" role="form">
         <div class="modal-header">
            <h2><i class="icon icon-question-sign"></i> Are you sure?</h2>
         </div>
         <div class="modal-body">
            <big>This will remove the <span class="panelName"></span> configuration!</big>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-lg btn-primary" data-dismiss="modal"><i class="icon icon-undo"></i> No, keep it!</button>
           <button type="button" class="btn btn-lg btn-danger btn-removeConfig" data-dismiss="modal"><i class="icon icon-circledelete"></i> Delete it!</button>
         </div>
         <input type="hidden" name="type" />
         <input type="hidden" name="id" />
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->