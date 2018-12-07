<form class="form-horizontal col-xs-12">
    <div class="list-inline">
        <div class="text-right">
        {% if realParent == 1 or realParent == 3 %}
            <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#form-agent-add-subgame">
                {{translate['button_add']}}
            </button>
        {% endif %}
        </div>
    </div>
    <ul class="list-inline header-list text-center">
      <li class="col-xs-1 list-group-item list">{{translate['head_list_number']}}</li>
      <li class="col-xs-3 list-group-item list">{{translate['head_list_game']}}</li>
      <li class="col-xs-3 list-group-item list">[{{agentGame.game.name}}] {{translate['head_list_status']}}</li>
      <li class="col-xs-3 list-group-item list">[{{translate['text_subgame']}}] {{translate['head_list_status']}}</li>
      <li class="col-xs-2 list-group-item list">{{translate['head_list_action']}}</li>
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
                <li class="col-xs-3 list-group-item"><strong class="text-{{agentSubGame.parent_status|gameStatus|lower}}">{{translate[agentSubGame.parent_status|gameStatus|lower]}}</strong></li>
                <li class="col-xs-3 list-group-item"><strong class="text-{{agentSubGame.status|gameStatus|lower}}">{{translate[agentSubGame.status|gameStatus|lower]}}</strong></li>
                <li class="col-xs-2 list-group-item">
                    <a href="{{url(module~'/subgame/detail/'~agentSubGame.id)}}">
                        <i class="fa fa-search text-danger" data-toggle="tooltip" data-placement="right" title="{{translate['text_detail']}}"></i>
                    </a>
                </li>
            </ul>
            {% set i = i +1 %}
        {% endif %}
        {% endfor %}
    {% else %}
        <h4 class="text-center">{{translate['text_no_data']}}</h4>
    {% endif %}
</form>

{{ widget('UserSubGameFormAddWidget', ["loginId" : user.id, "agentId" : agentGame.user.id, "gameId" : agentGame.game.id]) }}