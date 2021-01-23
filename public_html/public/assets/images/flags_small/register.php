<?php 
include_once('include.php');
include_once('checkAll.php');

//REGiSTER
if ($_REQUEST['registred']){
$name=$_REQUEST['name'];
$sname=$_REQUEST['sname'];
$uname=$_REQUEST['uname'];
$pass=$_REQUEST['pass'];
$email=$_REQUEST['email'];
$tname=$_REQUEST['tname'];

$tname = str_replace("&"," ",$tname);
$tname = str_replace("?"," ",$tname);
$country=$_REQUEST['country'];
$ip=$_SERVER['REMOTE_ADDR'];

//check team name		
$doquery=mysql_query("SELECT * FROM teams WHERE name='$tname';");
$result=mysql_fetch_array($doquery);
if($result['name']==$tname){$error='<span class="error">Team name already taken!</span>'; $fail=1;}

//check user name		
$doquery=mysql_query("SELECT * FROM users WHERE user='$uname';");
$result=mysql_fetch_array($doquery);
if($result['user']==$uname){$error='<span class="error">User name already taken!</span>'; $fail=1;}
if($ip==$result[registred_from] AND $ip!='213.226.141.123'){$error='<span class="error">IP address already taken!  If you are creating your first team, contact admins via contact form.</span>'; $fail=1;}

//and isFreeIp($ip)
if(!$fail){
//check all fields
if ($name and $sname and $uname and $pass and $email and $tname and $country){
			$yourCountry=$_REQUEST['yourcountry'];
			$registred=date("G:i:s d.m.Y"); 
			$query="INSERT INTO users(name,surname,user,team,email,password,country,registred,registred_from,yourcountry) VALUES('$name','$sname','$uname','$tname','$email','$pass','$country','$registred','$ip','$yourCountry')";
			$doquery=mysql_query($query,$link) or print mysql_error();
			$query="SELECT * FROM users WHERE user='$uname';";
			$doquery=mysql_query($query,$link);
			$result=mysql_fetch_array($doquery);
			$id=$result[ID];
			//send welcome message
			$time=time();
			$message="Hello,<br>
			Welcome to OneSkill Manager. If you have any questions contact <a href=profile.php?id=88>Trusis</a>, <a href=profile.php?id=88>karalis</a>
			or look in forum. Have a nice time here.<br>
			Best regards,<br>
			OSM Crew.";
			mysql_query("INSERT INTO messages(from1,to1,title,msg1,read1,time1) VALUES('88','$id','Welcome!','$message','0','$time');") or print mysql_error();
			
			$team_id=$result[ID];
			// starting money
			
			$option='Starting money';
			$query="SELECT * FROM goptions WHERE goption='$option';";
			$doquery=mysql_query($query,$link);
			$result=mysql_fetch_array($doquery);
			$smoney=$result['value'];
			//add team
			$mood=80;
			
			$query="INSERT INTO teams(name,money,uname,teamood,fanmood,spomood,country,league,tactic,presure,fans,arena,logo,controller) VALUES('$tname','$smoney','$uname','$mood','$mood','$mood','$country','-1','Normal','Normal','5000','7500','img/default_logo.png','C');";
			$doquery=mysql_query($query,$link) or print mysql_error();
			
			//asign players
			
			$ii=1;
				for($i=1; $i!=20; $i++){
				
				//select name
				$query=mysql_query("SELECT * FROM name WHERE country='$country' ORDER BY RAND()");
				$name=mysql_fetch_array($query);
				$name=$name[name];
				$query=mysql_query("SELECT * FROM surname WHERE country='$country' ORDER BY RAND()");
				$surname=mysql_fetch_array($query);
				$surname=$surname[surname];
				
				//calculate skill, age, talant
				$age=rand(20,30);
				$talant=rand(0,5);
				$skill=rand(100,200);
				
				
				$salary=round($skill*$skill/40+$talant*$talant*10*(1+($age-20)*0.05));
				$salary=$salary*$salary/100;
								
				//calculate pos
				if($i<3){
				$pos='G';
				$pos1=1;
				}
				if($i>=3 and $i<9){
				$pos='D';
				$pos1=2;
				}
				
				if($i>=9 and $i<15){
				$pos='M';
				$pos1=3;}
				
				if($i>15){
				$pos='F';
				$pos1=4;
				}
				//add player to team
								
				$query="INSERT INTO players(nationality,name,surname,age,exp,talant,energy,skill,salary,team,pos,psort,place) 
values('$country','$name','$surname','$age','0','$talant','100','$skill','$salary','$tname','$pos','$pos1','team');";
				
				mysql_query($query,$link);		
				
				$query=mysql_query("SELECT * FROM players WHERE name='$name' AND surname='$surname' AND team='$tname' AND skill='$skill'");
				$id=mysql_fetch_array($query);
				
				//add to stats table
				mysql_query("INSERT INTO cstats(id) VALUES('$id[id]')");
				mysql_query("INSERT INTO sstats(id) VALUES('$id[id]')");
				
				}
			//add team to economy tables				
			mysql_query("INSERT INTO economythisseason(id) values('$team_id')") or print mysql_error();
			mysql_query("INSERT INTO economythisweek(id) values('$team_id')") or print mysql_error();
			
			//add team to facilties
			mysql_query("INSERT INTO facilties(name,team,level) values('tg','$tname','0')");
			mysql_query("INSERT INTO facilties(name,team,level) values('ys','$tname','0')");
			
			$msg='<span class="msg">Registration completed. You may login now!</span>';
				
	}else{
	if(isFreeIp($ip))
		$error='<span class="error">Regsitration failed.</span>';
	else
		$error="<span class='error'>This IP is already used. If it's your first team, contact admins.</span>";
	
	}
}
}
$content="
<div class='table_wrapper_50'>
<form type='POST'>
<table width='100%'>
	<th colspan='2'>Registration</th>
