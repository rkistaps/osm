$(document).ready(function(){


  $("select[name='type']").change(function(){

    var p = $("input[type='password']");
    if($(this).val() == 'Public'){
      p.parent().hide();
    }else{
      p.parent().show();
    }

    if($(this).val() == 'Invite'){
      $(".cost").html("20");
    }else{
      $(".cost").html("2");
    }

  });

  $("select[name='stages']").change(function(){

    var t = $(this);
    var q = $("#qualification");
    var g = $("#groups");
    var p = $("#playoffs");
    var val = t.val();

    switch(val){
      case '1': g.show(); q.hide(); p.hide(); break;
      case '2': g.hide(); q.hide(); p.show(); break;
      case '3': g.show(); q.show(); p.hide(); break;
      case '4': g.show(); q.hide(); p.show(); break;
      case '5':  g.show(); q.show(); p.show(); break;
    }

  });


});