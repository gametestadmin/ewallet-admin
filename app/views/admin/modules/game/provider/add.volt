{% block content %}
<div id="wrapper">
    <form class="form-horizontal" action="#" method="post">
        <div class="form-group">
            <label>Timezone</label>
            <label>
                <select name="provider_timezone">
                    {% for gmtTime in gmt %}
                        {% set gmtDisplay = gmtTime %}
                        {% if gmtTime == 0%}
                        {% set gmtDisplay = '' %}
                        {% elseif gmtTime > 0%}
                        {% set gmtDisplay = '+'~gmtTime %}
                        {% endif %}
                        <option value="{{gmtTime}}" {% if gmtTime == 0 %}selected{% endif %}>GMT {{gmtDisplay}}</option>
                    {% endfor %}
                </select>
            </label>
        </div>
        <div class="form-group">
            <label>Name</label>
            <label>
                <input type="text" name="provider_name" placeholder="Name">
            </label>
        </div>
        <div class="form-group">
            <label>
                <a href="javascript:history.go(-1)">Back</>
            </label>
            <label>
                <input type="submit" name="submit" value="Add">
            </label>
        </div>
    </form>
</div>
{% endblock %}

{% block action_js %}

{% endblock %}