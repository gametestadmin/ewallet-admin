{% block content %}
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-xs-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title row">
                        <h5>{{action|capitalize}} {{controller|capitalize}}</h5>
                    </div>
                    <div class="ibox-content row">
                        <form class="form-horizontal col-xs-12" action="#" method="post">
                            <div class="form-group">
                                <label class="col-xs-3 control-label">Type</label>
                                <label class="col-xs-9">
                                    <input type="hidden" name="auth_id" value="{{providerGameEndpointAuth.id}}">
                                    <input type="hidden" name="tab" value="tab-endpoint">
                                    <input type="text" name="app_id" placeholder="App id" class="form-control" value="{{providerGameEndpointAuth.app_id}}">
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-3 control-label">Game Category</label>
                                <label class="col-xs-9">
                                    <input type="text" name="app_secret" placeholder="App Secret" class="form-control" value="{{providerGameEndpointAuth.app_secret}}">
                                </label>
                            </div>
                            <div class="form-group"><div class="hr-line-dashed"></div></div>
                            <div class="form-group pull-right">
                                <div class="col-xs-12">
                                    <label>
                                        <a href="{{url('javascript:history.go(-1)')}}" class="btn btn-sm btn-danger">Back</a>
                                    </label>
                                    <label>
                                        <input type="submit" class="btn btn-sm btn-info" value="Edit">
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