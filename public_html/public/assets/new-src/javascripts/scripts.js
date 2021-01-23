$(document).ready(function(){

  $("#loginform input[name='user']").focus(function(){
    $(this).val("").unbind("focus");
  });

  $("#login input[name='password']").focus(function(){
    $(this).after("<input type='password' name='password' value='' />").remove();
    $("#login input[name='password']").focus();
  });


});