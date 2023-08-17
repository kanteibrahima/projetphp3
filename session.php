<?php
session_start();

@$btnajouter=$_POST['btnajouter'];
@$btnpris=$_POST['btnpris'];
@$btnafficher=$_POST['btnafficher'];
@$nomProduit=$_POST['nomProduit'];
@$description=$_POST['description'];
@$quantite=$_POST['quantite'];
$erreur="";

require_once("connexion.php");

if(isset($_POST['btnajouter']))
{
    if(!empty($_POST['nomProduit']) AND !empty($_POST['description']) AND !empty($_POST['quantite']))
    {

        $sql = "INSERT INTO produits (nomProduit, description, quantite) VALUES (?, ?, ?)";
        $stmt = $bd->prepare($sql);
        $stmt->execute(array($nomProduit, $description, $quantite));
        echo " " . $quantite ." ". $nomProduit ." sont stockes dans le magasin";
    }
}


if(isset($_POST['btnpris']))
{
    if(!empty($_POST['nomProduit']) AND !empty($_POST['description']) AND !empty($_POST['quantite']))
    {

        // $sql = "INSERT INTO produitsprise (nomProduit, description, quantite) VALUES (?, ?, ?)";
        // $stmt = $bd->prepare($sql);
        // $stmt->execute(array($nomProduit, $description, $quantite));
        // $ac = $quantite;

        $sql = "UPDATE produits SET quantite = quantite - ?  WHERE nomProduit = ?";
        $stmt = $bd->prepare($sql);
        $stmt->execute([$quantite , $nomProduit]);
        // $stmt->execute(array($quantite , $nomProduit));


        echo " ". $quantite ." " .$nomProduit ." sont pris dans le stock";
    }
}

if(isset($_POST['btnafficher']))
{
    if(!empty($_POST['nomProduit']) )
    {

        $sql = "SELECT quantite FROM produits  WHERE nomProduit = ? ";
        $stmt = $bd->prepare($sql);
        $stmt->execute(array($nomProduit));
        $result = $stmt->fetch();

    if ($result) {
        echo "La Quantite du produit : " . $nomProduit. " disponible en stock est ". $result['quantite'];
    } else {
        echo "Prduit non trouve";
    }

    }
}

?>

<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Session</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
    <body>
        <form action="" method="POST">
            <label for="nomProduit">Produit</label>
            <input type="text" name="nomProduit" id="nomProduit">
            <label for="description">Description du Produit</label>
            <input type="text" name="description" id="description">
            <label for="quantite">Quantite</label>
            <input type="text" name="quantite" id="quantite">
            <input type="submit" name="btnajouter" value="Produit ajouter">
            <input type="submit" name="btnpris" value="Produit prise" >
            <input type="submit" name="btnafficher" value="Afficher" >          
        </form>
<!-- 
        <table>
            <th>PRODUIT</th>
            <th>DESCRIPTION</th>
            <th>QUANTITE</th>
        </table> -->

        <table class="table table-striped">
            <?php
             $sql = "SELECT nomProduit,description,quantite FROM produits";
             $stmt = $bd->query($sql);
            //  $stmt->execute(array());
             $rest = $stmt->fetchAll();
            ?>
            
            <div class="container">
                <div class="table">
                    <thead>
                        <tr>
                            <th scope="col">nomProduit</th>
                            <th scope="col">description</th>
                            <th scope="col">quantite</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($rest as $res)
                        { 
                             echo "<tr>";
                            
                               echo "<td>" . $res['nomProduit'] ."</td>" ;
                               echo "<td>" . $res['description'] ."</td>" ;
                               echo "<td>" . $res['quantite'] ."</td>" ;
                             echo "</tr>";                           
                            
                        }
                        ?>
                    </tbody>
                </div>
            </div>
        </table>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    </body>
</html>