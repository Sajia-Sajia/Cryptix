<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chiffrement et déchiffrement de transposition par colonnes</title>
    <link rel="stylesheet" type="text/css" href="../css/code_css_interface_2.css">
    <link rel="stylesheet" type="text/css" href="../css/code_css_interface3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
	<div class="form-group">
         <i class="fas fa-arrow-left back-arrow" onclick="goBack()"></i>
    </div>

    <div class="container"><h1>Transposition par colonnes</h1>
        <div class="container">
        <form id="myForm" method="post">
            <div class="form-group">
                <label for="cle">La clé :</label>
                <input type="texte" id="cle" placeholder="Entrez la clé" />
            </div>
                <div class="form-group">
                    <label for="texte">Texte en clair/chiffré :</label>
                    <textarea name="texte" placeholder="Entrez le text en clair/chiffré" id="texte"></textarea>
                </div>

                <button type="button" onclick="document.getElementById('number').value=encryptMessage(document.getElementById('texte').value,document.getElementById('cle').value)">Chiffrer</button>
                <button type="button" onclick="document.getElementById('number').value=decryptMessage(document.getElementById('texte').value,document.getElementById('cle').value)">Déchiffrer</button>

                <div class="form-group">
                    <label for="number"><br>Résultat :</label>
                    <textarea id="number" name="resultat" readonly>

                    </textarea>
                </div>

                <button type="button" onclick="resetForm()">Annuler</button>

            </div>

        </form>
    </div>
</body>
<script>
    // Encryption
function encryptMessage(msg,key) {
	let cipher = "";
    msg=msg.replace(/\s+/g, "");
	// track key indices
	let k_indx = 0;

	const msg_len = msg.length;
	const msg_lst = Array.from(msg);
	const key_lst = Array.from(key).sort();

	// calculate column of the matrix
	const col = key.length;

	// calculate maximum row of the matrix
	const row = Math.ceil(msg_len / col);

	// add the padding character '_' in empty
	// the empty cell of the matrix
	const fill_null = (row * col) - msg_len;
	for (let i = 0; i < fill_null; i++) {
		msg_lst.push('');
	}

	// create Matrix and insert message and
	// padding characters row-wise
	const matrix = [];
	for (let i = 0; i < msg_lst.length; i += col) {
		matrix.push(msg_lst.slice(i, i + col));
	}

	// read matrix column-wise using key
	for (let _ = 0; _ < col; _++) {
		const curr_idx = key.indexOf(key_lst[k_indx]);
		for (const row of matrix) {
			cipher += row[curr_idx];
		}
		k_indx++;
	}

	return cipher;
}

// Decryption
function decryptMessage(cipher,key) {
	let msg = "";
    cipher=cipher.replace(/\s+/g, "")
	// track key indices
	let k_indx = 0;

	// track msg indices
	let msg_indx = 0;
	const msg_len = cipher.length;
	const msg_lst = Array.from(cipher);

	// calculate column of the matrix
	const col = key.length;

	// calculate maximum row of the matrix
	const row = Math.ceil(msg_len / col);

	// convert key into list and sort 
	// alphabetically so we can access 
	// each character by its alphabetical position.
	const key_lst = Array.from(key).sort();

	// create an empty matrix to 
	// store deciphered message
	const dec_cipher = [];
	for (let i = 0; i < row; i++) {
		dec_cipher.push(Array(col).fill(null));
	}

	// Arrange the matrix column wise according 
	// to permutation order by adding into a new matrix
	for (let _ = 0; _ < col; _++) {
		const curr_idx = key.indexOf(key_lst[k_indx]);

		for (let j = 0; j < row; j++) {
			dec_cipher[j][curr_idx] = msg_lst[msg_indx];
			msg_indx++;
		}
		k_indx++;
	}

	// convert decrypted msg matrix into a string
	try {
		msg = dec_cipher.flat().join('');
	} catch (err) {
		throw new Error("This program cannot handle repeating words.");
	}

	const null_count = (msg.match(/_/g) || []).length;

	if (null_count > 0) {
		return msg.slice(0, -null_count);
	}

	return msg;
}
    function goBack() {
        window.location.href = "../choix_algo.php";
    }
</script>
</html>