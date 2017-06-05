<?php
  session_start();
if (isset($_SESSION['login']))
{
    header('location:dashboard.php');
}
?>
<?php
if(!empty($_POST["register-user"])) {
	/* Form Required Field Validation */
	foreach($_POST as $key=>$value) {
		if(empty($_POST[$key])) {
		$error_message = "All Fields are required";
		break;
		}
	}
	/* Password Matching Validation */
	if($_POST['password'] != $_POST['confirm_password']){
	$error_message = 'Passwords should be same<br>';
	}

	/* Validation to check if Terms and Conditions are accepted */
	if(!isset($error_message)) {
		if(!isset($_POST["terms"])) {
		$error_message = "Accept Terms and Conditions to Register";
		}
	}

	if(!isset($error_message)) {
		require_once("db.php");
		$type = '0'; //type = 0 Pour les Propiétairs

		$sql = "INSERT INTO user ( login, password, type ) VALUES ( :userName, :password, :type )";
		"INSERT INTO user (login, password, type) VALUES
			('" . $_POST["userName"] . "', '" . md5($_POST["password"]) . "', '0')";
		$pdo_statement = $pdo_conn->prepare( $sql );

		$result = $pdo_statement->execute( array(
			':userName'=>$_POST['userName'],
			':password'=>$_POST['password'],
			':type'=>$type) );

		if (!empty($result) ){
		  header('location:index.php');
		}
	}
}
?>
<!DOCTYPE html>
<html>
    <?php include 'header.php'; ?>
    <body id="top">
        <?php include 'navigation.php'; ?>
        <div id="content">
          <div class="container">
            <div class="row">

                <div>
                  <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">S'inscrire</h4>
                      </div>
                      <div class="modal-body">
                        <form role="form" name="frmRegistration" method="post" action="">
                            <?php if(!empty($success_message)) { ?>
                            <div class="alert alert-success"><?php if(isset($success_message)) echo $success_message; ?></div>
                            <?php } ?>
                            <?php if(!empty($error_message)) { ?>
                            <div class="alert alert-danger"><?php if(isset($error_message)) echo $error_message; ?></div>
                            <?php } ?>
                          <div class="form-group">
                            <input type="text" class="form-control input-lg" placeholder="Nom d'utilisateur" name="userName" value="<?php if(isset($_POST['userName'])) echo $_POST['userName']; ?>">
                          </div>
                          <div class="form-group">
                            <input type="password" class="form-control input-lg" placeholder="Mot de Passe" name="password" value="">
                          </div>
                          <div class="form-group">
                            <input type="password" class="form-control input-lg" placeholder="Confirmer le Mot de Passe" name="confirm_password" value="">
                          </div>
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" name="terms"> J'accepte les termes et les conditions
                            </label>
                          </div>
                          <div class="modal-footer">
                            <input type="submit" class="btn btn-warning btn-block btn-lg" name="register-user" value="S'inscrire">
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                </div>
            </div>
        </div>
        <?php include 'footercontent.php'; ?>
        <?php include 'footerscript.php'; ?>
    </body>
</html>
