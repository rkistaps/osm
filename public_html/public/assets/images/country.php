<?php 
include_once('include.php');
include_once('operations.php');
if($_SESSION['loggedin']!=1){print '<META HTTP-EQUIV="refresh" content="0; URL=index.php">';}
if($_REQUEST['country'] AND $_REQUEST['country']!='World'){$country=$_REQUEST['country'];}

if(!isCountry($country)){$error="<span class='error'>Country not found</span>";
}else{
	$query=mysql_query("SElect * FROM countrys WHERE country='$country'");
	$line=mysql_fetch_array($query);
	//get countrys info
	$round=$line[round];
	$season=$line[season];
	$nt_rank=$line[nt_rank];
	$nt_coach=$line[nt_coach];
	$u21_rank=$line[u21_rank];
	$u21_coach=$line[u21_coach];
	$u18_rank=$line[u18_rank];
	$u18_coach=$line[u18_coach];
	//country select
	$query=mysql_query("SELECT * FROM countrys ORDER BY country ASC");
	while($currCountry=mysql_fetch_array($query)){
		if($currCountry[country]==$country)
			$countryOpt.="\n\t\t<option SELECTED>$currCountry[country]</option>";
		else
			if($currCountry[country]!='World')$countryOpt.="\n\t\t<option>$currCountry[country]</option>";
	}
	$countryLinks="<div style='border:0px;' class='table_wrapper_right'><center> <select id='countrySelect' onChange='loadCountry()'>$countryOpt\n</select></div>";

		//top 10 teams
		$doquery=mysql_query("SELECT * from teams WHERE country='$country' ORDER BY overall DESC limit 10");
		$top10.="			
		<div class=table_wrapper_right>
		<table width=100%>
		<th>Top10 strongest teams</th>	
		";
		while($team=mysql_fetch_array($doquery)){
		$i++;
		$top10.="<tr><td>$i. <a href='team.php?team=$team[name]'>$team[name]</a>($team[overall])</td></tr>\n	";
		}
		$top10.="</table>\n	</div>";

			//top 10 richest teams
		$query="SELECT * from teams WHERE country='$country' ORDER BY money DESC limit 10";
		$doquery=mysql_query($query,$link);
		$top10r.="			
		<div class=table_wrapper_right>
		<table width=100%>
		<th>Top10 richest teams (milj.)</th>	
		";
		$i=0;
		while($team=mysql_fetch_array($doquery)){
		$i++;
		$team[money]=round($team[money]/1000000,2);
		$top10r.="<tr><td>$i. <a href='team.php?team=$team[name]'>$team[name]</a> $team[money]</td></tr>\n	";
		}
		$top10r.="</table>\n	</div>";

	//top 8 leagues
	$query="SELECT * from leagues WHERE country='$country' AND ready='1' ORDER BY level ASC limit 8";
	$doquery=mysql_query($query,$link);
	$top4.="
	<div class=table_wrapper_right>
	<table width=100%>
	<th>Top8 leagues</th>
	";
	$i=0;
	while($league=mysql_fetch_array($doquery)){
	$i++;
	$top4.="<tr><td>$i. <a href='league.php?id=$league[id]'>$league[name] ($league[lh])</a></td></tr>\n	";
	}
	$top4.="</table>\n	</div>";
	//user teams
	$query=mysql_query("SELECT * FROM teams WHERE country='$country' AND controller!='C'");
	$user_teams=mysql_num_rows($query);
	//news
	$news="
	<table width='100%' class='news'>
		<th colspan=4>Country News</th>
	";
	$query=mysql_query("SELECT * FROM nattalk WHERE country='$country' ORDER BY time DESC limit 10");
	while($new=mysql_fetch_array($query)){
	if($new[team]=='nat')$natteam='National Team'; else $natteam='U-18 Team';
	$time=date("d.m.Y",$new[time]);
	$news.="
	<tr>
		<td width='120px'>$natteam</td><td><a href='?country=$country&action=view&tid=$new[id]'>$new[title]</a></td><td>$time</td>
	</tr>
	";	
	}
	$news.="</table>";
	
	
	//main table
	
	
		$content="
		
		<!-- Right side -->
	<div id=right>
		$countryLinks
		$top4
		$top10
		$top10r
	</div>
	<div class='table_wrapper' style='border: 0px;'>
		<div id='box1'><img id='flag' src='img/flags/$country.png'></div>
		<div id='box2'>
		<table width='100%'>
			<th colspan=2>$country</th>
			<tr>
				<td>Season:</td><td>$season</td>
			</tr>
			<tr>
				<td>Week:</td><td>$round</td>
			</tr>
			<tr>
				<td>National Team rank:</td><td>$nt_rank</td>
			</tr>
			<tr>
				<td>U-18 Team rank:</td><td>$u18_rank</td>
			</tr>
			<tr>
				<td>Users Teams:</td><td>$user_teams</td>
			</tr>
		</table>
				<a href='nat.php?country=$country&squad=nat'>National Team</a> <a href='nat.php?country=$country&squad=u18'>U-18 Team</a>
		</div>
		<div id='box3'>
			$news
			
		</div>
	</div>
	
	$horAd
	$horAd
	";
	
	}

	
if($_REQUEST[action]=='view' and $_REQUEST[tid]){
	$tid=$_REQUEST[tid];
	$query=mysql_query("SELECT * FROM nattalk WHERE id='$tid'");
	$talk=mysql_fetch_Array($query);
	if(is_array($talk)){
		if($talk[team]=='nat')$natteam="National Team of $country"; else $natteam="U-18 Team of $country";
		$time=date("d.m.Y",$talk[time]);
		$query=mysql_query("SELECT * FROM users WHERE ID='$talk[user]'");
		$u=mysql_fetch_array($query);
		if($id==$u[ID]){
		$edit="<a href='nat.php?country=$talk[country]&squad=$talk[team]&action=edit&tid=$talk[id]'><img style='border:0px' src='/img/pencil.gif'></a>";
		$delete=" <a href='?action=delete&tid=$talk[id]'><img style='border:0px' src='/img/delete.png'></a>";
		
		}
		$content="
		<div id=right>
			$countryLinks
			$top4
			$top10
			$top10r
		</div>
		<div class='table_wrapper'>
			<table width='100%'>
				<th>Announcement from $natteam</th>
				<tr>
					<td><h1>$talk[title]</h1></td>
				</tr>
				<tr>
					<td>$talk[text]</td>
				</tr>
				<tr>
					<td style='text-align: right;'><a href='profile.php?id=$u[ID]'>$u[user]</a><br>$time<br>$edit $delete</td>
				</tr>
			</table>
		</div>
		";
	}else{
	}


}
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf8" />
<link rel="stylesheet" type="text/css" href="CSS/main.css" />
<link rel="stylesheet" type="text/css" href="CSS/country.css" />
<SCRIPT LANGUAGE="JavaScript" SRC="js/myscripts.js"></SCRIPT>
<link rel="icon" href="img/main_icon.jpg" type="image/x-icon" />
<link rel="shortcut icon" href="img/main_icon.jpg" type="image/x-icon" />
<?php print $keywords ?>
<title><?php print $title; ?></title>
</head>
<body>
<div id="all">
<!-- TOP -->
	<div id="top">
		<?php print $top; ?>
	</div>
<!-- LEFT SIDE -->
	<div id="left">
		<?php print $menu; ?>
	</div>
<!-- CENTER -->
	<div id="center">
	<?php
	if($msg){print $msg;}
	if($error){print $error;}
	print "$content" ;
	?>
	</div>
	<div id='bottom'>
		<?php print $bottom; ?>
	</div>
</div>


</body>
</html>
