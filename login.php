<?php
define("ROW_PER_PAGE",2);
require_once('db.php');
?>

<?php
session_start();
$conn = mysqli_connect("localhost","root","root","pfe_db");

$message="";
if(!empty($_POST["login"])) {
	$result = mysqli_query($conn,"SELECT * FROM user WHERE login='" . $_POST["user_name"] . "' and password = '". $_POST["password"]."'");
	$row  = mysqli_fetch_array($result);

	if(is_array($row)) {
	$_SESSION["login"] = $row['id'];
	} else {
	$message = "Invalid Username or Password!";
	}
}
if(!empty($_POST["logout"])) {
	$_SESSION["login"] = "";
	session_destroy();
}
?>
<!DOCTYPE html>
<html>
    <?php include 'header.php'; ?>
    <body id="top">
        <?php include 'navigation.php'; ?>
        <?php if(empty($_SESSION["login"])) { ?>
        <div id="content">
            <div class="container">
                <div class="row">
                    <div>
                      <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">Se connecter</h4>
                          </div>
                          <div class="modal-body">
                            <form role="form" action="" method="post" id="frmLogin">
                              <?php if(!empty($message)) { ?>
                                <div class="alert alert-danger">  <?php echo $message; ?>  </div>
                              <?php } ?>
                              <div class="form-group">
                                <label for="emailAddress">Nom d'utilisateur</label>
                                <input type="text" name="user_name" class="form-control input-lg" placeholder="Nom d'utilisateur">
                              </div>
                              <div class="form-group">
                                <label for="password">Mot de passe</label>
                                <input type="password" name="password" class="form-control input-lg" placeholder="mot de passe">
                              </div>
                              <div class="modal-footer">
                                <input type="submit" class="btn btn-warning btn-block btn-lg" value="Se connecter" name="login">
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } else {
            header('location:dashboard.php');
        } ?>
        <?php include 'footercontent.php'; ?>
        <?php include 'footerscript.php'; ?>
    </body>
</html>
