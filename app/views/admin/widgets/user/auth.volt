<form class="form-horizontal col-xs-12">
    <ul class="list-inline header-list text-center">
      <li class="col-xs-1 list-group-item">No</li>
      <li class="col-xs-6 list-group-item">App Id</li>
      <li class="col-xs-5 list-group-item">App Secret</li>
    </ul>
    <div style="height:300px; overflow:auto;">
    {% if user_auth is not null %}
        {% set i = 1 %}
        {% for userAuthData in user_auth %}
            {% if i%2 == 0 %}
            {% set class = "content-even" %}
            {% else %}
            {% set class = "content-odd" %}
            {% endif %}
            <ul class="list-inline {{class}} text-center">
                <li class="col-xs-1 list-group-item">{{i}}</li>
                <li class="col-xs-6 list-group-item">{{userAuthData.app_id}}</li>
                <li class="col-xs-5 list-group-item">{{userAuthData.app_secret}}</li>
            </ul>
            {% set i = i +1 %}
        {% endfor %}
    {% else %}
        <h4 class="text-center">-No data-</h4>
    {% endif %}
    </div>
</form>