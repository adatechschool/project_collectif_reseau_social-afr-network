
<?php// fichier inutile
if(!isset($_SESSION['connected_id'])){
    return header("Location: login.php");
    //die();
}else if(isset($_SESSION['connected_id'])){
     header("Location: /project_collectif_reseau_social-afr-network/Niveau1/wall.php");
}

?>