{% block content %}
<div id="wrapper" style="color:white;">
    <form class="form-horizontal" action="#" method="post">
        <div class="form-group">
            <label>Currency Code</label>
            <label>
                <input type="text" name="code" id="code" placeholder="Code">
            </label>
        </div>
        <div class="form-group">
            <label>Currency Name</label>
            <label>
                <input type="text" name="name" placeholder="Name">
            </label>
        </div>
        <div class="form-group">
            <label>Currency Symbol</label>
            <label>
                <input type="text" name="symbol" placeholder="Symbol">
            </label>
        </div>
        <div class="form-group">
            <label>
                <a href="javascript:history.go(-1)" class="button">Back</a>
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
        var max_chars = 3;
        $('#code').keyup( function(e){
            if ($(this).val().length >= max_chars) {
                $(this).val($(this).val().substr(0, max_chars));
            }
            this.value = this.value.toUpperCase();
        });
    </script>
{% endblock %}