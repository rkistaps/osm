$(document).ready(function(){

  $("a.cancel").click(function(){

    var friendly = $(this).attr('href');
    var elem = $(this);

    $.ajax({
      url: 'index.php?page=matches&method=ajax&action=cancel_friendly&friendly=' + friendly,
      async: false,
      success: function(data){
        if(data == 1){
          elem.parent().parent().remove();
        }
      }
    });

    return false;

  });

})