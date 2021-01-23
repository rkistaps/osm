var slideshow_speed = 3000;
var slideshow_handler;

if (navigator.userAgent.toLowerCase().indexOf("chrome") >= 0) {
    $(window).load(function(){
        $('input:-webkit-autofill').each(function(){
            var text = $(this).val();
            var name = $(this).attr('name');
            $(this).after(this.outerHTML).remove();
            $('input[name=' + name + ']').val(text);
        });
    });
}

$(document).ready(function(){


  $('div.select').click(function(){ $(this).toggleClass("active") });

  var i = 1000;
  $('div.select').each(function(){
    var width = $(this).width() - 2;
    console.log(width);
    $(".options", $(this)).css("width", width + "px");
    $(this).css("z-index", i--);
  });

  $("a.fancy").fancybox();

  $("#login form").submit(function(){

    var pasw = $("input[type='password']", $(this));
    var val = pasw.val();
    if(!val || val == '') return false;
    pasw.val(SHA1(val));

  });

  $(".message .close").click(function(){
    $(this).parent().fadeOut();
  });

  $("a.fancybox").fancybox({
    'onClosed'		: function() { $("#cw").show(); },
    'onStart'		: function() { $("#cw").hide(); }
  });

  $(".box .title .minimize").click(function(){

    if($(this).closest(".box").hasClass("minimized")){
      $(this).closest(".box").removeClass("minimized");
    }else{
      $(this).closest(".box").addClass("minimized");
    }

    return false;

  });

  $("input.date").datepicker({
    dateFormat: "yy-mm-dd",
    buttonImageOnly: true,
    buttonImage:  'img/calendar.gif',
    firstDay: 1,
    showAnim: 'slideDown',
    showOn: 'both'
  });

  $("#leagueSelect").change(function(){
    var id = $(this).attr("value");
    window.location="?page=league&id=" + id;
  });

  $("#mail input[name='checkToggle']").click(function(){

    if($(this).is(':checked')){
      $($(this).closest("form").find("input[type='checkbox']")).not(this).attr("checked", true).parent().addClass("ez-checked");
    }else{
      $($(this).closest("form").find("input[type='checkbox']")).not(this).attr("checked", false).parent().removeClass("ez-checked");
    }

  });

  $("a.show_result").click(function(){

    $(this).parent().parent().find(".choice").hide();
    $(this).parent().parent().find(".result").show();
    return false;

  });

  // start slideshow
  slideshow_handler = setTimeout("animateSlideshow()", slideshow_speed);

  // wall
  $("#postToWall textarea").keyup(function(){
    len = $(this).val();
    len = len.substr(0,300);
    $(this).val(len);
  });

  $("#market_form select[name='form']").change(function(){

    var saved_form = $("#market_form select[name='form']").val();
    if(saved_form != '0'){ document.location = '?page=market&action=load&form=' + saved_form; }
    return false;

  });

  $("#market_form input[name='save']").click(function(){

    var saved_form = $("#market_form select[name='form']").val();
    var title = '';
    if(saved_form == '0'){

      while(!title){
        title = prompt(title_prompt_text);
      }

      if(!title) return false;

      $("#market_form input[name='title']").val(title);

    }

  });

  $("select[name='teammates']").change(function(){

    var id = $(this).val();
    window.location="?page=player&id=" + id;


  });

  $("#delete_saved_form").click(function(){

    var saved_form = $("#market_form select[name='form']").val();
    if(saved_form == '0') return false;

    document.location = '?page=market&action=delete&form=' + saved_form;
    return false;
  });

  $("#mail .delete").click(function(){

    var link = $(this).attr("href")+"&method=ajax";
    var elem = $(this);
    $.ajax({
      url: link,
      async: false,
      success: function(data){
        if(data == '1'){
          elem.closest("tr").remove();
        }
      }
    });
    return false;

  });

  $(".confirm").click(function(){

    if($(this).is("input")){

      return confirm("Really want to: " + $(this).attr("value") + " ?");

    }else if($(this).is("a")){

      if($(this).text()){
        return confirm("Really want to: " + $(this).text() + " ?");
      }else{
        return confirm("Are you sure?");
      }

    }else{

      return confirm("Really?");

    }

  });


  $("#lang_menu").change(function(){

    var lang = $(this).find("select").val();
    window.location = "?lang=" + lang;

  });

  $("#left ul.menu li:nth-child(2) a").addClass("top");

  $(".mf_wrapper a img").click(function(){

    var id = $(this).parent().parent().parent().find("textarea").attr("id");

    switch($(this).attr("id")){
      case 'h1': addTags('[h1]','[/h1]', id);return;
      case 'h2': addTags('[h2]','[/h2]', id);return;
      case 'quote': addTags('[quote]','[/quote]', id);return;
      case 'user': addTags('[user id=xxx]','', id);return;
      case 'player': addTags('[player id=xxx]','', id);return;
      case 'team': addTags('[team id=xxx]','', id);return;
      case 'country': addTags('[country id=xxx]','', id);return;
      case 'league': addTags('[league id=xxx]','', id);return;
      case 'bold': addTags('[b]','[/b]', id);return;
      case 'italic': addTags('[italic]','[/italic]', id);return;
      case 'underline': addTags('[underline]','[/underline]', id);return;
      case 'link': addTags('[link url=xxx text=xxx]','', id);return;
      case 'img': addTags('[img src=xxx]','', id);return;
   }

  });


  $("img.revert").click(function(){

    var id = $(this).attr("id");
    var elem = $(this);

    $.ajax({
      url: 'index.php?page=market&method=ajax&action=revert&transfer=' + id,
      async: false,
      success: function(data){
        if(data == 1){
          elem.parent().parent().remove();
        }else{
          $("#content").prepend("<div class='error'>" + data  + "</div>");
        }
      }
    });

  });




  $("#username_input").focus();

  $('input[type="checkbox"]').ezMark();

  $("#tourtab").click(function() {
		$.fancybox([
      {'href'	: 'img/screens/login.png'},
      {'href'	: 'img/screens/news.png'},
			{'href'	: 'img/screens/players.png'},
      {'href'	: 'img/screens/player.png'},
      {'href'	: 'img/screens/preformance.png'},
      {'href'	: 'img/screens/progress.png'},
      {'href'	: 'img/screens/calendar.png'},
      {'href'	: 'img/screens/game.png'},
      {'href'	: 'img/screens/league.png'},
      {'href'	: 'img/screens/cl.png'},
      {'href'	: 'img/screens/country.png'},
      {'href'	: 'img/screens/nt.png'},
      {'href'	: 'img/screens/wc.png'},
      {'href'	: 'img/screens/wc_group.png'},
      {'href'	: 'img/screens/market.png'},
      {'href'	: 'img/screens/economy.png'},
      {'href'	: 'img/screens/profile.png'},
		], {
			'padding'			: 10,
			'transitionIn'		: 'none',
			'transitionOut'		: 'none',
			'type'            : 'image',
			'titlePosition'   : 'inside',
			'changeFade'      : 500
		});

    return false;
	});

  $("#createCountrySelect").change(function(){

    var me = $(this);

    if(!info_added){
      $("#createInfo").html(info);
      info_added = true;
    }

    var country = countries[me.val()];

    var t = info_text.replace("[cost]", country['price']);
    t = t.replace("[country]", country['name']);
    t = t.replace("[count]", upkeep);
    $("#createInfo p").html(t);

  });

});

