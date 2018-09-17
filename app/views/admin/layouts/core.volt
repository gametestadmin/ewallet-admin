{% set dirRoot = "" %}
{% if viewInModule is defined and viewInModule == TRUE %}
{% set dirRoot = "../../" %}
{% endif %}

<!DOCTYPE html>
<html lang="en">
    {% include dirRoot~'layouts/elements/head' %}
    <body>
        <div class="container-fluid height-100P">
            <div class="row height-100P">
                {% if user is not null %}
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 navigation-colour">
                        {% include dirRoot~'layouts/elements/leftnav' %}
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                        <div class="row header-menu">
                            {% include dirRoot~'layouts/elements/header' %}
                        </div>
                        {% include dirRoot~'layouts/elements/notification' %}
                        {{ content() }}
                        {% include dirRoot~'layouts/elements/footer' %}
                    </div>
                {% else %}
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    {% include dirRoot~'layouts/elements/notification' %}
                        {{ content() }}
                    </div>
                {% endif %}
            </div>
        </div>
        {% include dirRoot~'layouts/elements/js_footer' %}
    </body>
</html>
