<?php 
include 'inc/init.inc.php';
include 'inc/functions.inc.php';

    // CODE ...

// Les affichages dans la page commencent depuis la ligne suivante :
include 'inc/header.inc.php';
include 'inc/nav.inc.php';
?>

    <main class="container">
        <div class="bg-light p-5 rounded">
            <h1 class="pb-4 border-bottom"><i class="fas fa-ghost couleur_icone"></i> Eshop <i class="fas fa-ghost couleur_icone"></i></h1>
            <p class="lead">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nam ipsa corporis, sit soluta delectus similique non architecto? Atque, id, pariatur magnam doloribus dicta, fuga nisi ipsa odio eius veniam officia.</p>
            <?php echo $msg . '<hr>'; // variable destinée à afficher des messages utilisateur  ?>
        </div>

        <div class="row">
            <div class="col-12 mt-5">

            </div>
        </div>
    </main>

<?php 
include 'inc/footer.inc.php';

