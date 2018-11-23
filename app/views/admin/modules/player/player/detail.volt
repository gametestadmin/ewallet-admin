{% block content %}
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-xs-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title row">
                        <h5> {{ user_player.username }} </h5>
                    </div>
                    <div class="ibox-content row">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs">
                                <li id="head-tab-general" class="tab active"><a data-toggle="tab" href="#tab-general"> {{ translate['general']|upper }} </a></li>
                                <li id="head-tab-game" class="tab"><a href="{{'/'~module~'/game/'~action~'/'~id}}"> {{ translate['game']|upper }} </a></li>
                                <li id="head-tab-transaction" class="tab"><a href="{{'/'~module~'/transaction/'~action~'/'~id}}"> {{ translate['transaction']|upper }} </a></li>
                                <li id="head-tab-statement" class="tab"><a href="{{'/'~module~'/statement/'~action~'/'~id}}"> {{ translate['statement']|upper }} </a></li>
                            </ul>

                            <div class="tab-content padding-0">
                                <div id="tab-general" class="tab-pane active">
                                    <div class="panel-body">
                                        <form class="form-horizontal col-xs-12" action="#" method="post">
                                            <div class="form-group">
                                                <label class="col-xs-3 control-label"> {{ translate['username']|upper }} </label>
                                                <label class="col-xs-9">
                                                    <input type="text" placeholder="Type" class="form-control uppercase" class="form-control" value="{{user_player.username}}" readonly>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-xs-3 control-label"> {{ translate['created_date']|upper }} </label>
                                                <label class="col-xs-9">
                                                    <input type="text" placeholder="Type" class="form-control uppercase" class="form-control" value="{{user_player.created_date}}" readonly>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-xs-3 control-label"> {{ translate['last_login']|upper }} </label>
                                                <label class="col-xs-9">
                                                    <input type="text" placeholder="Type" class="form-control uppercase" class="form-control" value="{{user_player.last_updated_date}}" readonly>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-xs-3 control-label"> {{ translate['currency']|upper }} </label>
                                                <label class="col-xs-9">
                                                    <input type="text" placeholder="Type" class="form-control uppercase" class="form-control" value="{{user_player.currency}}" readonly>
                                                </label>
                                            </div>
                                            <div class="form-group"><div class="hr-line-dashed"></div></div>
                                            <div class="form-group pull-right">
                                                <div class="col-xs-12">
                                                </div>
                                            </div>
                                        </form>
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