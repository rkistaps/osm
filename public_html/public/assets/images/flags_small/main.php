<?php
include_once("include.php");
if($_SESSION['loggedin']!=1){print '<META HTTP-EQUIV="refresh" content="0; URL=index.php">';}

$right.=$verAd;
?>
<html>
<head>
<meta http-equiv='content-type' content='text/html; charset=utf8' />
<link rel="stylesheet" href="CSS/main.css" type="text/css">
<link rel="icon" href="img/main_icon.jpg" type="image/x-icon" />
<link rel="shortcut icon" href="img/main_icon.jpg" type="image/x-icon" />
<?php print $keywords ?><title><?php print $title; ?></title>
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
	print "
	<div id='right'>$right</div>
	<div class='table_wrapper' style='border:0px solid;'>
	<h1>Advertising Tips by <a href='profile.php?id=736'>Fugazi</a></h1>
	<p>
		<h2>What is the advantage for me when I advertise the game ?</h2>
	</p>
	<p>
		<ol>
			<li>For each approved club that joins OSM you will get 10k extra money send to your team.
			<li>It's the best way of helping your country in the game(Your national team will get a broader selection of players.).
			<li>If your country isn't included yet in the game,this is the way to get it added.
			<li>If there are enough users,your country will get it's own league in the future.
		</ol>
	</p>
	<h2>How can I advertise the game?</h2>
	<p>
		Well,try to convince your friends to join the game,because there's nothing more fun than doing better or beating someone you know.
	</p>
	<p>
		And,maybe the most effective way,make some post about the game in forums of your local/national soccerclubs and in forums of gamesites.
	</p>
	<p>
		Try to point out the advantages of the game against other soccersims like:
	</p>
	<p>
		<ol>
			<li>the game just started out,this your change to become a topclub !
			<li>The game isn't that hard to play and lots of users will help you out on the forums.
			<li>The game is under constant improvement and has dedicated developers.
		</ol>
	</p>
	<p>
		There is nothing to lose about advertising the game,it only takes a little bit of effort but if you do it well,it will give your club and country a significant boost.
	</p>
	<div class='newsBottom'>Posted by <a href='profile.php?id=736'>Fugazi</a><br>On: 05.04.2010</div>
	</div>
	
	<div class='table_wrapper' style='border:0px solid;'>
	<div>
	<h1>Several updates and usefull information.</h1>

<p> We made several small updates and bug fixes During last few days. Please read this info carefully, as there will be usefull information about how things are going in OSM.
</p>

<h2>Countries and National teams.</h2>

<p> We created option for National and U18 team coaches to write an announcement, which you can find in your <a href='country.php'>country news.</a> </p>
<p>Also during the last days we added several countries: <a href='country.php?country=USA'>USA</a>, <a href='country.php?country=Finland'>Finland</a> and <a href='country.php?country=Belgium'>Belgium</a>. Users, which plays in different countries, can move team to their country or create a new team. In both cases you should contact OSM crew.</p>

<h2>Free Agents</h2>
We decided to place National and U18 team players from bot or inactive teams in <a href='market.php'>transfer market</a> During several days we had a discussion about FA in our <a target='_blank' href='http://www.oneskillmanager.com/forum/index.php?a=vtopic&t=179'>forums</a>, so you can find detailed information there. 

<h2>Rating and energy updates.</h2>

<p> We fixed and updated rating calculations for your team as well as soft and hard presure effect on your teams energy. Detailed information you can see in our <a target='_blank' href='http://www.oneskillmanager.com/forum/index.php?a=vtopic&t=203'>forum</a>. </p>

<h2>Game event times</h2>

<p>As many of you noticed, we had problems with server time and several events happened late. This problem is fixed and everything should work fine. Still we will keep an eye on this. We added to server time one hour as spring time.</p>

<h2>League and cup prizes</h2>

<p>We had a discussion about those things too. As result we decided to decrease Cup prizes for first season. Detailed information will be later in our <a target='_blank' href='/forum/'>forum</a>.</p>

<h2>Player speciality</h2>
<p>After this weeks Weekly updates, you will be able to pull five more youths. The new thing is that there is possibility, that they will have speciality. This is new feature and will take effect in game engine only after this season. The specialities will be: tackling, passing, finishing. More information you will find in our <a href='http://www.oneskillmanager.com/forum/index.php?a=vtopic&t=210'>forum</a>.</p>

