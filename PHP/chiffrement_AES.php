<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chiffrement et déchiffrement de AES</title>
    <link rel="stylesheet" type="text/css" href="../css/code_css_interface_2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<style type="text/css">
    .contai {
        max-width: 800px;
        margin: 10px auto;
        margin: 0 auto;
        padding: 16px 10px;
        margin-top: 1px;
        background-color: rgba(255, 255, 255, 0.7);
        border-radius: 12px;
        color: red;
        box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
        }
</style>
<body>
    <?php
        function hexToBin($hex){
    return hex2bin(str_replace(' ', '', $hex));
}
?>

    <div class="form-group">
         <i class="fas fa-arrow-left back-arrow" onclick="goBack()"></i>
    </div>

     <div class="container">
        <h1>Chiffrement de AES</h1>
        <div class="container">
        <form id="myForm" method="post">
     <div class="form-group">
                <label for="cle">La clé :</label>
                <input type="text" value="<?php if (isset($_POST['cle'])) { echo $_POST['cle']; } ?>" name="cle" id="cle" placeholder="Entrez la clé" required />
    
    </div>

    <div class="form-group">
        <label for="texte">Texte en clair/chiffré :</label>
        <textarea name="texte" id="texte" placeholder="Entrez le text en clair/chiffré" required><?php if(isset($_POST['texte'])){
         echo $_POST['texte'];}?></textarea>
    </div>
    <div class="form-group">
                <label for="input_type">Type d'entrée:</label>
                <select class="form-control" id="input_type" name="input_type">
                    <option value="text">Texte</option>
                    <option value="hex">Hexadécimal</option>
                </select>
    </div>

        <button type="submit" name="chiffrer">Chiffrer</button>
        <button type="submit" name="dechiffrer">Déchiffrer</button>

        <div class="form-group">
            <label for="resultat"><br>Résultat :</label>
 <textarea id="number" name="resultat" readonly><?php if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $message = $_POST['texte'];
        $key = $_POST['cle'];
        $resultat = '';
        $resultat2 = '';
        $inputType = $_POST["input_type"];
        if ($inputType == "hex") {
        $message = hexToBin($message);
        $key = hexToBin($key);
        }
    if (isset($_POST['chiffrer'])) {
         $ciphertext = bin2hex(openssl_encrypt($message, 'aes-128-ecb', $key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING));
        //$resultat =$ciphertext;
        echo $ciphertext;
        }elseif (isset($_POST['dechiffrer'])){
  $decrypted = bin2hex(openssl_decrypt($message, 'aes-128-ecb', $key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING));
$resultat2 = $decrypted;
echo $resultat2;
        }

    }
?></textarea>
        </div>
    <button type="button" onclick="resetForm()">Annuler</button>

</div>
<?php
if(!empty($erreur)){
         echo "<div class=\"contai\">";

        echo $erreur;

        echo "</div>";
    }
if(!empty($erreur2)){
     echo "<div class=\"contai\">";

    echo $erreur2;

    echo "</div>";
}
?>
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