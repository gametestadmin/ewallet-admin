{% block content %}
<div id="wrapper">
    <form class="form-horizontal" action="#" method="post">
        <div class="form-group">
            <label>
                <input type="text" name="category_name" placeholder="Name" value="{{category.name}}">
            </label>
        </div>
        <div class="form-group">
            <label>
                <input type="radio" name="status" value="0" {%if category.status == 0%}checked{%endif%}>OFF
            </label>
            <label>
                <input type="radio" name="status" value="1" {%if category.status == 1%}checked{%endif%}>ON
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