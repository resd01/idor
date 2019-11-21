<?php


function bdd()
{
    $login_bdd ="root";
    $servername = "localhost";
    $bddpwd = "";

    $_con = new PDO("mysql:host=$servername;dbname=idor;charset=UTF8", $login_bdd, $bddpwd);
    $_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $_con;
}


function check_user($login)
{

    $r = bdd()->prepare("SELECT * FROM users WHERE login=:login");
    $r->bindParam(":login", $login);
    $r->execute();
    $user = $r->fetch(PDO::FETCH_OBJ);

    return $user;
}


function get_articles($id_user)
{
    $r = bdd()->prepare("SELECT * FROM articles WHERE id_user=:id_user");
    $r->bindParam(":id_user", $id_user);
    $r->execute();
    $articles = $r->fetchAll(PDO::FETCH_OBJ);

    return $articles;
}

function delete_article($id_article, $id_user)
{
    $r = bdd()->prepare("DELETE FROM articles WHERE id=:id AND id_user=:id_user");
    $r->bindParam(":id", $id_article);
    $r->bindParam(":id_user", $id_user);
    $r->execute();
}

function create_article($titre, $article, $id_user)
{
    $r = bdd()->prepare("INSERT INTO articles (titre, article, id_user) VALUES(:titre, :article, :id_user)");
    $r->bindParam(":titre", $titre);
    $r->bindParam(":article", $article);
    $r->bindParam(":id_user", $id_user);
    $r->execute();
}

function create_user($login, $password)
{

    $password = md5($password);

    $r = bdd()->prepare("INSERT INTO users (login, password) VALUES(:login, :password)");
    $r->bindParam(":login", $login);
    $r->bindParam(":password", $password);
    $r->execute();

    return check_user($login);
}

 ?>
