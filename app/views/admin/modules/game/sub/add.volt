{% block content %}
<div id="wrapper" style="color:white;">
    <form class="form-horizontal" action="#" method="post">
        <div class="form-group">
            <label>Provider Game</label>
            <label>
                <input type="text" id="provider" readonly>
                <input type="hidden" name="provider" id="providerId">
            </label>
        </div>
        <div class="form-group">
            <label>Category Game</label>
            <label>
                <select name="category" id="category">
                    <option value="">-Choose One-</option>
                    {% for category in categoryGame %}
                    <option value="{{category.code}}">{{category.name}}</option>
                    {% endfor %}
                </select>
            </label>
        </div>
        <div class="form-group">
            <label>Main Game</label>
            <label>
                <select name="main" id="main">
                    <option value="">-Choose One-</option>
                </select>
            </label>
            <label>
                <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#exampleModal" disabled>
                    Add New
                </button>
            </label>
        </div>
        <div class="form-group">
            <label>Name</label>
            <label>
                <input type="text" name="sub_name" id="sub_name" placeholder="Name">
            </label>
        </div>
        <div class="form-group">
            <label>Code</label>
            <label>
                <input type="text" name="" id="result" placeholder="Code" readonly size="10">
                -
                <input type="text" name="sub_code" id="sub_code" placeholder="Code">
            </label>
        </div>
        <div class="form-group">
            <label>
                <a href="{{url('javascript:history.go(-1)')}}">Back</a>
            </label>
            <label>
                <input type="submit" name="submit" value="Add">
            </label>
        </div>
    </form>

    <!-- Modal -->
    <div style="color:black;" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="form-horizontal" action="{{url('#')}}" method="post" id="form">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
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
                    <div class="form-group">
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
                    <div class="form-group">
                        <label>Main Name</label>
                        <lable>
                            <input type="text" name="main_name" id="main_modal" placeholder="Name">
                        </label>
                    </div>
                    <div class="form-group">
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