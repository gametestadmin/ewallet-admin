{% if playerside is not null %}
    <form class="form-horizontal col-xs-12">
        <ul class="list-inline header-list text-center">
          <li class="col-xs-2 list-group-item"> {{ translate['no']|upper }} </li>
          <li class="col-xs-5 list-group-item"> {{ translate['game']|upper }} </li>
          <li class="col-xs-5 list-group-item"> {{ translate['access_time']|upper }} </li>
        </ul>
        <div style="height:300px; overflow:auto;">
            {% set i = 1 %}
            {% for key, game_access in game_access_log %}
                {% set class = "content-odd" %}
                {% if i%2 == 0 %}
                    {% set class = "content-even" %}
                {% endif %}
                <ul class="list-inline {{class}} text-center">
                    <li class="col-xs-2 list-group-item"> {{i}} </li>
                    <li class="col-xs-5 list-group-item"> {{ game_list[game_access['game']] }} </li>
                    <li class="col-xs-5 list-group-item"> {{ game_access['access_time'] }} </li>
                </ul>
                {% set i = i +1 %}
            {% endfor %}
        </div>
    </form>
{% else %}
    <form class="form-horizontal col-xs-12">
        <ul class="list-inline header-list text-center">
          <li class="col-xs-2 list-group-item"> {{ translate['no']|upper }} </li>
          <li class="col-xs-3 list-group-item"> {{ translate['username']|upper }} </li>
          <li class="col-xs-3 list-group-item"> {{ translate['game']|upper }} </li>
          <li class="col-xs-4 list-group-item"> {{ translate['access_time']|upper }} </li>
        </ul>
        <div style="height:350px; overflow:auto;">
            {% set i = 1 %}
            {% for key, game_access in game_access_log %}
                {% set class = "content-odd" %}
                {% if i%2 == 0 %}
                    {% set class = "content-even" %}
                {% endif %}
                <ul class="list-inline {{class}} text-center">
                    <li class="col-xs-2 list-group-item"> {{i}} </li>
                    <li class="col-xs-3 list-group-item"> {{ user_player[game_access['user_player']] }} </li>
                    <li class="col-xs-3 list-group-item"> {{ game_list[game_access['game']] }} </li>
                    <li class="col-xs-4 list-group-item"> {{ game_access['access_time'] }} </li>
                </ul>
                {% set i = i +1 %}
            {% endfor %}
        </div>
    </form>
{% endif %}