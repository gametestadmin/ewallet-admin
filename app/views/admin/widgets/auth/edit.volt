<!-- Modal -->
<div class="modal fade" id="form-edit-auth" tabindex="-1" role="dialog" aria-labelledby="form-edit-auth-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal" action="{{url('game/auth/edit')}}" method="post" id="form">
            <div class="modal-header">
                <label class="col-xs-6">
                    <h3 class="modal-title" id="modalLabel">Edit Auth</h3>
                </label>
                <label class="col-xs-6">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </label>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="col-xs-3 control-label">App Id</label>
                    <label class="col-xs-9">
                        <input type="hidden" name="tab" value="tab-endpoint">
                        <input type="hidden" name="auth_id" id="auth_id">
                        <input type="text" name="app_id" id="app_id_edit" class="form-control">
                    </label>
                </div>
                <div class="form-group">
                    <label class="col-xs-3 control-label">App Secret</label>
                    <label class="col-xs-9">
                        <input type="text" name="app_secret" id="app_secret_edit" class="form-control">
                    </label>
                </div>
            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="submit">Edit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).on("click", ".auth-edit", function () {
    var authId = $(this).data('id');
    var app_id = $("#app_id_"+authId).html();
    var app_secret = $("#app_secret_"+authId).html();

    $(".modal-body #auth_id").val(authId);
    $(".modal-body #app_id_edit").val(app_id);
    $(".modal-body #app_secret_edit").val(app_secret);
});
</script>