<!-- Modal -->
<div class="modal fade" id="form-endpoint" tabindex="-1" role="dialog" aria-labelledby="form-endpoint-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal" action="{{url('game/endpoint/add')}}" method="post" id="form">
            <div class="modal-header">
                <label class="col-xs-6">
                    <h3 class="modal-title" id="form-endpoint-label">Add API <span class="endpoint_type_text"></span> Endpoint</h3>
                </label>
                <label class="col-xs-6">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </label>
            </div>
            <div class="modal-body">
                <input type="hidden" name="game" value="{{game.id}}">
                <input type="hidden" name="endpoint_type_value" id="endpoint_type_value">
                <input type="hidden" name="tab" value="tab-endpoint">
                <div class="form-group" id="transfer_type">
                    <label class="col-xs-3 control-label">Type</label>
                    <label class="col-xs-9">
                        <select name="transfer_type" class="form-control">
                            <option value="">-Choose One-</option>
                            {% for transferProviderGameEndpointTypeData, transferProviderGameEndpointTypeValue in transferProviderGameEndpointTypes %}
                                <option value="{{transferProviderGameEndpointTypeData}}">{{transferProviderGameEndpointTypeValue}}</option>
                            {% endfor %}
                        </select>
                    </label>
                </div>
                <div class="form-group" id="seamless_type">
                    <label class="col-xs-3 control-label">Type</label>
                    <label class="col-xs-9">
                        <select name="seamless_type" class="form-control">
                            <option value="">-Choose One-</option>
                            {% for seamlessProviderGameEndpointTypeData, seamlessProviderGameEndpointTypeValue in seamlessProviderGameEndpointTypes %}
                                <option value="{{seamlessProviderGameEndpointTypeData}}">{{seamlessProviderGameEndpointTypeValue}}</option>
                            {% endfor %}
                        </select>
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
                                <option value="{{providerGameEndpointData.id}}">{{providerGameEndpointData.aid~":"~providerGameEndpointData.asc}}</option>
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