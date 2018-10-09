<!-- Modal -->
<div class="modal fade" id="form-add-user-ip" tabindex="-1" role="dialog" aria-labelledby="form-add-user-ip-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal" action="{{url('agent/whitelist/add')}}" method="post" id="form">
            <div class="modal-header">
                <label class="col-xs-6">
                    <h3 class="modal-title" id="modalLabel">User Whitelist IP Form Add</h3>
                </label>
                <label class="col-xs-6">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </label>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="col-xs-3 control-label">Ip</label>
                    <label class="col-xs-9">
                        <input type="hidden" name="user" value="{{agent.id}}">
                        <input type="hidden" name="tab" value="tab-ip">
                        <input type="text" name="ip" class="form-control">
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