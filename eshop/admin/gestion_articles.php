<?php 
include '../inc/init.inc.php';
include '../inc/functions.inc.php';

// Restriction d'accès, si l'utilisateur n'est pas admin, on le redirige vers connexion.php
if( !user_is_admin() ) {
    header('location:../connexion.php');
    exit(); // bloque l'exécution du code à la suite de cette ligne.
}

//--------------------------------------------------------------------------
//--------------------------------------------------------------------------
// SUPPRESSION ARTICLE
//--------------------------------------------------------------------------
//--------------------------------------------------------------------------
if( isset($_GET['action']) && $_GET['action'] == 'supprimer' && !empty($_GET['id_article']) ) {
    $suppression = $pdo->prepare("DELETE FROM article WHERE id_article = :id_article");
    $suppression->bindParam(':id_article', $_GET['id_article'], PDO::PARAM_STR);
    $suppression->execute();
}

//--------------------------------------------------------------------------
//--------------------------------------------------------------------------
// ENREGISTREMENT & MODIFICATION ARTICLE 
//--------------------------------------------------------------------------
//--------------------------------------------------------------------------
$id_article = ''; // pour la modif
$ancienne_photo = ''; // pour la modif

$reference = '';
$categorie = '';
$titre = '';
$description = '';
$couleur = '';
$taille = '';
$sexe = '';
$prix = '';
$stock = '';
$photo = '';
// si le formulaire a été validé : isset de tous les champs sauf pour la Photo !
// Les pièces jointes d'un formulaire (input type="file") seront dans la superglobale $_FILES
// Ne pas oublier cet attribut sur la balisse form : enctype="multipart/form-data" sinon on ne récupère pas les pièces jointes.
if( isset($_POST['reference']) && isset($_POST['categorie']) && isset($_POST['titre']) && isset($_POST['description']) && isset($_POST['couleur']) && isset($_POST['taille']) && isset($_POST['sexe']) && isset($_POST['prix']) && isset($_POST['stock']) ) {

    $reference = trim($_POST['reference']);
    $categorie = trim($_POST['categorie']);
    $titre = trim($_POST['titre']);
    $description = trim($_POST['description']);
    $couleur = trim($_POST['couleur']);
    $taille = trim($_POST['taille']);
    $sexe = trim($_POST['sexe']);
    $prix = trim($_POST['prix']);
    $stock = trim($_POST['stock']);

    // Pour la modif, récupération de l'id et de la photo
    if( !empty($_POST['id_article']) ) {
        $id_article = trim($_POST['id_article']);
    }
    if( !empty($_POST['ancienne_photo']) ) {
        $photo = trim($_POST['ancienne_photo']);
    }

    // Déclaration d'une variable nous permettant de savoir s'il y a eu des erreurs dans nos contrôles
    $erreur = false;

    // La référence est obligatoire
    if( empty($reference) ) {
        $msg .= '<div class="alert alert-danger mt-3">Attention,<br>Référence obligatoire.</div>';
        // cas d'erreur 
        $erreur = true;
    }

    // Contrôle sur la disponibilité de la référence : car unique en BDD
    $verif_reference = $pdo->prepare("SELECT * FROM article WHERE reference = :reference");
    $verif_reference->bindParam(':reference', $reference, PDO::PARAM_STR);
    $verif_reference->execute();

    // Pour la modif on a rajouté le "&& empty($id_article)" car il ne faut pas tester la référence dans le cadre d'une modif car elle existe en bdd obligatoirement.
    if( $verif_reference->rowCount() > 0 && empty($id_article) ) {
        $msg .= '<div class="alert alert-danger mt-3">Attention,<br>Référence indisponible.</div>';
        // cas d'erreur 
        $erreur = true;
    }

    // Si le prix est vide on affecte à 0 pour ne pas avoir d'erreur sql + message utilisateur, on ne bloque pas l'enregistrement
    if( !is_numeric($prix) ) {
        $prix = 0;
        $msg .= '<div class="alert alert-warning mt-3">Attention,<br>Cet article n\'ayant pas de prix, le prix a été mis à 0.</div>';
    }

    // Si le stock est vide on affecte à 0 pour ne pas avoir d'erreur sql + message utilisateur, on ne bloque pas l'enregistrement
    if( !is_numeric($stock) ) {
        $stock = 0;
        $msg .= '<div class="alert alert-warning mt-3">Attention,<br>Cet article n\'ayant pas de stock, le stock a été mis à 0.</div>';
    }


    // Contrôle sur l'image
    // Les pièces jointes sont dans $_FILES
    // L'indice (le name du champ) qui sera dans $_FILES ne sera jamais vide car c'est un sous tableau array
    // Pour être sûr qu'un fichier a été chargé, on vérifie si l'indice name dans ce sous tableau n'est pas vide.
    if( !empty($_FILES['photo']['name']) ) {
        // pour éviter qu'une nouvelle image ayant le même nom qu'une image déjà enregistrée, on renomme le nom de l'image en rajoutant la référence qui est unique.
        $photo = $reference . '-' . $_FILES['photo']['name'];
        
        // Nous devons vérifier l'extension de l'image afin d'être sûr que c'est bien une image et que le format est compatible pour le web
        // tableau array contenant les extensions acceptées : 
        $tab_extension = array('jpg', 'jpeg', 'png', 'gif', 'webp');

        // on récupère l'extension du fichier, les extensions peuvent avoir une nb de caractère différent (jpg / jpeg / js ...)
        // Pour être sûr de récupérer l'extension complète, on va découper la chaine en partant de la fin et on remonte jusqu'à un caractère fourni en argument : le point . (même approche que dans la fonction class_active() voir le fichier functions.php)
        // exemple : strrchr('image.png', '.') => on récupère .png
        // au passage on enlève le . de l'extension avec substr()

        $extension = strrchr($photo, '.'); // exemple : strrchr('image.png', '.') => on récupère .png
        $extension = substr($extension, 1); // exemple : pour .png => on récupère png
        $extension = strtolower($extension); // on passe la chaine en minuscule pour pouvoir la tester // exemple : PNG => on récupère png

        // https://www.php.net/manual/fr/function.in-array.php
        if( in_array($extension, $tab_extension) ) {
            // format ok
            // on retravaille le nom de l'image pour enlever les caractères spéciaux et les espaces
            $photo = preg_replace('/[^A-Za-z0-9.\-]/', '', $photo);
            // echo $photo;

            // s'il n'y a pas eu d'erreur dans nos contrôles, on copie l'image depuis le form vers un dossier
            if($erreur == false) {
                // copy(emplacement_de_base, emplacement_cible);
                // l'image est conservée à la validation du formulaire dans l'indice de $_FILES['photo']['tmp_name']
                copy($_FILES['photo']['tmp_name'], ROOT_PATH . PROJECT_PATH . 'assets/img_articles/' . $photo);
            }

        } else {
            // format invalide
            $msg .= '<div class="alert alert-danger mt-3">Attention,<br>Format de l\'image invalide, format acceptés : jpg / jpeg /  png / gif / webp.</div>';
            // cas d'erreur 
            $erreur = true;
        }

    } // fin : une photo a été chargé

    // on enregistre en BDD
    if($erreur == false) {

        // si l'id_article n'est pas vide, on est dans une modif :
        if( !empty($id_article) ) {
            $enregistrement = $pdo->prepare("UPDATE article SET reference = :reference, categorie  = :categorie, titre = :titre, description = :description, couleur = :couleur, taille = :taille, sexe = :sexe, photo = :photo, prix = :prix, stock = :stock WHERE id_article = :id_article");

            $enregistrement->bindParam(':id_article', $id_article, PDO::PARAM_STR);
            
        } else {
            $enregistrement = $pdo->prepare("INSERT INTO article (reference, categorie, titre, description, couleur, taille, sexe, photo, prix, stock) VALUES (:reference, :categorie, :titre, :description, :couleur, :taille, :sexe, :photo, :prix, :stock)");
        }
        
        $enregistrement->bindParam(':reference', $reference, PDO::PARAM_STR);
        $enregistrement->bindParam(':categorie', $categorie, PDO::PARAM_STR);
        $enregistrement->bindParam(':titre', $titre, PDO::PARAM_STR);
        $enregistrement->bindParam(':description', $description, PDO::PARAM_STR);
        $enregistrement->bindParam(':couleur', $couleur, PDO::PARAM_STR);
        $enregistrement->bindParam(':taille', $taille, PDO::PARAM_STR);
        $enregistrement->bindParam(':sexe', $sexe, PDO::PARAM_STR);
        $enregistrement->bindParam(':photo', $photo, PDO::PARAM_STR);
        $enregistrement->bindParam(':prix', $prix, PDO::PARAM_STR);
        $enregistrement->bindParam(':stock', $stock, PDO::PARAM_STR);
        $enregistrement->execute();

    }

} // fin des isset

