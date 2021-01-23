$(document).ready(function(){

  $("#savedTacticsForm input[name='save_tactics']").click(function(){

    var tactic = $(this).closest("form").find("select").val();

    if(tactic == 0){
      var title = '';
      while(title == ''){
        title = prompt(title_prompt_text);
      }

      if(!title) return false;

      $(this).closest("form").find("input[name='new_name']").val(title);

    }

  });

  $("#delete_seved_tactic").click(function(){

    var tactic = $(this).closest("form").find("select").val();
    var href = $(this).attr("href");

    if(tactic == 0) return false;

    $(this).attr("href", href+tactic);

  });

  $("#playersList .player").draggable();
  $("#field").droppable({
    drop: function(event, ui){
      console.log(ui);
    }
  });


});