<h2>Upcoming Season</h2>
<p>
First OneSkill Manager season soon will reach it's midway, and several things about next season should be known:
<ul>
	<li>Several new leagues will be added (with enough users);
	<li>Two more countries will be added;
	<li>League prizes and ticket prices - will be the same for all divisions; !!!!
	<li>Cup prizes will be reduced, but still higher than this season;
	<li>We will put teams to their National leagues starting from highest league by - points, wins, goals
	<li>After world cup there will be 3 national qualify groups instead of two 
</ul>
</p>

<h2>Transfer market</h2>
<p>
We also decided to set range limit for minimal step to avoid cheating and mistakes. 
</p>

<h2>Top Teams</h2>
<p>Now in Team Top (in worlds and index page) are shown:<br>

* Teams who are in any league<br>
* Only human teams<br>
* Not locked users<br>
</p>

<h2>Voting</h2>
<p>
We are thankfull for those who vote for us <a target='_blank' href='http://www.worldonlinegames.com/game/sports/1440/oneskill-manager.aspx'>worldonlinegames</a>
and <a target='_blank' href='http://apexwebgaming.com/in/4875'>apexwebgaming</a>. We have to keep voting there to popularise OSM. </p>

<h2>Other things</h2>
<p> Also we would like to see you in our <a target='_blank' href='http://www.oneskillmanager.com/forum'>forum</a>
 where you can find important information and express your opinion about OneSkill Manager.</p>
	
	<div class='newsBottom'>Posted by OSM Crew<br>On: 02.04.2010</div>
		$adExc4
	</div>
 	<h1>Todays Updates</h1>
	<p>
	Today we added two new things to OSM. Both of them very interesting and useful in my opinion.
	</p>
	<p>
	* We added so-called 'Invitation URL'(you can find it in your profiles page). Use this URL to advertise OneSkill Manager on your blog, forum etc. And we will give <b>€10 000</b> for every team that will register and get our approval. All this kind of earnings will be displayed at Economys page in 'Temporary Income' place. You don't have to be close to math to make your calculations how much this could help your team. 
	</p>
	<p>
	<span class='note'>But remember that creating your own teams wont make you rich. It will make you banned :)</span>
	</p>
	<p>
	* Next thing we added is 'System Messages'. These messages will be quite similar to old ones. They will inform you about some actions related to your team. For now we have made system message for TM. This means, you will receive a message when someone makes a bid on your player. You will also get a message when someone outbids you on other player. We will also add System messages to other parts of OSM to improve gameplay.  We hope this will be useful. Enjoy!
	</p>
	<p>
	More disscusions about these update you can find <a href='http://www.oneskillmanager.com/forum/index.php?a=vtopic&t=194'>HERE</a>
	</p>
	<div class='newsBottom'>Posted by <a href='profile.php?id=88'>Trusis</a><br>On: 29.03.2010</div>
	</div>
	<div>
	<h1>Upcoming season and todays updates.</h1>
	<p>A lot of things has been done during the game was 
	closed and several after That. Most important of them were:</p>
	<ol>
		<li>Teams has been added to leagues.</li>
		<li>National and U-18 teams has been randomized into qualification groups.</li>
		<li>Cup created.</li>
		<li>All fixtures were generated.</li>
		<li>Bosnia and Hercegovina have been added to OSM.</li>
		<li>A lot of bot teams has been added.</li>
		<li>Inactive teams has been declared as bots.</li>
	</ol>
	<p>All active teams has been added to leagues by random. So you can see how lucky you were. Prizes and ticket
	prices are the same for IV - VI leagues, so only teams, which plays in III leagues, has an
	advantage. Next new teams will change inactive and bot teams, which plays in IV to VI leagues.</p>
	<p>Also we would like to congratulate Bosnia and Hercegovina as they joined OSM today!</p>
	<p>We have to admit, that not all National teams will participate in first WC and U-18 WC qualification as there is 
	only 16 places. Three National and U-18 teams, that won't participate in WC qualification are 
	Germany, France and Turkey. All National teams will take a part in next World cup qualifications. 
	</p>
	<p>Tomorrow we have to test other things on our test server, that means, game will be online all day.
	 More about these tests you will be able to find out in our <a href='/forum/'>forum</a> tomorrow.
	</p>
	<p>Also soon we will announce our new local forum moderators as many users asked</p>
	<p>Currently we have a lot to do, so we can't spend as much time as we would like to advertise OSM.
	We have very few users from several big countries like Germany, France etc. We would be grateful for
	any kind of advertising support.</p>
	<div class='newsBottom'>Posted by OSM Crew.<br>On: 13.03.2010</div>
	</div>
		
	<div style='overflow: hidden;'>
	<h2>Database error and new Update</h2>
	<p>
		Hello,<br>
		As you all felt, today we faced our first big database error. Some essential parts of our database were lost,therefore all you of were not able to login. This led to a full-scale password recovery procedure(more info <a href='http://www.oneskillmanager.com/forum/index.php?a=vtopic&t=53' target='_blank'>Here</a>).<br>
		All I can say in now, that we(admins) had a good lesson today. 
	</p>
	<p>
		As a gratitude to all for understanding, we announce a new update - \"Profile Edit\". Now you can
		edit information about you, hide your real name, set your logo and change current password.<br>
		Hope to see nice logos here. :)
	</p>
		<div class='newsBottom'>Posted by <a href='profile.php?id=8'>Trusis</a><br>On: 09.03.2010</div>
	</p>
	</div>
	<div style='overflow: hidden;'>
	<h2>The power of forum</h2>
	<p>		
