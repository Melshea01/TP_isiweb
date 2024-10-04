<?php
  require_once "php/DialogueBD.php" ;
  require_once "php/FctUtiles.php";
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
				<label for="Firstname">Prenom :</label>
				<input type="text" name="Firstname" value="<?php echo "{$_SESSION['customer']['firstname']}"; ?>" required>
			  </div>
			  <br>
			  <div class="obligatoire">
				<label for="Surname">Nom :</label>
				<input type="text" name="Surname" value="<?php echo "{$_SESSION['customer']['surname']}"; ?>" required>
			  </div>
			  <br>
			  <div class="obligatoire">
				<label for="Adress1">Adress1 :</label>
				<input type="text" name="Adress1" value="<?php echo "{$_SESSION['customer']['add1']}"; ?>" required>
			  </div>
			  <br>
			  <div class="falcutatif">
				<label for="Adress2">Adress2 :</label>
				<input type="text" name="Adress2" value="<?php echo "{$_SESSION['customer']['add2']}"; ?>">
			  </div>
			  <br>
			  <div class="obligatoire">
				<label for="Ville">Ville :</label>
				<input type="text" name="Ville" value="<?php echo "{$_SESSION['customer']['city']}"; ?>" required>
			  </div>
			  <br>
			  <div class="obligatoire">
				<label for="PostCode">Code postale :</label>
				<input type="text" name="PostCode" value="<?php echo "{$_SESSION['customer']['postcode']}"; ?>" required>
			  </div>
			  <br>
			  <div class="obligatoire">
				<label for="Phone">Telephone :</label>
				<input type="text" name="Phone" value="<?php echo "{$_SESSION['customer']['phone']}"; ?>" required>
			  </div>
			  <br>
			  <div class="obligatoire">
				<label for="Email">Email :</label>
				<input type="text" name="Email" value="<?php echo "{$_SESSION['customer']['email']}"; ?>" required>
			  </div>
			</fieldset></br>
			<input class="barre" type="submit" name="infos" value="Etape suivante : mode de paiement" />
		  </form>

		</br></br></br>
		<?php

		if(isset($_POST['infos']))
		  {
        try {
          $address =$undlg->getAdressesbis($_POST['Firstname'], $_POST['Surname'], $_POST['Adress1'], $_POST['Ville'], $_POST['Phone']);
          if ($address == NULL) {
            $undlg->addAdress($_POST['Firstname'], $_POST['Surname'], $_POST['Adress1'], $_POST['Adress2'], $_POST['Ville'], $_POST['PostCode'], $_POST['Phone'], $_POST['Email']);
            $address =$undlg->getAdressesbis($_POST['Firstname'], $_POST['Surname'], $_POST['Adress1'], $_POST['Ville'], $_POST['Phone']);
          }
          $undlg->newOrder($_SESSION['customer']['id'], 1, $address["id"], "" ,MontantGlobal());
          $_SESSION["order"]=$undlg->getOrder($_SESSION['customer']['id'], $address["id"]);
          for($i = 0; $i < compterArticles(); $i++){
            $undlg->newOrderItem($_SESSION['order']['id'], $_SESSION["panier"]['id'][$i], $_SESSION["panier"]['qteProduit'][$i]);
          }
        } catch (\Exception $e) {
          $erreur = $e->getMessage();
        }

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
