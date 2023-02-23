
<?php include_once('connexion_bdd.php') ?>
session_start();
?>
<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>ReSoC - Post d'usurpateur</title> 
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" href="style.css"/>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    </head>
    <body>
	<div class="d-flex justify-content-end">
		<?php include_once('header.php') ?>
		<div id="wrapper" class="d-flex flex-row-reverse w-75">

		    <aside>
			<h2>Présentation</h2>
			<p>Sur cette page on peut poster un message en se faisant 
			    passer pour quelqu'un d'autre</p>
		    </aside>
		    <main>
			<article>
			    <h2>Poster un message</h2>
			    <?php
			    /**
			     * BD
			     */
			    
			    /**
			     * Récupération de la liste des auteurs
			     */
			    $listAuteurs = [];
			    $laQuestionEnSql = "SELECT * FROM users";
			    $lesInformations = $mysqli->query($laQuestionEnSql);
			    while ($user = $lesInformations->fetch_assoc())
			    {
				$listAuteurs[$user['id']] = $user['alias'];
			    }


			    /**
			     * TRAITEMENT DU FORMULAIRE
			     */
			    // Etape 1 : vérifier si on est en train d'afficher ou de traiter le formulaire
			    // si on recoit un champs email rempli il y a une chance que ce soit un traitement
			    $enCoursDeTraitement = isset($_POST['auteur']);
			    if ($enCoursDeTraitement)
			    {
				// on ne fait ce qui suit que si un formulaire a été soumis.
				// Etape 2: récupérer ce qu'il y a dans le formulaire @todo: c'est là que votre travaille se situe
				// observez le résultat de cette ligne de débug (vous l'effacerez ensuite)
				echo "<pre>" . print_r($_POST, 1) . "</pre>";
				// et complétez le code ci dessous en remplaçant les ???
				$authorId = $_POST['auteur'];
				$postContent = $_POST['message'];


				//Etape 3 : Petite sécurité
				// pour éviter les injection sql : https://www.w3schools.com/sql/sql_injection.asp
				$authorId = intval($mysqli->real_escape_string($authorId));
				$postContent = $mysqli->real_escape_string($postContent);
				//Etape 4 : construction de la requete
				$lInstructionSql = "INSERT INTO posts "
					. "(id, user_id, content, created, parent_id) "
					. "VALUES (NULL, "
					. $authorId . ", "
					. "'" . $postContent . "', "
					. "NOW(), "
					. "NULL);"
					;
				//echo $lInstructionSql;
				// Etape 5 : execution
				$ok = $mysqli->query($lInstructionSql);
				if ( ! $ok)
				{
				    echo "Impossible d'ajouter le message: " . $mysqli->error;
				} else
				{
				    echo "Message posté en tant que :" . $listAuteurs[$authorId];
				}
			    }
			    ?>                     
			    <form action="usurpedpost.php" method="post">
				<input type='hidden' name='???' value='achanger'>
				<dl>
				    <dt><label for='auteur'>Auteur</label></dt>
				    <dd><select name='auteur'>
					    <?php
					    foreach ($listAuteurs as $id => $alias)
						echo "<option value='$id'>$alias</option>";
					    ?>
					</select></dd>
				    <dt><label for='message'>Message</label></dt>
				    <dd><textarea name='message'></textarea></dd>
				</dl>
				<input type='submit'>
			    </form>               
			</article>
		    </main>
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>


              


    </body>
</html>
