
<?php
session_start();
?>

<header class="w-25 d-flex flex-column">
<nav class="navbar position-fixed navbar-expand-lg w-25 h-75 d-flex justify-content-end navbar-light bg-light">
  <div class="container-fluid d-flex flex-column h-100 ">
    <a class="navbar-brand d-flex justify-content-center" href="#"><img class="w-25" src="afrnetwork.jpg" alt="Logo de notre réseau social"/>
    </a>

      <div class="collapse navbar-collapse h-75" id="navbarSupportedContent d-flex flex-column">
      <ul class="navbar-nav me-auto h-100 mb-2 mb-lg-0 d-flex flex-column">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Accueil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Liens</a>
        </li>
  	<li class="nav-item"> 
	<a class="nav-link" href="news.php?user_id=<?php echo $_SESSION['connected_id']?>">Actualités</a>
	</li>
	<li class="nav-item">
	<a class="nav-link" href="wall.php?user_id=<?php echo $_SESSION['connected_id']?>">Mur</a>
	</li>
	<li class="nav-item">
	<a class="nav-link" href="feed.php?user_id=<?php echo $_SESSION['connected_id']?>">Flux</a>
	</li>       
  <?php echo session_id()?>
  <?php echo $_SESSION['connected_id']?>

	<li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
		profile
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">

	    <li><a class="dropdown-item" href="settings.php?user_id=<?php echo $_SESSION['connected_id']?>">Paramètres</a></li>
	    <li><a class="dropdown-item" href="followers.php?user_id=<?php echo $_SESSION['connected_id']?>">Mes abonnements</a></li>
	    <li><a class="dropdown-item" href="subscriptions.php?user_id=<?php echo $_SESSION['connected_id']?>">Mes suiveurs</a></li>
    	    <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Déconnexion</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
</header>

