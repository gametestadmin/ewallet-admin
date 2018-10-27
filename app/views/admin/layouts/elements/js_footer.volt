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

    $(document).ready(function() {
        // For Notification
        $(".alert").show();
        $(".alert").addClass("in");

        $( ".close" ).click(function() {
            $(".alert").slideUp(350, function() {
                $(this).remove();
            });
        });

        $( ".navbar-minimalize" ).click(function() {
            var mini = $("body").hasClass("mini-navbar");
            if(mini == true){
                $(".large-logo").addClass("profile-element");
                $(".mini-logo").removeClass("hide");
            }else{
                $(".mini-logo").addClass("hide");
                $(".large-logo").removeClass("profile-element");
            }
        });
        var active = $(".nav-header li").hasClass("active");
        if(active == true){
            $("li.active span.nav-label").addClass("nav-label-active");
        }
    });

    window.setTimeout(function() {
        $(".alert").slideUp(500, function() {
            $(this).remove();
        });

    }, 2000);


    $('#myModal').on('shown.bs.modal', function () {
      $('#myInput').trigger('focus')
    })
</script>
{% endblock %}

