<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Cryptix/Hill</title>
	<link rel="stylesheet" type="text/css" href="../css/code_css_interface_2.css">
	<link rel="stylesheet" type="text/css" href="../css/code_css_interface4.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<?php
$error = '';
$error2 = '';
function PGCD($a, $b){
		while ($b != 0) {
		$temp = $b;
		$b = $a % $b;
		$a = $temp;
		}
		return $a;
	}
function isCopremieravec26($number) {
    return (PGCD($number, 26) == 1);
}
function determinant($matrice) {
    return $matrice[0][0] * $matrice[1][1] - $matrice[0][1] * $matrice[1][0];
}
function modInverse($a, $n) {
    $n0 = $n;
    $x0 = 0;
    $resu = 1;

    while ($a > 1) {
        $q = intval($a / $n);
        $t = $n;
        $n = $a % $n;
        $a = $t;
        $t = $x0;
        $x0 = $resu - $q * $x0;
        $resu = $t;
    }

    if ($resu < 0) {
        $resu += $n0;
    }

    return $resu;
}	
function inverseMatrice($cle,$detInv) {
		//global $error ;

		$inversecle = [
		[
		($cle[1][1] * $detInv) % 26,
		(-$cle[0][1] * $detInv + 26) % 26,
		],
		[
		(-$cle[1][0] * $detInv + 26) % 26,
		($cle[0][0] * $detInv) % 26,
		],
		];
		return $inversecle;
	}
function chiffrer($text,$cle){
	  if (!preg_match("/^[A-Za-z \r\n]+$/", $text)) { 
	  		return false; // \r\n pour les retours a la ligne windows
	  }else{
	$text = preg_replace("/[^A-Za-z]/", '', strtoupper($text));// Convertir le texte en majuscules
   
    // Assurer que la longueur du texte est un multiple de la taille de la matrice
    $cleLength = count($cle);
    $textLength = strlen($text);
    $paddingLength = ($cleLength - ($textLength % $cleLength)) % $cleLength;

    if ($paddingLength > 0) {
        $text .= str_repeat('X', $paddingLength);
    }
	// Vérification du déterminant et de la co-primalité
    $det = determinant($cle);
    if ($det != 0 && isCopremieravec26($det)) {
	
		// Correction des indices négatifs 
        for ($i = 0; $i < $cleLength; $i++) {
            for ($j = 0; $j < $cleLength; $j++) {
                $cle[$i][$j] = $cle[$i][$j]  % 26;
                if ($cle[$i][$j] < 0) {
                    $cle[$i][$j] += 26;
                }
            }
        }
    $result = '';
    $blockSize = 2;

    for ($i = 0; $i < $textLength; $i += $blockSize) {
        $block = substr($text, $i, $blockSize);
        $blockVector = [];

        // Convertir le bloc en vecteur de nombres (indices des lettres dans l'alphabet)
        for ($j = 0; $j < $blockSize; $j++) {
            $blockVector[] = ord($block[$j]) - ord('A');
        }

        // Effectuer le chiffrement de Hill
        $encryptedVector = [];
        for ($row = 0; $row < $cleLength; $row++) {
            $value = 0;
            for ($col = 0; $col < $cleLength; $col++) {
                $value += $cle[$row][$col] * $blockVector[$col];
            }
            $encryptedVector[] = $value % 26;
        }

        // Convertir le vecteur chiffré en texte chiffré
        for ($j = 0; $j < $blockSize; $j++) {
            $result .= chr($encryptedVector[$j] + ord('A'));
        }
    }
    return $result;
}else{
	return true;
}
}
	}
