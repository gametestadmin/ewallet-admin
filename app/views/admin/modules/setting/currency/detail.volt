{% block content %}
<div id="wrapper">
    <form class="form-horizontal" action="#" method="post">
        <div class="form-group">
            <label>Currency Code</label>
            <label>
                <input type="text" value="{{currency.code}}" readonly>
            </label>
        </div>
        <div class="form-group">
            <label>Currency Name</label>
            <label>
                <input type="text" name="name" value="{{currency.name}}" readonly>
            </label>
        </div>
        <div class="form-group">
            <label>Currency Symbol</label>
            <label>
                <input type="text" name="symbol" value="{{currency.symbol}}"readonly>
            </label>
        </div>
        <div class="form-group">
            <div class="input-group">
                <label>Status</label>
                {% if currency.status == 1 %}
                    {% set status = 'Active' %}
                {% else %}
                    {% set status = 'InActive' %}
                {% endif %}
                <input type="text" class="" readonly value="{{status}}">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                    <div class="dropdown-menu">
                        <a href="{{'/'~module~'/'~controller~'/status/'~currency.code|lowercase}}">
                        {% if currency.status == 1 %}
                            InActive
                        {% else %}
                            Active
                        {% endif %}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>
                <a href="{{'/'~module~'/'~controller}}">Back</a>
            </label>
            <label>
                <a href="{{'/'~module~'/'~controller~'/edit/'~currency.code|lowercase}}">Edit</a>
            </label>
        </div>
    </form>
</div>
{% endblock %}

{% block action_js %}

{% endblock %}