We would like to announce, that we laucnhed Elections in forum, so you can see more information there. By the way, there is a lot of useful information about game in forum.
</p><p>
In last days we had to take serious actions to deal with cheating. Please be aware of suspicious transfers to avoid being locked.
</p><p>
Also we would like to add, that next small announecments will be shown on forums, only the big(global) ones will be posted here.
</p>
		<div class='newsBottom'>Posted by <a href='profile.php?id=89'>karalis</a><br>On: 07.03.2010</div>
	</p>
	</div>


	<div style='overflow: hidden;'>
	<h2>Welcome Estonia</h2>
	<p>
		<img src='img/flags/Estonia.png' style='float:right;border:1px solid black;'> We added <a href='country.php?country=Estonia' style='font-weight:bold'>Estonia</a>, as we promised. Now all Estonians can register under their flag. 
		All other Estonians who already has registred under different nations can choose from two options now:
		<ul>
			<li><b>a)</b> We can change your clubs country to Estonia. This means you will keep your current players
			with their current nationality, but all next youths will have estonian nationality. 
			</li>
			<li>
			<b>b)</b> You can register once again and choose Estonia as your teams country.
			</li>
		</ul>
		You have to decide and inform OSM crew, so we can take futher actions. Especially if you are going to register again.
		<p>
			Big thanks to <a href='profile.php?id=115' style='font-weight:bold'>MitteKeegi</a> for his activity and his efforts to make estonian
			community so big.
		</p>
		<p>
			As you can see, it is not so hard to make things happen here. All you need to do is help your cummunity grow.
		</p>
		<div class='newsBottom'>Posted by <a href='profile.php?id=88'>Trusis</a><br>On: 06.03.2010</div>
	</p>
	</div>
	<div style='overflow: hidden;'>
	<h2>New information</h2>
	<p>
		We have added some new parts in manual - weekly schedule and leagues. There you can find out, how things will happen. I would like to remind, that first seasons league draw will happen on 13.03.2010. Then you will be able to see your future fixtures and your league. At the beggining there will be one league - World (1-1-2-4-8).  All teams will be randomized in 3rd, 4th and 5th lvls. Currently we are working on some other parts of manual and game.
	</p>
	<p>
About countries -

Currently there's only 16 countries from Europe, but that count will be extended world wide, when there will be enough active members.

We have decided to add Estonia as country due to activity of Estonian community. As we noted before, we are looking for at least 20 users to add their country. If you would like to speed up that process, you can advertise OSM in your local forums. But please avoid spamming. 
	<div class='newsBottom'>Posted by <a href='profile.php?id=89'>Karalis</a><br>On: 06.03.2010</div>
	</p>
	</div>
	<div style='overflow: hidden;'>
		<h2>Welcome to OneSkillManager! </h2>
		<p>  OSM is new football manager game. Currently we are waiting for users to sing up for their teams. First season of OSM will start after two weeks on 16.03.2010. During this time you can do a lot of things:
	<ul>
		<li>read manual</li>
		<li>set line-up and tactics</li>
		<li>pull youths</li>
		<li>maybe you need some staff?</li>
		<li>take a part in our forums</li>
		<li>choose your training priority</li>
		<li>and one of the most interesting - you can play two friendly games each day!</li>
	</ul>
		In these two weeks your team will not receive training, economy updates and players won't loose energy. At the begginig you will recieve 1 000 000€. We highly suggest to read manual to use that moneay wisely. If you have any questions don't be afraid to ask our admins <a href='profile.php?id=89'>Karalis</a> and <a href='profile.php?id=88'>Trusis</a>.
		<div class='newsBottom'>Posted by <a href='profile.php?id=88'>Trusis</a><br>On: 03.03.2010</div>
		</p>
	</div>
	</div>
	"; 
	?>
	</div>
	<div id='bottom'>
		<?php print $bottom; ?>
	</div>
</div>
</body>
</html>
