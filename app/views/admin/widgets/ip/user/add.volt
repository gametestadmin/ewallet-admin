<!-- Modal -->
<div class="modal fade" id="form-add-user-ip" tabindex="-1" role="dialog" aria-labelledby="form-add-user-ip-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal" action="{{url('agent/whitelist/add')}}" method="post" id="form">
            <div class="modal-header">
                <label class="col-xs-6">
                    <span class="modal-title" id="modalLabel">{{translate['title_text_add_whitelist_ip']}}</span>
                </label>
                <label class="col-xs-6">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </label>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="col-xs-3 control-label">{{translate['form_whitelist_ip']}}</label>
                    <label class="col-xs-9">
                        <input type="hidden" name="user" value="{{agent.id}}">
                        <input type="hidden" name="tab" value="tab-ip">
                        <input type="text" name="ip" class="form-control" placeholder="{{translate['placeholder_whitelist_ip']}}">
                    </label>
                </div>
            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{translate['button_close']}}</button>
                    <button type="submit" class="btn btn-primary" id="submit">{{translate['button_add']}}</button>
                </div>
            </form>
        </div>
    </div>
</div>