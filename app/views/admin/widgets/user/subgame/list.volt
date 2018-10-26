<form class="form-horizontal col-xs-12">
    <div class="list-inline">
        <div class="text-right">
            <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#form-agent-add-subgame">
                Add New
            </button>
        </div>
    </div>
    <ul class="list-inline header-list text-center">
      <li class="col-xs-1 list-group-item list">No</li>
      <li class="col-xs-3 list-group-item list">Game</li>
      <li class="col-xs-2 list-group-item list">Game Type</li>
      <li class="col-xs-2 list-group-item list">Parent Status</li>
      <li class="col-xs-2 list-group-item list">Status</li>
      <li class="col-xs-2 list-group-item list">Action</li>
    </ul>
    {% if agent_subgames is not null %}
        {% set i = 1 %}
        {% for agentSubGame in agent_subgames %}
        {% if agentSubGame is not null %}
            {% if i%2 == 0 %}
            {% set class = "content-even" %}
            {% else %}
            {% set class = "content-odd" %}
            {% endif %}
            <ul class="list-inline {{class}} text-center">
                <li class="col-xs-1 list-group-item">{{i}}</li>
                <li class="col-xs-3 list-group-item">{{agentSubGame.game.name}}</li>
                <li class="col-xs-2 list-group-item">{{agentSubGame.game_type|gameType}}</li>
                <li class="col-xs-2 list-group-item"><strong class="text-{{agentSubGame.parent_status|gameStatus|lower}}">{{agentSubGame.parent_status|gameStatus}}</strong></li>
                <li class="col-xs-2 list-group-item"><strong class="text-{{agentSubGame.status|gameStatus|lower}}">{{agentSubGame.status|gameStatus}}</strong></li>
                <li class="col-xs-2 list-group-item">
                    <a href="{{url(module~'/game/detail/'~agentSubGame.id)}}">
                        <span class="fa fa-search text-danger"></span>
                    </a>
                </li>
            </ul>
            {% set i = i +1 %}
        {% endif %}
        {% endfor %}
    {% else %}
        <h4 class="text-center">-No data-</h4>
    {% endif %}
</form>

{{ widget('UserSubGameFormAddWidget', ["loginId" : user.id, "agentId" : agentGame.user.id, "gameId" : agentGame.game.id]) }}