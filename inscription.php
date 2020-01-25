   
<?php



$host = "localhost";
$user ="root";
$password = "";
$bdd = "espace-membre";

//------------------------------------------------------------------------------------------------
function connect_to_db(){
	global $host, $user, $password, $bdd;
	
	$link_db = mysqli_connect($host, $user, $password, $bdd);
	if (!$link_db) {
    die('Erreur de connexion : '.$host.' -  '.$user.' - '.$password.' - '.$bdd.' (' . mysqli_connect_errno() . ') '
            . mysqli_connect_error());
	}
	
	return $link_db;
}



//--------------------------------------------------------------------------------------------
function close_db($link_db){
	mysqli_close($link_db);
}


//---------------------------------------------------------------------------------------------------
function insert_membres($pseudo, $mail,$mdp)

{
	$link_db=connect_to_db();
	
	$sql = "INSERT INTO membres ( 
				pseudo,
				mail,
				motdepasse

				)
								
			VALUES	('".$pseudo."', '".$mail."', '".$mdp."')";

	//$mysqli->set_charset("SET NAMES utf8");
	if(!mysqli_query($link_db, $sql)){
		printf("erreur : %s\n\n"."<br>".$sql."<br>", mysqli_error($link_db));
	}
	

	
	$link_db->close();
}




//Point d'entrée
//------------------------------------------------------------------------------------------------



if (!empty($_POST['pseudo']) and !empty($_POST['mail']) and !empty($_POST['mdp'])){
  $pseudo = $_POST['pseudo'];
  $mail = $_POST['mail'];
  $mail2 = $_POST['mail2'];
  $mdp = sha1($_POST['mdp']);
  $mdp2 = sha1($_POST['mdp2']);


if (($mdp == $mdp2) and ($mail == $mail2)) {


			   $reqmail = $?->prepare("SELECT * FROM membres WHERE mail = ?");
               $reqmail->execute(array($mail));
               $mailexist = $reqmail->rowCount();
               if($mailexist == 0) {

	insert_membres($pseudo, $mail, $mdp);

}
else {
	$erreur = "vous avez deja un compte";
}
}

}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>inscription</title>
	<link rel="stylesheet" type="text/css" href="css/inscription.css">
</head>
<body>
  <div align="center">


  	<h2>inscription</h2>
  	<br /><b />

  	<form method="POST" action="">
	  		<table>
		  		<tr>
		  			<td align="right">
		  			<label for="pseudo">votre pseudo :</label>
		  			</td>
		  			<td>
		  			<input type="text" placeholder="votre pseudo" name="pseudo" id="pseudo" value="<?php if(isset($pseudo)){echo($pseudo);} ?>"/>
		  			
		  			</td>
		  		</tr>	
		  		<tr>
		  			<td align="right">
		  			<label for="mail">votre mail:</label>
		  			</td>
		  			<td>
		  			<input type="text" placeholder="votre mail" name="mail" id="mail" value="<?php if(isset($mail)) {echo($mail);} ?>"/>
		  			</td>
		  		</tr>	
		  			<tr>
		  			<td align="right">
		  			<label for="mail2">confirmer votre mail:</label>
		  			</td>
		  			<td>
		  			<input type="email" placeholder="confirmer votre mail" name="mail2" id="mail2">
		  			</td>
		  		</tr>	
		  				<tr>
		  			<td align="right">
		  			<label for="mdp">mot de passe:</label>
		  			</td>
		  			<td>
		  			<input type="password" placeholder="mot de passe" name="mdp" id="mdp">
		  			</td>
		  		</tr>	
		  				<tr>
		  			<td align="right">
		  			<label for="mdp2">confirmer votre mot de passe:</label>
		  			</td>
		  			<td>
		  			<input type="password" placeholder="confirmer votre mot de passe" name="mdp2" id="mdp2">
		  			</td>
		  		</tr>
		  		<tr>
		  			<td></td>
		  			<td align="center">
		  				<br>
		  				<input type="submit" name="forminscription" value="je m inscrie">	
		  			</td>
		  		</tr>
		  	</table>
  		</form>
  		<?php 

  		if (isset($erreur)) {
  			echo '<a class="red">'.$erreur.'</a>';
  		}

  		 ?>
  </div>
</body>
</html>