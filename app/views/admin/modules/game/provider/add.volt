{% block content %}
<div id="wrapper">
    <form class="form-horizontal" action="#" method="post">
        <div class="form-group">
            <label>
                <input type="text" name="provider_timezone" placeholder="Timezone">
            </label>
        </div>
        <div class="form-group">
            <label>
                <input type="text" name="provider_name" placeholder="Name">
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