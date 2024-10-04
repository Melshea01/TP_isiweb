<?php
require_once "php/DialogueBD.php" ;
require_once 'php/FctUtiles.php';
  session_start();
  //$_SESSION['connected'] = false;
    try{
      $undlg = new DialogueBD();
      creationPanier();
      $cat = $undlg->getCategories();
    } catch (Exception $e) {
      $erreur = $e->getMessage();
    }
    if (isset ($_GET["action"]))
    {
      if ($_GET["action"]=="ajout")
        ajouterArticle($_GET["image"],$_GET["l"],$_GET["q"],$_GET["p"]);

      if ($_GET["action"]=="suppression")
        supprimerArticle($_GET["l"]);

      if ($_GET["action"]=="reinit")
      {
        supprimePanier();
        creationPanier();
      }

  	unset ($_GET["action"]);

  $erreur = false;

$action = (isset($_POST['action'])? $_POST['action']:  (isset($_GET['action'])? $_GET['action']:null )) ;
if($action !== null)
{
   if(!in_array($action,array('ajout', 'suppression', 'refresh')))
   $erreur=true;

   //récupération des variables en POST ou GET
   $l = (isset($_POST['l'])? $_POST['l']:  (isset($_GET['l'])? $_GET['l']:null )) ;
   $p = (isset($_POST['p'])? $_POST['p']:  (isset($_GET['p'])? $_GET['p']:null )) ;
   $q = (isset($_POST['q'])? $_POST['q']:  (isset($_GET['q'])? $_GET['q']:null )) ;

   //Suppression des espaces verticaux
   $l = preg_replace('#\v#', '',$l);
   //On vérifie que $p est un float
   $p = floatval($p);

   //On traite $q qui peut être un entier simple ou un tableau d'entiers
    
   if (is_array($q)){
      $QteArticle = array();
      $i=0;
      foreach ($q as $contenu){
         $QteArticle[$i++] = intval($contenu);
      }
   }
   else
   $q = intval($q);
    
}

if (!$erreur){
   switch($action){
      Case "ajout":
         ajouterArticle($l,$q,$p);
         break;

      Case "suppression":
         supprimerArticle($l);
         break;

      Case "refresh" :
         for ($i = 0 ; $i < count($QteArticle) ; $i++)
         {
            modifierQTeArticle($_SESSION['panier']['libelleProduit'][$i],round($QteArticle[$i]));
         }
         break;

      Default:
         break;
   }
}
  }



echo '<?xml version="1.0" encoding="utf-8"?>';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">

  <head>
		<meta charset="utf-8" />
		<link href="style/design.css" rel="stylesheet">
		<title>Votre panier</title>
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

<form method="post" action="panier.php">
<table style="width: 400px">
    <caption>Votre pannier :</caption>
    <tr>
		<th>Image</td>
        <th>Libellé</td>
        <th>Quantité</td>
        <th>Prix Unitaire</td>
        <th>Action</td>
    </tr>


    <?php
		$nbArticles=count(array_filter($_SESSION['panier']['libelleProduit'], function($x) { return !empty($x); }));
		$nbArticlestot=count($_SESSION['panier']['libelleProduit']);
        if ($nbArticles <= 0)
        echo "<tr><td colspan=\"5\">Votre panier est vide </ td></tr>";
        else
        {
            for ($i=0 ;$i < $nbArticlestot ; $i++) {
				if (!empty($_SESSION['panier']['libelleProduit'])) {

                echo "<tr>";
				echo "<td><img class=\"moyen\" src=\"productimages/"."{$_SESSION['panier']['image'][$i]}"."\" alt=\"image du produit\"></ td>";
                echo "<td>".htmlspecialchars($_SESSION['panier']['libelleProduit'][$i])."</ td>";
                echo "<td>".htmlspecialchars($_SESSION['panier']['qteProduit'][$i])."</td>";
                echo "<td>".htmlspecialchars($_SESSION['panier']['prixProduit'][$i])."€</td>";
                echo "<td><a href=\"".htmlspecialchars("panier.php?action=suppression&l=".rawurlencode($_SESSION['panier']['libelleProduit'][$i]))."\">Supprimer l'article</a></br></br>";
				echo "<a href=\"".htmlspecialchars("panier.php?image=".rawurlencode($_SESSION['panier']["image"][$i])."&action=ajout&l=".rawurlencode($_SESSION['panier']['libelleProduit'][$i])."&q=1&p=".rawurlencode($_SESSION['panier']['prixProduit'][$i]))."\" \">En ajouter un</a>";

				echo "</td>";
                echo "</tr>";
				}
			}
            echo "<tr><td colspan=\"2\"> </td>";
            echo "<td colspan=\"3\">";
            echo "Total du pannier : ".MontantGlobal()."€";
            echo "</td></tr>";
            echo "<tr><td colspan=\"5\"></td></tr>";
            echo "<tr>";
			      echo "<td></td>";
            echo "<td class=\"barre\"><a href=\"".htmlspecialchars("panier.php?action=reinit")."\">Supprimer le panier</a>";

			/*echo "</td>";
      echo "<td></td>";
			echo "<td class=\"barre\"><a href=\"".htmlspecialchars("paiement1.php?montant=".rawurlencode(MontantGlobal()))."\">Payer</a>";

			echo"</tr>";*/
        }

    ?>
</table>
</form>

		</section>

		<footer>
    </br></br>
			Copyright – FELIUS | VANDERVALLE - Tous droits réservés<br />
		</footer>

	</body>

</html>
