{% set dirRoot = "" %}
{% if viewInModule is defined and viewInModule == TRUE %}
{% set dirRoot = "../../" %}
{% endif %}

<!DOCTYPE html>
<html lang="en">
    {% include dirRoot~'layouts/elements/head' %}
    <body>
        {% if user is not null %}
            <div class="container-fluid">
                <div class="row">
                    {% include dirRoot~'layouts/elements/leftnav' %}
                    <div id="wrapper" class="col-xs-12">
                        <div id="page-wrapper" class="gray-bg">
                            {% include dirRoot~'layouts/elements/header' %}
                            {% include dirRoot~'layouts/elements/notification' %}
                            {{ widget('MenuWidget', []) }}
                            {{ content() }}
                            {% include dirRoot~'layouts/elements/footer' %}
                        </div>
                    </div>
                </div>
            </div>
        {% else %}
            <div class="row login-page">
                {% include dirRoot~'layouts/elements/notification' %}
                {{ content() }}
            </div>
        {% endif %}

        {% include dirRoot~'layouts/elements/js_footer' %}
    </body>
</html>
