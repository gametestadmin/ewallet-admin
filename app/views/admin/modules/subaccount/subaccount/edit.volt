{% block content %}
<div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-xs-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title row">
                        <h5>{{childuser.username}}</h5>
                    </div>
                    <div class="ibox-content row">
                        <div class="panel-body">
                            <form class="form-horizontal col-xs-12"  method="post">
                                <b class="text-red"> please rename the below and remove this line </b>
                                <div class="form-group">
                                    <div class="col-xs-4"> <b> Module </b> </div>
                                    <div class="col-xs-4"> <b> Controller </b> </div>
                                    <div class="col-xs-4"> <b> Action </b> </div>
                                    <div class="hr-line-dashed"></div>
                                </div>
                                {% for modulename , moduleList in aclParent %}
                                    <div class="row subaccount-border-bottom level-1-area">
                                        <div class="col-xs-4 parent">
                                            <input type="checkbox" data-level="parent" name="acl[]" id="{{modulename}}" disabled {% if aclChild[moduleList['id']] is defined and aclChild[moduleList['id']] == 1 %}  checked="checked" {% endif %} value="{{moduleList['id']}}"   >
                                            <b>{{ translate[moduleList['name']]|upper }}</b>
                                        </div>
                                        <div class="col-xs-8 level-2-area">
                                            {% for  controllername , controllerList in moduleList['child'] %}
                                            {% if controllerList['child']|length > 1 %}
                                            <div class="row subaccount-border-bottom">
                                                 <div class="col-xs-6">
                                                    <input type="checkbox" name="acl[]" data-level="child"  {% if aclChild[controllerList['id']] is defined and aclChild[controllerList['id']] == 1 %}  checked="checked" {% endif %} value="{{controllerList['id']}}"  >
                                                    <b>{{ translate[controllerList['name']]|upper }}  </b>
                                                 </div>
                                                 <div class="col-xs-6 level-3-area">
                                            {% endif %}
                                                {% for actionkey , action in controllerList['child'] %}
                                                    {% if action != 'index' %}
                                                        <div class="row subaccount-border-bottom">
                                                            <div class="col-xs-12">
                                                                <input type="checkbox"  name="acl[]" data-level="subchild"  {% if aclChild[action['id']] is defined and aclChild[action['id']] == 1 %}  checked="checked" {% endif %} value="{{action['id']}}"  >
                                                                <b>{{ translate[action['name']]|upper }}</b>
                                                            </div>
                                                        </div>
                                                    {% endif %}
                                                {% endfor %}
                                            {% if controllerList['child']|length > 1 %}
                                                 </div>
                                            </div>
                                            {% endif %}
                                            {% endfor %}
                                        </div>
                                    </div>
                                {% endfor %}
                                <div class="form-group"><div class="hr-line-dashed"></div></div>
                                <div class="form-group pull-right">
                                    <div class="col-xs-12">
                                        <label>
                                            <a href="{{url('javascript:history.go(-1)')}}" class="btn btn-sm btn-danger">{{translate['back']|upper}}</a>
                                        </label>
                                        <label>
                                            <input type="submit" class="btn btn-sm btn-info" value="{{translate['edit']|upper}}">
                                        </label>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


{% endblock %}

{% block action_js %}

    <script>

        $('[data-level="child"]').change(function (event) {
            var checked = $(this).is(':checked') ;
            var parent = $(this).closest('.level-1-area').find('[data-level="parent"]') ;
            var child = $(this) ;
            var subchild = $(this).parent().parent().find('[data-level="subchild"]') ;

            if (checked) {
                parent.prop('checked', true);
                subchild.prop('checked', true);
            } else {
                parent.prop('checked', false);
                subchild.prop('checked', false);
            }
        });

        $('[data-level="subchild"]').change(function (event) {
            var checked = $(this).is(':checked');
            var parent = $(this).closest('.level-1-area').find('[data-level="parent"]') ;
            var child =  $(this).closest('.level-3-area').parent().find('[data-level="child"]') ;
            var subchild =  $(this) ;

            if (checked) {
                parent.prop('checked', true);
                child.prop('checked', true);
            }

            //count child => active subchild
            $totalSelected = 0;
            $(this).closest('.level-3-area').find('[data-level="subchild"]').each(function() {
                if($(this).is(':checked')){
                    $totalSelected++;
                }
            });



                console.log($totalSelected);
            console.log( $(this).siblings );

        });

        $("form").submit(function() {
            $("input").removeAttr("disabled");
        });

    </script>



{% endblock %}