{% if viewInModule is defined and viewInModule == TRUE %}
{% set dirRoot = "../../" %}
{% else %}
{% set dirRoot = "" %}
{% endif %}

{% include dirRoot~'layouts/elements/header' %}
<div class="row">
    <div class="col-xs-12 position-relative">
        <div class="row">
        {% block content %}{% endblock %}
        </div>
    </div>
</div>

{% block action_js %}
{% endblock %}