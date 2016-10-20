<!DOCTYPE html>
	<head>
	    <meta charset="utf-8" />
	    <title>Formulaire HTML</title>
	</head>
	<body>
		<?php
		$verif = false;
		$tab_bachelor = array("dev","business","design");
		foreach($_POST as $key=>$value)
		{
			if(!empty($_POST[$key] && $key != "send")){
				$verif = true;
			} 
		}
		if(!$verif && isset($_POST["send"]))
			$tab_error["data"] ="Aucune donnée reçu";

		function display_error($champ, $code){
			switch ($code) {
				case 0:
					return "Le champ ".$champ." ne doit pas être vide";
				case 1:
					return  "Le champ ".$champ." ne peut contenir que des caractères alphabétiques";
					break;
				case 2:
					return "Le champ ".$champ." doit être une adresse mail valide";
					break;
				case 3:
					return "Le champ ".$champ." ne doit contenir que des caractères numériques";
					break;
				case 4:
					return "Le champ ".$champ." ne doit contenir que les mots dev, business ou design";
					break;
				case 5:
					return "Le champ ".$champ." doit contenir au moins 8 caractères";
					break;
				case 6:
					return "Le champ ".$champ." doit être identique au mot de passe";
					break;
				case 7:
					return "Vous ne pouvez sélectionner que 2 livres maximum";
					break;
			}
		}
