<?php 
include 'inc/init.inc.php';
include 'inc/functions.inc.php';

// Vider le panier
if( isset($_GET['action']) &&  $_GET['action'] == 'vider' ) {
    unset($_SESSION['panier']);
    // $msg .= '<div class="alert alert-warning">Le panier </div>';
}

// payer le panier
if( isset($_GET['action']) &&  $_GET['action'] == 'payer' ) {
    unset($_SESSION['panier']);
    $msg .= '<div class="alert alert-success">Merci pour votre commande, le paiement par chèque doit être envoyé à l\'adresse : 1 rue du commerce 75000 Paris.</div>';

    // Contrôle sur la disponibilité des stocks 
    // Enregistrement de la commande en bdd
    // Enregistrement du détails commande en bdd
    // Mise à jour des stocks

    // envoie d'un mail de confirmation
    // mail(...);

}


//  Création du panier :
create_cart();

// on ajoute au panier
if( isset($_POST['id_article']) && isset($_POST['quantite']) ) {
    $recup_article = $pdo->prepare("SELECT * FROM article WHERE id_article = :id_article");
    $recup_article->bindParam(':id_article', $_POST['id_article'], PDO::PARAM_STR);
    $recup_article->execute();

    $infos = $recup_article->fetch(PDO::FETCH_ASSOC);

    add_product($_POST['id_article'], $infos['titre'], $_POST['quantite'], $infos['prix']);

}




// Les affichages dans la page commencent depuis la ligne suivante :
include 'inc/header.inc.php';
include 'inc/nav.inc.php';
// echo '<pre>'; var_dump($_POST); echo '</pre>';
// echo '<pre>'; var_dump($_SESSION); echo '</pre>';
?>

    <main class="container">
        <div class="bg-light p-5 rounded">
            <h1 class="pb-4 border-bottom"><i class="fas fa-ghost couleur_icone"></i> Panier <i class="fas fa-ghost couleur_icone"></i></h1>
            <p class="lead">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nam ipsa corporis, sit soluta delectus similique non architecto? Atque, id, pariatur magnam doloribus dicta, fuga nisi ipsa odio eius veniam officia.</p>
            <?php echo $msg . '<hr>'; // variable destinée à afficher des messages utilisateur  ?>
        </div>

        <div class="row">
            <div class="col-12 mt-5">
                <table class="table table-bordered">
                    <tr>
                        <th>N°</th>
                        <th>Titre</th>
                        <th>Quantité</th>
                        <th>Prix unitaire</th>
                    </tr>

                    <?php 
                    
                    if( empty($_SESSION['panier']['id_article']) ) {
                        echo '<tr>';
                        echo '<td colspan="4" class="text-center"><h4>Votre panier est vide</h4></td>';
                        echo '</tr>';
                    } else {

                        $montant_total = 0;

                        for($i = 0; $i < count($_SESSION['panier']['id_article']); $i++) {
                            echo '<tr>';

                            echo '<td>' . $_SESSION['panier']['id_article'][$i] . '</td>';
                            echo '<td>' . $_SESSION['panier']['titre'][$i] . '</td>';
                            echo '<td>' . $_SESSION['panier']['quantite'][$i] . '</td>';
                            echo '<td>' . $_SESSION['panier']['prix'][$i] . '</td>';

                            echo '</tr>';
                            $montant_total += ($_SESSION['panier']['prix'][$i] * $_SESSION['panier']['quantite'][$i]);
                        }

                        echo '<tr><td colspan="3">Montant total :</td><td>' . $montant_total . ' €</td></tr>';

                        echo '<tr>';

                        echo '<td colspan="2">';

                        if( user_is_connected() ) {
                            echo '<a href="?action=payer" class="btn btn-success">Payer le panier</a>';
                        } else {
                            echo 'Veuillez vous <a href="connexion.php">connecter</a> ou vous <a href="inscription.php">inscrire</a> afin de payer votre panier.';
                        }

                        echo '</td>';

                        echo '<td colspan="2"><a href="?action=vider" class="btn btn-danger confirm_delete">Vider le panier</a></td>';

                        echo '</tr>';

                    }

                    ?>

                </table>
            </div>
        </div>
    </main>

<?php 
include 'inc/footer.inc.php';

