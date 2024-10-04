<?php
  session_start();
  require_once "php/DialogueBD.php" ;

  try{
    $undlg = new DialogueBD();
    $cat = $undlg->getCategories();
    if(isset($_GET['id'])){
       $undlg->payementConfirme($_GET['id']);
    }
    $orders = $undlg->getOrders();
    for($i = 0; $i < count($orders); $i++){
      $customer = $undlg->getAdresses($orders[$i]['customer_id']);
      $orders[$i]['customer'] = $customer;
      $address = $undlg->getAdresses($orders[$i]['delivery_add_id']);
      $orders[$i]['address'] = $address;
      $item = $undlg->getOrderItems($orders[$i]['id']);
      $orders[$i]['items'] = $item;
      for($j = 0; $j < count($orders[$i]['items']); $j++){
        $product = $undlg->getProduct($orders[$i]['items'][$j]['id']);
        $orders[$i]['items'][$j]['name'] = $product['name'];
        $orders[$i]['items'][$j]['price'] = $product['price'];
      }
    }
  } catch (Exception $e) {
    $erreur = $e->getMessage();
  }
?>
<!DOCTYPE php>
<php lang="fr">

  <head>
		<meta charset="utf-8" />
		<link href="style/design.css" rel="stylesheet">
		<title>Liste des commandes</title>
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
      if(isset($_SESSION['admin'])){
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
			<h1>Les commandes :</h1>
          <?php
          for($i = 0; $i < count($orders); $i++) {
            echo "<ul><li>Client : <ul><li>{$orders[$i]['address']['firstname']} {$orders[$i]['address']['lastname']}</li></ul></li>";
            echo "<li>Coordonnées : <ul><li>{$orders[$i]['address']['add1']}</li><li>{$orders[$i]['address']['add2']}</li><li>{$orders[$i]['address']['city']}</li><li>{$orders[$i]['address']['postcode']}</li><li>{$orders[$i]['address']['phone']}</li><li>{$orders[$i]['address']['email']}</li></ul></li>";
            if($orders[$i]['registered'] == 1){
              echo "<li>Le client est enregistré.</li>";
            }
            else{
              echo "<li>Le client n'est pas enregistré.</li>";
            }
            if($orders[$i]['payment_type'] == 1){
              echo "Payment par chèque";
            }
            elseif($orders[$i]['payment_type'] == 2){
              echo "Payement par Paypal";
            }
            elseif ($orders[$i]['status'] < 2) {
              echo "Le client n'a pas encore procédé au payement.";
            }
            echo "<li>{$orders[$i]['date']}</li>";
            if($orders[$i]['status'] == 0){
              echo "<li>Le client est encore entrain de remplir son panier.</li>";
            }
            elseif ($orders[$i]['status'] == 1) {
              echo "<li>Le client a entré son adresse.</li>";
            }
            elseif ($orders[$i]['status'] == 2) {
              echo "<li>Le client a payé pour son panier.</li>";
            }
            else{
              echo "<li>L'administrateur à confirmé la transaction et envoyé la transaction.<li>";
            }
            echo "<li>{$orders[$i]['session']}</li>";
            echo "<li>Les produits :<ul>";
            foreach ($orders[$i]['items'] as $key => $value) {
              echo "<li>Le produit {$value['id']} {$value['name']}, {$value['price']}€ l'unité, quantité : {$value['quantity']}</li>";
            }
            echo "</ul></li><li>Prix total : {$orders[$i]['total']}€</li>";
            if($orders[$i]['status'] == 2){
              echo "<li><a href=\"commandes.php?id={$orders[$i]['id']}\">Confirmer le paiment</a></li>";
            }
            elseif ($orders[$i]['status'] < 2) {
              echo "<li>En attente de paiement</ul></li>";
            }
            else {
              echo "<li>Le paiment est confirmé</li></ul> </br>";
            }

          }
           ?>
		</section>

		<footer>

			Copyright – FELIUS | VANDERVALLE - Tous droits réservés<br />
		</footer>

	</body>
</php>
