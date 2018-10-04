<div class="panel-body">
    <form class="form-horizontal col-xs-12">
        <div class="list-inline text-right">
            <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#form-auth">
                Add New
            </button>
        </div>
        <ul class="list-inline header-list text-center">
          <li class="col-xs-1 list-group-item">No</li>
          <li class="col-xs-5 list-group-item">App Id</li>
          <li class="col-xs-5 list-group-item">App Secret</li>
          <li class="col-xs-1 list-group-item">&nbsp;</li>
        </ul>
        <div style="height:200px; overflow:auto;">
        {% if page is not null %}
            {% set i = 1 %}
            {% for providerGameEndpointAuthData in page %}
                {% if i%2 == 0 %}
                {% set class = "content-even" %}
                {% else %}
                {% set class = "content-odd" %}
                {% endif %}
                <ul class="list-inline {{class}} text-center">
                    <li class="col-xs-1 list-group-item">{{i}}</li>
                    <li class="col-xs-5 list-group-item"><span id="app_id_{{providerGameEndpointAuthData.id}}">{{providerGameEndpointAuthData.app_id}}</span></li>
                    <li class="col-xs-5 list-group-item"><span id="app_secret_{{providerGameEndpointAuthData.id}}">{{providerGameEndpointAuthData.app_secret}}</span></li>
                    <li class="col-xs-1 list-group-item">
                        <span class="auth-edit fa fa-edit text-primary" data-id="{{providerGameEndpointAuthData.id}}" data-toggle="modal" data-target="#form-edit-auth"></span>
                    </li>
                </ul>
                {% set i = i +1 %}
            {% endfor %}
        {% else %}
            <h4>-No data-</h4>
        {% endif %}
        </div>
    </form>
</div>

{{ widget('AuthFormAddWidget', ["id": game.id]) }}
{{ widget('AuthFormEditWidget', ["id": game.id]) }}
