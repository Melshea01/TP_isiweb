<?php
  session_start();
  require_once "php/DialogueBD.php" ;


  try{
    $undlg = new DialogueBD();
    $cat = $undlg->getCategories();
  } catch (Exception $e) {
    $erreur = $e->getMessage();
  }
?>
<!DOCTYPE php>
<php lang="fr">

  <head>
		<meta charset="utf-8" />
		<link href="style/design.css" rel="stylesheet">
		<title>Page d'acceuil d'ISIWEB4SHOP</title>
	</head>

	<body>

		<header>
			<h1>Bienvenue sur ISIWEB4SHOP</h1>
			<a class="barre" href="index.php">Accueil</a>
			<a class="barre" href="panier.php">Voir Panier/Payer</a>
      <?php
      if(isset($_SESSION['customer']) && $_SESSION['customer'] != null){
        echo "<a class=\"barre\" href=\"deconnexion.php\">{$_SESSION["customer"]["firstname"]} {$_SESSION["customer"]["surname"]}</a>";
      }
       ?>
		</header>

		<nav>
			<h1>Catégories :</h1>
				<ul>
          <?php
          for($i = 0; $i < count($cat); $i++) {
            echo "<li><a href=\"liste.php?catId={$cat[$i]["id"]}&catName={$cat[$i]["name"]}\"><img src=\"{$cat[$i]["image"]}\" class=\"mini\" alt=\"{$cat[$i]["name"]}\" title=\"{$cat[$i]["name"]}\" /> {$cat[$i]["name"]}</a></li>";
          }
           ?>
				</ul>
		</nav>

		<section>
			<article>
<div class="deconnexion">
<h1>Se deconnecter :</h1>
<form name="deconnexion" method="post">
<input type="submit" name="DeConnexion" value="Se deconnecter" />
</form>
<?php
  if(isset($_POST['DeConnexion'])){
    $_SESSION['customer'] = null;
    $_SESSION['admin'] = null;
    header('Location: index.php');
    exit();
     }

?>
</div>
			</article>

		</section>

		<footer>
			<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
			Copyright – FELIUS | VANDERVALLE - Tous droits réservés<br />
		</footer>

	</body>
