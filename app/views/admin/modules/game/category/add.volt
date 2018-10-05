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
                                    <label class="col-xs-3 control-label">Category Name</label>
                                    <label class="col-xs-9">
                                        <input type="text" name="category_name" class="form-control" id="name" placeholder="Name">
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Category Code</label>
                                    <label class="col-xs-9">
                                        <input type="text" name="category_code" class="form-control" id="code" placeholder="Code">
                                    </label>
                                </div>
                                <div class="form-group"><div class="hr-line-dashed"></div></div>
                                <div class="form-group pull-right">
                                    <div class="col-xs-12">
                                        <label>
                                            <a href="javascript:history.go(-1)" class="btn btn-sm btn-danger">Back</a>
                                        </label>
                                        <label>
                                            <input type="submit" name="submit" class="btn btn-sm btn-primary" value="Add">
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
        $(document).ready(function(){
            $('#name').on('keyup',function(e) {
               $("#code").val($(this).val().replace(/[^A-Za-z0-9]+/g, "-").toLowerCase());
            });
        });
    </script>

{% endblock %}