{% block content %}
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-xs-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title row">
                            <h5>{{translate['title_text_add_currency']}}</h5>
                        </div>
                        <div class="ibox-content row">
                            <form method="post" action="{{url('/setting/currency/add')}}" class="form-horizontal col-xs-12">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">{{translate['form_currency_code']}}</label>
                                    <div class="col-md-9">
                                        <input type="text" name="code" id="code" class="form-control" placeholder="{{translate['placeholder_currency_code']}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">{{translate['form_currency_name']}}</label>
                                    <div class="col-md-9">
                                        <input type="text" name="name" class="form-control" placeholder="{{translate['placeholder_currency_name']}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">{{translate['form_currency_symbol']}}</label>
                                    <div class="col-md-9">
                                        <input type="text" name="symbol" class="form-control" placeholder="{{translate['placeholder_currency_symbol']}}">
                                    </div>
                                </div>
                                <div class="form-group"><div class="hr-line-dashed"></div></div>
                                <div class="form-group pull-right">
                                    <div class="col-xs-12">
                                        <label>
                                            <a href="{{url(module~'/'~controller)}}" class="btn btn-sm btn-danger">{{translate['button_back']}}</a>
                                        </label>
                                        <label>
                                            <input type="submit" class="btn btn-sm btn-primary" name="submit" value="{{translate['button_add']}}">
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

    <script>
        var max_chars = 3;
        $('#code').keyup( function(e){
            if ($(this).val().length >= max_chars) {
                $(this).val($(this).val().substr(0, max_chars));
            }
            this.value = this.value.toUpperCase();
        });
    </script>
{% endblock %}