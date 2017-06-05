<?php

require_once("db.php");
  $postid = $_GET["id"];
  $getposts = $pdo_conn->prepare("SELECT * FROM posts WHERE id = $postid");
  $getposts->execute();
  $posts = $getposts->fetchAll();
  foreach ($posts as $post) {}

  if ($post['validation'] == '0') {
    $pdo_statement=$pdo_conn->prepare("update posts set validation = '1' where id=" . $_GET["id"]);
    $result = $pdo_statement->execute();
    if($result) {
    	header('location:dashboard.php');
    }
  }

  if ($post['validation'] == '1') {
    $pdo_statement=$pdo_conn->prepare("update posts set validation = '0' where id=" . $_GET["id"]);
    $result = $pdo_statement->execute();
    if($result) {
    	header('location:dashboard.php');
    }
  }
?>
