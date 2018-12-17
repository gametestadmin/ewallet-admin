<!-- Modal -->
<div class="modal fade" id="form-agent-add-subgame" tabindex="-1" role="dialog" aria-labelledby="form-agent-add-subgame-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal" action="{{url('downline/game/add')}}" method="post" id="form">
                <div class="modal-header">
                    <label class="col-xs-6">
                        <h3 class="modal-title" id="form-agent-add-subgame-label">{{translate['title_text_add_downline_sub_games']}}</h3>
                    </label>
                    <label class="col-xs-6">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </label>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-xs-3 control-label">{{translate['form_game']}}</label>
                        <label class="col-xs-9">
                            <input type="hidden" name="agent" value="{{agentGame.user.id}}">
                            <input type="text" class="form-control" name="category" value="{{agentGame.game.name}}" readonly>
                            <input type="hidden" name="tab" value="tab-subgame">
                        </label>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-3 control-label">{{translate['form_sub_game']}}</label>
                        <label class="col-xs-9">
                            <select name="game" class="form-control" id="game">
                                <option value="">{{translate['form_choose_one']}}</option>
                                {% if subGames != false %}
                                    {% for subGame in subGames %}
                                        <option value="{{subGame.id}}">{{subGame.name}}</option>
                                    {% endfor %}
                                {% endif %}
                            </select>
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{translate['button_close']}}</button>
                    <button type="submit" class="btn btn-primary" id="submit">{{translate['button_add']}}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        /*$("#category").change(function(){
            var category = $("#category").val();
            console.log(category);
        });

        $("#category").change(function(){
            var category = $("#category option:selected").val();

            $.ajax({
                type: "POST",
                url: "{{url('ajax/agent/game')}}",
                data: { category : category }
            }).done(function(response){
                //console.log(response);
                if(response == false){
                    $("#game").html("<option value=''>-Add One-</option>");
                }else{
                    //console.log(response);
                    $("#game").html("<option value=''>-Choose One-</option>");
                    $("#game").append(response);
                }
            });
        });*/
    });
</script>