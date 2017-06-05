<?php
  session_start();
  require_once("db.php");
if (isset($_SESSION['login']))
{
    $userid = $_SESSION['login'];
    $getUsers = $pdo_conn->prepare("SELECT * FROM user WHERE id = $userid");
    $getUsers->execute();
    $users = $getUsers->fetchAll();
    foreach ($users as $user) {}
}else{
    header('location:login.php');
}
?>
<?php
if(!empty($_POST["add_record"])) {
	require_once("db.php");

	$target = "img/".basename($_FILES['image']['name']);
	$image = $_FILES['image']['name'];

	$sql = "INSERT INTO posts ( user_id, post_title, description, ville, adresse, prix, image, type, validation, post_at ) VALUES ( :user_id, :post_title, :description, :ville, :adresse, :prix, :image, :type, :validation, :post_at )";
	$pdo_statement = $pdo_conn->prepare( $sql );

	$result = $pdo_statement->execute( array(
        ':user_id'=>$_POST['user_id'],
        ':post_title'=>$_POST['post_title'],
        ':description'=>$_POST['description'],
		':ville'=>$_POST['ville'],
		':adresse'=>$_POST['adresse'],
		':prix'=>$_POST['prix'],
        ':image'=>$_FILES['image']['name'],
        ':type'=>$_POST['type'],
        ':validation'=>$_POST['validation'],
        ':post_at'=>$_POST['post_at'] ) );

	if (!empty($result) ){
	  header('location:dashboard.php');
  }
	move_uploaded_file($_FILES['image']['tmp_name'], $target);
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
                    <div class="modal-dialog">
                      <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">Ajouter nouvelle Annonce</h4>
                          </div>
                          <div class="modal-body">
                            <form name="frmAdd" action="" method="POST" enctype="multipart/form-data">
                              <div class="form-group">
                            	  <label>Title: </label>
                            	  <input type="text" name="post_title" class="form-control input-lg" required />
                              </div>
                              <div class="form-group">
                            	  <label>Description: </label>
                            	  <textarea name="description" class="form-control input-lg" rows="5" required ></textarea>
                              </div>
                              <div class="form-group">
                            	  <label>Ville: </label>
                            	  <input type="text" name="ville" class="form-control input-lg" required />
                              </div>
                              <div class="form-group">
                            	  <label>Adresse: </label>
                            	  <input type="text" name="adresse" class="form-control input-lg" required />
                              </div>
                              <div class="form-group">
                            	  <label>Prix: </label>
                            	  <input type="text" name="prix" class="form-control input-lg" required />
                              </div>
                              <div class="form-group">
                            	  <label>Image: </label>
                            	  <input type="file" name="image" class="form-control input-lg" required />
                              </div>
                              <div class="form-group">
                            	  <label>Type: </label>
                                  <select name="type">
                                      <option value="vendre">Vendre</option>
                                      <option value="louer">Louer</option>
                                  </select>
                              </div>
                              <div>
                                  <input type="hidden" name="user_id" value="<?php echo $_SESSION['login']; ?>"/>
                                    <?php
                                        $usertype = $user['type'];
                                        if ($usertype == '0') {
                                    ?>
                                        <input type="hidden" name="validation" value="0"/>
                                    <?php
                                        } else {
                                    ?>
                                        <input type="hidden" name="validation" value="1"/>
                                    <?php
                                        }
                                    ?>
                                  <input type="hidden" name="post_at" value="<?php echo date("Y-m-d"); ?>"/>
                              </div>
                              <div class="modal-footer">
                                <input type="submit" class="btn btn-warning btn-block btn-lg" value="Ajouter l'Annonce" name="add_record">
                              </div>
                              </form>
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
