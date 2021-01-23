$(document).ready(function(){

  $("#language,#compare").change(function(){

  var lang = $("#language").val();
  var compare = $("#compare").val();

  window.location="?page=translation&lang=" + lang + "&compare=" + compare; 

  });

})