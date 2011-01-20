<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?PHP
include("mysql.php");
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<script type="text/javascript"> </script>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<meta name="viewport" content="initial-scale=1.0, width=device-width, user-scalable=no" />
	<meta name="format-detection" content="telephone=no" />
	<link rel="apple-touch-icon" href="img/icon.png" />
	<link rel="apple-touch-startup-image" href="img/splash.png" />
	<link rel="stylesheet" type="text/css" href="kahls.css" />
	<title>Kaffe på Kahls</title>
</head>
<body>

<h1><a href="/"><img src="img/logo.png" style="margin: auto"/></a></h1>

<?PHP

// Om formuläret är skickat, kontrollera att minst två deltagare är valda
if (!empty($_POST['submit'])) {
	if (count($_POST['people']) < 2) {
		echo "<h2>Ange minst två deltagare!</h2>";
	}
	else {
		// Skriv kod för att avgöra vem som betalat minst ggr.
		// Om samma antal, den som inte betalat på längst tid betalar
		
		// Antal deltagare
		echo "<p>" . count($_POST['people']) . " deltagare.</p>";

		// För varje deltagare, räkna antalet gånger han betalat
		foreach($_POST['people'] as $bitch) {
			$query = "SELECT COUNT(date) AS count FROM kahls WHERE sugardaddy=" . $bitch;
			$result = mysql_fetch_array(mysql_query($query));
			echo "<p>ID=" . $bitch . " har betalat " . $result['count'] . "ggr.</p>";
			$deltagare[$bitch] = $result['count'];
		}
		
		// Jämför antalet gånger per deltagare
		// Om en deltagare har < näst minst, låt honom betala
		// Om en deltagare har <= näst minst, jämför datum
		
		// SQL
		// Ta fram alla besökare per tillfälle:
		/*
		SELECT b.id, b.name
		FROM bitches AS b
		LEFT JOIN kahls_bitches AS kb ON kb.bitches_id = b.id
		LEFT JOIN kahls AS k ON k.id = kb.kahls_id
		WHERE kb.kahls_id =  '3'
		*/
		// Ta fram besökarna vid valt tillfälle med id, namn, gånger de betalat tidigare
		// samt datum för senaste betalning.
		/*
		SELECT kb.bitches_id, b.name, COUNT(kk.sugardaddy) AS times_paid,
		MAX(kk.date) AS last_paid
		FROM kahls AS k
		LEFT JOIN kahls_bitches AS kb
		ON kb.kahls_id = k.id
		LEFT JOIN kahls AS kk
		ON kb.bitches_id = kk.sugardaddy
		LEFT JOIN bitches AS b
		ON b.id = kb.bitches_id
		WHERE k.id = 3
		GROUP BY kb.bitches_id
		ORDER BY times_paid ASC, last_paid ASC;
		*/
?>
<h2>betalar idag!</h2>

<hr />

<form action="/" method="post">
	<input type="hidden" name="originalBitch" value="" />
	<h2>...Eller betalade någon annan ändå?
	<select name="vembetalade">
		<option value="false">-</option>
<?PHP
	$query = "SELECT * FROM bitches";
	$result = mysql_query($query);
	while ($bitch = mysql_fetch_array($result)) {
?>
		<option value="<?=$bitch['id']?>"><?=$bitch['name']?></option>
<?PHP
	}
?>
	</select></h2>
	<h1><input type="submit" name="betala" value="Betala!" class="submit" /></h1>
</form>
<?PHP
	}
}
// Om betalning gjorts, kontrollera datat och utför skrivningen
elseif (!empty($_POST['betala'])) {
	
}
// Default. Printa ut alla deltagare, skicka dessa som formulär tillbaka till sidan
else {
?>

<h2>Ange deltagare:</h2>

<form action="/" method="post">
<?PHP
	$query = "SELECT * FROM bitches";
	$result = mysql_query($query);
?>
	<ul>
<?PHP
	while ($bitch = mysql_fetch_array($result)) { ?>
		<li><input type="checkbox" name="people[]" value="<?=$bitch['id']?>" id="people_<?=$bitch['id']?>" class="checkbox" /><label for="people_<?=$bitch['id']?>"> <?=$bitch['name']?></a></li>
<?PHP
	}
?>
	</ul>

	<input type="submit" name="submit" value="Vem ska betala?" class="submit" />
</form>

<?PHP
}
?>

</body>
</html>
