<?php
  require_once "php/DialogueBD.php" ;
  session_start();
  $_SESSION['connected'] = false;
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
			<a class="barre" href="connexion.php">S'identifier</a>
			<a class="barre" href="panier.php">Voir Panier/Payer</a>
		</header>

		<nav>
			<h1>Catégories :</h1>
				<ul>
          <?php
          for($i = 0; $i < count($cat); $i++) {
            echo "<li><a href=\"liste.php?catId={$cat[$i]["id"]}catName={$cat[$i]["name"]}\"><img src=\"{$cat[$i]["image"]}\" class=\"mini\" alt=\"{$cat[$i]["name"]}\" title=\"{$cat[$i]["name"]}\" /> {$cat[$i]["name"]}</a></li>";
          }
           ?>
				</ul>
		</nav>

		<section>
			<article>
				<div class="connexion">
      <h1>S'identifier :</h1>
      <form name="connexion" method="post">
        <fieldset class="formulaire">
          <legend><strong>Connexion</strong></legend>
          <div class="obligatoire">
            <label for="Identifiant">Identifiant :</label>
            <input type="text" name="Identifiant" required>
          </div>
          <br>
          <div class="obligatoire">
            <label for="Password">Mot de Passe :</label>
            <input type="password" name="Password" required>
          </div>
        </fieldset></br>
        <input type="submit" name="Connexion" value="Se connecter" />
      </form>
      <?php
      if(isset($_POST['Connexion']))
      {
        try
        {
           $undlg = new DialogueBD();
           $utilisateur = $undlg->getCustomer($_POST['Identifiant'], $_POST['Password']);
         }
         catch (Exception $e)
         {
           $erreur = $e->getMessage();
         }
         /*print_r($utilisateur);*/

        if(isset($utilisateur['NomUtil']) && isset($utilisateur['PrenomUtil']))
        {
          header('Location: selection.php');
          $_SESSION['login'] = $_POST['Identifiant'];
          $_SESSION['NomUtil'] = $utilisateur['NomUtil'];
          $_SESSION['PrenomUtil'] = $utilisateur['PrenomUtil'];
          $_SESSION['connected'] = true;
          exit();
        }
        else
        {
            echo'<p class="rouge">Données entrées incorrectes !</p>';
        }

      }

      session_destroy();
    ?>
    </div>
			</article>

		</section>

		<footer>
			</br></br>
			Copyright – FELIUS | VANDERVALLE - Tous droits réservés<br />
		</footer>

	</body>
