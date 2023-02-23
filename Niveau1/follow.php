<?php 

$follow_sent = isset($_POST['post_user_id']);

var_dump($_POST);

if ($follow_sent) {

    echo "<pre>" . print_r($_POST, 1) . "</pre>";

$followedId = $_SESSION["connected_id"];
$followingId = $_POST['post_user_id'];
//echo "post_id".  $_POST['post_user_id'];
$verif_followsql = "SELECT * FROM followers WHERE followers.followed_user_id = '$followingId' AND followers.following_user_id = '$followedId' ";
$res = $mysqli->query($verif_followsql)->fetch_all();

if($res == []){
    $add_follow_sql = "INSERT INTO socialnetwork.followers (id, followed_user_id, following_user_id) 
    VALUES (NULL, '$followedId', '$followingId');";
    $ok = $mysqli->query($add_follow_sql);
    if(!$ok){
        echo "L'ajout du follower a échoué : " . $mysqli->error;
    }
    // echo "Cet utilisateur n'a jamais liké.";
} else {
    echo "<article> Vous avez suivez déjà ce profil.</article>";
}
}
?>
