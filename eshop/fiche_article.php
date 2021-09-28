<?php
include 'inc/init.inc.php';
include 'inc/functions.inc.php';

if (isset($_GET['id_article'])) {
    $recup_article = $pdo->prepare("SELECT * FROM article WHERE id_article = :id_article");
    $recup_article->bindParam(':id_article', $_GET['id_article'], PDO::PARAM_STR);
    $recup_article->execute();

    // on vérifie si on a une ligne (si on a bien récupéré un article)
    if ($recup_article->rowCount() < 1) {
        // on redirige vers index
        header('location:index.php');
    }
} else {
    header('location:index.php');
}

// on traite la ligne avec fetch
$infos_article = $recup_article->fetch(PDO::FETCH_ASSOC);
// var_dump($infos_article);

// Les affichages dans la page commencent depuis la ligne suivante :
include 'inc/header.inc.php';
include 'inc/nav.inc.php';
?>

<main class="container">
    <div class="bg-light p-5 rounded">
        <h1 class="pb-4 border-bottom"><i class="fas fa-ghost couleur_icone"></i> <?php echo $infos_article['titre']; ?> <i class="fas fa-ghost couleur_icone"></i></h1>
        <p class="lead"><?php echo $infos_article['description']; ?></p>
        <?php echo $msg . '<hr>'; // variable destinée à afficher des messages utilisateur ?>
    </div>

    <div class="row">
        <div class="col-sm-6 mt-5">

            <?php if($infos_article['stock'] == 0) { ?>
             
            <p class="alert alert-danger">Rupture de stock pour cet article</p>    
                
            <?php } else { ?>

            <form method="post" action="panier.php">
                <input type="hidden" name="id_article" value="<?php echo $infos_article['id_article']; ?>">
                <div class="row">
                    <div class="col-3">
                        <select name="quantite" class="form-control">
                        <?php 
                            // une boucle pour afficher la quantité, on limite selon le stock ou maximum 5
                            for($i = 1; $i <= $infos_article['stock'] && $i <= 5; $i++) {
                                echo '<option>' . $i . '</option>';
                            }                        
                        ?>
                        </select>
                    </div>
                    <div class="col-9">
                        <input type="submit" name="ajouter_panier" value="Ajouter au panier" class="btn btn-outline-dark w-100">
                    </div>
                </div>
            </form>

            <?php }  ?>

            <hr>

            <ul class="list-group">
                <li class="list-group-item bg-indigo text-white" aria-current="true">Details :</li>
                <li class="list-group-item"><b>N° :</b> <?php echo $infos_article['id_article']; ?> </li>
                <li class="list-group-item"><b>Référence :</b> <?php echo $infos_article['reference']; ?> </li>
                <li class="list-group-item"><b>Titre :</b> <?php echo $infos_article['titre']; ?> </li>
                <li class="list-group-item"><b>Catégorie :</b> <?php echo $infos_article['categorie']; ?> </li>
                <li class="list-group-item"><b>Couleur :</b> <?php echo $infos_article['couleur']; ?> </li>
                <li class="list-group-item"><b>Taille :</b> <?php echo $infos_article['taille']; ?> </li>
                <li class="list-group-item"><b>Sexe :</b> <?php echo $infos_article['sexe']; ?> </li>
                <li class="list-group-item"><b>Prix :</b> <?php echo $infos_article['prix']; ?> € </li>
                <li class="list-group-item"><b>Stock :</b> <?php echo $infos_article['stock']; ?> </li>
                <li class="list-group-item"><b>Description :</b> <?php echo $infos_article['description']; ?> </li>
            </ul>
        </div>
        <div class="col-sm-6 mt-5">
            <img src="<?php echo URL . 'assets/img_articles/' . $infos_article['photo']; ?>" alt="Image de l'article : <?php echo $infos_article['titre']; ?>" class="img-thumbnail w-100">
        </div>
    </div>
</main>

<?php
include 'inc/footer.inc.php';
