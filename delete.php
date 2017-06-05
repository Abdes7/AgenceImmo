<?php
  session_start();
if (isset($_SESSION['login']))
{
}else{
    header('location:login.php');
}
?>
<?php
require_once("db.php");
$pdo_statement=$pdo_conn->prepare("delete from posts where id=" . $_GET['id']);
$pdo_statement->execute();
header('location:dashboard.php');
?>