<tr>
	<td>Name</td><td><input name='name'></td>
</tr>
<tr>
	<td>Surname</td><td><input name='sname'></td>
</tr>
<tr>
	<td>User name</td><td><input name='uname'></td>
</tr>
<tr>
	<td>Password</td><td><input name='pass' type='password'></td>
</tr>
<tr>
	<td>E-mail</td><td><input name='email' id='mail'></td>
</tr>
<tr>
	<td>Team name</td><td><input name='tname' onKeyUp='letterCount(team)' id='team'> <span id='teamLetters'>0/30</span></td>
</tr>
<tr>
	<td>Teams country</td><td><SELECT NAME='country'>
	<option>Bosnia and Hercegovina</option>
	<option>Czech Republic</option>
	<option>Denmark</option>
	<option>England</option>
	<option>Estonia</option>
	<option>France</option>
	<option>Germany</option>
	<option>Greece</option>
	<option>Italy</option>
	<option>Latvia</option>
	<option>Netherlands</option>
	<option>Portugal</option>
	<option>Romania</option>	
	<option>Russia</option>
	<option>Scotland</option>
	<option>Spain</option>
	<option>Sweden</option>
	<option>Turkey</option>
	<option>Ukraine</option>
	</SELECT></td>
</tr>
<tr>
	<td>Your country:</td><td><input name='yourcountry'> *</td>
</tr>
<tr>
	<td colspan='2'><center><input type='submit' name='registred' value='Register'></td>
</tr>
</table>
</form>
* - fill in only if your country is not listed in 'Teams country' field.
</div>
"; 

?>

<html>
<head>
<meta http-equiv='content-type' content='text/html; charset=utf8' />
<script type='text/javascript' src='js/myscripts.js'></script>
<link rel="stylesheet" href="CSS/main.css" type="text/css">
<link rel="stylesheet" href="CSS/login.css" type="text/css">
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
	<?php print $horMenu; ?>
<!-- LEFT SIDE -->
	<div style="width:200px" id="left">
	<?php 
		print $menu;
	?>
	</div>
<!-- CENTER -->
	<div id="center" style="width:670px;">
	<?php 
	if($msg){print $msg;}
	if($error){print $error;}
		print $content;
	?>
	</div>
</div>
</body>
</html>
