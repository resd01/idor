<?php

require_once("bdd.php");

session_start();
$mode = 0;
if(isset($_GET["action"]) && ($_GET["action"] === "logout"))
{
    unset($_SESSION);
    session_destroy();
    header("Location: index.php");
}

if(isset($_SESSION) && (count($_SESSION) > 0))
{
    $mode = 1;
    echo "Bonjour ". $_SESSION['login'] . "</br>";

    if((isset($_POST["titre"]) && $_POST["titre"] !== "") && (isset($_POST["article"]) && $_POST["article"] !== ""))
    {
        $titre = $_POST["titre"];
        $article = $_POST["article"];
        create_article($titre, $article, $_SESSION["id"]);
    }

    if(isset($_GET["delete"]) && $_GET["delete"] !== "")
    {
        $id_article = $_GET["delete"];
        delete_article($id_article);
    }

    $articles = get_articles($_SESSION["id"]);

}
elseif((isset($_POST["login"]) && $_POST["login"] !== "") && (isset($_POST["password"]) && $_POST["password"] !== ""))
{
    $login = $_POST["login"];
    $password = $_POST["password"];
    if($user = check_user($login))
    {
        if(md5($password) === $user->password)
        {
            $_SESSION["login"] = $user->login;
            $_SESSION["id"] = $user->id;
            header("Location: index.php");
        }
        else
        {
            echo "bad password";
        }
    }
}

// gestion de l'affichage
if($mode === 1)
{
?>
    <html>
        <head>
            <meta charset="UTF-8">
        </head>
        <body>
            <a href="index.php?action=logout">logout</a></br></br>
            <?php
                foreach($articles as $article)
                {
                    echo "<div style='border:2px solid;'>";
                    echo "Titre: <b>$article->titre</b>";
                    echo "&nbsp;&nbsp;<a href='index.php?delete=$article->id'>del</a></br></br>";
                    echo "Corp: $article->article";
                    echo "</div></br></br>";
                }
            ?>
            <form id="mon_article" method="POST" action="index.php">
                <label for="titre">Titre:</label>
                <input type="text" id="titre" name="titre"></br></br>
                <label for="article">Corps de l'article:</label></br>
                <textarea form="mon_article" id="article" name="article"></textarea></br>
                <button type="submit">envoyer</button>
            </form>
        </body>
    </html>
<?php
}
if($mode === 0)
{
?>
    <html>
        <head>
            <meta charset="UTF-8">
        </head>
        <body>
            <a href="inscription.php">inscription</a>
        </br></br>
            <form method="POST">
                <label for="login">Login</label>
                <input type="text" id="login" name="login">
                <label for="password">Password</label>
                <input type="password" id="password" name="password">
                <button type="submit">s'inscire</button>
            </form>
        </body>
    </html>
<?php
}
