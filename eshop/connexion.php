<?php 
include 'inc/init.inc.php';
include 'inc/functions.inc.php';

// Déconnexion utilisateur
if( isset($_GET['action']) && $_GET['action'] == 'deconnexion' ) {
    session_destroy(); // on détruit la session : l'utilisateur n'est plus connecté !
}


// Restriction d'accès, si l'utilisateur est connecté, on le renvoie vers profil.php
if( user_is_connected() ) {
    header('location:profil.php');
}


// Si le formulaire a été validé
if( isset($_POST['pseudo']) && isset($_POST['mdp']) ) {
    $pseudo = trim($_POST['pseudo']);
    $mdp = trim($_POST['mdp']);

    // on déclenche une requete de récupération basée sur le pseudo
    $connexion = $pdo->prepare("SELECT * FROM membre WHERE pseudo = :pseudo");
    $connexion->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
    $connexion->execute();

    // on vérifie s'il y a une ligne récupérée.
    if($connexion->rowCount() > 0) {
        // pseudo ok
        // on doit vérifier le mdp

        $infos = $connexion->fetch(PDO::FETCH_ASSOC);
        // var_dump($infos);
        // password_verify(mdp_du_form, mdp_de_bdd); => true / false
        if(password_verify($mdp, $infos['mdp'])) {
            // mdp ok
            // On place dans la $_SESSION les informations utilisateur (sauf le mdp) dans un sous tableau "membre"
            // L'ouverture de la session provient de init.inc.php
            $_SESSION['membre'] = array();
            $_SESSION['membre']['id_membre'] = $infos['id_membre'];
            $_SESSION['membre']['pseudo'] = $infos['pseudo'];
            $_SESSION['membre']['nom'] = $infos['nom'];
            $_SESSION['membre']['prenom'] = $infos['prenom'];
            $_SESSION['membre']['email'] = $infos['email'];
            $_SESSION['membre']['sexe'] = $infos['sexe'];
            $_SESSION['membre']['ville'] = $infos['ville'];
            $_SESSION['membre']['cp'] = $infos['cp'];
            $_SESSION['membre']['adresse'] = $infos['adresse'];
            $_SESSION['membre']['statut'] = $infos['statut'];    
            // on redirige vers profil.php 
            header('location:profil.php');       


        } else {
            // mdp nok
            $msg .= '<div class="alert alert-danger mt-3">Attention,<br>Erreur sur le pseudo et/ou le mot de passe</div>';
        }

    } else {    
        // pseudo nok
        $msg .= '<div class="alert alert-danger mt-3">Attention,<br>Erreur sur le pseudo et/ou le mot de passe</div>';
    }
}

// Les affichages dans la page commencent depuis la ligne suivante :
include 'inc/header.inc.php';
include 'inc/nav.inc.php';
// echo '<pre>'; print_r($_SESSION); echo '</pre>';
?>

    <main class="container">
        <div class="bg-light p-5 rounded">
            <h1 class="pb-4 border-bottom"><i class="fas fa-ghost couleur_icone"></i> Connexion <i class="fas fa-ghost couleur_icone"></i></h1>
            <p class="lead">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nam ipsa corporis, sit soluta delectus similique non architecto? Atque, id, pariatur magnam doloribus dicta, fuga nisi ipsa odio eius veniam officia.</p>
            <?php echo $msg . '<hr>'; // variable destinée à afficher des messages utilisateur  ?>
        </div>

        <div class="row">
            <div class="col-sm-4 mt-5 mx-auto">
                <form method="post" action="" class="border p-3">
                    <div class="mb-3">
                        <label for="pseudo" class="form-label">Pseudo</label>
                        <input type="text" class="form-control" id="pseudo" name="pseudo" value="">
                    </div>
                    <div class="mb-3">
                        <label for="mdp" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="mdp" name="mdp">
                    </div>
                    <div class="mb-3">
                        <input type="submit" class="btn btn-outline-dark w-100" id="connexion" name="connexion" value="Connexion">
                    </div>
                </form>
            </div>
        </div>
    </main>

<?php 
include 'inc/footer.inc.php';

