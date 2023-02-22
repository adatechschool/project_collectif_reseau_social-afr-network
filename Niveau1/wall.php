<?php
require ('connexion_bdd.php');
session_start();
?>
<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>ReSoC - Mur</title> 
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" href="style.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    </head>
    <body>
	<div class="d-flex justify-content-end ">
		<?php include_once('header.php') ?>
		
		<div id="wrapper" class="d-flex flex-row-reverse w-75">
		    <?php
		    /**
		     * Etape 1: Le mur concerne un utilisateur en particulier
		     * La première étape est donc de trouver quel est l'id de l'utilisateur
		     * Celui ci est indiqué en parametre GET de la page sous la forme user_id=...
		     * Documentation : https://www.php.net/manual/fr/reserved.variables.get.php
		     * ... mais en résumé c'est une manière de passer des informations à la page en ajoutant des choses dans l'url
		     */
		    $userId =intval($_GET['user_id']);
            //include_once('connexion_bdd.php');

		    ?>
			
		    <aside class="w-25">
			<?php
			/**
			 * Etape 3: récupérer le nom de l'utilisateur
			 */                
			$laQuestionEnSql = "SELECT * FROM users WHERE id= '$userId' ";
			$lesInformations = $mysqli->query($laQuestionEnSql);
			$user = $lesInformations->fetch_assoc();
			//@todo: afficher le résultat de la ligne ci dessous, remplacer XXX par l'alias et effacer la ligne ci-dessous
			//echo "<pre>" . print_r($user, 1) . "</pre>";
			?>
			<img class="w-25" src="user.jpg" alt="Portrait de l'utilisatrice"/>
			<section>
			    <h3>Présentation</h3>
			    <p>Sur cette page vous trouverez tous les messages de l'utilisatrice : <?php echo $user["alias"] ?></p>
			</section>
		    </aside>

		    <main class="w-50">
			<?php
			/**
			 * Etape 3: récupérer tous les messages de l'utilisatrice
			 */
			$laQuestionEnSql = "
			    SELECT posts.content, posts.created, users.alias as author_name, 
			    COUNT(likes.id) as like_number, GROUP_CONCAT(DISTINCT tags.label) AS taglist 
			    FROM posts
			    JOIN users ON  users.id=posts.user_id
			    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
			    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
			    LEFT JOIN likes      ON likes.post_id  = posts.id 
			    WHERE posts.user_id='$userId' 
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
			 */
			while ($post = $lesInformations->fetch_assoc()){
			    //echo "<pre>" . print_r($post, 1) . "</pre>";
			    ?>                
			    <article>
					<h3>
						<time datetime='<?php echo $post["created"] ?>' ><?php echo $post["created"] ?></time>
					</h3>
					<address><?php echo $post["author_name"] ?></address>
					<div>
						<p><?php echo $post["content"] ?></p>
					</div>  

				<footer>
				<small>♥ <?php echo $post["like_number"] ?></small>
				<a href="">#<?php echo $post["taglist"] ?></a>

                <?php //echo "<pre>" . print_r($post, 1) . "</pre>";?>                
                    <article>
                        <h3>
							<time datetime='<?php echo $post["created"] ?>' ><?php echo $post["created"] ?></time>
                        </h3>
				<address>
					<?php echo $post["author_name"] ?>
				</address>
                <div>
					<p><?php echo $post["content"] ?></p>
                </div>                                            
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
