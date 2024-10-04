<?php
  session_start();
  require_once "php/DialogueBD.php" ;

  try{
    $undlg = new DialogueBD();
    $cat = $undlg->getCategories();
    $product = $undlg->getProducts($_GET['catId']);
  } catch (Exception $e) {
    $erreur = $e->getMessage();
  }
  if(isset($_GET["id"])){
    addPanier(intval($_GET["id"]));
    echo"bonjour";
  }
?>
<!DOCTYPE php>
<php lang="fr">

  <head>
		<meta charset="utf-8" />
		<link href="style/design.css" rel="stylesheet">
		<title>Liste des produits</title>
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
      if(isset($_SESSION['admin']['username'])){
        echo "<a class=\"barre\" href=\"commandes.php\">Acceder au commandes</a>";
        echo "<a class=\"barre\" href=\"deconnexion.php\">{$_SESSION["admin"]["username"]}</a>";
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
        <table>
        <caption>Les Produits :</caption>
        <thead>
          <tr>
            <th>Photo</th><th>Nom</th><th>Description</th><th>Prix</th>
          </tr>
        </thead>
        <tbody>
          <?php
          for ($i=0; $i < count($product); $i++) {
            echo "<tr>";
            echo "<td><img class=\"moyen\" src=\"productimages/{$product[$i]["image"]}\" alt=\"image du produit {$product[$i]["name"]}\"></td><td>{$product[$i]["name"]}</td><td>{$product[$i]["description"]}</td><td>{$product[$i]["price"]}‎€
            </td>
            <td><a class=\"bordered\" 
            href=\"panier.php?image={$product[$i]["image"]}&amp;
            action=ajout&amp;l={$product[$i]["name"]}
            &amp;q=1&amp;p={$product[$i]["price"]}\" onclick=\"window.location.href=\"page.html\"\">Ajouter au panier</a></td>";
            echo "</tr>";
          }
           ?>
        </tbody>
      </table>

		</section>

		<footer>
    </br></br>
			Copyright – FELIUS | VANDERVALLE - Tous droits réservés<br />
		</footer>

	</body>
</php>
