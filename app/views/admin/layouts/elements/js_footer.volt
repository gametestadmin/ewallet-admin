{% block action_js %}

<script src="{{assets_url}}thirdparty/js/inspinia.js"></script>
<script src="{{assets_url}}thirdparty/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="{{assets_url}}thirdparty/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="{{assets_url}}thirdparty/js/plugins/pace/pace.min.js"></script>

<script>
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
    }, 112000);
</script>
{% endblock %}


