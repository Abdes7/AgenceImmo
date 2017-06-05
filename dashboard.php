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
define("ROW_PER_PAGE",5000000);
require_once('db.php');
?>
<!DOCTYPE html>
<html>
    <?php include 'header.php'; ?>
<body id="top">

    <?php include 'navigation.php'; ?>

    <?php
    	$search_keyword = '';
    	if(!empty($_POST['search']['keyword'])) {
    		$search_keyword = $_POST['search']['keyword'];
    	}
    	$sql = 'SELECT * FROM posts WHERE post_title LIKE :keyword OR description LIKE :keyword OR post_at LIKE :keyword ORDER BY id DESC ';

    	/* Pagination Code starts */
    	$per_page_html = '';
    	$page = 1;
    	$start=0;
    	if(!empty($_POST["page"])) {
    		$page = $_POST["page"];
    		$start=($page-1) * ROW_PER_PAGE;
    	}
    	$limit=" limit " . $start . "," . ROW_PER_PAGE;
    	$pagination_statement = $pdo_conn->prepare($sql);
    	$pagination_statement->bindValue(':keyword', '%' . $search_keyword . '%', PDO::PARAM_STR);
    	$pagination_statement->execute();

    	$row_count = $pagination_statement->rowCount();
    	if(!empty($row_count)){
    		$per_page_html .= "<div style='text-align:center;margin:20px 0px;'>";
    		$page_count=ceil($row_count/ROW_PER_PAGE);
    		if($page_count>1) {
    			for($i=1;$i<=$page_count;$i++){
    				if($i==$page){
    					$per_page_html .= '<input type="submit" name="page" value="' . $i . '" class="btn-page current" />';
    				} else {
    					$per_page_html .= '<input type="submit" name="page" value="' . $i . '" class="btn-page" />';
    				}
    			}
    		}
    		$per_page_html .= "</div>";
    	}else {
    	    $emptypost = "Votre recherche n'a donné aucun résultat";
    	}

    	$query = $sql.$limit;
    	$pdo_statement = $pdo_conn->prepare($query);
    	$pdo_statement->bindValue(':keyword', '%' . $search_keyword . '%', PDO::PARAM_STR);
    	$pdo_statement->execute();
    	$result = $pdo_statement->fetchAll();
    ?>

