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

    <!-- Main scripts -->
    <link href="{{assets_url}}thirdparty/css/bootstrap.min.css" rel="stylesheet">
    <script src="{{assets_url}}thirdparty/js/jquery-3.3.1.min.js"></script>
    <script src="{{assets_url}}thirdparty/js/bootstrap.min.js"></script>

    <!-- CSS scripts -->
    {% if environment == 'development' %}
        <link rel="stylesheet/less" type="text/css" href="{{assets_url}}{{template}}/less/style.less" />
        <script>less = { env: '{{environment}}'};</script>
        <script src="{{assets_url}}thirdparty/js/less.min.js"></script>
        <script>less.watch();</script>
    {% else %}
        <link href="{{assets_url}}{{template}}/css/{{environment}}/style.min.css" rel="stylesheet">
    {% endif %}

    <!-- NOTE : Temporary Style -->
    <style>
        #wrapper{
            color:white !important;
        }
    </style>
</head>