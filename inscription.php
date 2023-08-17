<?php
session_start();

@$valider = $_POST['valider'];
@$nom = $_POST['nom'];
@$prenom = $_POST['prenom'];
@$login = $_POST['login'];
@$mdp = $_POST['mdp'];
@$mdpbis = $_POST['mdpbis'];
$erreur = "";

require_once("connexion.php");

if (isset($_POST['valider'])) {
    if (!empty($_POST['nom']) and !empty($_POST['prenom']) and !empty($_POST['login']) and !empty($_POST['mdp']) and !empty($_POST['mdpbis'])) {
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $login = htmlspecialchars($_POST['login']);
        $mdp = sha1($_POST['mdp']);
        $mdpbis = sha1($_POST['mdpbis']);
        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $reqmail = $bd->prepare("SELECT * FROM inscription WHERE login=? ");
            $reqmail->execute(array($login));
            $mailexist = $reqmail->rowCount();
            if ($mailexist == 0) {
                if ($mdp == $mdpbis) {

                    $insertmbr = $bd->prepare("INSERT INTO inscription (nom, prenom, login, mot_de_passe, confirmation_mot_de_passe) VALUES (?, ?, ?, ?, ?)");
                    $insertmbr->execute(array($nom, $prenom, $login, $mdp, $mdpbis));


                    $erreur = "votre compte a  bien ete creer";
                    echo $erreur;
                    header("Location: login.php");
                } else {

                    echo "<p style='color:red'> Veuillez saisir le meme mot de passe </p>";
                }
            } else {
                $erreur = "Adresse email deja utiliser";
                echo "<p style='color:red'> $erreur </p>";
            }
        }
    } else {
        $erreur = "Tous les champs doivent etre remplies";
        echo " <p style='color:red'> $erreur </p> ";
    }
}

?>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="mb-3">
            <div class="row g-3">
                <div class="align-items-center my-5 ">
                <h1> Page d'Inscription </h1>
                </div>
                <form action="" method="POST">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" class="form-control" name="nom" id="nom" placeholder="Nom" required>

                    <label for="prenom" class="form-label">Prenom</label>
                    <input type="text" class="form-control" name="prenom" id="prenom" placeholder="Prenom" required>

                    <label for="login" class="form-label">Login</label>
                    <input type="email" class="form-control" name="login" id="login" placeholder="a@gmail.com" required>

                    <label for="mdp" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" name="mdp" id="mdp" placeholder="****" required>

                    <label for="mdpbis" class="form-label">Confirmation Mot de passe</label>
                    <input type="password" class="form-control" name="mdpbis" id="mdpbis" placeholder="****" required> <br>

                    <input type="submit" class="btn btn-success" name="valider" value="Inscription">
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>