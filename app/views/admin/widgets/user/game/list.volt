<form class="form-horizontal col-xs-12">
    <div class="list-inline">
        <div class="text-right">
        {% if realParent == 1 or realParent == 3 %}
            <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#form-agent-add-game">
                Add New
            </button>
        {% endif %}
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
    {% if user_games is not null %}
        {% set i = 1 %}
        {% for userGame in user_games %}
            {% if i%2 == 0 %}
            {% set class = "content-even" %}
            {% else %}
            {% set class = "content-odd" %}
            {% endif %}
            <ul class="list-inline {{class}} text-center">
                <li class="col-xs-1 list-group-item">{{i}}</li>
                <li class="col-xs-3 list-group-item">{{userGame.game.name}}</li>
                <li class="col-xs-2 list-group-item">{{userGame.game_type|gameType}}</li>
                <li class="col-xs-2 list-group-item"><strong class="text-{{userGame.parent_status|gameStatus|lower}}">{{userGame.parent_status|gameStatus}}</strong></li>
                <li class="col-xs-2 list-group-item"><strong class="text-{{userGame.status|gameStatus|lower}}">{{userGame.status|gameStatus}}</strong></li>
                <li class="col-xs-2 list-group-item">
                    <a href="{{url(module~'/game/detail/'~userGame.id)}}">
                        <span class="fa fa-search text-danger"></span>
                    </a>
                </li>
            </ul>
            {% set i = i +1 %}
        {% endfor %}
    {% else %}
        <h4 class="text-center">-No data-</h4>
    {% endif %}
</form>

{{ widget('UserGameFormAddWidget', ["loginId" : user.id, "agentId" : agent.id]) }}