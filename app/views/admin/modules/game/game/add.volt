{% block content %}
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-xs-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title row">
                        <h5>Add Game</h5>
                    </div>
                    <div class="ibox-content row">
                        <form class="form-horizontal col-xs-12" action="{{url(router.getRewriteUri())}}" method="post">
                            <div class="form-group">
                                <label class="col-xs-3 control-label">Provider Game</label>
                                <label class="col-xs-9">
                                    <select name="provider" class="form-control">
                                        <option value="">-Choose One-</option>
                                        {% for provider in providerGame %}
                                            <option value="{{provider.id}}">{{provider.nm}}</option>
                                        {% endfor %}
                                    </select>
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-3 control-label">Category Game</label>
                                <label class="col-xs-7">
                                    <select name="category" id="category" class="form-control">
                                        <option value="">-Choose One-</option>
                                        {% for category in categoryGame %}
                                        <option value="{{category.cd}}">{{category.nm}}</option>
                                        {% endfor %}
                                    </select>
                                </label>
                                <label class="col-xs-2 text-right">
                                    <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#form-add-category">
                                        Add New
                                    </button>
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-3 control-label">Name</label>
                                <label class="col-xs-9">
                                    <input type="text" name="name" class="form-control" id="main_name" placeholder="Name">
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-3 control-label">Code</label>
                                <label class="col-xs-3">
                                    <input type="text" name="" id="result" class="form-control" placeholder="Code" readonly size="10">
                                </label>
                                <label class="col-xs-6">
                                    <input type="text" name="code" class="form-control" id="main_code" placeholder="Code">
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
    <!-- Modal -->
    <div class="modal fade" id="form-add-category" tabindex="-1" role="dialog" aria-labelledby="form-add-category-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="form-horizontal" action="{{url(router.getRewriteUri())}}" method="post" id="form">
                <div class="modal-header">
                    <label class="col-xs-6">
                        <h4 class="modal-title" id="form-add-category-label">Add Category Game</h4>
                    </label>
                    <label class="col-xs-6">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </label>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Category Name</label>
                        <lable class="col-xs-9">
                            <input type="text" class="form-control" name="category_name" id="name" placeholder="Name">
                            <input type="hidden" name="url" placeholder="Name" value="{{router.getRewriteUri()}}">
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Category Code</label>
                        <lable class="col-xs-9">
                            <input type="text" class="form-control" name="category_code" id="code" placeholder="Code">
                        </label>
                    </div>
                </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="submit">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
{% endblock %}

{% block action_js %}
    <script>
        $(function(){
            $('#category').change(function(){
                var a = $(this).val();
                var msg = a;
                $('#result').val(msg); // selector for div
            });

            $('#form').submit(function (e) {
                var dataSplit;
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: '{{url('game/ajax')}}',
                    data: $('#form').serialize(),
                    success: function(data) {
                        if(data == "error"){
                            alert(data);
                        }else{
                            dataSplit = data.split("|");
                            categoryCode = dataSplit[0];
                            categoryName = dataSplit[1];
                            $("#category").append("<option value='"+categoryCode+"'>"+categoryName+"</option>");
                            $("#category").val(categoryCode);
                            $('#result').val(categoryCode);
                            $('.modal').modal('hide');
                        }
                    },
                });
                return false;
            });
        });
        $(document).ready(function(){
            $('#name').on('keyup',function(e) {
               $("#code").val($(this).val().replace(/[^A-Za-z0-9]+/g, "-").toLowerCase());
            });

            $('#main_name').on('keyup',function(e) {
               $("#main_code").val($(this).val().replace(/[^A-Za-z0-9]+/g, "-").toLowerCase());
            });
        });

        $('#myModal').on('shown.bs.modal', function () {
          $('#myInput').trigger('focus')
        })

    </script>
{% endblock %}