//--------------------------------------------------------------------------
//--------------------------------------------------------------------------
// RECUPERATION DES INFOS DE L'ARTICLE A MODIFIER
//--------------------------------------------------------------------------
//--------------------------------------------------------------------------
if( isset($_GET['action']) && $_GET['action'] == 'modifier' && !empty($_GET['id_article']) ) {
    // pour la modification, on lance une requete en bdd et on affecte les infos dans les variables présentent dans les value de nos champs du form
    $recup_infos = $pdo->prepare("SELECT * FROM article WHERE id_article = :id_article");
    $recup_infos->bindParam(':id_article', $_GET['id_article'], PDO::PARAM_STR);
    $recup_infos->execute();

    $infos_article = $recup_infos->fetch(PDO::FETCH_ASSOC);

    $id_article = $infos_article['id_article'];
    $reference = $infos_article['reference'];
    $categorie = $infos_article['categorie'];
    $titre = $infos_article['titre'];
    $description = $infos_article['description'];
    $couleur = $infos_article['couleur'];
    $taille = $infos_article['taille'];
    $sexe = $infos_article['sexe'];
    $prix = $infos_article['prix'];
    $stock = $infos_article['stock'];
    $ancienne_photo = $infos_article['photo'];
}


//--------------------------------------------------------------------------
//--------------------------------------------------------------------------
// RECUPERATION DES ARTICLES EN BDD
//--------------------------------------------------------------------------
//--------------------------------------------------------------------------
$liste_articles = $pdo->query("SELECT * FROM article ORDER BY categorie, titre");

