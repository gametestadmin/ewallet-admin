{% block content %}
    <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-xs-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title row">
                            <h5>{{childuser.username}} </h5>
                        </div>
                        <div class="ibox-content row">
                            <div class="tabs-container">
                                <ul class="nav nav-tabs">
                                    <li id="head-tab-general" class="tab"><a href="{{'/'~module~'/player/'~action~'/'~id }}"> {{ translate['general']|upper }} </a></li>
                                    <li id="head-tab-game" class="tab active"><a data-toggle="tab" href="#tab-general"> {{ translate['game']|upper }} </a></li>
                                    <li id="head-tab-transaction" class="tab"><a href="{{'/'~module~'/transaction/'~action~'/'~id}}"> {{ translate['transaction']|upper }} </a></li>
                                    <li id="head-tab-statement" class="tab"><a href="{{'/'~module~'/statement/'~action~'/'~id}}"> {{ translate['statement']|upper }} </a></li>
                                </ul>
                                <div class="tab-content padding-0">
                                    <div id="tab-general" class="tab-pane active">
                                        <div class="panel-body">
                                            <form class="form-horizontal col-xs-12" action="#" method="post">
                                            <div class="form-group">
                                                <label class="col-xs-2 control-label"> {{ translate['game']|upper }} </label>
                                                <label class="col-xs-10">
                                                    <input type="text" placeholder="{{ translate['game']|upper }}" name="game" class="form-control" class="form-control submit_input" value="{{ post['game'] }}">
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-xs-2 control-label"> {{ translate['start_date']|upper }} </label>
                                                <label class="col-xs-10">
                                                    <input type="text" id="datepicker" placeholder="{{ translate['start_date']|upper }}" name="date_start" class="form-control submit_input" class="form-control" value="{{ post['date_start'] }}">
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-xs-2 control-label"> {{ translate['end_date']|upper }} </label>
                                                <label class="col-xs-10">
                                                    <input type="text" id="datepicker1" placeholder="{{ translate['end_date']|upper }}" name="date_end" class="form-control submit_input" class="form-control" value="{{ post['date_end'] }}" disabled>
                                                </label>
                                            </div>


                                            {{ widget('ReportGameAccessLogWidget', ["data": post , "realuser" : real_user ]) }}


                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
{% endblock %}

{% block action_js %}
  <script>
      $( function() {
        $('#datepicker').datepicker({
              dateFormat: 'dd-mm-yy',
              setDate: new Date( "{{ post['date_start'] }}" ),
              minDate: -60 ,
              maxDate: 0 ,
              onClose : function() {
                var days = datePickerDifference( $(this).val() , Date() );
                $( "#datepicker1" ).datepicker( "option", "minDate", -days );
                $('#datepicker1').removeAttr("disabled");
              }
          });
      } );

      $( function() {
           $('#datepicker1').datepicker({
                 dateFormat: 'dd-mm-yy',
                 setDate: new Date( "{{ post['date_end'] }}" ),
                 minDate: -60 ,
                 maxDate: 0 ,
                 onClose : function() {
                    var days = datePickerDifference( $(this).val() , Date() );
                    $( "#datepicker" ).datepicker( "option", "maxDate", -days );
                 }

             });
      } );

      function datePickerDifference( dateStart , dateEnd ){
          var dateStart = toDate(dateStart);
          var days = ( Date.parse(dateEnd) - Date.parse(dateStart) ) / (1000 * 60 * 60 * 24);
          console.log(Math.floor(days));
          return Math.floor(days);
      }


      $(function() {
         $(".submit_input").change(function() {
           //$("form").submit();
         });
       });

       function toDate(dateStr) {
         const [day, month, year] = dateStr.split("-")
         return new Date(year, month - 1, day)
       }
  </script>
{% endblock %}