function animateSlideshow(){

  var next = $("#slideshow .next");
  var current = $("#slideshow .current");

  next.show();

  $("#slideshow .current").animate({
    opacity: 0
  }, slideshow_speed/2, function() {



    current.css({
      opacity: 1,
      "backgroundImage": next.css("backgroundImage")
    });

    if(!slides[i]) i = 0;

    next.hide();
    next.css("backgroundImage", "url("+slides[i]+")");

    i = i + 1;
    setTimeout("animateSlideshow()", slideshow_speed);
  });

  return true;

}



function addTags(tag1,tag2,id){

  var textarea = document.getElementById(id);
  if (document.selection){
    textarea.focus();
    var sel = document.selection.createRange();
    sel.text = tag1 + sel.text + tag2;
  }else{
    var textarea = document.getElementById(id);
    var len = textarea.value.length;
    var start = textarea.selectionStart;
    var end = textarea.selectionEnd;
    var sel = textarea.value.substring(start, end);
    var replace = tag1 + sel + tag2;
    textarea.value = textarea.value.substring(0,start) + replace + textarea.value.substring(end,len);
  }
   textarea.focus();

}

// number formatting function
// copyright Stephen Chapman 24th March 2006, 10th February 2007
// permission to use this function is granted provided
// that this copyright notice is retained intact
function FormatNumber(num){
  var p = num.toFixed(0).split(".");
  return p[0].split("").reverse().reduce(function(acc, num, i, orig) {
      return  num + (i && !(i % 3) ? "," : "") + acc;
  }, "");

}



function gup( name )
{
  name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
  var regexS = "[\\?&]"+name+"=([^&#]*)";
  var regex = new RegExp( regexS );
  var results = regex.exec( window.location.href );
  if( results == null )
    return "";
  else
    return results[1];
}

/**
*
*  Secure Hash Algorithm (SHA1)
*  http://www.webtoolkit.info/
*
**/

