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
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    {% include dirRoot~'layouts/elements/leftnav' %}
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                    <div class="margin-bottom-20">
                        {% include dirRoot~'layouts/elements/header' %}
                    </div>
                    {% include dirRoot~'layouts/elements/notification' %}
                    <div>
                        {{ content() }}
                    </div>
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
