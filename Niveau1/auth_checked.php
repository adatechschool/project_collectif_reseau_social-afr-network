<?php

if(!isset($_SESSION['connected_id'])){
    return header("Location: /project_collectif_reseau_social-afr-network/Niveau1/login.php");
}else if(isset($_SESSION['connected_id'])){
   return header ("Location: /project_collectif_reseau_social-afr-network/Niveau1/wall.php?");
}

?>