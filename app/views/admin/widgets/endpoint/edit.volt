<!-- Modal -->
<div class="modal fade" id="form-edit-endpoint" tabindex="-1" role="dialog" aria-labelledby="form-edit-endpoint-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal" action="{{url('game/endpoint/edit')}}" method="post" id="form">
            <div class="modal-header">
                <label class="col-xs-6">
                    <h3 class="modal-title" id="form-edit-endpoint-label">API Endpoint Edit</h3>
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
                    </label>
                </div>
                <div class="form-group">
                    <label class="col-xs-3 control-label">Type</label>
                    <label class="col-xs-9">
                        <input type="hidden" name="game" value="{{game.id}}">
                        <select name="type" id="endpoint_type" class="form-control">
                            <option value="">-Choose One-</option>
                            {% for value, providerGameEndpointTypeData in providerGameEndpointType %}
                                <option value="{{providerGameEndpointTypeData}}">{{value}}</option>
                            {% endfor %}
                        </select>
                        <input type="hidden" name="tab" value="tab-endpoint">
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
                                <option value="{{providerGameEndpointData.id}}">{{providerGameEndpointData.app_id~":"~providerGameEndpointData.app_secret}}</option>
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
$(document).on("click", ".endpoint-edit", function () {
    var endPointId = $(this).data('id');
    var type = $("#endpoint_type_"+endPointId).html();
    var auth = $("#endpoint_auth_"+endPointId).html();
    var url = $("#endpoint_url_"+endPointId).html();
    var dataSplit;
    dataSplit = url.split("//");
    var protocol = dataSplit[0]+"//";

    $(".modal-body #endpoint_id").val(endPointId);
    $(".modal-body #endpoint_type").val(type);
    $(".modal-body #endpoint_auth").val(auth);
    $(".modal-body #endpoint_protocol").val(protocol);
    $(".modal-body #endpoint_url").val(dataSplit[1]);

});
</script>