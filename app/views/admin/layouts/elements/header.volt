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
                <b class="header-info-cur"> {{translate['currency']|upper }} </b>
            </span>
        </div>

        <div class="text-right margin-10-20">
            <select class="header-language-list" name="language" onchange="location = this.value;">
                {% for langkey , language_code in language_list%}
                    <option value="/language?code={{language_code}}" {% if language_code == language %} selected {% endif %}> {{translate['language_'~language_code]|upper}} </option>
                {% endfor %}
            </select>
            <a href="{{url('/logout')}}" class="header-button-logout" >
                Log out
            </a>
        </div>
    </nav>
</div>