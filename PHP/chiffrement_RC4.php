<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chiffrement et déchiffrement par RC4</title>
    <link rel="stylesheet" type="text/css" href="../css/code_css_interface_2.css">
    <link rel="stylesheet" type="text/css" href="../css/code_css_interface3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
    <div class="form-group">
         <i class="fas fa-arrow-left back-arrow" onclick="goBack()"></i>
    </div>
    <div class="container">
        <h1>Chiffrement par RC4</h1>
        <div class="container">
        <form id="myForm" method="post">

            <p class="erreurCle"> </p>
            <p class="erreurChar"></p>
            <p class="erreurChiffre"> </p>
            <p class="erreurFrappe"></p>

            <div class="form-group">
                <label for="cle">La clé :</label>
                <input type="number" id="nombre" placeholder="Entrez la clé" >
            </div>
            <div class="form-group">
                <label for="cle">La taille de s :</label>
                <input type="number" id="nombre1" placeholder="Taille de S">
            </div>
            <div id="tableau-container"></div>
                <div class="form-group">
                    <label for="texte">Texte en clair/chiffré :</label>
                    <textarea name="texte" placeholder="Entrez le text en clair/chiffré" id="texte"></textarea>
                </div>

                <button type="button" onclick="document.getElementById('number').value = rc4(document.getElementById('nombre').value,document.getElementById('texte').value,document.getElementById('nombre1').value)">Chiffrer</button>
                <button type="button" onclick="document.getElementById('number').value = rc4dech(document.getElementById('nombre').value,document.getElementById('texte').value,document.getElementById('nombre1').value)">Dechiffrer</button>

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
    function rc4(key, input, n) {
        let S = [];
        let K = [];
        input = input.replace(/\s+/g, "");
        for (let i = 0; i < n; i++) {
            S[i] = i;
            K[i] = key[i % key.length];
        }
        let j = 0;
        for (let i = 0; i < n; i++) {
            j = (parseInt(j) + parseInt(S[i]) + parseInt(K[i])) % n;
            const x = S[i];
            S[i] = S[j];
            S[j] = x;
        }

        let i = 0;
        j = 0;
        const output = [];
            for (let k = 0; k < input.length; k++) {
                console.log(input.length);
                i = (i + 1) % 10;
                j = (j + parseInt(S[i])) % n; 
                const x = S[i];
                S[i] = S[j];
                S[j] = x;
                const temp = (parseInt(S[i]) + parseInt(S[j])) % n;
                console.log(temp);
                const keystream = S[temp] ^ input[k];
                output.push(keystream);
            }

        return output;
   }
   function rc4dech(key, input, n) {
        let S = [];
        let K = [];
        input = input.replace(/\s+/g, "");
        for (let i = 0; i < n; i++) {
            S[i] = i;
            K[i] = key[i % key.length];
        }
        let j = 0;
        for (let i = 0; i < n; i++) {
            j = (parseInt(j) + parseInt(S[i]) + parseInt(K[i])) % n;
            const x = S[i];
            S[i] = S[j];
            S[j] = x;
        }

        let i = 0;
        j = 0;
        const output = [];
            for (let k = 0; k < input.length; k++) {
                console.log(input.length);
                i = (i + 1) % 10;
                j = (j + parseInt(S[i])) % n; 
                const x = S[i];
                S[i] = S[j];
                S[j] = x;
                const temp = (parseInt(S[i]) + parseInt(S[j])) % n;
                console.log(temp);
                const keystream = S[temp] ^ input[k];
                output.push(keystream);
            }

        return output;
   }
//     function rc4(key, input) {
//     let S = [];
//     let K = [];
//     input = input.replace(/\s+/g, "");
//     for (let i = 0; i < 256; i++) {
//         S[i] = i;
//         K[i] = key[i % key.length].charCodeAt(0);
//     }
//     let j = 0;
//     for (let i = 0; i < 256; i++) {
//         j = (j + S[i] + K[i]) % 256;
//         const temp = S[i];
//         S[i] = S[j];
//         S[j] = temp;
//     }

//     let i = 0;
//     j = 0;
//     const output = [];
//     for (let k = 0; k < input.length; k++) {
//         i = (i + 1) % 256;
//         j = (j + S[i]) % 256;
//         const temp = S[i];
//         S[i] = S[j];
//         S[j] = temp;
//         const keystream = S[(S[i] + S[j]) % 256];
//         const encryptedChar = keystream ^ input[k].charCodeAt(0);
//         output.push(encryptedChar);
//     }

//     return output;
// }
   function goBack() {
        window.location.href = "../choix_algo.php";
    }
</script>
</script>

</html>