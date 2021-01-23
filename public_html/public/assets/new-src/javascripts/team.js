$(document).ready(function(){
  $("#tablist li a").click(function(){
    $("#tabcontent").html("<div class='center'><img src='img/loading.gif' /></div>");
    $("#tablist li").removeClass("current");
    $(this).parent().addClass("current");
    var t = $(this).attr("href");
    var id = gup("id");

    $("#tabcontent").load('index.php?page=team&id='+id+'&method=ajax&show=' + t);
    return false;
  })
})