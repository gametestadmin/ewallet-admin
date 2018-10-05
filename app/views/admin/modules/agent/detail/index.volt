{% block content %}
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-xs-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title row">
                    <h5>{{controller|capitalize}} {{module|capitalize}}</h5>
                </div>
                <div class="ibox-content row">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs">
                            <li id="head-tab-general" class="tab"><a data-toggle="tab" href="#tab-general">General</a></li>
                            <li id="head-tab-currency" class="tab"><a data-toggle="tab" href="#tab-currency">Currency</a></li>
                            <li id="head-tab-game" class="tab"><a data-toggle="tab" href="#tab-game">Game</a></li>
                        </ul>
                        <div class="tab-content padding-0">
                            <div id="tab-general" class="tab-pane">
                                <div class="panel-body">
                                    1
                                </div>
                            </div>
                            <div id="tab-currency" class="tab-pane">
                                <div class="panel-body">
                                    2
                                </div>
                            </div>
                            <div id="tab-game" class="tab-pane">
                                <div class="panel-body">
                                    3
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{% endblock %}

{% block action_js %}
    <script>
        var url = window.location.href;
        var activeTab = url.substring(url.indexOf("#") + 1);

        if(url.includes("#") == true){
            $(".tab").removeClass("active");
            $("#head-" + activeTab).addClass("active");

            $(".tab-pane").removeClass("active");
            $("#" + activeTab).addClass("active");
        }else{
            $("#head-tab-general").addClass("active");
            $("#tab-general").addClass("active");
            // temporary
            {% set gameCurrencyData = 1 %}
            {% set providerEndPointData = 1 %}
            {% if gameCurrencyData != 0 and providerEndPointData != 0 %}
                $("#head-tab-currency").removeClass("active");
                $("#tab-currency").removeClass("active");

                $("#head-tab-game").removeClass("active");
                $("#tab-game").removeClass("active");
            {% else %}
                $("#head-tab-general").removeClass("active");
                $("#tab-general").removeClass("active");

                {% if gameCurrencyData == 0 %}
                    $("#head-tab-currency").addClass("active");
                    $("#tab-currency").addClass("active");
                {% elseif providerEndPointData == 0 %}
                    $("#head-tab-game").addClass("active");
                    $("#tab-game").addClass("active");
                {% endif %}
            {% endif %}
        }
    </script>
{% endblock %}