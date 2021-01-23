$(document).ready(function(){

  $("#manage_polls tr.last input").live("focus",(function(){
    init_last_manage_polls_input($(this));
  }));

  $("#manage_polls input[name='addQuestion']").click(function(){

    question_count++;

    $("table.question").last().after(' \
      <table class="question">          \
            <tr>      \
              <td>' + type + ':</td>    \
              <td>                    \
                <select name="types[]">  \
                  <option value="single">' + single + '</option>  \
                  <option value="multiple">' + multiple + '</option> \
                </select>               \
              </td>             \
            </tr>        \
            <tr>      \
              <td>' + question + ':</td>   \
              <td><input class="wide" name="questions[]" /></td>  \
            </tr>                    \
            <tr class="last">   \
              <td>' + answer + '</td> \
              <td><input class="wide" name="answers[' + question_count + '][]" /></td>   \
            </tr>  \
            </table>  \
    ');

    return false;

  });

  $("#manage_polls").submit(function(){
    $("tr.last", $(this)).remove();
  });

  $("#linkToCountry").click(function(){
    $("#countrySelect").toggle('slow');
  });

  $("a.thumb_up").click(function(){

    var post = $(this).attr('href');
    var elem = $(this);


    $.ajax({
      url: 'index.php?page=forum&method=ajax&action=ratePositive&post=' + post,
      async: false,
      success: function(data){
        if(data == 1){

          elem.parent().addClass("positive").html("+1");

        }else{
          elem.parent().parent().before("<div class='error'>" + data + "</div>");
        }
      }
    });

    return false;

  });

  $("a.thumb_down").click(function(){

    var post = $(this).attr('href');
    var elem = $(this);


    $.ajax({
      url: 'index.php?page=forum&method=ajax&action=rateNegative&post=' + post,
      async: false,
      success: function(data){
        if(data == 1){

          elem.parent().addClass("negative").html("-1");

        }else{
          elem.parent().parent().before("<div class='error'>" + data + "</div>");
        }
      }
    });


    return false;

  });


  $("a.leaveForum").click(function(){

    var forum = $(this).attr('href');
    var elem = $(this);

    $.ajax({
      url: 'index.php?page=forum&method=ajax&action=leaveForum&forum=' + forum,
      async: false,
      success: function(data){
        if(data == 1){

          elem.parent().parent().remove();

        }else{
          //alert(data);
        }
      }
    });

    return false;

  });

  $("a.commentEdit").click(function(){

    var id = $(this).attr("href");
    $.ajax({
      url: 'index.php?page=forum&method=ajax&action=getPost&post=' + id,
      async: true,
      success: function(data){
        if(data != 0){
          $("#post_form textarea").val(data).focus();
          $("#post_form form").append("<input type='hidden' name='post_id' value='" + id + "'/>");
          $("#post_form input[type='submit']").attr("value", editValue);
          $("#post_form input[type='submit']").attr("name", "editComment");
        }
      }
    });

    return false;
  });

  $("a.commentDelete").click(function(){
    var entry = $(this);
    var id = $(this).attr("href");
    $.ajax({
      url: 'index.php?page=forum&method=ajax&action=deletePost&post=' + id,
      async: true,
      success: function(data){
        if(data == 1){
          entry.closest(".commentWrap").remove();
        }
      }
    });

    return false;
  });

  $("#mods a.no").click(function(){

    var forum = gup("forum");
    var mod = $(this).attr("href");
    var elem = $(this);

    $.ajax({
      url: 'index.php?page=forum&method=ajax&action=removeMod&mod=' + mod + '&forum=' + forum,
      async: false,
      success: function(data){
        if(data == 1){
          elem.parent().parent().remove();
        }
      }
    });
    return false;
  });

  $('a.removeCat').click(function(){

    var forum = $(this).find("img").attr("class");
    var category = $(this).attr("href");
    var elem = $(this);

    $.ajax({
      url: 'index.php?page=forum&method=ajax&action=removeCat&cat=' + category + '&forum=' + forum,
      async: false,
      success: function(data){
        if(data == 1){
          elem.parent().parent().parent().remove();
        }
      }
  });

  return false;
  });

  $('a.removeTopic').click(function(){

    var forum = $(this).find("img").attr("class");
    var topic = $(this).attr("href");
    var elem = $(this);

    $.ajax({
      url: 'index.php?page=forum&method=ajax&action=removeTopic&topic=' + topic + '&forum=' + forum,
      async: false,
      success: function(data){
        if(data == 1){
          elem.parent().parent().parent().remove();
        }
      }
  });

  return false;
  });



  add_unmark_hot();
  add_mark_hot();
  add_comment_remove();
  add_comment_show();
  add_comment_sneek();

});

