<div class="panel-body">
    <form class="form-horizontal col-xs-12">
        <div class="list-inline text-right">
            <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#form-currency">
                Add New
            </button>
        </div>
        <ul class="list-inline header-list text-center">
          <li class="col-sm-1 col-xs-1 list-group-item">ID</li>
          <li class="col-sm-3 col-xs-3 list-group-item">Symbol</li>
          <li class="col-sm-3 col-xs-3 list-group-item">Code</li>
          <li class="col-sm-3 col-xs-3 list-group-item">Name</li>
          <li class="col-sm-2 col-xs-2 list-group-item">&nbsp;</li>
        </ul>
        {% if page is not null %}
            {% set i = 1 %}
            {% for gameCurrencyData in page %}
                {% if i%2 == 0 %}
                {% set class = "content-even" %}
                {% else %}
                {% set class = "content-odd" %}
                {% endif %}
                <ul class="list-inline {{class}} text-center">
                    <li class="col-sm-1 col-xs-1 list-group-item">{{i}}</li>
                    <li class="col-sm-3 col-xs-3 list-group-item">{{gameCurrencyData.currency.symbol}}</li>
                    <li class="col-sm-3 col-xs-3 list-group-item">{{gameCurrencyData.currency.code}}</li>
                    <li class="col-sm-3 col-xs-3 list-group-item">{{gameCurrencyData.currency.name}}</li>
                    <li class="col-sm-2 col-xs-2 list-group-item">
                        {% if gameCurrencyData.default == 1 %}
                            Default
                        {% else %}
                            <a href="{{'/game/currency/edit/'~game.id~'?default='~gameCurrencyData.id~'&tab=tab-currency'}}">Make Default</a>
                        {%endif%}
                    </li>
                </ul>
                {% set i = i +1 %}
            {% endfor %}
        {% else %}
            <h4>-No data-</h4>
        {% endif %}
    </form>

    <div class="row text-center">
        <div class="col-xs-12">
            <ul class="pagination">
            {% set page = pagination %}
            {% if page != null %}
            {% for i in 1..page %}
              <li>
                <a href="{{router.getRewriteUri()~'/?pages='~i}}#tab-currency" {% if i == pages %}class="pagination-numb"{% endif %}>{{i}}</a>
              </li>
            {% endfor %}
            {% endif %}
            </ul>
        </div>
    </div>
</div>

{{ widget('CurrencyFormWidget', []) }}
