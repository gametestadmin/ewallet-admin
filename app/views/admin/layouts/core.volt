<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="dns-prefetch" href="http://www.google-analytics.com">
        <link rel="dns-prefetch" href="http://www.googletagmanager.com">
        {% block title %}{{get_title()}}{% endblock %}
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport' />
        <meta name="application-name" content="xxx" />
        <meta name="description" content="xxx" />
        <meta name="keywords" content="xxx" />
        <meta name="author" content="xxx" />
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12">
                    {{ content() }}
                </div>
            </div>
        </div>
    </body>
</html>
