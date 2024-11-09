<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chiffrement et déchiffrement de César</title>
    <link rel="stylesheet" type="text/css" href="../css/code_css_interface_2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<?php
    $texte = '';
    $cle = '';
    $error = '';
function chiffrer($texte, $cle) {
    $resultat = '';
    for ($i = 0; $i < strlen($texte); $i++) {
            $caractere = $texte[$i];

            if (ctype_alpha($caractere)) { // Elle renvoie true si le caractère est un lettre, sinon elle renvoie false. Les caractères non alphabétiques (comme les chiffres ou la ponctuation) sont laissés inchangés.
                $minuscule = (ctype_lower($caractere)); // prendra la valeur true si le caractère contenu dans la variable $caractere est une lettre minuscule, et elle prendra la valeur false sinon.
                $caractere = strtolower($caractere); // la variable $caractere sera converti en minuscules
                $caractere = chr((ord($caractere) - 97 + $cle + 26) % 26 + 97);
                // ord($caractere): Convertit le caractère en sa valeur ASCII.
                // chr(....): Convertit la valeur résultante en un caractère.
                if (!$minuscule) {
                    $caractere = strtoupper($caractere);
                }
            }
            $resultat .= $caractere;
        }
 echo $resultat;   
}

function dechiffrer($texte, $cle) {

    $resultat = '';
    for ($i = 0; $i < strlen($texte); $i++) {
            $caractere = $texte[$i];

            if (ctype_alpha($caractere)) {
                $minuscule = (ctype_lower($caractere)); 
                $caractere = strtolower($caractere); // $caractere sera converti en minuscules
                $caractere = chr((ord($caractere) - 97 - $cle + 26) % 26 + 97); // 26: Ajoute 26 pour éviter les nombres négatifs lors de la division modulo.
                if (!$minuscule) {
                    $caractere = strtoupper($caractere);
                }
            }

            $resultat .= $caractere;
        }
 echo $resultat;      
}
?>
<body>

    <div class="form-group">
         <i class="fas fa-arrow-left back-arrow" onclick="goBack()"></i>
    </div>
        <div class="container"><h1>Chiffrement de César</h1>
        <div class="container">
        <form id="myForm" action="" method="post">
                <div class="form-group">
                <label for="cle">La clé :</label>
                <input type="number" value="<?php if (isset($_POST['cle'])) { echo $_POST['cle']; } ?>" name="cle" id="cle" placeholder="Entrez la clé" required />

</div>
<!-- <div class="container"> -->
    <div class="form-group">
        <label for="texte">Texte en clair/chiffré :</label>
        <textarea name="texte" id="texte" placeholder="Entrez le text en clair/chiffré" required><?php if(isset($_POST['texte'])){
         echo $_POST['texte'];}?></textarea>
    </div>

        <button type="submit" name="chiffrer">Chiffrer</button>
        <button type="submit" name="dechiffrer">Déchiffrer</button>
        
        <div class="form-group">
            <label for="resultat"><br>Résultat :</label>
 <textarea id="number" name="resultat" readonly><?php if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['chiffrer'])) {
        $texte = $_POST['texte'];
        $cle = $_POST['cle'];
        $resultat = chiffrer($texte, $cle);
    } elseif (isset($_POST['dechiffrer'])) {
        $texte = $_POST['texte'];
        $cle = $_POST['cle'];
        $resultat = dechiffrer($texte, $cle);
    }
}?></textarea>
        </div>
    <button type="button" onclick="resetForm()">Annuler</button>            
</div>
</form>
</div>
<script type="text/javascript">
function resetForm() {
        document.getElementById("myForm").reset();
    }
function goBack() {
        window.location.href = "../choix_algo.php";
    }
</script>
</body>
</html>