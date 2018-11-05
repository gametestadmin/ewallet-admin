<div class="row">
    <nav class="navbar navbar-static-top header-menu" role="navigation">
        <div class="navbar-header margin-10-20">
            <a class="navbar-minimalize">
                <b class="fa fa-bars header-menu-minimalize"></b>
            </a>
            <span class="header-menu-information">
                <b class="header-info-user"> {{ real_user.username|upper }} </b>
                <b class="header-info-code">
                {% if real_user.id == user.id %}
                    {{ translate[real_user.type|agentType]|upper }}
                {% else %}
                    {{ translate['subaccount']|upper }}
                {% endif %}
                </b>
                <span class="header-info-cur cursor-pointer" data-toggle="modal" data-target="#header-currency-list"> <b> {{translate['currency']|upper }} </b> </span>
            </span>
        </div>

        <div class="text-right margin-10-20">
            <select class="header-language-list" name="language" onchange="location = this.value;">
                {% for langkey , language_code in language_list%}
                    <option value="/language?code={{language_code}}" {% if language_code == language %} selected {% endif %}> {{translate['language_'~language_code]|upper}} </option>
                {% endfor %}
            </select>
            <a href="{{url('/logout')}}" class="header-button-logout" >
                {{ translate['logout']|upper }}
            </a>
        </div>
    </nav>
</div>

<!-- Modal -->
<div class="modal fade" id="header-currency-list" tabindex="-1" role="dialog" aria-labelledby="currency-list" aria-hidden="true">
    <div class="modal-dialog header-modal-currency" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="col-xs-6">
                    <h4 class="modal-title" id="currency-list"> {{translate['currency_list']|upper }} </h4>
                </label>
                <label class="col-xs-6">
                    <span aria-hidden="true">
                        <button type="button" class="close uppercase" data-dismiss="modal" aria-label="Close">
                            &times;
                        </button>
                    </span>
                </label>
            </div>
            <div class="modal-body min-height-200 max-height-400">
                <ul class="list-inline header-list text-center">
                    <li class="col-xs-2 list-group-item list">{{ translate['symbol']|upper }}</li>
                    <li class="col-xs-4 list-group-item list">{{ translate['code']|upper }}</li>
                    <li class="col-xs-4 list-group-item list">{{ translate['currency_name']|upper }}</li>
                    <li class="col-xs-2 list-group-item list">{{ translate['default']|upper }}</li>
                </ul>
                {% set i = 1 %}
                {% for currencylist in user_currency_list %}
                    {% if i%2 == 0 %}
                        {% set class = "content-even" %}
                    {% else %}
                        {% set class = "content-odd" %}
                    {% endif %}
                    <ul class="list-inline {{class}} text-center">
                        <li class="col-xs-2 list-group-item">{{ currencylist.currency.symbol|upper }}</li>
                        <li class="col-xs-4 list-group-item">{{ currencylist.currency.code|upper }}</li>
                        <li class="col-xs-4 list-group-item">{{ currencylist.currency.name|upper }}</li>
                        <li class="col-xs-2 list-group-item">
                            {% if currencylist.default == 1 %}
                                <i class="fa fa-check text-success" data-toggle="tooltip" data-placement="right" title="{{ translate['default']|upper }}"></i>
                            {% else %}
                                <a href="{{url('/user/currency/edit/'~currencylist.id)}}">
                                    <i class="fa fa-times text-danger" data-toggle="tooltip" data-placement="right" title="{{ translate['not_default']|upper }}"></i>
                                </a>
                            {%endif%}
                        </li>
                    </ul>
                    {% set i = i +1 %}
                {% endfor %}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>