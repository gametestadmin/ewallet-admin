<div class="row">
    <label class="col-xs-12">
        {{module|capitalize}}
        {% if controller != "index" %}
        >
        {{controller|capitalize}}
        {% endif %}
        {% if action != "index" %}
        >
        {{action|capitalize}}
        {% endif %}
    </label>
</div>