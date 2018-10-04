{% block content %}
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-xs-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title row">
                            <h5>General</h5>
                        </div>
                        <div class="ibox-content row">
                            <form class="form-horizontal col-xs-12" action="#" method="post">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Currency Code</label>
                                    <label class="col-xs-9">
                                        <input type="text" class="form-control" value="{{currency.code}}" readonly>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Currency Name</label>
                                    <label class="col-xs-9">
                                        <input type="text" name="name" class="form-control" value="{{currency.name}}">
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Currency Symbol</label>
                                    <label class="col-xs-9">
                                        <input type="text" name="symbol" class="form-control" value="{{currency.symbol}}">
                                    </label>
                                </div>
                                <div class="form-group"><div class="hr-line-dashed"></div></div>
                                <div class="form-group pull-right">
                                    <div class="col-xs-12">
                                        <label>
                                            <a href="javascript:history.go(-1)" class="btn btn-sm btn-danger">Back</a>
                                        </label>
                                        <label>
                                            <input type="submit" name="submit" class="btn btn-sm btn-primary" value="Edit">
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