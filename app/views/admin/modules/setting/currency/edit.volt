{% block content %}
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-xs-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title row">
                            <h5>[{{currency.name}}] {{translate['title_text_edit']}}</h5>
                        </div>
                        <div class="ibox-content row">
                            <form class="form-horizontal col-xs-12" action="#" method="post">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">{{translate['form_currency_code']}}</label>
                                    <label class="col-xs-9">
                                        <input type="text" class="form-control" value="{{currency.code}}" readonly placeholder="{{translate['placeholder_currency_code']}}">
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">{{translate['form_currency_name']}}</label>
                                    <label class="col-xs-9">
                                        <input type="text" name="name" class="form-control" value="{{currency.name}}" placeholder="{{translate['placeholder_currency_name']}}">
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">{{translate['form_currency_symbol']}}</label>
                                    <label class="col-xs-9">
                                        <input type="text" name="symbol" class="form-control" value="{{currency.symbol}}" placeholder="{{translate['placeholder_currency_symbol']}}">
                                    </label>
                                </div>
                                <div class="form-group"><div class="hr-line-dashed"></div></div>
                                <div class="form-group pull-right">
                                    <div class="col-xs-12">
                                        <label>
                                            <a href="javascript:history.go(-1)" class="btn btn-sm btn-danger">{{translate['button_back']}}</a>
                                        </label>
                                        <label>
                                            <input type="submit" name="submit" class="btn btn-sm btn-primary" value="{{translate['button_edit']}}">
                                        </label>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
{% endblock %}

{% block action_js %}

{% endblock %}