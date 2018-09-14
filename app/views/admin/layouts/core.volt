{% set dirRoot = "" %}
{% if viewInModule is defined and viewInModule == TRUE %}
{% set dirRoot = "../../" %}
{% endif %}

<!DOCTYPE html>
<html lang="en">
    {% include dirRoot~'layouts/elements/head' %}
    <body>
        <div class="container-fluid">
            <div class="row">
                {% if user is not null %}
                    {% include dirRoot~'layouts/elements/leftnav' %}
                    <div id="wrapper">
                        <div id="page-wrapper" class="gray-bg">
                            {% include dirRoot~'layouts/elements/header' %}
                            {% include dirRoot~'layouts/elements/notification' %}
                            {{ content() }}
                            {% include dirRoot~'layouts/elements/footer' %}
                        </div>
                    </div>
                {% else %}
                    {% include dirRoot~'layouts/elements/notification' %}
                    {{ content() }}
                {% endif %}



            </div>
        </div>
        {% include dirRoot~'layouts/elements/js_footer' %}
    </body>
</html>
