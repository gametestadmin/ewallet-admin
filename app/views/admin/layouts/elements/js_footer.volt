{% block action_js %}
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