function dechiffrer($text, $cle) {
    if (!preg_match("/^[A-Za-z \r\n]+$/", $text)) {
        return false; // \r\n pour les retours a la ligne windows
    } else {
        $text = preg_replace("/[^A-Za-z]/", '', strtoupper($text)); // Convertir en majuscules et garder que les lettres

        // Assurer que la longueur du texte est un multiple de la taille de la matrice
        $cleLength = count($cle);
        $textLength = strlen($text);
        $paddingLength = ($cleLength - ($textLength % $cleLength)) % $cleLength;

        if ($paddingLength > 0) {
            $text .= str_repeat('X', $paddingLength);
        }

        // Vérifier si la matrice est inversible
        $det = determinant($cle);
        if ($det != 0 && isCopremieravec26($det)) {

            // Calculer l'inverse du déterminant modulo 26
            $detInverse = modInverse($det, 26);

            // Calculer la matrice inverse modulo 26
            $matriceInverse = inverseMatrice($cle,$detInverse);

            // Correction des indices négatifs à l'aide de l'inverse modulaire
            for ($i = 0; $i < $cleLength; $i++) {
                for ($j = 0; $j < $cleLength; $j++) {
                    $matriceInverse[$i][$j] = $matriceInverse[$i][$j] % 26;
                    if ($matriceInverse[$i][$j] < 0) {
                        $matriceInverse[$i][$j] += 26;
                    }
                }
            }

            $result = '';
            $blockSize = 2;

            for ($i = 0; $i < strlen($text); $i += $blockSize) {
                $block = substr($text, $i, $blockSize);
                $blockVector = [];

                // Convertir le bloc en vecteur de nombres (indices des lettres dans l'alphabet)
                for ($j = 0; $j < $blockSize; $j++) {
                    $blockVector[] = ord($block[$j]) - ord('A');
                }

                // Effectuer le déchiffrement de Hill
                $decryptedVector = [];
                for ($row = 0; $row < $cleLength; $row++) {
                    $value = 0;
                    for ($col = 0; $col < $cleLength; $col++) {
                        $value += $matriceInverse[$row][$col] * $blockVector[$col];
                    }
                    $decryptedVector[] = $value % 26;
                }

                // Convertir le vecteur déchiffré en texte déchiffré
                for ($j = 0; $j < $blockSize; $j++) {
                    $result .= chr($decryptedVector[$j] + ord('A')); // Assurer la positivité modulo 26
                }
            }
            return $result;
        } else {
            return true;
        }
    }
}

?>
<body>
		<!-- <form id="myForm" method="post" onsubmit="return false;"> -->
	<div class="form-group">
         <i class="fas fa-arrow-left back-arrow" onclick="goBack()"></i>
    </div>
	<div class="cont">
	<h1>Chiffrement de Hill</h1>
	<form id="myForm" method="post">
	<div class="container">
	<div class="left-side">
	<div class="form-group">
		<label for="matrice11">Coefficient (1,1) :</label>
		<input type="number" name="matrice11" id="matrice11" placeholder="Entrez le coefficient (1,1)" value="<?php if (isset($_POST['matrice11'])) { echo $_POST['matrice11']; } ?>" required />
	</div>
		<div class="form-group">
		<label for="matrice12">Coefficient (1,2) :</label>
		<input type="number" name="matrice12" id="matrice12" placeholder="Entrez le coefficient (1,2)" value="<?php if (isset($_POST['matrice12'])) { echo $_POST['matrice12']; } ?>" required />
	</div>
	<div class="form-group">
		<label for="matrice21">Coefficient (2,1) :</label>
		<input type="number" name="matrice21" id="matrice21" placeholder="Entrez le coefficient (2,1)" value="<?php if (isset($_POST['matrice21'])) { echo $_POST['matrice21']; } ?>" required />
	</div>
		<div class="form-group">
		<label for="matrice22">Coefficient (2,2) :</label>
		<input type="number" name="matrice22" id="matrice22" placeholder="Entrez le coefficient (2,2)" value="<?php if (isset($_POST['matrice22'])) { echo $_POST['matrice22']; } ?>" required />
	</div>
	</div>
	<div class="right-side">

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
		$texte = $_POST['texte'] ;
		$cle = [[$_POST['matrice11'] , $_POST['matrice12']] , [$_POST['matrice21'] , $_POST['matrice22']]] ;
		$result = chiffrer($texte,$cle);
		$result2 = dechiffrer($texte,$cle);
		if (isset($_POST['chiffrer'])) {
		// echo chiffrer($texte, $cle);
				if($result ===false){
					$error = "Attention : Le texte ne doit contenir que des lettres et des espaces.";
				}elseif($result ===true){
					$error = "Attention : La matrice n'est pas valide pour le chiffrement de Hill.";
				}else{
					echo $result;
				}
		} elseif (isset($_POST['dechiffrer'])) {
		// echo dechiffrer($texte, $cle);
		if($result2 ===false){
					$error = "Attention : Le texte ne doit contenir que des lettres et des espaces.";
				}elseif($result2 ===true){
					$error = "Attention : La matrice n'est pas valide pour le chiffrement de Hill.";
				}else{
					echo $result2;
				}
		}
		}?></textarea>
	</div>
	<button type="button" onclick="resetForm()">Annuler</button>
	</div>
</div>
<?php
if(!empty($error)){
		 echo "<div class=\"contai\">";

		echo $error;

		echo "</div>";
	}
?>
</form>
</div>

<script type="text/javascript">
	// Vérifier si une erreur est présente et afficher une alerte
	// if (<?php echo !empty($error) ? 'true' : 'false'; ?>) {
	//     alert('<?php echo $error; ?>');
	// }
function resetForm() {
		document.getElementById("myForm").reset();
	}
function goBack() {
        window.location.href = "../choix_algo.php";
	}
</script>
</body>
</html>