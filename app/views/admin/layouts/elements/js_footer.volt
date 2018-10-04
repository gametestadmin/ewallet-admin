{% block action_js %}

<script src="{{assets_url}}thirdparty/js/inspinia.js"></script>
<script src="{{assets_url}}thirdparty/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="{{assets_url}}thirdparty/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="{{assets_url}}thirdparty/js/plugins/pace/pace.min.js"></script>

<script>

    //flash message
    function errorMessage(text){
        var alert = $("#alert").clone();
        alert.removeAttr("id").removeClass("hidden");
        alert.find( "#alert-content" ).removeAttr("id").addClass("alert").addClass("alert-danger").addClass("alert-dismissible");
        alert.find( "#alert-message" ).html(text);
        alert.appendTo('#notif-bar');
        window.setTimeout(function() {
            $(".alert").slideUp(500, function() {
                $(this).remove();
            });
        }, 3000);
    }
    function successMessage(text){
        var alert = $("#alert").clone();
        alert.removeAttr("id").removeClass("hidden");
        alert.find( "#alert-content" ).removeAttr("id").addClass("alert").addClass("alert-success").addClass("alert-dismissible") ;
        alert.find( "#alert-message" ).html(text);
        alert.appendTo('#notif-bar');
        window.setTimeout(function() {
            $(".alert").slideUp(500, function() {
                $(this).remove();
            });
        }, 3000);
    }

    // For Notification
    $(document).ready(function() {
        $(".alert").show();
        $(".alert").addClass("in");

        $( ".close" ).click(function() {
            $(".alert").slideUp(350, function() {
                $(this).remove();
            });
        });
    });

    window.setTimeout(function() {
        $(".alert").slideUp(500, function() {
            $(this).remove();
        });
    }, 1232000);

</script>
{% endblock %}


