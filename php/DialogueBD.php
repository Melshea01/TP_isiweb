<?php
/**
* Description of DialogueBD
*
* @author Basile Vandervalle
*/
require_once('Connexion.php');
date_default_timezone_set('GMT');
class DialogueBD {

    function getAdmin($us, $psw){
      try {
        $conn = Connexion::getConnexion();
        $sql = "SELECT id, username FROM admin Where username=:us and password=SHA1(:psw)";
        $sth = $conn->prepare($sql);
        $sth->execute(array(':us' => $us, ':psw' => $psw));
        $utilisateur =$sth->fetch(PDO::FETCH_ASSOC);
        return $utilisateur;
      }
      catch (PDOException $e) {
        $erreur = $e->getMessage();
        }
    }

    function getLogin($us, $psw){
      try {
        $conn = Connexion::getConnexion();
        $sql = "SELECT id, customer_id, username FROM logins Where username=:us and password=SHA1(:psw)";
        $sth = $conn->prepare($sql);
        $sth->execute(array(':us' => $us, ':psw' => $psw));
        $utilisateur =$sth->fetch(PDO::FETCH_ASSOC);
        return $utilisateur;
      }
      catch (PDOException $e) {
        $erreur = $e->getMessage();
        }
    }

    function getCustomer($id){
      try {
        $conn = Connexion::getConnexion();
        $sql = "SELECT * FROM customers Where id=:id";
        $sth = $conn->prepare($sql);
        $sth->execute(array(':id' => $id));
        $customer =$sth->fetch(PDO::FETCH_ASSOC);
        return $customer;
      }
      catch (PDOException $e) {
        $erreur = $e->getMessage();
        }
    }

    function getCustomerBis($firstname, $surname){
      try {
        $conn = Connexion::getConnexion();
        $sql = "SELECT * FROM customers Where firstname=:firstname and surname=:surname";
        $sth = $conn->prepare($sql);
        $sth->execute(array(':firstname' => $firstname, ':surname' => $surname));
        $customer =$sth->fetch(PDO::FETCH_ASSOC);
        return $customer;
      }
      catch (PDOException $e) {
        $erreur = $e->getMessage();
        }
    }

    function getCustomerBis2($firstname, $surname, $add, $c, $p){
      try {
        $conn = Connexion::getConnexion();
        $sql = "SELECT * FROM customers Where firstname=:firstname and surname=:surname and add1=:add and city=:c and phone=:p";
        $sth = $conn->prepare($sql);
        $sth->execute(array(':firstname' => $firstname, ':surname' => $surname, ':add' => $add, ':c' => $c, ':p' => $p));
        $customer =$sth->fetch(PDO::FETCH_ASSOC);
        return $customer;
      }
      catch (PDOException $e) {
        $erreur = $e->getMessage();
        }
    }

    function getCategories(){
      try {
        $conn = Connexion::getConnexion();
        $sql = "SELECT * FROM categories";
        $sth = $conn->prepare($sql);
        $sth->execute();
        $categories =$sth->fetchAll(PDO::FETCH_ASSOC);
        return $categories;
      }
      catch (PDOException $e) {
        $erreur = $e->getMessage();
        }
    }

    function getProducts($catId){
      try {
        $conn = Connexion::getConnexion();
        $sql = "SELECT * FROM products where cat_id=:catId";
        $sth = $conn->prepare($sql);
        $sth->execute(array(':catId' => $catId));
        $categories =$sth->fetchAll(PDO::FETCH_ASSOC);
        return $categories;
      }
      catch (PDOException $e) {
        $erreur = $e->getMessage();
        }
    }

    function getProduct($Id){
      try {
        $conn = Connexion::getConnexion();
        $sql = "SELECT * FROM products where id=:Id";
        $sth = $conn->prepare($sql);
        $sth->execute(array(':Id' => $Id));
        $categories =$sth->fetch(PDO::FETCH_ASSOC);
        return $categories;
      }
      catch (PDOException $e) {
        $erreur = $e->getMessage();
        }
    }


    function newCustomer($firsname, $surname, $add1, $add2="", $add3="", $city, $poste, $phone, $mail, $regis){
      try{
      $conn = Connexion::getConnexion();
      $sql = "INSERT INTO customers values (Null, :firsname, :surname, :add1, :add2, :add3, :city, :poste, :phone, :mail, :regis)";
      $sth = $conn->prepare($sql);
      $sth->execute(array(':firsname' => $firsname, ':surname' => $surname, ':add1' => $add1, ':add2' => $add2, ':add3' => $add3, ':city' => $city, ':poste' => $poste, ':phone' => $phone, ':mail' => $mail, ':regis' => $regis));
      $customer =$sth->fetch(PDO::FETCH_ASSOC);
      return $customer;
    }
    catch (PDOException $e) {
      $erreur = $e->getMessage();
      }
    }

    function newLogin($id, $username, $password){
      try{
      $conn = Connexion::getConnexion();
      $sql = "INSERT INTO logins values (Null, :id, :username, SHA1(:password))";
      $sth = $conn->prepare($sql);
      $sth->execute(array(':id' => $id, ':username' => $username, ':password' => $password));
      $login =$sth->fetch(PDO::FETCH_ASSOC);
      return $login;
    }
    catch (PDOException $e) {
      $erreur = $e->getMessage();
      }
    }


