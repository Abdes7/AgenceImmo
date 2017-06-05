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

if(!empty($_POST["save_record"])) {
	$target = "img/".basename($_FILES['image']['name']);
	$image = $_FILES['image']['name'];

	$pdo_statement=$pdo_conn->prepare("update posts set post_title='" . $_POST[ 'post_title' ] . "', description='" . $_POST[ 'description' ]. "',  ville='" . $_POST[ 'ville' ]. "', adresse='" . $_POST[ 'adresse' ]. "',  prix='" . $_POST[ 'prix' ]. "', image='" . $_FILES['image']['name']. "', post_at='" . $_POST[ 'post_at' ]. "' where id=" . $_GET["id"]);
	$result = $pdo_statement->execute();
	if($result) {
		header('location:dashboard.php');
	}
	move_uploaded_file($_FILES['image']['tmp_name'], $target);
}
$pdo_statement = $pdo_conn->prepare("SELECT * FROM posts where id=" . $_GET["id"]);
$pdo_statement->execute();
$result = $pdo_statement->fetchAll();
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
                            <h4 class="modal-title">Modifier l'Annonce</h4>
                          </div>
                          <div class="modal-body">
                              <form name="frmAdd" action="" method="POST" enctype="multipart/form-data">
                                  <div class="form-group">
                                	  <label>Title: </label>
                                	  <input type="text" name="post_title" class="form-control input-lg" value="<?php echo $result[0]['post_title']; ?>" required  />
                                  </div>
                                  <div class="form-group">
                                	  <label>Description: </label>
                                	  <textarea name="description" class="form-control input-lg" rows="5" required ><?php echo $result[0]['description']; ?></textarea>
                                  </div>
                                  <div class="form-group">
                                	  <label>Ville: </label>
                                	  <input type="text" name="ville" class="form-control input-lg" value="<?php echo $result[0]['ville']; ?>" required />
                                  </div>
                                  <div class="form-group">
                                	  <label>Adresse: </label>
                                	  <input type="text" name="adresse" class="form-control input-lg" value="<?php echo $result[0]['adresse']; ?>" required />
                                  </div>
                                  <div class="form-group">
                                	  <label>Prix: </label>
                                	  <input type="text" name="prix" class="form-control input-lg" value="<?php echo $result[0]['prix']; ?>" required />
                                  </div>
                                  <div class="form-group">
                                	  <label>Image: </label>
                                	  <input type="file" name="image" class="form-control input-lg" required />
                                  </div>
                                  <div class="form-group">
                                	  <label>Type: </label>
                                      <select name="type">
                                          <option <?php if ($result[0]['type'] == 'vendre') echo "selected"; ?> value="vendre">Vendre</option>
                                          <option <?php if ($result[0]['type'] == 'louer') echo "selected"; ?> value="louer">Louer</option>
                                      </select>
                                  </div>
                                  <input type="hidden" name="post_at" value="<?php echo $result[0]['post_at']; ?>" required />
                                  <div class="modal-footer">
                                    <input type="submit" class="btn btn-warning btn-block btn-lg" value="Enregistrer la Modification" name="save_record">
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
