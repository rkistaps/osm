$(document).ready(function(){
  $("#tablist li a").click(function(){
    $("#tabcontent").html("<div class='center'><img src='img/loading.gif' /></div>");
    $("#tablist li").removeClass("current");
    $(this).parent().addClass("current");
    var t = $(this).attr("href");
    var id = gup("country");
    var team = gup("team");

    $("#tabcontent").load('index.php?page=natTeam&country='+id+'&team='+team+'&method=ajax&show=' + t);
    return false;
  });

  $("a.add").click(function(){

    var player = $(this).attr("href");
    var id = gup("country");
    var team = gup("team");
    var elem = $(this);

    $.ajax({
      url: 'index.php?page=natTeam&country='+id+'&team='+team+'&method=ajax&action=addPlayer&player=' + player,
      async: false,
      success: function(data){
        if(data == 1){
          elem.parent().parent().remove();
        }
      }
    });

    return false;
  });


  $("a.remove").click(function(){

    var player = $(this).attr("href");
    var id = gup("country");
    var team = gup("team");
    var elem = $(this);

    $.ajax({
      url: 'index.php?page=natTeam&country='+id+'&team='+team+'&method=ajax&action=removePlayer&player=' + player,
      async: false,
      success: function(data){   
        if(data == 1){
          elem.parent().parent().remove();
        }
      }
    });

    return false;


  });


  $(".players_list input[type='checkbox']").click(function(){

    var pos = $(this).parent().parent().find("span").attr("class");

    if($(this).parent().parent().parent().hasClass("lineup")){
      $(this).parent().parent().parent().removeClass("lineup");
      switch(pos){
        case 'G': g--; break;
        case 'D': d--; break;
        case 'M': m--; break;
        case 'F': f--; break;
      }

    }else{
      $(this).parent().parent().parent().addClass("lineup");
      switch(pos){
        case 'G': g++; break;
        case 'D': d++; break;
        case 'M': m++; break;
        case 'F': f++; break;
      }
    }

    $("span.formation").html(d + "-" + m + "-" + f);

    var valid = check_formation();
    if(!valid){
      $("input[name='setLineup']").attr("disabled", "disabled").addClass("disabled");
    }else{
      $("input[name='setLineup']").attr("disabled", "").removeClass("disabled");
    }



  })

});

function check_formation(){

  if(g != 1) return false;
  if(d < 3 ||  d > 5) return false;
  if(m < 3 ||  m > 5) return false;
  if(f < 1 ||  f > 3) return false;
  if(g + d + m + f != 11) return false;

  return true;


}