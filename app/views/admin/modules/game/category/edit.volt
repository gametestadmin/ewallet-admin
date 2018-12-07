{% block content %}
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-xs-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title row">
                            <h5>[{{category.name}}] Edit</h5>
                        </div>
                        <div class="ibox-content row">
                            <form class="form-horizontal col-xs-12" action="{{url(router.getRewriteUri())}}" method="post">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Category Code</label>
                                    <label class="col-xs-9">
                                        <input type="text" placeholder="Name" class="form-control" value="{{category.code}}" readonly>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Category Name</label>
                                    <label class="col-xs-9">
                                        <input type="text" name="category_name" id="name" placeholder="Name" class="form-control" value="{{category.name}}">
                                    </label>
                                </div>
                                <div class="form-group"><div class="hr-line-dashed"></div></div>
                                <div class="form-group pull-right">
                                    <div class="col-xs-12">
                                        <label>
                                            <a href="javascript:history.go(-1)" class="btn btn-sm btn-danger">Back</a>
                                        </label>
                                        <label>
                                            <input type="submit" name="submit" class="btn btn-sm btn-info" value="Edit">
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