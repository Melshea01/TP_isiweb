<?php
  require_once "php/DialogueBD.php" ;
  session_start();
  //$_SESSION['connected'] = false;
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
		<title>Page de Paiement</title>
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
      if(isset($_SESSION['admin']["userame"])){
        echo "<a class=\"barre\" href=\"deconnexion.php\">{$_SESSION["admin"]["username"]}</a>";
        echo "<a class=\"barre\" href=\"commandes.php\">Acceder au commandes</a>";
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
		<?php
		echo "<H1>Montant total du pannier : ".htmlspecialchars($_SESSION['montanttot'])." €</H1>";
		?>
		</br>
		<H1>PAIEMENT ETAPE 2/2 : Mode de paiement</H1>
		</br></br><hr size="3"></br>
		<H2>Cheque :</h2>
		<img class="moyen" src="images/cheque.jpg" alt=\"logo cheque"></br></br></br>
		<hr size="3"></br>
		Veuillez envoyer un cheque du montant ci-dessus à l'adresse postale suivante :</br></br>
		ISIWEB4SHOP </br>
		420 rue Bidon 69100 Villeurbanne</br></br>
		Lorsque votre cheque sera reçu, un administrateur pourra valider votre commande.
		</section>

		<footer>
			</br></br>
			Copyright – FELIUS | VANDERVALLE - Tous droits réservés<br />
		</footer>

	</body>
</php>
