<!-- Modal -->
<div class="modal fade" id="form-endpoint" tabindex="-1" role="dialog" aria-labelledby="form-endpoint-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal" action="{{url('game/endpoint/add')}}" method="post" id="form">
            <div class="modal-header">
                <label class="col-xs-6">
                    <h3 class="modal-title" id="form-endpoint-label">Add API Endpoint</h3>
                </label>
                <label class="col-xs-6">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </label>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="col-xs-3 control-label">Type</label>
                    <label class="col-xs-9">
                        <input type="hidden" name="game" value="{{game.id}}">
                        <select name="type" class="form-control">
                            <option value="">-Choose One-</option>
                            {% for providerGameEndpointTypeValue, providerGameEndpointTypeData in providerGameEndpointTypes %}
                                <option value="{{providerGameEndpointTypeValue}}">{{providerGameEndpointTypeData}}</option>
                            {% endfor %}
                        </select>
                        <input type="hidden" name="tab" value="tab-endpoint">
                    </label>
                </div>
                <div class="form-group">
                    <label class="col-xs-3 control-label">Endpoint</label>
                    <label class="col-xs-3">
                        <select name="endpoint" class="form-control">
                            {% for value, httpListData in httpList %}
                                <option value="{{value}}">{{value}}</option>
                            {% endfor %}
                        </select>
                    </label>
                    <label class="col-xs-6">
                        <input type="text" name="url" class="form-control">
                    </label>
                </div>
                <div class="form-group">
                    <label class="col-xs-3 control-label">Auth</label>
                    <label class="col-xs-9">
                        <select name="auth" class="form-control">
                            <option value="0">No Auth</option>
                            {% for providerGameEndpointData in providerGameEndpoint %}
                                <option value="{{providerGameEndpointData.id}}">{{providerGameEndpointData.app_id~":"~providerGameEndpointData.app_secret}}</option>
                            {% endfor %}
                        </select>
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