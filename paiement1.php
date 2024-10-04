<?php
  require_once "php/DialogueBD.php" ;
  session_start();
  //$_SESSION['connected'] = false;
  try{
    $undlg = new DialogueBD();
    $cat = $undlg->getCategories();
	$montant=$_GET["montant"];
	$_SESSION['montanttot'] = $montant;
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
		echo "<H1>Montant total du pannier : ".htmlspecialchars($montant)." €</H1>";
		?>

		</br>
		<H1>ETAPE 1/2 : Informations de commande</H1>
		</br></br></br>
		
		<form name="infos" method="post">
			<fieldset class="formulaire">
			  <div class="obligatoire">
			  </br>
				<label for="Firstname">Prenom :</label>
				<input type="text" name="Firstname" required>
			  </div>
			  <br>
			  <div class="obligatoire">
				<label for="Surname">Nom :</label>
				<input type="text" name="Surname" required>
			  </div>
			  <br>
			  <div class="obligatoire">
				<label for="Adress1">Adress1 :</label>
				<input type="text" name="Adress1" required>
			  </div>
			  <br>
			  <div class="falcutatif">
				<label for="Adress2">Adress2 :</label>
				<input type="text" name="Adress2">
			  </div>
			  <br>
			  <div class="obligatoire">
				<label for="Ville">Ville :</label>
				<input type="text" name="Ville" required>
			  </div>
			  <br>
			  <div class="obligatoire">
				<label for="PostCode">Post Code :</label>
				<input type="text" name="PostCode" required>
			  </div>
			  <br>
			  <div class="obligatoire">
				<label for="Phone">Telephone :</label>
				<input type="text" name="Phone" required>
			  </div>
			  <br>
			  <div class="obligatoire">
				<label for="Email">Email :</label>
				<input type="text" name="Email" required>
				</br></br>
			  </div>
			</fieldset></br>
			<input class="barre" type="submit" name="infos" value="Etape suivante : mode de paiement" />
		  </form>
		
		</br></br></br>
		<?php
		
		if(isset($_POST['infos']))
		  {
			header('Location: paiement2.php');
		  }
		
		?>
		
		</section>

		<footer>
			</br></br>
			Copyright – FELIUS | VANDERVALLE - Tous droits réservés<br />
		</footer>

	</body>
</php>
