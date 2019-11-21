<?php

require_once("bdd.php");

if((isset($_POST["login"]) && $_POST["login"] !== "") && (isset($_POST["password"]) && $_POST["password"] !== ""))
{
    $login = $_POST["login"];
    $password = $_POST["password"];

    if(!check_user($login))
    {
        $user = create_user($login, $password);
        session_start();
        $_SESSION["id"] = $user->id;
        $_SESSION["login"] = $user->login;
        header("Location: index.php");
    }
}

 ?>

 <html>
     <head>
     </head>
     <body>
         <form method="POST" action="inscription.php">
             <label for="login">Login</label>
             <input type="text" id="login" name="login">
             <label for="password">Password</label>
             <input type="password" id="password" name="password">
             <button type="submit">s'inscire</button>
         </form>
     </body>
 </html>
