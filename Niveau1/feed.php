<?php include_once ('connexion_bdd.php') ?>
<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>ReSoC - Flux</title>         
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" href="style.css"/>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    </head>
    <body>

	<div class="d-flex justify-content-end">
        	<?php include_once('header.php') ?>
		<div id="wrapper" class="d-flex flex-row-reverse w-75">
		    <?php
		    /**
		     * Cette page est TRES similaire à wall.php. 
		     * Vous avez sensiblement à y faire la meme chose.
		     * Il y a un seul point qui change c'est la requete sql.
		     */
		    /**
		     * Etape 1: Le mur concerne un utilisateur en particulier
		     */
		    $userId = intval($_GET['user_id']);
		    ?>


		    <aside>
			<?php
			/**
			 * Etape 3: récupérer le nom de l'utilisateur
			 */
			$laQuestionEnSql = "SELECT * FROM `users` WHERE id= '$userId' ";
			$lesInformations = $mysqli->query($laQuestionEnSql);
			$user = $lesInformations->fetch_assoc();
			//@todo: afficher le résultat de la ligne ci dessous, remplacer XXX par l'alias et effacer la ligne ci-dessous
			//echo "<pre>" . print_r($user, 1) . "</pre>";
			?>
			<img class="w-25" src="user.jpg" alt="Portrait de l'utilisatrice"/>
			<section>
			
			    <h3>Présentation</h3>
			    <p>Sur cette page vous trouverez tous les message des utilisatrices
				auxquel est abonnée l'utilisatrice <?php echo $user["alias"] ?> 
			    </p>

			</section>
		    </aside>
		    <main>
			<?php
			/**
			 * Etape 3: récupérer tous les messages des abonnements
			 */
			$laQuestionEnSql = "
			    SELECT posts.content,
			    posts.created,
			    users.alias as author_name,  
			    count(likes.id) as like_number,  
			    GROUP_CONCAT(DISTINCT tags.label) AS taglist 
			    FROM followers 
			    JOIN users ON users.id=followers.followed_user_id
			    JOIN posts ON posts.user_id=users.id
			    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
			    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
			    LEFT JOIN likes      ON likes.post_id  = posts.id 
			    WHERE followers.following_user_id='$userId' 
			    GROUP BY posts.id
			    ORDER BY posts.created DESC  
			    ";
			$lesInformations = $mysqli->query($laQuestionEnSql);
			if ( ! $lesInformations)
			{
			    echo("Échec de la requete : " . $mysqli->error);
			}
			
			
			/**
			 * Etape 4: @todo Parcourir les messsages et remplir correctement le HTML avec les bonnes valeurs php
			 * A vous de retrouver comment faire la boucle while de parcours...
			 */
			
			while($message = $lesInformations->fetch_assoc())
			{
				//echo "<pre>" . print_r($message, 1) . "</pre>"
			?>                
			<article>
			    <h3>
			    <time datetime='<?php echo $message["created"] ?>' > <?php echo $message["created"] ?> </time>
			    </h3>
			    
			    <address> <?php echo $message["author_name"] ?> </address>
			    <div>
			    <p> <?php echo $message["content"] ?> </p>
			    </div>                                            
			    <footer>

			    <small>♥ <?php echo $message["like_number"] ?></small>

			    <a href="">#<?php echo $message["taglist"] ?></a>,


			    </footer>
			</article>
			<?php } ?>

		    </main>
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    </body>
</html>
