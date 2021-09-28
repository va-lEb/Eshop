<?php
include 'inc/init.inc.php';
include 'inc/functions.inc.php';


// Récupération des catégories 
$liste_categories = $pdo->query("SELECT DISTINCT categorie FROM article ORDER BY categorie"); // requete


// Récupération des articles
if( isset($_GET['categorie']) ) {
    $liste_articles = $pdo->prepare("SELECT * FROM article WHERE categorie = :categorie ORDER BY categorie, titre");
    $liste_articles->bindParam(':categorie', $_GET['categorie'], PDO::PARAM_STR);
    $liste_articles->execute();
} else {
    $liste_articles = $pdo->query("SELECT * FROM article ORDER BY categorie, titre");
}



// Les affichages dans la page commencent depuis la ligne suivante :
include 'inc/header.inc.php';
include 'inc/nav.inc.php';
?>
<main class="container">
    <div class="bg-light p-5 rounded">
        <h1 class="pb-4 border-bottom"><i class="fas fa-ghost couleur_icone"></i> Eshop <i class="fas fa-ghost couleur_icone"></i></h1>
        <p class="lead">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nam ipsa corporis, sit soluta delectus similique non architecto? Atque, id, pariatur magnam doloribus dicta, fuga nisi ipsa odio eius veniam officia.</p>
        <?php echo $msg . '<hr>'; // variable destinée à afficher des messages utilisateur  
        ?>
    </div>

    <div class="row">
        <div class="col-sm-3 mt-5">
            <ul class="list-group">
                <li class="list-group-item bg-indigo text-white" aria-current="true">Catégories : </li>
                <li class="list-group-item"><a href="<?php echo URL; ?>">Tous les articles</a></li>
                <?php
                // EXERCICE : listez les catégories (sans doublon) dans une liste ul li, les catégories doivent être en lien a href=""
                while ($ligne = $liste_categories->fetch(PDO::FETCH_ASSOC)) {
                    // var_dump($ligne);
                    echo '<li class="list-group-item"><a href="?categorie=' . $ligne['categorie'] . '">' . ucfirst($ligne['categorie']) . '</a></li>';
                    // ucfirst() fonction prédéfinie pour avoir la première lettre d'une chaine en majuscule.
                }
                ?>
            </ul>

        </div>
        <div class="col-sm-9 mt-5">
            <div class="row">
            <?php
            while ($article = $liste_articles->fetch(PDO::FETCH_ASSOC)) {
                // var_dump($article);
                echo '
                <div class="col-sm-6 col-lg-3 col-md-4 mb-3">
                    <div class="card">
                        <img src="' . URL . 'assets/img_articles/' . $article['photo'] . '" class="card-img-top" alt="Une image article : ' . $article['titre'] . '">
                        <div class="card-body">
                            <h5 class="card-title">' . ucfirst($article['titre']) . '</h5>
                            <p class="card-text">Catégorie : ' . $article['categorie'] . '<br>Prix : ' . $article['prix'] . ' €</p>
                            <a href="fiche_article.php?id_article=' . $article['id_article'] . '" class="btn btn-outline-dark w-100">Fiche article</a>
                        </div>
                    </div>
                </div>';
            }

            ?>            
            </div>
        </div>
    </div>
</main>

<?php
include 'inc/footer.inc.php';