<form role="form" name='frmSearch' action='' method='post'>
<!-- begin:header -->
<div id="header" class="heading" style="background-image: url(img/img01.jpg);">
  <div class="container">
    <div class="row">
      <div class="col-md-10 col-md-offset-1 col-sm-12">
          <h1 style="text-align:center;color:white;">Bienvenue <?php echo $user["login"]; ?></h1>
        <div class="quick-search">
          <div class="row">
            <div class="col-md-offset-3">
              <div class="col-md-6 col-sm-3 col-xs-6">
                <div class="form-group">
                  <label for="bedroom">Recherche</label>
                  <input type="text" class="form-control" placeholder="Enter le Mot clé" name='search[keyword]' value="<?php echo $search_keyword; ?>" id='keyword' maxlength='25'>
                </div>
              </div>
              <!-- break -->
              <div class="col-md-3 col-sm-3 col-xs-6">
                <div class="form-group">
                  <label for="maxprice">&nbsp;</label>
                  <input type="submit" name="submit" value="Recherche" class="btn btn-warning btn-block">
                </div>
              </div>
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- end:header -->
<div id="content">
  <div class="container">
    <div class="row">
        <h2><?php echo $emptypost; ?></h2>
        <div class="row container-realestate">
          <div class="col-md-12 col-sm-12 col-xs-12">

                <?php

                if (!empty($result))
                {

                    foreach ($result as $post) {
                        if ($user['type'] == '0') {
                            if ($post["user_id"] == $user['id']) {
                	?>
            <div class="property-container">
              <div class="property-content-list">
                <div class="property-image-list">
                  <img src="img/<?php echo $post["image"]; ?>">
                  <div class="property-price">
                      <?php

                        if ($post["type"] == 'vendre') {
                      ?>
                            <h4>A Vendre</h4>
                            <span><?php echo $post["prix"]; ?></span><small> DH</small>
                      <?php
                        }elseif($post["type"] == 'louer') {
                      ?>
                            <h4>A Louer</h4>
                            <span><?php echo $post["prix"]; ?><small> DH /Mois</small></span>
                      <?php
                        }
                       ?>

                  </div>
                </div>
                <div class="property-text">
                  <h3><a><?php echo $post["post_title"]; ?></a> <small><?php echo $post["post_at"]; ?> <?php echo $post["ville"]; ?></small><small>Adresse : <?php echo $post["adresse"]; ?></small></h3>
                  <p><?php echo $post["description"]; ?></p>
                  <h4>
                      <?php if ($post["validation"] == '1'): ?>
                          <a class="ajax-action-links btn btn-info">Annonce valider</a>
                      <?php else: ?>
                          <a class="ajax-action-links btn btn-warning">En attendant</a>
                      <?php endif; ?>
                       - <a class="ajax-action-links btn btn-primary" href='edit.php?id=<?php echo $post['id']; ?>'>Modifier</a> -
                      <a class="ajax-action-links btn btn-danger" href='delete.php?id=<?php echo $post['id']; ?>'>Supprimer</a>
                  </h4>
                </div>
              </div>
          </div>
              <?php
                 }
             }elseif($user['type'] == '1') { ?>
                 <div class="property-container">
                   <div class="property-content-list">
                     <div class="property-image-list">
                       <img src="img/<?php echo $post["image"]; ?>">
                       <div class="property-price">
                           <?php

                             if ($post["type"] == 'vendre') {
                           ?>
                                 <h4>A Vendre</h4>
                                 <span><?php echo $post["prix"]; ?></span><small> DH</small>
                           <?php
                             }elseif($post["type"] == 'louer') {
                           ?>
                                 <h4>A Louer</h4>
                                 <span><?php echo $post["prix"]; ?><small> DH /Mois</small></span>
                           <?php
                             }
                            ?>

                       </div>
                     </div>
                     <div class="property-text">
                       <h3><a><?php echo $post["post_title"]; ?></a> <small><?php echo $post["post_at"]; ?> <?php echo $post["ville"]; ?></small><small>Adresse : <?php echo $post["adresse"]; ?></small></h3>
                       <p><?php echo $post["description"]; ?></p>
                       <h4>
                           <?php if ($post["validation"] == '1'): ?>
                               <a href='accept.php?id=<?php echo $post['id']; ?>' class="ajax-action-links btn btn-info">Accepté</a>
                           <?php else: ?>
                               <a href='accept.php?id=<?php echo $post['id']; ?>' class="ajax-action-links btn btn-warning">Non Accepter</a>
                           <?php endif;
                            if ($post["user_id"] == $user['id']) {
                           ?>
                            - <a class="ajax-action-links btn btn-primary" href='edit.php?id=<?php echo $post['id']; ?>'>Modifier</a> -
                           <a class="ajax-action-links btn btn-danger" href='delete.php?id=<?php echo $post['id']; ?>'>Supprimer</a>
                           <?php }else {
                               $nmuserid = $post["user_id"];
                               $nmgetUsers = $pdo_conn->prepare("SELECT * FROM user WHERE id = $nmuserid");
                               $nmgetUsers->execute();
                               $nmusers = $nmgetUsers->fetchAll();
                               foreach ($nmusers as $nmuser) {}
                           ?>
                               <h4>By : <?php echo $nmuser["login"]; ?></h4>
                           <?php } ?>
                       </h4>
                     </div>
                   </div>
                 </div>
             <?php }
          	}
          }
          ?>

            </div>
        </div>
        <?php echo $per_page_html; ?>
     </div>
   </div>
</div>
</form>
    <?php include 'footercontent.php'; ?>
    <?php include 'footerscript.php'; ?>
</body>
</html>
