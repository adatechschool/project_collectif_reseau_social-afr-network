<?php require ('connexion_bdd.php');?>
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
        <?php include_once('header.php') ?>
         
        <div id="wrapper" class="w-75 d-flex flex-row-reverse">
		    <aside class="border border-dark">

		<!-- Search form -->
		<div class="w-100 active-pink-4 mb-2">

		  <input class="form-control rounded-pill" type="text" placeholder="Search" aria-label="Search">

		</div>

			    <h3>Tendances pour vous</h3>
				<!--@todo remplire par les mots clés du bdd -->
				<ul>
					<li><a href="#">#tags </a></li>
					<li><a href="#">#tags </a></li>
					<li><a href="#">#tags </a></li>
					<li><a href="#">#tags </a></li>
					<li><a href="tags.php?tag_id=1">#Mots-clés</a></li>
				</ul>
			</section>
		    </aside>
            <main>
            <?php include('addlike.php'); ?>

                <?php
                /*
                  // C'est ici que le travail PHP commence
                  // Votre mission si vous l'acceptez est de chercher dans la base
                  // de données la liste des 5 derniers messsages (posts) et
                  // de l'afficher
                  // Documentation : les exemples https://www.php.net/manual/fr/mysqli.query.php
                  // plus généralement : https://www.php.net/manual/fr/mysqli.query.php
                 */


                // Etape 1: Ouvrir une connexion avec la base de donnée.

                include_once('connexion_bdd.php');

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
                    posts.id as post_id,
                    posts.created,
                    users.alias as author_name,
                    posts.user_id, 
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

                // Etape 3: Parcourir ces données et les ranger bien comme il faut dans du html
                // NB: à chaque tour du while, la variable post ci dessous reçois les informations du post suivant.
                while ($post = $lesInformations->fetch_assoc())
                {
                    //la ligne ci-dessous doit etre supprimée mais regardez ce 
                    //qu'elle affiche avant pour comprendre comment sont organisées les information dans votre 
                    //echo "<pre>". print_r ($post, 1) ."<pre>";

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

            <!-- Pour linker le nom de l'utilisateur à son mur -->
			<address><a href="wall.php?user_id=<?php echo $post['user_id'] ?>"><?php echo $post['author_name'] ?></a></address>

			<div>
			    <p><?php echo $post['content'] ?></p>
			</div>

			<div class="d-flex bg-secondary justify-content-between">

			<div>

            <footer>
                            <small>
                                <form action="news.php" method="post">
                                    <input type='hidden' name='post_id' value="<?php echo $post['post_id'] ?>">   
                                    <input type='submit' value="♥ <?php echo $post['like_number'] ?>">
                                </form>
                            </small>
                            <?php include('tagLinks.php') ?>
                        </footer>

					<?php echo $post['like_number'] ?>

				</div>
				<div>
					<a href=""><?php echo $post['taglist'] ?></a>,
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
