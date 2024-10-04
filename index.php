<?php
  session_start();
  require_once "php/DialogueBD.php" ;
  require_once "php/FctUtiles.php" ;
  if(!isset($_SESSION['connected'])){
    $_SESSION['connected'] = true;
  }
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
    <script src="js/javascript.js">

    </script>
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
      if(isset($_SESSION['admin']["username"])){
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
      <div class="selection">
        <p><a id="Connexion">Connexion</a>|<a id="Inscription">Inscription</a></p>
      </div>
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
           $admin =  $undlg->getAdmin($_POST['Identifiant'], $_POST['Password']);
           if(!isset($admin['username'])){
             $utilisateur = $undlg->getLogin($_POST['Identifiant'], $_POST['Password']);
             $customer = $undlg->getCustomer($utilisateur['customer_id']);
             $_SESSION['customer'] = $customer;
             $_SESSION['admin'] = null;
           }
           else{
             $_SESSION['admin'] = $admin;
             $_SESSION['customer'] = null;
           }
         }
         catch (Exception $e)
         {
           $erreur = $e->getMessage();
         }

        if(isset($_SESSION['customer']['firstname']) && isset($_SESSION['customer']['surname']))
        {
          foreach ($customer as $key => $value) {
            $_SESSION[$key] = $value;
          }
          header('Location: index.php');
          exit();
        }
        elseif(isset($_SESSION['admin']['username'])){
          header('Location: commandes.php');
          exit();
        }
        else
        {
            echo'<p class="rouge">Données entrées incorrectes !</p>';
        }

      }

    ?>
    </div>
    <div class="inscription">
  <h1>S'inscrire :</h1>
  <form name="inscription" method="post">
    <fieldset class="formulaire">
      <legend><strong>Inscription</strong></legend>
      <div class="obligatoire">
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
      <div class="falcutatif">
        <label for="Adress3">Adress3 :</label>
        <input type="text" name="Adress3">
      </div>
      <br>
      <div class="obligatoire">
        <label for="Ville">Ville :</label>
        <input type="text" name="Ville" required>
      </div>
      <br>
      <div class="obligatoire">
        <label for="PostCode">Code postale :</label>
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
      </div>
      <br>
      <div class="obligatoire">
        <label for="Password">Mot de Passe :</label>
        <input type="password" name="Password" required>
      </div>
    </fieldset></br>
    <input type="submit" name="Inscription" value="S'inscrire" />
  </form>
  <?php
  if(isset($_POST['Inscription']))
  {
    try
    {
       $undlg = new DialogueBD();
       $custo=$undlg->newCustomer($_POST['Firstname'], $_POST['Surname'], $_POST['Adress1'], $_POST['Adress2'], $_POST['Adress3'], $_POST['Ville'], $_POST['PostCode'], $_POST['Phone'], $_POST['Email'], 1);
       $customer = $undlg->getCustomerBis($_POST['Firstname'], $_POST['Surname']);
       $undlg->newLogin($customer['id'], $_POST['Surname'], $_POST['Password']);
       echo "Votre identifiant et votre Nom";
     }
     catch (Exception $e)
     {
       $erreur = $e->getMessage();
     }

    if(isset($customer['firstname']) && isset($customer['surname']))
    {
      foreach ($customer as $key => $value) {
        $_SESSION[$key] = $value;
      }
      print_r($_SESSION);
    }
    else
    {
        echo'<p class="rouge">Données entrées incorrectes !</p>';
    }
  }
?>
</div>

</div>

		</section>

		<footer>
			<br/><br/>
			Copyright – FELIUS | VANDERVALLE - Tous droits réservés<br />
		</footer>
	</body>
