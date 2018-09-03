{% block content %}
<div id="wrapper">
    <form class="form-horizontal" action="#" method="post">
        <div class="form-group">
            <label>Timezone</label>
            <label>
                {% set gmtDisplay = provider.timezone %}
                {% if provider.timezone == 0%}
                {% set gmtDisplay = '' %}
                {% elseif provider.timezone > 0%}
                {% set gmtDisplay = '+'~provider.timezone %}
                {% endif %}
                <input type="text" placeholder="Code" value="GMT {{gmtDisplay}}" readonly>
            </label>
        </div>
        <div class="form-group">
            <label>Name</label>
            <label>
                <input type="text" placeholder="Name" value="{{provider.name}}" readonly>
            </label>
        </div>
        <div class="form-group">
            <div class="input-group">
                <label>Status</label>
                <select class="status">
                    {% for key, value in status %}
                        <option value="{{provider.id~"|"~value}}" {% if provider.status == value %}selected{% endif %}>{{key}}</option>
                    {% endfor %}
                </select>
            </div>
        </div>
        <div class="form-group">
            <label>
                <a href="javascript:history.go(-1)">Back</>
            </label>
            <label>
                <a href="{{'/'~module~'/'~controller~'/edit/'~provider.id}}">Edit</>
            </label>
        </div>
    </form>
</div>
{% endblock %}

{% block action_js %}
    <script>
        jQuery(function () {
            jQuery(".status").change(function () {
                location.href = '/game/provider/status/'+jQuery(this).val();
            })
        })
    </script>
{% endblock %}