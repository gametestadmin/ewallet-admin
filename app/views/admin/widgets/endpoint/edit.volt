<!-- Modal -->
<div class="modal fade" id="form-edit-endpoint" tabindex="-1" role="dialog" aria-labelledby="form-edit-endpoint-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal" action="{{url('game/endpoint/edit')}}" method="post" id="form">
            <div class="modal-header">
                <label class="col-xs-6">
                    <h3 class="modal-title" id="form-edit-endpoint-label">API Endpoint <span class="endpoint_type_text"></span> Edit</h3>
                </label>
                <label class="col-xs-6">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </label>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="col-xs-9">
                        <input type="hidden" name="endpoint_id" id="endpoint_id">
                        <input type="hidden" name="game" value="{{game.id}}">
                        <input type="hidden" name="tab" value="tab-endpoint">
                    </label>
                </div>
                <div class="form-group">
                    <label class="col-xs-3 control-label">Type</label>
                    <label class="col-xs-9">
                        <select name="type" id="endpoint_type" class="form-control" disabled>
                            <option value="">-Choose One-</option>
                            {% for providerGameEndpointType, providerGameEndpointTypeValue in providerGameEndpointTypes %}
                                <option disabled value="{{providerGameEndpointType}}" class="{{providerGameEndpointType}}">{{providerGameEndpointTypeValue}}</option>
                            {% endfor %}
                        </select>
                    </label>
                </div>
                <div class="form-group">
                    <label class="col-xs-3 control-label">Endpoint</label>
                    <label class="col-xs-3">
                        <select name="endpoint" id="endpoint_protocol" class="form-control">
                            <option value="">-Choose One-</option>
                            {% for value, httpListData in httpList %}
                                <option value="{{value}}">{{value}}</option>
                            {% endfor %}
                        </select>
                    </label>
                    <label class="col-xs-6">
                        <input type="text" name="url" id="endpoint_url" class="form-control">
                    </label>
                </div>
                <div class="form-group">
                    <label class="col-xs-3 control-label">Auth</label>
                    <label class="col-xs-9">
                        <select name="auth" id="endpoint_auth" class="form-control">
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
                    <button type="submit" class="btn btn-primary" id="submit">Edit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>

</script>