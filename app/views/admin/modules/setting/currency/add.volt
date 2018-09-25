{% block content %}
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-xs-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title row">
                            <h5>General</h5>
                        </div>
                        <div class="ibox-content row">
                            <form method="post" action="{{url('/content-editor/add')}}" class="form-horizontal col-xs-12">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Currency Code</label>
                                    <div class="col-md-9">
                                        <input type="text" name="code" id="code" class="form-control" placeholder="Code">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Currency Name</label>
                                    <div class="col-md-9">
                                        <input type="text" name="name" class="form-control" placeholder="Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Currency Symbol</label>
                                    <div class="col-md-9">
                                        <input type="text" name="symbol" class="form-control" placeholder="Symbol">
                                    </div>
                                </div>
                                <div class="form-group"><div class="hr-line-dashed"></div></div>
                                <div class="form-group pull-right">
                                    <div class="col-xs-12">
                                        <label>
                                            <a href="javascript:history.go(-1)" class="btn btn-md btn-danger">Back</a>
                                        </label>
                                        <label>
                                            <input type="submit" class="btn btn-primary" name="submit" value="Add">
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