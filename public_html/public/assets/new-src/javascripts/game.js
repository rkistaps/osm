var running = false;
var min = 0;
var speed = 0;
var width = 0;

$(document).ready(function(){

  $("#start").click(function(){

    if(running) return;

    running = true;
    speed = $("#speed").val();

    run();
  });

  $("#pause").click(function(){

    if(!running) return;
    running = false;

  });

  $("#speed").change(function(){ speed = $(this).val(); });


});

function run(){



  if(!running) return;

  display_events(min);

  if(min == 93) return;

  min = min + 1;
  $("#fill").css("width",min*5 + "px");
  $("#min").html(min_txt.replace("[min]", min));

  setTimeout("run()", speed);

}

function display_events(min){

  for (variable in events)
  {

    if(events[variable].clean_min == min){

      $("#live #progress_bar").closest("tr").after("<tr><td>" + events[variable].img + "</td><td>" + events[variable].min  + "</td><td>" + events[variable].text + "</td></tr>");

      if(events[variable].team != '' && ( events[variable].type == 'goal' || events[variable].type == 'penalty_goal')){

        if(events[variable].team == 'ht'){
          var hg = parseInt($("#hg").html());
          $("#hg").html(hg+1);
        }

        if(events[variable].team == 'at'){
          var ag = parseInt($("#ag").html());
          $("#ag").html(ag+1);
        }


      }


    }
  }

}