function add_unmark_hot(){
  $('a.unMarkHot').click(function(){

    var forum = $(this).find("img").attr("class");
    var topic = $(this).attr("href");
    var elem = $(this);

    $.ajax({
      url: 'index.php?page=forum&method=ajax&action=unMarkHot&topic=' + topic + '&forum=' + forum,
      async: false,
      success: function(data){
        if(data == 1){
          elem.find("img").attr("src","img/flame.gif");
          elem.parent().parent().parent().find("td:eq(1) img").attr("src","img/note.gif");
          elem.addClass("markHot");
          elem.removeClass("unMarkHot");
          elem.unbind("click");
          add_mark_hot();
        }
      }
  });

  return false;
  });

}

function init_last_manage_polls_input(elem){

  var tr = elem.parent().parent();
  tr.clone().insertAfter(tr);
  tr.removeClass("last");
  tr.find("input").unbind("focus");

  /*$("#manage_polls tr.last input").focus(function(){
    init_last_manage_polls_input($(this));
  });  */

}

function add_mark_hot(){
  $('a.markHot').click(function(){

    var forum = $(this).find("img").attr("class");
    var topic = $(this).attr("href");
    var elem = $(this);

    $.ajax({
      url: 'index.php?page=forum&method=ajax&action=markHot&topic=' + topic + '&forum=' + forum,
      async: false,
      success: function(data){
        if(data == 1){
          elem.find("img").attr("src","img/water.gif");
          elem.parent().parent().parent().find("td:eq(1) img").attr("src","img/flame.png");
          elem.unbind("click");
          elem.removeClass("markHot");
          elem.addClass("unMarkHot");
          add_unmark_hot();
        }
      }
  });

  return false;
  });

}


function add_comment_remove(){
  $('a.commentRemove').click(function(){

      var forum = $(this).find("img").attr("class");
      var post = $(this).attr("href");
      var elem = $(this);

      $.ajax({
        url: 'index.php?page=forum&method=ajax&action=removePost&post=' + post + '&forum=' + forum,
        async: false,
        success: function(data){
          if(data != '0'){
            elem.parent().find(".comment").html("<div class='removed'> " + data + "</div>");
            elem.find("img").attr("src", "img/undo.gif");
            elem.removeClass("commentRemove");
            elem.addClass("commentShow");
            elem.unbind('click');
            add_comment_show();
            $('a.commentSneek').show();
          }
        }
    });
    return false;
    });
}

function add_comment_show(){

  $('a.commentShow').click(function(){
    var forum = $(this).find("img").attr("class");
    var post = $(this).attr("href");
    var elem = $(this);

    $.ajax({
      url: 'index.php?page=forum&method=ajax&action=showPost&post=' + post + '&forum=' + forum,
      async: false,
      success: function(data){
        if(data != 0){
          elem.parent().find(".comment").html(data);
          elem.find("img").attr("src", "img/hide.png");
          elem.removeClass("commentShow");
          elem.addClass("commentRemove");
          elem.unbind('click');
          $('a.commentSneek').hide();
          add_comment_remove();
        }
      }
  });
  return false;
  });

}

function add_comment_sneek(){

  $('a.commentSneek').click(function(){
    var forum = $(this).find("img").attr("class");
    var post = $(this).attr("href");
    var elem = $(this);

    $.ajax({
      url: 'index.php?page=forum&method=ajax&action=sneekPost&post=' + post + '&forum=' + forum,
      async: false,
      success: function(data){
        if(data != 0){
          elem.parent().find(".comment").html(data);
        }
      }
    });
    return false;
  });

}
