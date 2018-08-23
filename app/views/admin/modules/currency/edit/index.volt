{% extends "../../layouts/one-column.volt" %}

{% block content %}
<div id="wrapper">
    <form class="form-horizontal" action="#" method="post">
        <div class="form-group">
            <label>
                {{currency.code}}
            </label>
        </div>
        <div class="form-group">
            <label>
                <input type="text" name="name" value="{{currency.name}}">
            </label>
        </div>
        <div class="form-group">
            <label>
                <input type="text" name="symbol" value="{{currency.symbol}}">
            </label>
        </div>
        <div class="form-group">
            <label>
                <input type="radio" name="status" value="0" {% if currency.status == 0 %}checked{% endif %}>OFF
            </label>
            <label>
                <input type="radio" name="status" value="1" {% if currency.status == 1 %}checked{% endif %}>ON
            </label>
        </div>
        <div class="form-group">
            <label>
                <input type="submit" name="submit" value="Edit">
            </label>
        </div>
    </form>
</div>
{% endblock %}

{% block action_js %}

{% endblock %}