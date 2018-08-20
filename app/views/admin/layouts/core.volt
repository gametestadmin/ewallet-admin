{% set dirRoot = "" %}
{% if viewInModule is defined and viewInModule == TRUE %}
{% set dirRoot = "../../" %}
{% endif %}

<!DOCTYPE html>
<html lang="en">
    {% include dirRoot~'layouts/elements/head' %}
    <body>
    template = {{template}} / environment = {{environment}}
        {% include dirRoot~'layouts/elements/header' %}
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    {% include dirRoot~'layouts/elements/notification' %}
                        {{ content() }}
                    </div>
                </div>
            </div>
        {% include dirRoot~'layouts/elements/footer' %}
        {% include dirRoot~'layouts/elements/js_footer' %}
    </body>
</html>
