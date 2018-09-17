{% block content %}
<div id="wrapper" class="col-xs-12" style="color:white;">
    <form class="form-horizontal" action="#" method="post">
        <div class="form-group col-xs-12">
            <label>Provider Game</label>
            <label>
                <select name="provider">
                <option value="">-Choose One-</option>
                {% for provider in providerGame %}
                    <option value="{{provider.id}}">{{provider.name}}</option>
                {% endfor %}
                </select>
            </label>
        </div>
        <div class="form-group col-xs-12">
            <label>Category Game</label>
            <label>
                <select name="category" id="category">
                    <option value="">-Choose One-</option>
                    {% for category in categoryGame %}
                    <option value="{{category.code}}">{{category.name}}</option>
                    {% endfor %}
                </select>
            </label>
            <label>
                <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#exampleModal">
                    Add New
                </button>
            </label>
        </div>
        <div class="form-group col-xs-12">
            <label>Name</label>
            <label>
                <input type="text" name="main_name" id="main_name" placeholder="Name">
            </label>
        </div>
        <div class="form-group col-xs-12">
            <label>Code</label>
            <label>
                <input type="text" name="" id="result" placeholder="Code" readonly size="10">
                -
                <input type="text" name="main_code" id="main_code" placeholder="Code">
            </label>
        </div>
        <div class="form-group col-xs-12">
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
                    <div class="form-group col-xs-12">
                        <label>Category Name</label>
                        <lable>
                            <input type="text" name="category_name" id="name" placeholder="Name">
                            <input type="hidden" name="url" placeholder="Name" value="{{router.getRewriteUri()}}">
                        </label>
                    </div>
                    <div class="form-group col-xs-12">
                        <label>Category Code</label>
                        <lable>
                            <input type="text" name="category_code" id="code" placeholder="Code">
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