/**** Verification prenom ****/
		if($verif){
			empty($_POST['prenom']) ? $tab_error["prenom"] = display_error("prenom",0) : ctype_alpha($_POST["prenom"]) ? $prenom = $_POST["prenom"] : $tab_error["prenom"] = display_error("prenom",1);

			empty($_POST['nom']) ? $tab_error["nom"] = display_error("nom",0) : ctype_alpha($_POST["nom"]) ? $nom = $_POST["nom"] : $tab_error["nom"] =display_error("nom",1) ;

			empty($_POST['email']) ? $tab_error["email"] = display_error("email",0) : filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) ? $email = $_POST["email"] : $tab_error["email"] = display_error("email",2);

			empty($_POST['age']) ? $tab_error["age"] = display_error("age",0) : ctype_digit($_POST["age"]) ? $age = $_POST["age"] : $tab_error["age"] =  display_error("age",3) ;

			empty($_POST['bachelor']) ? $tab_error["bachelor"] = display_error("bachelor",0) : in_array($_POST['bachelor'],$tab_bachelor) ? $bachelor= $_POST["bachelor"] : $tab_error["bachelor"] = display_error("bachelor",4) ;
			empty($_POST['pass']) ? $tab_error["pass"] = display_error("mot de passe",0) : (strlen($_POST["pass"]) > 7) ? $pass= $_POST["pass"] : $tab_error["pass"] = display_error("mot de passe",5);

			empty($_POST['verif_pass']) ? $tab_error["verif_pass"] = display_error("verif_pass", "verification mot de passe",0) : ($_POST["verif_pass"] == $pass) ? $verif_pass= $_POST["pass"] : $tab_error["verif_pass"] = display_error("verification mot de passe",6);
			empty($_POST['gender']) ? $tab_error["gender"] = display_error("sexe",0) : $gender= $_POST["gender"];
			empty($_POST['texte']) ? $tab_error["texte"] =  display_error("texte",0) : $texte= $_POST["texte"];
			if(isset($_POST['livre']) == false){
				$tab_error["livre"] =  display_error("livre",0) ;
			}
			else if (count($_POST['livre']) < 3){
				$livre= $_POST["livre"];
			}
			else{
				$tab_error["livre"] = display_error("livre",7);
			}
		}

		?>

		<form method="POST" action="control.php">
			<table>
				<tr><td colspan="3"><?php if(isset($tab_error["data"])) echo $tab_error["data"] ?></td></tr>
				<tr>
					<td>Prénom:</td><td><input type="text" name="prenom" value="<?php if(isset($_POST['prenom']))echo $_POST['prenom'] ?>" ></td><td><?php if(isset($tab_error["prenom"])) echo $tab_error["prenom"] ?></td>
				</tr>
				<tr>
					<td>Nom: </td><td><input type="text" value="<?php if(isset($_POST['nom'])) echo $_POST['nom'] ?>" name="nom"></td><td><?php  if(isset($tab_error["nom"])) echo $tab_error["nom"] ?></td>
				</tr>
				<tr>
					<td>E-mail: </td><td><input type="text" value="<?php if(isset($_POST['email']))echo $_POST['email'] ?>" name="email"></td><td><?php  if(isset($tab_error["email"])) echo $tab_error["email"] ?></td>
				</tr>
				<tr>
					<td>Age: </td><td><input type="text" value="<?php if(isset($_POST['age']))echo $_POST['age'] ?>" name="age"></td><td><?php  if(isset($tab_error["age"])) echo $tab_error["age"] ?></td>
				</tr>
				<tr> 
					<td>Diplôme:</td><td> <input type="text" value="<?php if(isset($_POST['bachelor']))echo $_POST['bachelor'] ?>" name="bachelor"></td><td><?php  if(isset($tab_error["bachelor"])) echo $tab_error["bachelor"] ?></td>
				</tr>
				<tr>
					<td>Mots de passe: </td><td><input type="password" name="pass"></td><td><?php  if(isset($tab_error["pass"])) echo $tab_error["pass"] ?></td>
				</tr>
				<tr>
					<td>Verifier mots de passe:</td><td> <input type="password" name="verif_pass"></td><td><?php  if(isset($tab_error["verif_pass"])) echo $tab_error["verif_pass"] ?></td>
				</tr>
				<tr>
				<?php if(!empty($_POST['gender'])){
					$gender= $_POST['gender'];
				} else {
					$gender = "";
				}
				?>
				<td>Sexe:</td><td> <input type= "radio" name="gender" value="Homme" <?php if($gender == "Homme") echo "checked" ?> > Homme
					  	 		   <input type= "radio" name="gender" value="Femme" <?php if($gender == "Femme") echo "checked" ?>  > Femme</td><td><?php  if(isset($tab_error["gender"])) echo $tab_error["gender"] ?></td>
				</tr>
				<tr>
					<td>Texte: </td><td><textarea name="texte" rows="4" cols="15" placeholder="Ecrire un commentaire..." ><?php if(isset($_POST['texte']))echo $_POST['texte'] ?></textarea></td><td><?php  if(isset($tab_error["texte"])) echo $tab_error["texte"] ?></td>
				</tr>
				<tr>
					<td>Selectionner vos volumes préférés<br> de la trilogie du voyageur galactique</td>
					<td>
					<input type="checkbox" name="livre[1]" value="Le Guide du voyageur galactique" <?php if(isset($_POST['livre'][1]))echo "checked" ?> > Le Guide du voyageur galactique<br>
					<input type="checkbox" name="livre[2]" value="Le Dernier Restaurant avant la fin du monde" <?php if(isset($_POST['livre'][2]))echo "checked" ?>> Le Dernier Restaurant avant la fin du monde<br>
					<input type="checkbox" name="livre[3]" value="La Vie, l\'Univers et le Reste" <?php if(isset($_POST['livre'][3]))echo "checked" ?>> La Vie, l'Univers et le Reste<br>
					<input type="checkbox" name="livre[4]" value="Salut, et encore merci pour le poisson" <?php if(isset($_POST['livre'][4]))echo "checked" ?>> Salut, et encore merci pour le poisson<br>
					<input type="checkbox" name="livre[5]" value="Globalement inoffensive" <?php if(isset($_POST['livre'][5]))echo "checked" ?>> Globalement inoffensive<br></td><br><td><?php  if(isset($tab_error["livre"])) echo $tab_error["livre"] ?></td>
				</tr>
				<tr>
					<td></td><td><input type="submit" name="send"></td>
				</tr>
			</table>
		</form>
		<?php if(!isset($tab_error) && isset($_POST["send"])) {
			echo "
			<table border='1'>
				<tr>
					<td>Nom:</td><td>$nom</td>
				</tr>
				<tr>
					<td>Prénom:</td><td>$prenom</td>
				</tr>
				<tr>
					<td>E-mail:</td><td>$email</td>
				</tr>
				<tr>
					<td>Bachelor:</td><td>$bachelor</td>
				</tr>
				<tr>
					<td>Age:</td><td>$age</td>
				</tr>
				<tr>
					<td>Mot de passe:</td><td>$pass</td>
				</tr>
				<tr>
					<td>Sexe:</td><td>$gender</td>
				</tr>
				<tr>
					<td>Texte:</td><td>$texte</td>
				</tr>
				<tr>
					<td>Livres préférés:</td>
					<td>";
					if(isset($livre)){
						foreach ($livre as $key => $value) {
							if($key != 0){
								echo ", ";
							}
							echo $value;
						}
					}
					echo"
					</td>
				</tr>
			</table>";
		}
		?>
	</body>
</html>
