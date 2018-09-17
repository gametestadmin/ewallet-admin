{% block content %}
<div id="wrapper" class="col-xs-12">
    <form class="form-horizontal" action="#" method="post">
        <div class="form-group col-xs-12">
            <label>Type</label>
            <label>
                <input type="text" placeholder="Game Type" value="{{game.type|gameType}}" readonly>
            </label>
        </div>
        <div class="form-group col-xs-12">
            <label>Game Category</label>
            <label>
                <input type="text" placeholder="Game Category" value="{{game.game_parent|gameName}}" readonly>
            </label>
        </div>
        <div class="form-group col-xs-12">
            <label>Game Code</label>
            <label>
                <input type="text" placeholder="Name" value="{{game.code}}" readonly>
            </label>
        </div>
        <div class="form-group col-xs-12">
            <label>Game Name</label>
            <label>
                <input type="text" name="main_name" placeholder="Name" value="{{game.name}}">
            </label>
        </div>
        <div class="form-group col-xs-12">
            <label>
                <a href="{{url('javascript:history.go(-1)')}}">Back</>
            </label>
            <label>
                <input type="submit" value="Edit">
            </label>
        </div>
    </form>
</div>
{% endblock %}

{% block action_js %}
    <script>
        jQuery(document).ready(function($){
            var select = $('.status');
            var previouslySelected;
            select.focus(function(){
                previouslySelected = this.value;
            }).change(function(){
                var conf = confirm('Are You Sure?');
                if(!conf){
                    this.value = previouslySelected;
                    return;
                }
                location.href = '/game/category/status/'+jQuery(this).val();
            });
        });
    </script>
{% endblock %}