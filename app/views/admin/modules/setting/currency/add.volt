{% block content %}
<!--<div id="wrapper" class="col-xs-12" style="color:white;">
    <form class="form-horizontal" action="#" method="post">
        <div class="form-group col-xs-12">
            <label>Currency Code</label>
            <label>
                <input type="text" name="code" id="code" placeholder="Code">
            </label>
        </div>
        <div class="form-group col-xs-12">
            <label>Currency Name</label>
            <label>
                <input type="text" name="name" placeholder="Name">
            </label>
        </div>
        <div class="form-group col-xs-12">
            <label>Currency Symbol</label>
            <label>
                <input type="text" name="symbol" placeholder="Symbol">
            </label>
        </div>
        <div class="form-group col-xs-12">
            <label>
                <a href="javascript:history.go(-1)" class="button">Back</a>
            </label>
            <label>
                <input type="submit" name="submit" value="Add">
            </label>
        </div>
    </form>
</div>-->

<div id="wrapper" class="col-xs-12">
    <div id="page-wrappers" class="gray-bg">
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-xs-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>General</h5>
                            <div class="ibox-tools">
                                <!--<span id="step">{% if step == 0 %}Step 1 of 3{% endif %}</span>-->
                                <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <form method="post" action="{{url('/content-editor/add')}}" class="form-horizontal">
                                <div class="row form-group">
                                    <label class="col-md-3 control-label">Currency Code</label>
                                    <div class="col-md-9">
                                        <input type="text" name="code" id="code" placeholder="Code">
                                    </div>
                                </div>
                                <div class="form-group col-xs-12">
                                    <label class="col-md-3 control-label">Currency Name</label>
                                    <div class="col-md-9">
                                        <input type="text" name="name" placeholder="Name">
                                    </div>
                                </div>
                                <div class="form-group col-xs-12">
                                    <label class="col-md-3 control-label">Currency Symbol</label>
                                    <div class="col-md-9">
                                        <input type="text" name="symbol" placeholder="Symbol">
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group col-xs-12">
                                    <label class="col-md-3 control-label">&nbsp;</label>
                                    <label class="col-md-9">
                                        <label>
                                            <a href="javascript:history.go(-1)" class="btn btn-md btn-danger">Back</a>
                                        </label>
                                        <label><input type="submit" class="btn btn-primary" name="submit" value="Submit"></label>
                                    </label>
                                </div>
                            </form>
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
        var max_chars = 3;
        $('#code').keyup( function(e){
            if ($(this).val().length >= max_chars) {
                $(this).val($(this).val().substr(0, max_chars));
            }
            this.value = this.value.toUpperCase();
        });
    </script>
{% endblock %}