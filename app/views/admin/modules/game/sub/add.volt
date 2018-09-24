{% block content %}
        {{ widget('MenuWidget', []) }}
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-xs-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title row">
                            <h5>General</h5>
                        </div>
                        <div class="ibox-content row">
                            <form class="form-horizontal" action="#" method="post">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Provider Game</label>
                                    <label class="col-xs-9">
                                        <input type="text" id="provider" class="form-control" readonly>
                                        <input type="hidden" name="provider" id="providerId">
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Category Game</label>
                                    <label class="col-xs-9">
                                        <select name="category" id="category" class="form-control">
                                            <option value="">-Choose One-</option>
                                            {% for category in categoryGame %}
                                            <option value="{{category.code}}">{{category.name}}</option>
                                            {% endfor %}
                                        </select>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Main Game</label>
                                    <label class="col-sm-7 col-xs-6">
                                        <select name="main" id="main" class="form-control">
                                            <option value="">-Choose One-</option>
                                        </select>
                                    </label>
                                    <label class="col-sm-2 col-xs-3 text-right">
                                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#exampleModal" disabled>
                                            Add New
                                        </button>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Name</label>
                                    <label class="col-xs-9">
                                        <input type="text" name="sub_name" class="form-control" id="sub_name" placeholder="Name">
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Code</label>
                                    <label class="col-xs-3">
                                        <input type="text" name="" class="form-control" id="result" placeholder="Code" readonly size="10">
                                    </label>
                                    <label class="col-xs-6">
                                        <input type="text" name="sub_code" class="form-control" id="sub_code" placeholder="Code">
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3"></label>
                                    <label class="col-xs-9"><input type="checkbox" name="parent_currency"> Copy Currency From Parent*</label>
                                </div>
                                <div class="form-group"><div class="hr-line-dashed"></div></div>
                                <div class="form-group pull-right">
                                    <div class="col-xs-12">
                                        <label>
                                            <a href="{{url('javascript:history.go(-1)')}}" class="btn btn-sm btn-danger">Back</a>
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
    <div style="color:black;" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="form-horizontal col-xs-12" action="{{url('#')}}" method="post" id="form">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group col-xs-12">
                        <label>Provider Game</label>
                        <lable>
                            <select name="provider" id="provider_modal">
                                <option value="">-Choose One-</option>
                                {% for provider in providerGame %}
                                    <option value="{{provider.id}}">{{provider.name}}</option>
                                {% endfor %}
                            </select>
                        </label>
                    </div>
                    <div class="form-group col-xs-12">
                        <label>Category Name</label>
                        <lable>
                            <select name="category" id="category_modal">
                                <option value="">-Choose One-</option>
                                {% for category in categoryGame %}
                                <option value="{{category.code}}">{{category.name}}</option>
                                {% endfor %}
                            </select>
                        </label>
                    </div>
                    <div class="form-group col-xs-12">
                        <label>Main Name</label>
                        <lable>
                            <input type="text" name="main_name" id="main_modal" placeholder="Name">
                        </label>
                    </div>
                    <div class="form-group col-xs-12">
                        <label>Main Code</label>
                        <label>
                            <input type="text" id="result_modal" placeholder="Code" readonly size="10">
                            -
                        </label>
                        <lable>
                            <input type="text" name="main_code" id="code_modal" placeholder="Code">
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
</div>
{% endblock %}

{% block action_js %}
    <script>
        $(function(){
            $('#main').change(function(){
                var a = $(this).val();
                var msg = a;
                $('#result').val(msg); // selector for div
            });

            $('#category_modal').change(function(){
                var a = $(this).val();
                var msg = a;
                $('#result_modal').val(msg); // selector for div
            });

            $('#form').submit(function (e) {
                var dataSplit;
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: '{{url('game/ajax?action=sub')}}',
                    data: $('#form').serialize(),
                    success: function(data) {
                        if(data == "error"){
                            alert(data);
                        }else{
                        //alert(data);
                            dataSplit = data.split("|");
                            mainCode = dataSplit[0];
                            mainName = dataSplit[1];
                            $("#main").append("<option value='"+mainCode+"'>"+mainName+"</option>");
                            $("#main").val(mainCode);
                            $('#result').val(mainCode);
                            $("#form").trigger( "reset" );
                            $('.modal').modal('hide');
                        }
                    },
                });
                return false;
            });
        });

        $(document).ready(function(){
            $('#main_modal').on('keyup',function(e) {
               $("#code_modal").val($(this).val().replace(/[^A-Za-z0-9]+/g, "-").toLowerCase());
            });

            $('#sub_name').on('keyup',function(e) {
               $("#sub_code").val($(this).val().replace(/[^A-Za-z0-9]+/g, "-").toLowerCase());
            });

            mainGame = new Array();
            $("#category").change(function(){
                var selectedCode = $("#category option:selected").val();
                $.ajax({
                    type: "POST",
                    url: "{{url('game/ajax')}}",
                    data: { code : selectedCode }
                }).done(function(data){
                    $(".btn").removeAttr('disabled');
                    $("#result").val("");
                    $("#provider").val("");
                    $("#providerId").val(providerId);
                    $("#main").html("<option value=''>-Choose One-</option>"+data);
                });
            });

            $("#main").change(function(){
                var selectedCode = $("#main option:selected").val();
                var dataSplit;
                $.ajax({
                    type: "POST",
                    url: "{{url('game/ajax')}}",
                    data: { mainCode : selectedCode }
                }).done(function(data){
                    dataSplit = data.split("|");
                    providerName = dataSplit[1];
                    providerId = dataSplit[0];
                    $("#provider").val(providerName);
                    $("#providerId").val(providerId);
                });
            });
        });

        $('#myModal').on('shown.bs.modal', function () {
          $('#myInput').trigger('focus')
        })
    </script>
{% endblock %}