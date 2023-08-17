<?php
session_start();

@$btnconnexion = $_POST['btnconnexion'];
@$mailconnect = $_POST['mailconnect'];
@$mdpconnect = $_POST['mdpconnect'];
$erreur = "";

require_once("connexion.php");

if (isset($_POST['btnconnexion'])) {
    $mailconnect = htmlspecialchars($_POST['mailconnect']);
    $mdpconnect = sha1($_POST['mdpconnect']);
    if (!empty($_POST['mailconnect']) and !empty($_POST['mdpconnect'])) {
        $requser = $bd->prepare("SELECT * FROM inscription WHERE login=? AND mot_de_passe=? ");
        $requser->execute(array($mailconnect, $mdpconnect));
        $userexist = $requser->rowCount();

        if ($userexist == 1) {
            $userinfo = $requser->fetch();
            $_SESSION['id']  = $userinfo['id'];
            $_SESSION['nom'] = $userinfo['nom'];
            $_SESSION['prenom'] = $userinfo['prenom'];
            $_SESSION['login'] = $userinfo['login'];
            header('Location: session.php?id=' . $_SESSION['id']);
        } else {
            $erreur = "Mail ou mot de passe incorrect";
            echo "<p style='color:red'> $erreur </p>";
        }
    } else {
        // $erreur = "Tous les champs doivent etre remplies";
        // echo "<p style='color:red'> $erreur </p>";
    }
}

?>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>
    <div class="container align-items-center">
        <div class="row">
            <div class="col-6">
                <div class="py-6 m-5 ">
                    <h1> Page de connexion </h1> <br>
                    <form action="" method="POST">
                        <input type="email" class="form-control form-control-lg" name="mailconnect" id="mailconnect" placeholder="iam@gmail.com" required /> <br>
                        <input type="password" class="form-control form-control-lg" name="mdpconnect" id="mdpconnect" placeholder="****" required /> <br>
                        <input type="submit" class="btn btn-primary" name="btnconnexion" value="Se Connecter" />
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>