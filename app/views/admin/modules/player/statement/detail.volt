{% block content %}
    <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-xs-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title row">
                            <h5>{{childuser.username}} </h5>
                        </div>
                        <div class="ibox-content row">
                            <div class="tabs-container">
                                <ul class="nav nav-tabs">
                                    <li id="head-tab-general" class="tab"><a href="{{'/'~module~'/player/'~action~'/'~id }}"> {{ translate['general']|upper }} </a></li>
                                    <li id="head-tab-game" class="tab"><a href="{{'/'~module~'/game/'~action~'/'~id}}"> {{ translate['game']|upper }} </a></li>
                                    <li id="head-tab-transaction" class="tab"><a href="{{'/'~module~'/transaction/'~action~'/'~id}}"> {{ translate['transaction']|upper }} </a></li>
                                    <li id="head-tab-statement" class="tab active"><a data-toggle="tab" href="#tab-general"> {{ translate['statement']|upper }} </a></li>
                                </ul>

                                <div class="tab-content padding-0">
                                    <div id="tab-general" class="tab-pane active">
                                        <div class="panel-body">

                                            This is inside statement detail


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
{% endblock %}