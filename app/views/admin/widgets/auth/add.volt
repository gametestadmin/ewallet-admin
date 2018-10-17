<!-- Modal -->
<div class="modal fade" id="form-auth" tabindex="-1" role="dialog" aria-labelledby="form-auth-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal" action="{{url('game/auth/add')}}" method="post" id="form">
            <div class="modal-header">
                <label class="col-xs-6">
                    <h3 class="modal-title" id="form-auth-label">Add API Authentication</h3>
                </label>
                <label class="col-xs-6">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </label>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="col-xs-3 control-label">App Id</label>
                    <label class="col-xs-9">
                        <input type="hidden" name="tab" value="tab-endpoint">
                        <input type="hidden" name="game" value="{{game.id}}">
                        <input type="text" name="app_id" class="form-control" placeholder="App Id">
                    </label>
                </div>
                <div class="form-group">
                    <label class="col-xs-3 control-label">App Secret</label>
                    <label class="col-xs-9">
                        <input type="text" name="app_secret" class="form-control" placeholder="App Secret">
                    </label>
                </div>
            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="submit">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>