    function getAdresses($id){
      try {
        $conn = Connexion::getConnexion();
        $sql = "SELECT * FROM delivery_addresses where id=:id";
        $sth = $conn->prepare($sql);
        $sth->execute(array(':id' => $id));
        $categories =$sth->fetch(PDO::FETCH_ASSOC);
        return $categories;
      }
      catch (PDOException $e) {
        $erreur = $e->getMessage();
        }
    }


    function getOrders(){
      try {
        $conn = Connexion::getConnexion();
        $sql = "SELECT * FROM orders order by date";
        $sth = $conn->prepare($sql);
        $sth->execute();
        $categories =$sth->fetchAll(PDO::FETCH_ASSOC);
        return $categories;
      }
      catch (PDOException $e) {
        $erreur = $e->getMessage();
        }
    }


    function getOrder($c, $a){
      try {
        $conn = Connexion::getConnexion();
        $sql = "SELECT * FROM orders where customer_id=:c and delivery_add_id=:a and status=1 order by date DESC";
        $sth = $conn->prepare($sql);
        $sth->execute(array(':c' => $c, ':a' => $a));
        $categories =$sth->fetch(PDO::FETCH_ASSOC);
        return $categories;
      }
      catch (PDOException $e) {
        $erreur = $e->getMessage();
        }
    }

    function getOrderItems($id){
      try {
        $conn = Connexion::getConnexion();
        $sql = "SELECT * FROM orderitems where order_id=:id";
        $sth = $conn->prepare($sql);
        $sth->execute(array(':id' => $id));
        $categories =$sth->fetchall(PDO::FETCH_ASSOC);
        return $categories;
      }
      catch (PDOException $e) {
        $erreur = $e->getMessage();
        }
    }

    function payementConfirme($id){
      try{
      $conn = Connexion::getConnexion();
        $sql = "UPDATE orders SET status = 10 where id = :id";
      $sth = $conn->prepare($sql);
      $sth->execute(array(':id' => $id));
      $sth->fetch(PDO::FETCH_ASSOC);
    }
    catch (PDOException $e) {
      $erreur = $e->getMessage();
      }
    }

    function newOrder($id, $r, $add, $s="", $t){
      try{
      $conn = Connexion::getConnexion();
      $sql = "INSERT INTO orders VALUES (NULL, :id, :r, :add, 0, :d , 1, :s, :t)";
      $sth = $conn->prepare($sql);
      $sth->execute(array(':id' => $id, ':r' => $r, ':add' => $add, ':s' => $s, ':t' => $t, ':d' => gmdate("H:i:s")));
      $sth->fetch(PDO::FETCH_ASSOC);
      return;
    }
    catch (PDOException $e) {
      $erreur = $e->getMessage();
      }
    }

    function addAdress($f, $l, $add, $add2, $c, $poste, $phone, $e){
      try{
      $conn = Connexion::getConnexion();
      $sql = "INSERT INTO delivery_addresses VALUES (NULL, :f, :l, :add, :add2, :c, :poste, :p, :e)";
      $sth = $conn->prepare($sql);
      $sth->execute(array(':f' => $f, ':l' => $l, ':add' => $add, ':add2' => $add2, ':c' => $c, ':poste' => $poste, ':p' => $phone, ':e' => $e));
      $address =$sth->fetch(PDO::FETCH_ASSOC);
      return $address;
    }
    catch (PDOException $e) {
      $erreur = $e->getMessage();
      }
    }


    function getAdressesbis($f, $l, $add, $c, $p){
      try {
        $conn = Connexion::getConnexion();
        $sql = "SELECT * FROM delivery_addresses where firstname=:f and lastname=:l and add1=:add and city=:c and phone=:p";
        $sth = $conn->prepare($sql);
        $sth->execute(array(':f' => $f, ':l' => $l, ':add' => $add, ':c' => $c, ':p' => $p));
        $adresse =$sth->fetch(PDO::FETCH_ASSOC);
        return $adresse;
      }
      catch (PDOException $e) {
        $erreur = $e->getMessage();
        }
    }

    function newOrderItem($o, $p, $q){
      try{
      $conn = Connexion::getConnexion();
      $sql = "INSERT INTO orderitems values (Null, :o, :p, :q)";
      $sth = $conn->prepare($sql);
      $sth->execute(array(':o' => $o, ':p' => $p, ':q' => $q));
      $sth->fetch(PDO::FETCH_ASSOC);
      return ;
    }
    catch (PDOException $e) {
      $erreur = $e->getMessage();
      }
    }

    function modifierOrder($id, $p){
      try{
      $conn = Connexion::getConnexion();
      $sql = "UPDATE orders SET status = 2, payment_type=:p  where id = :id";
      $sth = $conn->prepare($sql);
      $sth->execute(array(':id' => $id, ':p' => $p));
      $sth->fetch(PDO::FETCH_ASSOC);
    }
    catch (PDOException $e) {
      $erreur = $e->getMessage();
      }
    }

    public function query($sql,$data = array()){
      $conn = Connexion::getConnexion();
      $req = $conn->prepare($sql);
      $req->execute($data);
      return $req-> fetchAll(PDO::FETCH_ASSOC);
    }
}


 ?>
