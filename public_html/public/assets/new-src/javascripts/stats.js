$(document).ready(function(){

  $("#age_limit, #position, #nationality").change(function(){

    $(this).parent().submit();


  });


});