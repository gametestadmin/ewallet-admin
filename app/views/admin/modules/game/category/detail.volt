{% block content %}
<div id="wrapper">
    <form class="form-horizontal" action="#" method="post">
        <div class="form-group">
            <label>Category Name</label>
            <label>
                <input type="text" placeholder="Name" value="{{category.name}}" readonly>
            </label>
        </div>
        <div class="form-group">
            <label>Status</label>
            <select class="status">
                {% for key, value in status %}
                    <option value="{{category.id~"|"~value}}" {% if category.status == value %}selected{% endif %}>{{key}}</option>
                {% endfor %}
            </select>
        </div>
        <div class="form-group">
            <label>
                <a href="javascript:history.go(-1)">Back</>
            </label>
            <label>
                <a href="{{'/'~module~'/'~controller~'/edit/'~category.code|lowercase}}">Edit</>
            </label>
        </div>
    </form>
</div>
{% endblock %}

{% block action_js %}

{% endblock %}