<!-- Modal -->
<div class="modal fade" id="switchPool" tabindex="-1" role="dialog" aria-labelledby="switchPoolLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h2><i class="icon icon-refreshalt"></i> Switch Active Mining Pool</h2>
                </div>
                <div class="modal-body" style="padding-bottom: 0px;">
                    <div class="ajax-loader"></div>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped" style="display: none;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Selected</th>
                                    <th>Active</th>
                                    <th>URL</th>
                                    <th>Priority</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="form-group checkbox resetStats" style="text-align: center;">
                        <input id="resetStats" type="checkbox" name="resetStats" value="1"><label for="resetStats" style="display: inline;">Reset stats</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-lg btn-primary" data-dismiss="modal"><i class="icon icon-undo"></i> Stay in current pool</button>
                    <button type="button" class="btn btn-lg btn-success" data-dismiss="modal"><i class="icon icon-refreshalt"></i> Switch pool</button>
                </div>
            </form>
            </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
