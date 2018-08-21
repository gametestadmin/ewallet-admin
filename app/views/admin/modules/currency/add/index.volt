{% extends "../../layouts/one-column.volt" %}

{% block content %}
<div id="wrapper">
    <form class="form-horizontal" action="#" method="post">
        <div class="form-group">
            <label>
                <input type="text" name="code" placeholder="Code">
            </label>
        </div>
        <div class="form-group">
            <label>
                <input type="text" name="name" placeholder="Name">
            </label>
        </div>
        <div class="form-group">
            <label>
                <input type="text" name="symbol" placeholder="Symbol">
            </label>
        </div>
        <div class="form-group">
            <label>
                <input type="submit" name="submit" value="Add">
            </label>
        </div>
    </form>
</div>
{% endblock %}

{% block action_js %}

{% endblock %}