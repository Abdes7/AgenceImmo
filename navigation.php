<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-top">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php"><span>Age<strong>llo.</strong></span></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="navbar-top">
      <ul class="nav navbar-nav navbar-right">
        <?php if (isset($_SESSION['login'])) { ?>
        <li><a href="dashboard.php">Tableau de Board</a></li>
        <?php } ?>
        <li><a href="index.php">Accueil</a></li>
        <li><a href="about.php">About</a></li>
        <?php if (isset($_SESSION['login'])) { ?>
            <li><a href="logout.php" class="signin">Déconnexion</a></li>
            <li><a href="add.php" class="signup">Ajouter Annonce</a></li>
        <?php }else { ?>
            <li><a href="login.php" class="signin">Se connecter</a></li>
            <li><a href="register.php" class="signup">S'inscrire</a></li>
        <?php } ?>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container -->
</nav>
