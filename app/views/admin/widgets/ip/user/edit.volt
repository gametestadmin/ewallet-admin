<!-- Modal -->
<div class="modal fade" id="form-edit-user-ip" tabindex="-1" role="dialog" aria-labelledby="form-edit-user-ip-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal" action="{{url('agent/whitelist/edit')}}" method="post" id="form">
            <div class="modal-header">
                <label class="col-xs-6">
                    <h3 class="modal-title" id="modalLabel">Edit User Whitelist IP Form Edit</h3>
                </label>
                <label class="col-xs-6">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </label>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="col-xs-3 control-label">Ip</label>
                    <label class="col-xs-9">
                        <input type="hidden" name="ip_id" id="ip_id">
                        <input type="hidden" name="user" id="user">
                        <input type="hidden" name="tab" value="tab-ip">
                        <input type="text" name="ip" id="ip" class="form-control">
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
$(document).on("click", ".ip-edit", function () {
    var ipId = $(this).data('id');
    var ip = $("#id_"+ipId).html();
    var user = $("#user_"+ipId).html();

    $(".modal-body #ip_id").val(ipId);
    $(".modal-body #ip").val(ip);
    $(".modal-body #user").val({{userId}});

});
</script>