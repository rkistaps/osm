$(document).ready(function(){

  init_search_form();

  $("a.sign").click(function(){

    var id = $(this).attr("id");
    var elem = $(this);

    $.ajax({
      url: 'index.php?page=staff&method=ajax&action=sign&staff=' + id,
      async: false,
      success: function(data){
        if(data == '1'){
          document.location = '?page=staff&signed=1&staff=' + id;
        }else{
          $(".error").remove();
          $("h1.styled").after("<div class='error'>" + data + "</div>");
          $(".error").focus();
        }
      }
    });

    return false;

  });

  $("a.fire").click(function(){

    var id = $(this).attr("id");
    var elem = $(this);

    $.ajax({
      url: 'index.php?page=staff&method=ajax&action=fire&staff=' + id,
      async: false,
      success: function(data){
        if(data == '1'){
          document.location = '?page=staff&fired=1&staff=' + id;
        }else{
          $(".error").remove();
          $("h1.styled").after("<div class='error'>" + data + "</div>");
          $(".error").focus();
        }
      }
    });

    return false;

  });

});

function init_search_form(){

  var form = $("#staff_search_form");
  $("select", form).change(function(){

    var val = $(this).val();
    for(i in staff_types){

      if(staff_types[i]['id'] == val){

        $("th.skill1").html(staff_types[i]['skill1_name']);

        if(staff_types[i]['skill2_name']){
          $("th.skill2").html(staff_types[i]['skill2_name']);
          $("input[name='skill2']").show();
        }else{
           $("th.skill2").html("");
           $("input[name='skill2']").hide();
        }

        if(staff_types[i]['skill3_name']){
          $("th.skill3").html(staff_types[i]['skill3_name']);
          $("input[name='skill3']").show();
        }else{
           $("th.skill3").html("");
           $("input[name='skill3']").hide();
        }

      }

    }

  });

}