{% block content %}
<div id="wrapper">
    <form class="form-horizontal" action="#" method="post">
        <div class="form-group">
            <label>Category Name</label>
            <label>
                <input type="text" name="category_name" id="name" placeholder="Name">
            </label>
        </div>
        <div class="form-group">
            <label>Category Code</label>
            <label>
                <input type="text" name="category_code" id="code" placeholder="Code">
            </label>
        </div>
        <div class="form-group">
            <label>
                <a href="javascript:history.go(-1)">Back</>
            </label>
            <label>
                <input type="submit" name="submit" value="Add">
            </label>
        </div>
    </form>
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