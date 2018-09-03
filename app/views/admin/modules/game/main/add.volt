{% block content %}
<div id="wrapper" style="color:white;">
    <form class="form-horizontal" action="#" method="post">
        <div class="form-group">
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
        <div class="form-group">
            <label>Category Game</label>
            <label>
                <select name="category" id="category" onchange="myNewFunction(this)">
                <option value="">-Choose One-</option>
                {% for category in categoryGame %}
                    <option value="{{category.code}}">{{category.name}}</option>
                {% endfor %}
                </select>
            </label>
        </div>
        <div class="form-group">
            <label>Code</label>
            <label>

                <div style="background:#CCC;width:100px;min-height:0;overflow:hidden;float:left;display:block;">
                    <span id="result"></span>
                </div>
                <input type="text" name="main_code" id="main_code" placeholder="Code">
            </label>
        </div>
        <div class="form-group">
            <label>Name</label>
            <label>
                <input type="text" name="main_name" id="main_name" placeholder="Name">
            </label>
        </div>
        <div class="form-group">
            <label>
                <input type="submit" name="submit" value="Add">
            </label>
        </div>
    </form>
</div>
{% endblock %}

{% block action_js %}
    <script>
        $(function(){

        $('#category').change(function(){
        var a = $(this).val();
        var msg = a;
        $('#result').html(msg); // selector for div

        });

        });

        $(document).ready(function(){
            $('#main_name').on('keyup',function(e) {
               $("#main_code").val($(this).val().replace(/[^A-Za-z0-9]+/g, "-").toLowerCase());
            });
        });
    </script>
{% endblock %}