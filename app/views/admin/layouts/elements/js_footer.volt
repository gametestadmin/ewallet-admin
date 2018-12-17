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

    function myCurrency(){
        var counter = 1 ;
        $.ajax({
          type: "POST",
          url: '{{url('ajax/currency/list')}}',
          data: {
            "id" : null ,
          },
          dataType : "json",
          success: function(result) {
            $.each( result , function(index, item) {
                var myCurrencies = $("#CloneCurrency").clone();
                myCurrencies.removeAttr("id").removeClass("hidden").addClass("CurrencyClone") ;
                if ( counter %2 == 0 ) {
                    myCurrencies.addClass("content-even");
                } else {
                    myCurrencies.addClass("content-odd");
                }
                myCurrencies.find(".currency-symbol").html(item["symbol"]) ;
                myCurrencies.find(".currency-code").html(item["code"]) ;
                myCurrencies.find(".currency-currency_name").html(item["currency_name"]) ;
                myCurrencies.find(".currency-default").children().attr('data-id' , item["id"]) ;

                if( item["default"] == 1){
                    myCurrencies.find(".currency-default").children().children().addClass("text-success").addClass("fa-check") ;
                } else {
                    myCurrencies.find(".currency-default").children().children().addClass("text-danger").addClass("fa-times") ;
                }
                myCurrencies.appendTo('#CurrencyBelow');
                counter = counter + 1 ;
                //console.log(item);
            });

          },
          error: function(jqXHR , textStatus , errorThrown) {
                //console.log(jqXHR.responseJSON['messages']);
                errorMessage(jqXHR.responseJSON['messages']);

          }
      });
    }

    $(document).on('click', ".setmycurrency", function() {
            //console.log( $(this).data("id"));
            $.ajax({
                  type: "POST",
                  url: '{{url('ajax/currency/default')}}',
                  data: {
                    "id" : $(this).data("id") ,
                  },
                  dataType : "json",
              success: function(result) {
                successMessage(result['messages']);
                removeMyCurrency();
                myCurrency();

            },
              error: function(jqXHR , textStatus , errorThrown) {
                //console.log(jqXHR);
                //console.log(textStatus);
                //console.log(errorThrown);
                //errorMessage(jqXHR.responseJSON['messages']);

            }
        });

    });

    function removeMyCurrency(){
        $('.CurrencyClone').remove();
    }

    $('.modal').on('hidden.bs.modal', function () {
            removeMyCurrency();
    });

    $('#myModal').on('shown.bs.modal', function () {
      $('#myInput').trigger('focus')
    })


    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
{% endblock %}

