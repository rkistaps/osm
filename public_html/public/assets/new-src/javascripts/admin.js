$(document).ready(function(){

  $("#language,#compare").change(function(){

  var lang = $("#language").val();
  var compare = $("#compare").val();

  window.location="?page=admin&show=translation&lang=" + lang + "&compare=" + compare; 

  });

  init_match_reports();

});


function init_match_reports(){

  $("#match_reports textarea.last").keyup(function(){

    var tr = $(this).closest("tr");
    var new_tr = tr.clone();
    tr.find("textarea").unbind("keyup").removeClass("last");
    tr.after(new_tr);
    init_match_reports();

  });

}