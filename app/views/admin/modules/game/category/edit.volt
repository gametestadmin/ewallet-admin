{% block content %}
<div id="wrapper" class="col-xs-12">
    <form class="form-horizontal" action="#" method="post">
        <div class="form-group col-xs-12">
            <label>Category Name</label>
            <label>
                <input type="text" name="category_name" id="name" placeholder="Name" value="{{category.name}}">
            </label>
        </div>
        <div class="form-group col-xs-12">
            <label>
                <a href="javascript:history.go(-1)">Back</>
            </label>
            <label>
                <input type="submit" name="submit" value="Edit">
            </label>
        </div>
    </form>
</div>
{% endblock %}

{% block action_js %}
{% endblock %}