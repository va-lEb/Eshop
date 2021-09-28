<?php
include 'inc/init.inc.php';
include 'inc/functions.inc.php';

// Restriction d'accès, si l'utilisateur est connecté, on le renvoie vers profil.php
if( user_is_connected() ) {
    header('location:profil.php');
}

// Vérification de l'existance des informations provenants du formulaire

// On déclare des variables vides nous permettant de les appeler dans les values de nos champs du form. Si le form est validé, on  récupère dans le if les valeurs dans ces variables, cela permettra d'afficher la valeur par défaut dans le form.
$pseudo = '';
$mdp = ''; // on affiche pas le  mdp dans le form pour ne pas faire peur à l'utilisateur.
$nom = '';
$prenom = '';
$email = '';
$sexe = '';
$ville = '';
$cp = '';
$adresse = '';

// Enregistrement :
if( isset($_POST['pseudo']) && isset($_POST['mdp']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email']) && isset($_POST['sexe']) && isset($_POST['ville']) && isset($_POST['cp']) && isset($_POST['adresse']) ) {

    $pseudo = trim($_POST['pseudo']);
    $mdp = trim($_POST['mdp']);
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $sexe = trim($_POST['sexe']);
    $ville = trim($_POST['ville']);
    $cp = trim($_POST['cp']);
    $adresse = trim($_POST['adresse']);

    // Contrôles :
    // - taille du pseudo
    // - caractères présent dans le pseudo
    // - unicité du pseudo
    // - format du mail
    // - le mdp ne doit pas être vide
    // - taille du code postal et ne doit contenir que des chiffres

    $erreur = false; // variable de contrôle nous permettant dans un deuxième temps plus bas de savoir s'il y a eu une erreur dans nos traitement.

    // - taille du pseudo : entre 4 et 14 caractères inclus
    if( iconv_strlen($pseudo) < 4 || iconv_strlen($pseudo) > 14 ) {
        $msg .= '<div class="alert alert-danger mt-3">Attention,<br>Le pseudo doit avoir entre 4 et 14 caractères inclus.</div>';
        // cas d'erreur 
        $erreur = true;
    }

    // - caractères présent dans le pseudo
    // Afin de vérifier les caractères présents dans le pseudo, nous allons utiliser une expression réguliere (regex)
    // une regex n'est pas du php, on s'en sert via des fonctions de php prévues
    // preg_match() est une fonction prédéfinie permettant de tester une chaine selon une expression régulière fournie en argument.
    // si tous les caractères de la chaine correspondent à notre regex, on obtient 1 sinon 0, et false s'il y a une erreur
    // https://www.php.net/manual/fr/function.preg-match.php
    $verif_caractere = preg_match('#^[a-zA-Z0-9._-]+$#', $pseudo);
    // var_dump($verif_caractere);

    /*
    Explications de la regex
    ------------------------
    #   les # représentent le début et la fin de l'expression (il est possible d'utiliser les /  :'/^[a-zA-Z0-9._-]+$/' )
    ^   dit à la regex que la chaine ne peut commencer que par les caractères entre []
    $   dit à la regex que la chaine ne peut finir que par les caractères entre []
    Le fait de bloquer le début et la fin fait que l'on ne peut avoir que ces caractères dans la chaine.
    +   permet de préciser que l'on peut avoir plusieurs fois le même caractères dans la chaine.
    Entre [] : les caractères autorisés :
    a-z toutes les minuscules
    A-Z toutes les majuscules
    0-9 tous les chiffres
    ._- le point, l'underscore et le tiret sont aussi autorisés.
    */
    if(!$verif_caractere) { // équivalent à : if($verif_caractere == 0)
        $msg .= '<div class="alert alert-danger mt-3">Attention,<br>Caractères autorisés pour le pseudo : A-Z 0-9 _ . -</div>';
        // cas d'erreur 
        $erreur = true;
    }


    // - unicité du pseudo
    // pour savoir si le pseudo est disponible, on lance une requete select basée sur le pseudo, si on récupère des infos, le pseudo est indisponible sinon disponible.
    $verif_pseudo = $pdo->prepare("SELECT * FROM membre WHERE pseudo = :pseudo");
    $verif_pseudo->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
    $verif_pseudo->execute();
    // var_dump($verif_pseudo);
    // var_dump(get_class_methods($verif_pseudo));
    if($verif_pseudo->rowCount() > 0) {
        // pseudo indisponible
        $msg .= '<div class="alert alert-danger mt-3">Attention,<br>Pseudo indisponible.</div>';
        // cas d'erreur 
        $erreur = true;
    }


    // - format du mail
    if( filter_var($email, FILTER_VALIDATE_EMAIL) == false ) {
        $msg .= '<div class="alert alert-danger mt-3">Attention,<br>Format du mail incorrect.</div>';
        // cas d'erreur 
        $erreur = true;
    }


    // - le mdp ne doit pas être vide (ce contrôle est à multiplier pour tous les champs obligatoires)
    // if($mdp == '') {
    // if(iconv_strlen($mdp) < 1) {
    if(empty($mdp)) {
        $msg .= '<div class="alert alert-danger mt-3">Attention,<br>Le mot de passe est obligatoire.</div>';
        // cas d'erreur 
        $erreur = true;
    }


    // - taille du code postal et ne doit contenir que des chiffres
    // https://www.php.net/manual/fr/function.is-numeric.php
    // dans $_POST tout est string
    // is_numeric() nous renvoie true ou false selon si l'information ne contient que des chiffres ou pas.
    // l'intérêt est que cette fonction permet de vérifier si une chaine de caractère ne contient que des chiffres.
    if(iconv_strlen($cp) != 5 || !is_numeric($cp)) {
        $msg .= '<div class="alert alert-danger mt-3">Attention,<br>Le code postal doit être numérique et de taille 5.</div>';
        // cas d'erreur 
        $erreur = true;
    }

    // s'il n'y a pas eu d'erreur, on lance l'enregistrement en bdd
    // if(!$erreur) {}
    if($erreur == false) {

        // cryptage du mdp
        // password_hash($mdp, PASSWORD_DEFAULT) // permet de crypter (hasher) une chaine de caractère
        // Pour la connexion  afin de pouvoir comparer le mdp du form avec celui enregistré on utilisera : 
        // password_verify($mdp, $mdp_bdd)
        $mdp = password_hash($mdp, PASSWORD_DEFAULT);

        // Pour le statut :
        // 1 => membre
        // 2 => admin
        // ...
        $inscription = $pdo->prepare("INSERT INTO membre (pseudo, mdp, nom, prenom, email, sexe, ville, cp, adresse, statut) VALUES (:pseudo, :mdp, :nom, :prenom, :email, :sexe, :ville, :cp, :adresse, 1)");
        $inscription->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
        $inscription->bindParam(':mdp', $mdp, PDO::PARAM_STR);
        $inscription->bindParam(':nom', $nom, PDO::PARAM_STR);
        $inscription->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $inscription->bindParam(':email', $email, PDO::PARAM_STR);
        $inscription->bindParam(':sexe', $sexe, PDO::PARAM_STR);
        $inscription->bindParam(':ville', $ville, PDO::PARAM_STR);
        $inscription->bindParam(':cp', $cp, PDO::PARAM_STR);
        $inscription->bindParam(':adresse', $adresse, PDO::PARAM_STR);
        $inscription->execute();

        /*
            Creez deux comptes :
            login : admin / mdp : admin
            login : test / mdp : test
        */

    }

}

// Les affichages dans la page commencent depuis la ligne suivante :
include 'inc/header.inc.php';
include 'inc/nav.inc.php';
// var_dump($_POST);
?>

<main class="container">
    <div class="bg-light p-5 rounded">
        <h1 class="pb-4 border-bottom"><i class="fas fa-ghost couleur_icone"></i> Inscription <i class="fas fa-ghost couleur_icone"></i></h1>
        <p class="lead">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nam ipsa corporis, sit soluta delectus similique non architecto? Atque, id, pariatur magnam doloribus dicta, fuga nisi ipsa odio eius veniam officia.</p>
        <?php echo $msg . '<hr>'; // variable destinée à afficher des messages utilisateur  ?>
    </div>

    <div class="row">
        <div class="col-12 mt-5">
            <!-- début -->
            <form method="post" action="" class="border p-3">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="pseudo" class="form-label">Pseudo</label>
                            <input type="text" class="form-control" id="pseudo" name="pseudo" value="<?php echo $pseudo; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="mdp" class="form-label">Mot de passe</label>
                            <input type="text" class="form-control" id="mdp" name="mdp">
                        </div>
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="nom" name="nom" value="<?php echo $nom; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="prenom" class="form-label">Prénom</label>
                            <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo $prenom; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="sexe" class="form-label">Sexe</label>
                            <select class="form-control" id="sexe" name="sexe">
                                <option value="m">homme</option>
                                <option value="f" <?php if($sexe == 'f') { echo 'selected'; } ?> >femme</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="ville" class="form-label">Ville</label>
                            <input type="text" class="form-control" id="ville" name="ville" value="<?php echo $ville; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="cp" class="form-label">Code postal</label>
                            <input type="text" class="form-control" id="cp" name="cp" value="<?php echo $cp; ?>">
                        </div>
                        <div class="mb-4">
                            <label for="adresse" class="form-label">Adresse</label>
                            <textarea class="form-control" id="adresse" name="adresse"><?php echo $adresse; ?></textarea>
                        </div>
                        <div class="mb-3">
                            <input type="submit" class="btn btn-outline-dark w-100" id="inscription" name="inscription" value="Inscription">
                        </div>
                    </div>
                </div>
            </form>
            <!-- fin -->
        </div>
    </div>
</main>

<?php
include 'inc/footer.inc.php';
