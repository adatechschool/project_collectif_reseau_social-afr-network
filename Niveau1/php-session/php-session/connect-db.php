<?php
session_start();

$pdo = new PDO('mysql:host=localhost:3306;dbname=socialnetwork', 'root', 'root', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);