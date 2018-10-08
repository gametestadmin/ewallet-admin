<form class="form-horizontal col-xs-12">
    <div class="list-inline text-right">
        {% if loginId == agentParent %}
        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#form-user-currency">
            Add New
        </button>
        {% endif %}
    </div>
    <ul class="list-inline header-list text-center">
      <li class="col-sm-1 col-xs-1 list-group-item">Symbol</li>
      <li class="col-sm-3 col-xs-3 list-group-item">Code</li>
      <li class="col-sm-3 col-xs-3 list-group-item">Name</li>
      <li class="col-sm-3 col-xs-3 list-group-item">Status</li>
      <li class="col-sm-2 col-xs-2 list-group-item">&nbsp;</li>
    </ul>
    {% if user_currency is not null %}
        {% set i = 1 %}
        {% for userCurrencyData in user_currency %}
            {% if i%2 == 0 %}
            {% set class = "content-even" %}
            {% else %}
            {% set class = "content-odd" %}
            {% endif %}
            <ul class="list-inline {{class}} text-center">
                <li class="col-sm-1 col-xs-1 list-group-item">{{userCurrencyData.currency.symbol}}</li>
                <li class="col-sm-3 col-xs-3 list-group-item">{{userCurrencyData.currency.code}}</li>
                <li class="col-sm-3 col-xs-3 list-group-item">{{userCurrencyData.currency.name}}</li>
                <li class="col-sm-3 col-xs-3 list-group-item">status</li>
                <li class="col-sm-2 col-xs-2 list-group-item">
                    {% if userCurrencyData.default == 1 %}
                        Default
                    {% else %}
                        <a href="{{'/agent/currency/edit/'~agent.id~'?default='~userCurrencyData.id~'&tab=tab-currency'}}">Make Default</a>
                    {%endif%}
                </li>
            </ul>
            {% set i = i +1 %}
        {% endfor %}
    {% else %}
        <h4 class="text-center">-No data-</h4>
    {% endif %}
</form>

{{ widget('UserCurrencyFormAddWidget', ["loginId" : user.id, "agentId" : agent.id]) }}
