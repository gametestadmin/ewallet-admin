<div class="panel-body">
    <form class="form-horizontal col-xs-12">
        <div class="list-inline text-right">
            <div class="row">
                <div class="col-xs-4 text-left">
                    <h4>{{translate['endpoint_authentication']}}</h4>
                </div>
                <div class="col-xs-8">
                    <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#form-auth">
                        {{translate['button_add']}}
                    </button>
                </div>
            </div>
        </div>
        <ul class="list-inline header-list text-center">
          <li class="col-xs-1 list-group-item">{{translate['head_list_number']}}</li>
          <li class="col-xs-5 list-group-item">{{translate['head_list_app_id']}}</li>
          <li class="col-xs-5 list-group-item">{{translate['head_list_app_secret']}}</li>
          <li class="col-xs-1 list-group-item">&nbsp;</li>
        </ul>
        <div style="height:200px; overflow:auto;">
        {% if provider_game_endpoint_auth is not null %}
            {% set i = 1 %}
            {% for providerGameEndpointAuthData in provider_game_endpoint_auth %}
                {% if i%2 == 0 %}
                {% set class = "content-even" %}
                {% else %}
                {% set class = "content-odd" %}
                {% endif %}
                <ul class="list-inline {{class}} text-center">
                    <li class="col-xs-1 list-group-item">{{i}}</li>
                    <li class="col-xs-5 list-group-item"><span id="app_id_{{providerGameEndpointAuthData.id}}">{{providerGameEndpointAuthData.aid}}</span></li>
                    <li class="col-xs-5 list-group-item"><span id="app_secret_{{providerGameEndpointAuthData.id}}">{{providerGameEndpointAuthData.asc}}</span></li>
                    <li class="col-xs-1 list-group-item">
                        <span class="auth-edit fa fa-edit text-primary" data-id="{{providerGameEndpointAuthData.id}}" data-toggle="modal" data-target="#form-edit-auth"></span>
                    </li>
                </ul>
                {% set i = i +1 %}
            {% endfor %}
        {% else %}
            <h4 class="text-center">-{{translate['text_no_data']}}-</h4>
        {% endif %}
        </div>
    </form>
</div>

{{ widget('AuthFormAddWidget', ["gameId": game.id]) }}
{{ widget('AuthFormEditWidget', ["gameId": game.id]) }}
