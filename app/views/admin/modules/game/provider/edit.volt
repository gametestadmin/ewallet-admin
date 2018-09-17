{% block content %}
<div id="wrapper" class="col-xs-12">
    <form class="form-horizontal" action="#" method="post">
        <div class="form-group col-xs-12">
            <label>Timezone</label>
            <label>
                <select name="provider_timezone">
                    <option value="">-Choose One-</option>
                    {% for gmtTime in gmt %}
                        {% set gmtDisplay = gmtTime %}
                        {% if gmtTime == 0%}
                        {% set gmtDisplay = '' %}
                        {% elseif gmtTime > 0%}
                        {% set gmtDisplay = '+'~gmtTime %}
                        {% endif %}
                        <option value="{{gmtTime}}"{%if provider.timezone == gmtTime%}selected{%endif%}>GMT {{gmtDisplay}}</option>
                    {% endfor %}
                </select>
            </label>
        </div>
        <div class="form-group col-xs-12">
            <label>Name</label>
            <label>
                <input type="text" name="provider_name" placeholder="Name" value="{{provider.name}}">
            </label>
        </div>
        <div class="form-group col-xs-12">
            <label>
                <a href="javascript:history.go(-1)">Back</a>
            </label>
            <label>
                <input type="submit" name="submit" value="Edit">
            </label>
        </div>
    </form>
</div>
{% endblock %}

{% block action_js %}

{% endblock %}