// Les affichages dans la page commencent depuis la ligne suivante :
include '../inc/header.inc.php';
include '../inc/nav.inc.php';
// var_dump($_POST);
// var_dump($_FILES);
?>

    <main class="container">
        <div class="bg-light p-5 rounded">
            <h1 class="pb-4 border-bottom"><i class="fas fa-ghost couleur_icone"></i> Gestion articles <i class="fas fa-ghost couleur_icone"></i></h1>
            <p class="lead">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nam ipsa corporis, sit soluta delectus similique non architecto? Atque, id, pariatur magnam doloribus dicta, fuga nisi ipsa odio eius veniam officia.</p>
            <?php echo $msg . '<hr>'; // variable destinée à afficher des messages utilisateur  ?>
        </div>

        <div class="row">
            <div class="col-12 mt-5">
                <form method="post" action="" class="border p-3" enctype="multipart/form-data">

                    <input type="hidden" name="id_article" value="<?php echo $id_article; ?>">
                    <input type="hidden" name="ancienne_photo" value="<?php echo $ancienne_photo; ?>">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="reference" class="form-label">Référence</label>
                                <input type="text" class="form-control" id="reference" name="reference" value="<?php echo $reference; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="categorie" class="form-label">Catégorie</label>
                                <select class="form-control" id="categorie" name="categorie">
                                    <option>Tshirt</option>                                    
                                    <option <?php if($categorie == 'Echarpe') { echo 'selected'; } ?> >Echarpe</option>                                    
                                    <option <?php if($categorie == 'Pantalon') { echo 'selected'; } ?> >Pantalon</option>                                    
                                    <option <?php if($categorie == 'Chemise') { echo 'selected'; } ?> >Chemise</option>                                    
                                    <option <?php if($categorie == 'Polos') { echo 'selected'; } ?> >Polos</option>                                    
                                    <option <?php if($categorie == 'Chaussettes') { echo 'selected'; } ?> >Chaussettes</option>                                    
                                    <option <?php if($categorie == 'Veste') { echo 'selected'; } ?> >Veste</option>                                    
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="titre" class="form-label">Titre</label>
                                <input type="text" class="form-control" id="titre" name="titre" value="<?php echo $titre; ?>">
                            </div>
                            <div class="mb-4">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" rows="3" name="description"><?php echo $description; ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="couleur" class="form-label">Couleur</label>
                                <select class="form-control" id="couleur" name="couleur">
                                    <option>Bleu</option>                                    
                                    <option <?php if($couleur == 'Blanc') { echo 'selected'; } ?>>Blanc</option>                                    
                                    <option <?php if($couleur == 'Vert') { echo 'selected'; } ?>>Vert</option>                                    
                                    <option <?php if($couleur == 'Rose') { echo 'selected'; } ?>>Rose</option>                                    
                                    <option <?php if($couleur == 'Rouge') { echo 'selected'; } ?>>Rouge</option>                                    
                                    <option <?php if($couleur == 'Beige') { echo 'selected'; } ?>>Beige</option>                                    
                                    <option <?php if($couleur == 'Noir') { echo 'selected'; } ?>>Noir</option>                                    
                                    <option <?php if($couleur == 'Gris') { echo 'selected'; } ?>>Gris</option>                                    
                                    <option <?php if($couleur == 'Jaune') { echo 'selected'; } ?>>Jaune</option>                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="taille" class="form-label">Taille</label>
                                <select class="form-control" id="taille" name="taille">
                                    <option>XXS</option>                                    
                                    <option <?php if($taille == 'XS') { echo 'selected'; } ?> >XS</option>                                    
                                    <option <?php if($taille == 'S') { echo 'selected'; } ?> >S</option>                                    
                                    <option <?php if($taille == 'M') { echo 'selected'; } ?> >M</option>                                    
                                    <option <?php if($taille == 'L') { echo 'selected'; } ?> >L</option>                                    
                                    <option <?php if($taille == 'XL') { echo 'selected'; } ?> >XL</option>                                    
                                    <option <?php if($taille == 'XXL') { echo 'selected'; } ?> >XXL</option>                                    
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="sexe" class="form-label">Sexe</label>
                                <select class="form-control" id="sexe" name="sexe">
                                    <option value="m">homme</option>
                                    <option value="f" <?php if($sexe == 'f') { echo 'selected'; } ?> >femme</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="photo" class="form-label">Photo</label>
                                <input type="file" class="form-control" id="photo" name="photo">
                            </div>
                            <div class="mb-3">
                                <label for="prix" class="form-label">Prix</label>
                                <input type="text" class="form-control" id="prix" name="prix" value="<?php echo $prix; ?>">                            
                            </div>
                            <div class="mb-3">
                                <label for="stock" class="form-label">Stock</label>
                                <input type="text" class="form-control" id="stock" name="stock" value="<?php echo $stock; ?>">                            
                            </div>
                            <div class="mb-3">                                
                                <input type="submit" class="btn btn-outline-primary w-100" id="enregistrement" name="enregistrement" value="Enregistrement">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Affichage du tableau des articles -->
        <div class="row">
            <div class="col-12 mt-5">
                <table class="table table-bordered">
                    <tr class="bg-indigo text-white">
                        <th>Id</th>
                        <th>Référence</th>
                        <th>Catégorie</th>
                        <th>Titre</th>
                        <th>Description</th>
                        <th>Couleur</th>
                        <th>Taille</th>
                        <th>Sexe</th>
                        <th>Photo</th>
                        <th>Prix</th>
                        <th>Stock</th>
                        <th>Modif</th>
                        <th>Suppr</th>
                    </tr>
                    <?php 
                        while($ligne = $liste_articles->fetch(PDO::FETCH_ASSOC)) {
                            echo '<tr>';
                            echo '<td>' . $ligne['id_article'] . '</td>';
                            echo '<td>' . $ligne['reference'] . '</td>';
                            echo '<td>' . $ligne['categorie'] . '</td>';
                            echo '<td>' . $ligne['titre'] . '</td>';
                            echo '<td>' . substr($ligne['description'], 0, 17) . ' <a href="">...</a></td>';
                            echo '<td>' . $ligne['couleur'] . '</td>';
                            echo '<td>' . $ligne['taille'] . '</td>';
                            echo '<td>' . $ligne['sexe'] . '</td>';
                            echo '<td class="text-center"><img src="' . URL . 'assets/img_articles/' . $ligne['photo'] . '" class="img-thumbnail" width="70"></td>';
                            echo '<td>' . $ligne['prix'] . '</td>';
                            echo '<td>' . $ligne['stock'] . '</td>';

                            echo '
                            <td class="text-center"><a href="?action=modifier&id_article=' . $ligne['id_article'] . '" class="btn btn-warning text-white"><i class="fas fa-edit"></i></a></td>';

                            echo '<td class="text-center"><a href="?action=supprimer&id_article=' . $ligne['id_article'] . '" class="btn btn-danger confirm_delete" ><i class="far fa-trash-alt"></i></a></td>';

                            // si on veut faire le  bouton dans un form
                            // echo '<td class="text-center"><form action="" ><input type="hidden" name="action" value="supprimer"><input type="hidden" name="id_article" value="' . $ligne['id_article'] . '"><button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i></button></form></td>';

                            echo '</tr>';
                        }
                    ?>

                </table>
            </div>
        </div>
    </main>

<?php 
include '../inc/footer.inc.php';

