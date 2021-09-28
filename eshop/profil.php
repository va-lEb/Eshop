<?php
include 'inc/init.inc.php';
include 'inc/functions.inc.php';

// Restriction d'accès, si l'utilisateur n'est pas connecté, on redirige vers connexion.php
// Attention, header('location:...') doit être exécutée avant tout affichage dans la page. 
if( !user_is_connected() ) {
    header('location:connexion.php');
}


if($_SESSION['membre']['sexe'] == 'm') {
    $sexe = 'homme';
} else {
    $sexe = 'femme';
}

if($_SESSION['membre']['statut'] == 2) {
    $statut = 'vous êtes administrateur';
} else {
    $statut = 'vous êtes membre';
}

// Les affichages dans la page commencent depuis la ligne suivante :
include 'inc/header.inc.php';
include 'inc/nav.inc.php';
// echo '<pre>'; print_r($_SESSION); echo '</pre>';
?>

<main class="container">
    <div class="bg-light p-5 rounded">
        <h1 class="pb-4 border-bottom"><i class="fas fa-ghost couleur_icone"></i> Profil <i class="fas fa-ghost couleur_icone"></i></h1>
        <p class="lead">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nam ipsa corporis, sit soluta delectus similique non architecto? Atque, id, pariatur magnam doloribus dicta, fuga nisi ipsa odio eius veniam officia.</p>
        <?php echo $msg . '<hr>'; // variable destinée à afficher des messages utilisateur  
        ?>
    </div>

    <div class="row">
        <div class="col-sm-6 mt-5">
            <?php
            // echo $_SESSION['membre']['pseudo']; 
            // si le statut est égal à 2 on affiche vous êtes administrateur sinon on affiche vous êtes membre
            // Pour sexe selon la valeur on affiche homme ou femme


            ?>
            <ul class="list-group">
                <li class="list-group-item bg-indigo text-white" aria-current="true">Vos informations</li>
                
                <li class="list-group-item li_flex"><span><b>N° : </b><?php echo $_SESSION['membre']['id_membre']; ?></span><i class="fas fa-user couleur_icone"></i></li>

                <li class="list-group-item li_flex"><span><b>Pseudo : </b><?php echo $_SESSION['membre']['pseudo']; ?></span><i class="fas fa-ghost couleur_icone"></i></li>

                <li class="list-group-item li_flex"><span><b>Nom : </b><?php echo $_SESSION['membre']['nom']; ?></span><i class="fas fa-signature couleur_icone"></i></li>

                <li class="list-group-item li_flex"><span><b>Prénom : </b><?php echo $_SESSION['membre']['prenom']; ?></span><i class="fas fa-signature couleur_icone"></i></li>

                <li class="list-group-item li_flex"><span><b>Email : </b><?php echo $_SESSION['membre']['email']; ?></span><i class="far fa-envelope couleur_icone"></i></li>

                <li class="list-group-item li_flex"><span><b>Sexe : </b><?php echo $sexe; ?></span><i class="fas fa-venus-mars couleur_icone"></i></li>

                <li class="list-group-item li_flex"><span><b>Ville : </b><?php echo $_SESSION['membre']['ville']; ?></span><i class="fas fa-city couleur_icone"></i></li>

                <li class="list-group-item li_flex"><span><b>Code postal : </b><?php echo $_SESSION['membre']['cp']; ?></span><i class="far fa-address-card couleur_icone"></i></li>

                <li class="list-group-item li_flex"><span><b>Adresse : </b><?php echo $_SESSION['membre']['adresse']; ?></span><i class="fas fa-address-card couleur_icone"></i></li>

                <li class="list-group-item li_flex"><span><b>Statut : </b><?php echo $statut; ?></span><i class="fas fa-user-tag couleur_icone"></i></li>
                
            </ul>
        </div>
        <div class="col-sm-6 mt-5">
            <img src="assets/img/profil.jpg" alt="une image de profil" class="w-100 img-thumbnail">
        </div>
    </div>
</main>

<?php
include 'inc/footer.inc.php';
