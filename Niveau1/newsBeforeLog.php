<?php require ('connexion_bdd.php');
//verification
if ($mysqli->connect_errno)
{
    echo "<article>";
    echo("Échec de la connexion : " . $mysqli->connect_error);
    echo("<p>Indice: Vérifiez les parametres de <code>new mysqli(...</code></p>");
    echo "</article>";
    exit();
}
      // Etape 2: Poser une question à la base de donnée et récupérer ses informations
                // cette requete vous est donnée, elle est complexe mais correcte, 
                // si vous ne la comprenez pas c'est normal, passez, on y reviendra
                $laQuestionEnSql = "
                    SELECT posts.content,
                    posts.created,
                    users.alias as author_name,  
                    count(likes.id) as like_number,  
                    GROUP_CONCAT(DISTINCT tags.label) AS taglist 
                    FROM posts
                    JOIN users ON  users.id=posts.user_id
                    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
                    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
                    LEFT JOIN likes      ON likes.post_id  = posts.id 
                    GROUP BY posts.id
                    ORDER BY posts.created DESC  
                    LIMIT 5
                    ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                // Vérification
                if ( ! $lesInformations)
                {
                    echo "<article>";
                    echo("Échec de la requete : " . $mysqli->error);
                    echo("<p>Indice: Vérifiez la requete  SQL suivante dans phpmyadmin<code>$laQuestionEnSql</code></p>");
                    exit();
                }
            
                $lesInformations2 = $mysqli->query($laQuestionEnSql);
                // Vérification
                if ( ! $lesInformations2)
                {
                    echo "<article>";
                    echo("Échec de la requete : " . $mysqli->error);
                    echo("<p>Indice: Vérifiez la requete  SQL suivante dans phpmyadmin<code>$laQuestionEnSql</code></p>");
                    exit();
                }
            
?>
<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>ReSoC - Actualités</title> 
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" href="style.css"/>
	<!-- fontawsom pour l'icon  -->
	<script src="https://kit.fontawesome.com/9ff4db8985.js" crossorigin="anonymous"></script>
	<!-- bootstrap link css -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    </head>
    <body>

	<div class="d-flex justify-content-end">
	<!-- header -->
        <?php include_once('headerBeforeLog.php') ?>
         
        <div id="wrapper" class="w-75 d-flex flex-row-reverse">
		    <aside class="border border-dark">

		<!-- Search form -->
		<div class="w-100 active-pink-4 mb-2">

		  <input class="form-control rounded-pill" type="text" placeholder="Search" aria-label="Search">

		</div>

			    <h3>Tendances pour vous</h3>
				<!--@todo remplire par les mots clés du bdd -->
                 <?php
               while ($tags = $lesInformations2->fetch_assoc())
                {
                    ?>
				<ul>
					<li><a href="newsBeforeLog.php?tagslist=<?php echo $tags['taglist'] ?>">#<?php echo $tags['taglist'] ?></a></li>
				</ul>
               <?php }?> 
			</section>
		    </aside>
            <main>


                <?php
                /*
                  // C'est ici que le travail PHP commence
                  // Votre mission si vous l'acceptez est de chercher dans la base
                  // de données la liste des 5 derniers messsages (posts) et
                  // de l'afficher
                  // Documentation : les exemples https://www.php.net/manual/fr/mysqli.query.php
                  // plus généralement : https://www.php.net/manual/fr/mysqli.query.php
                 */

                // Etape 3: Parcourir ces données et les ranger bien comme il faut dans du html
                // NB: à chaque tour du while, la variable post ci dessous reçois les informations du post suivant.
                while ($post = $lesInformations->fetch_assoc())
                {
                    //la ligne ci-dessous doit etre supprimée mais regardez ce 
                    //qu'elle affiche avant pour comprendre comment sont organisées les information dans votre 


                    // @todo : Votre mission c'est de remplacer les AREMPLACER par les bonnes valeurs
                    // ci-dessous par les bonnes valeurs cachées dans la variable $post 
                    // on vous met le pied à l'étrier avec created
                    // 
                    // avec le ? > ci-dessous on sort du mode php et on écrit du html comme on veut... mais en restant dans la boucle
                    ?>
		    <article>

			<h3>
			    <time datetime="<?php echo $post['created'] ?>"><?php echo $post['created'] ?></time>
			</h3>

			<address><?php echo $post['author_name'] ?></address>

			<div>
			    <p><?php echo $post['content'] ?></p>
			</div>

			<div class="d-flex bg-secondary justify-content-between">

			<div>
			    <button type="button" class="border-0 bg-secondary" aria-label="Close">
			<i class="fa-regular fa-heart"></i>
			<svg class="icon-heart" xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M244 84L255.1 96L267.1 84.02C300.6 51.37 347 36.51 392.6 44.1C461.5 55.58 512 115.2 512 185.1V190.9C512 232.4 494.8 272.1 464.4 300.4L283.7 469.1C276.2 476.1 266.3 480 256 480C245.7 480 235.8 476.1 228.3 469.1L47.59 300.4C17.23 272.1 0 232.4 0 190.9V185.1C0 115.2 50.52 55.58 119.4 44.1C164.1 36.51 211.4 51.37 244 84C243.1 84 244 84.01 244 84L244 84zM255.1 163.9L210.1 117.1C188.4 96.28 157.6 86.4 127.3 91.44C81.55 99.07 48 138.7 48 185.1V190.9C48 219.1 59.71 246.1 80.34 265.3L256 429.3L431.7 265.3C452.3 246.1 464 219.1 464 190.9V185.1C464 138.7 430.4 99.07 384.7 91.44C354.4 86.4 323.6 96.28 301.9 117.1L255.1 163.9z"/></svg>
			</button>

					<?php echo $post['like_number'] ?>

				</div>
				<div>
					<a href="newsBeforeLog.php?tagslist= <?php echo $post['taglist'] ?>"><?php echo $post['taglist'] ?></a>,
				</div>
			</div>
		    </article>
		    <?php
                    // avec le <?php ci-dessus on retourne en mode php 
                }// cette accolade ferme et termine la boucle while ouverte avant.
                ?>

            </main>
        </div>
	</div>
	<script src="app.js"></script>
	<!-- bootsrap link js -->
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
	<!-- js app -->
    </body>
</html>