function SHA1 (msg) {

	function rotate_left(n,s) {
		var t4 = ( n<<s ) | (n>>>(32-s));
		return t4;
	};

	function lsb_hex(val) {
		var str="";
		var i;
		var vh;
		var vl;

		for( i=0; i<=6; i+=2 ) {
			vh = (val>>>(i*4+4))&0x0f;
			vl = (val>>>(i*4))&0x0f;
			str += vh.toString(16) + vl.toString(16);
		}
		return str;
	};

	function cvt_hex(val) {
		var str="";
		var i;
		var v;

		for( i=7; i>=0; i-- ) {
			v = (val>>>(i*4))&0x0f;
			str += v.toString(16);
		}
		return str;
	};


	function Utf8Encode(string) {
		string = string.replace(/\r\n/g,"\n");
		var utftext = "";

		for (var n = 0; n < string.length; n++) {

			var c = string.charCodeAt(n);

			if (c < 128) {
				utftext += String.fromCharCode(c);
			}
			else if((c > 127) && (c < 2048)) {
				utftext += String.fromCharCode((c >> 6) | 192);
				utftext += String.fromCharCode((c & 63) | 128);
			}
			else {
				utftext += String.fromCharCode((c >> 12) | 224);
				utftext += String.fromCharCode(((c >> 6) & 63) | 128);
				utftext += String.fromCharCode((c & 63) | 128);
			}

		}

		return utftext;
	};

	var blockstart;
	var i, j;
	var W = new Array(80);
	var H0 = 0x67452301;
	var H1 = 0xEFCDAB89;
	var H2 = 0x98BADCFE;
	var H3 = 0x10325476;
	var H4 = 0xC3D2E1F0;
	var A, B, C, D, E;
	var temp;

	msg = Utf8Encode(msg);

	var msg_len = msg.length;

	var word_array = new Array();
	for( i=0; i<msg_len-3; i+=4 ) {
		j = msg.charCodeAt(i)<<24 | msg.charCodeAt(i+1)<<16 |
		msg.charCodeAt(i+2)<<8 | msg.charCodeAt(i+3);
		word_array.push( j );
	}

	switch( msg_len % 4 ) {
		case 0:
			i = 0x080000000;
		break;
		case 1:
			i = msg.charCodeAt(msg_len-1)<<24 | 0x0800000;
		break;

		case 2:
			i = msg.charCodeAt(msg_len-2)<<24 | msg.charCodeAt(msg_len-1)<<16 | 0x08000;
		break;

		case 3:
			i = msg.charCodeAt(msg_len-3)<<24 | msg.charCodeAt(msg_len-2)<<16 | msg.charCodeAt(msg_len-1)<<8	| 0x80;
		break;
	}

	word_array.push( i );

	while( (word_array.length % 16) != 14 ) word_array.push( 0 );

	word_array.push( msg_len>>>29 );
	word_array.push( (msg_len<<3)&0x0ffffffff );


	for ( blockstart=0; blockstart<word_array.length; blockstart+=16 ) {

		for( i=0; i<16; i++ ) W[i] = word_array[blockstart+i];
		for( i=16; i<=79; i++ ) W[i] = rotate_left(W[i-3] ^ W[i-8] ^ W[i-14] ^ W[i-16], 1);

		A = H0;
		B = H1;
		C = H2;
		D = H3;
		E = H4;

		for( i= 0; i<=19; i++ ) {
			temp = (rotate_left(A,5) + ((B&C) | (~B&D)) + E + W[i] + 0x5A827999) & 0x0ffffffff;
			E = D;
			D = C;
			C = rotate_left(B,30);
			B = A;
			A = temp;
		}

		for( i=20; i<=39; i++ ) {
			temp = (rotate_left(A,5) + (B ^ C ^ D) + E + W[i] + 0x6ED9EBA1) & 0x0ffffffff;
			E = D;
			D = C;
			C = rotate_left(B,30);
			B = A;
			A = temp;
		}

		for( i=40; i<=59; i++ ) {
			temp = (rotate_left(A,5) + ((B&C) | (B&D) | (C&D)) + E + W[i] + 0x8F1BBCDC) & 0x0ffffffff;
			E = D;
			D = C;
			C = rotate_left(B,30);
			B = A;
			A = temp;
		}

		for( i=60; i<=79; i++ ) {
			temp = (rotate_left(A,5) + (B ^ C ^ D) + E + W[i] + 0xCA62C1D6) & 0x0ffffffff;
			E = D;
			D = C;
			C = rotate_left(B,30);
			B = A;
			A = temp;
		}

		H0 = (H0 + A) & 0x0ffffffff;
		H1 = (H1 + B) & 0x0ffffffff;
		H2 = (H2 + C) & 0x0ffffffff;
		H3 = (H3 + D) & 0x0ffffffff;
		H4 = (H4 + E) & 0x0ffffffff;

	}

	var temp = cvt_hex(H0) + cvt_hex(H1) + cvt_hex(H2) + cvt_hex(H3) + cvt_hex(H4);

	return temp.toLowerCase();

}