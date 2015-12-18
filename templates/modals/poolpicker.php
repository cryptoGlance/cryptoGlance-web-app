<!-- Modal -->
<div class="modal fade" id="poolPicker" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" role="form">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h2 class="modal-title title-add" style="display: none;"><i class="icon icon-edit"></i> Add PoolPicker</h2>
                    <h2 class="modal-title title-edit" style="display: none;"><i class="icon icon-edit"></i> Edit PoolPicker</h2>
                </div>
                <div class="modal-body">
                    <div class="form-group form-left">
                        <table class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <tr>
                                <td><input type="checkbox" class="form-control" name="algorithms[]" value="lyra2re" id="poolpickerLyra2re"></td>
                                <td><label for="poolpickerLyra2re">Lyra2RE</label></td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" class="form-control" name="algorithms[]" value="neoscrypt" id="poolpickerNeoScrypt"></td>
                                <td><label for="poolpickerNeoScrypt">NeoScrypt</label></td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" class="form-control" name="algorithms[]" value="nist5" id="poolpickerNist5"></td>
                                <td><label for="poolpickerNist5">Nist5</label></td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" class="form-control" name="algorithms[]" value="scrypt" id="poolpickerScrypt" /></td>
                                <td><label for="poolpickerScrypt">Scrypt</label></td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" class="form-control" name="algorithms[]" value="keccak" id="poolpickerKeccak" /></td>
                                <td><label for="poolpickerKeccak">Keccak</label></td>
                            </tr>
                        </table>
                    <table class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <tr>
                        <td><input type="checkbox" class="form-control" name="algorithms[]" value="scryptn" id="poolpickerScryptN"></td>
                        <td><label for="poolpickerScryptN">Scrypt-N</label></td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="form-control" name="algorithms[]" value="sha256" id="poolpickerSha256"></td>
                        <td><label for="poolpickerSha256">SHA-256</label></td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="form-control" name="algorithms[]" value="x11" id="poolpickerX11"></td>
                        <td><label for="poolpickerX11">X11</label></td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="form-control" name="algorithms[]" value="x13" id="poolpickerX13"></td>
                        <td><label for="poolpickerX13">X13</label></td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="form-control" name="algorithms[]" value="x15" id="poolpickerX15"></td>
                        <td><label for="poolpickerX15">X15</label></td>
                    </tr>
                    </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-lg btn-danger btn-cancelConfig" data-dismiss="modal"><i class="icon icon-undo"></i> Cancel</button>
                    <button type="button" class="btn btn-lg btn-success btn-saveConfig" id="btnSavePoolPicker"><i class="icon icon-save-floppy"></i> Save</button>
                </div>
                <input type="hidden" name="type" value="pool-picker" />
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
