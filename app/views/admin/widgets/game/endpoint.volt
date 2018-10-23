<div class="panel-body">
    <form class="form-horizontal col-xs-12">
        <div class="list-inline text-right">
            <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#form-endpoint">
                Add New
            </button>
        </div>
        <ul class="list-inline header-list text-center">
          <li class="col-xs-1 list-group-item">No</li>
          <li class="col-xs-3 list-group-item">Type</li>
          <li class="col-xs-3 list-group-item">Endpoint</li>
          <li class="col-xs-4 list-group-item">Auth</li>
          <li class="col-xs-1 list-group-item">&nbsp;</li>
        </ul>
        <div style="height:200px; overflow:auto;">
        {% if page is not null %}
            {% set i = 1 %}
            {% for providerGameEndpointData in page %}
                {% if i%2 == 0 %}
                {% set class = "content-even" %}
                {% else %}
                {% set class = "content-odd" %}
                {% endif %}
                <ul class="list-inline {{class}} text-center">
                    <li class="col-sm-1 col-xs-1 list-group-item">{{i}}</li>
                    <li class="col-sm-3 col-xs-3 list-group-item"><span id="endpoint_type_{{providerGameEndpointData.id}}" class="hidden">{{providerGameEndpointData.type}}</span>{{providerGameEndpointData.type|endPointType}}</li>
                    <li class="col-sm-3 col-xs-3 list-group-item"><span id="endpoint_url_{{providerGameEndpointData.id}}">{{providerGameEndpointData.endpoint}}</span></li>
                    <li class="col-sm-4 col-xs-4 list-group-item" title="{{providerGameEndpointData.provider_game_endpoint_auth|endPointAuth}}"><span id="endpoint_auth_{{providerGameEndpointData.id}}" class="hidden">{{providerGameEndpointData.provider_game_endpoint_auth}}</span>{{providerGameEndpointData.provider_game_endpoint_auth|endPointAuth}}</li>
                    <li class="col-sm-1 col-xs-1 list-group-item">
                        <span class="endpoint-edit fa fa-edit text-primary" data-id="{{providerGameEndpointData.id}}" data-toggle="modal" data-target="#form-edit-endpoint"></span>
                    </li>
                </ul>
                {% set i = i +1 %}
            {% endfor %}
        {% else %}
            <h4 class="text-center">-No data-</h4>
        {% endif %}
        </div>
    </form>
</div>


    <!--<span id="end_type-1" class="hidden">2</span>
    <span id="end_type_method-1" class="hidden">1</span>-->

{{ widget('EndpointFormAddWidget', ["id": game.id]) }}
{{ widget('EndpointFormEditWidget', ["id": game.id]) }}