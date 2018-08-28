{% block content %}
<div id="wrapper">
    <form class="form-horizontal" action="#" method="post">
        <div class="form-group">
            <label>
                <select name="provider">
                <option value="">-Choose One-</option>
                {% for provider in providerGame %}
                    <option value="{{provider.id}}">{{provider.name}}</option>
                {% endfor %}
                </select>
            </label>
        </div>
        <div class="form-group">
            <label>
                <select name="category">
                <option value="">-Choose One-</option>
                {% for category in categoryGame %}
                    <option value="{{category.id}}">{{category.name}}</option>
                {% endfor %}
                </select>
            </label>
        </div>
        <div class="form-group">
            <label>
                <input type="text" name="main_name" placeholder="Name">
            </label>
        </div>
        <div class="form-group">
            <label>
                <input type="radio" name="status" value="0" checked>OFF
            </label>
            <label>
                <input type="radio" name="status" value="1">ON
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