<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chiffrement et déchiffrement par Vigenère</title>
    <link rel="stylesheet" type="text/css" href="../css/code_css_interface_2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<?php
function chiffrer($text, $cle) {
    $text = strtoupper($text);
    $cle = strtoupper($cle);
    $result = '';

    $cleLength = strlen($cle);
    for ($i = 0, $j = 0; $i < strlen($text); $i++) {
        $char = $text[$i];

        if (ctype_alpha($char)) {
            $offset = ord('A');
            $result .= chr((ord($char) + ord($cle[$j % $cleLength]) - 2 * $offset) % 26 + $offset);
            $j++;
        } else {
            $result .= $char;
        }
    }

    return $result;
}
function dechiffrer($text, $cle) {
    $text = strtoupper($text);
    $cle = strtoupper($cle);
    $result = '';

    $cleLength = strlen($cle);
    for ($i = 0, $j = 0; $i < strlen($text); $i++) {
        $char = $text[$i];

        if (ctype_alpha($char)) {
            $offset = ord('A');
            $result .= chr((ord($char) - ord($cle[$j % $cleLength])+ 26) % 26 + $offset);
            $j++;
        } else {
            $result .= $char;
        }
    }

    return $result;
}
?>

<body>
       
    <div class="form-group">
         <i class="fas fa-arrow-left back-arrow" onclick="goBack()"></i>
    </div>

    <div class="container">
        <h1>Chiffrement de Vigenère</h1>
        <div class="container">
        <form id="myForm" method="post">
	 <div class="form-group">
                <label for="cle">La clé :</label>
                <input type="text" value="<?php if (isset($_POST['cle'])) { echo $_POST['cle']; } ?>" name="cle" id="cle" placeholder="Entrez la clé" required />
	
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
       echo chiffrer($texte, $cle);
    } elseif (isset($_POST['dechiffrer'])) {
        $texte = $_POST['texte'];
        $cle = $_POST['cle'];
        echo dechiffrer($texte, $cle);
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