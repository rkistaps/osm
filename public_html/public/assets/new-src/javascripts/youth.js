$(document).ready(function(){

  $("img.changeName").click(function(){

    var id = $(this).attr("id");
    var name = $(this).parent().find(".name").text().trim();
    var surname = $(this).parent().find(".surname").text().trim();

    name = "<input name='name' value='" + name + "' />";
    surname = "<input name='surname' value='" + surname + "' />";

    $(this).parent().html("<form method='post' action='?page=youth'><input type='hidden' name='id' value='" + id + "' />" + name + " " + surname + " <input type='submit' value='' name='changeName' class='save' /></form>");

    initSave();



  });


});

function initSave(){

  $(".save_name_change").unbind("click");

  $(".save_name_change").click(function(){

    $(this).parent().submit();


  });


}