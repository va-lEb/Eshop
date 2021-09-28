<?php

// Fonction pour mettre la classe active sur les liens du menu
// echo class_active('/profil.php');
function class_active($url) {
    // strrchr(permet de découper une chaine depuis la fin et de remonter jusqu'au deuxième argument)
    // exemple strrchr('DIW60/php/eshop/profil.php', '/'); on récupère /profil.php
    $page = strrchr($_SERVER['PHP_SELF'], '/');
    // on test si $url correspond à la page récupérée
    if($page == $url) {
        return ' active ';
    }
}

// Fonction permettant de savoir si l'utilisateur est connecté : true / false
function user_is_connected() {
    if( !empty($_SESSION['membre']) ) {
        return true;
    } else {
        return false;
    }
}

// Fonction permettant de savoir si un utilisateur est connecté et en plus si son statut est admin
function user_is_admin() {
    if(user_is_connected() && $_SESSION['membre']['statut'] == 2) {
        return true;
    }
    return false;
}

// Fonction pour créer l'outil panier dans la session
function create_cart() {
    // si le panier n'existe pas dans $_SESSION, on le crée
    if( !isset($_SESSION['panier']) ) {
        $_SESSION['panier'] = array();
        $_SESSION['panier']['id_article'] = array();
        $_SESSION['panier']['titre'] = array();
        $_SESSION['panier']['quantite'] = array();
        $_SESSION['panier']['prix'] = array();
    }
    // sinon rien : le panier est déjà présent.
}

// Fonction permettant d'ajouter un article dans le panier
function add_product($id_article, $titre, $quantite, $prix) {
    // Avant d'ajouter l'article, nous devons vérifier s'il n'est pas déjà présent.
    // S'il est présent on ne change que la quantité
    // Sinon on rajoute les 4 informations attendues

    // array_search() permet de chercher une valeur dans un  tableau array et on récupère l'indice correspondant.
    // Un fois l'indice récupéré, on pour aller changer la quantité correspondante à cet indice
    // Attention : si la valeur n'est pas trouvé on obtient false, il est aussi possible d'obtenir l'indice 0, donc il faut faire une condition stricte (===)

    $position_article = array_search($id_article, $_SESSION['panier']['id_article']);

    if($position_article === false) {
        $_SESSION['panier']['id_article'][] = $id_article;
        $_SESSION['panier']['titre'][] = $titre;
        $_SESSION['panier']['quantite'][] = $quantite;
        $_SESSION['panier']['prix'][] = $prix;
    } else {
        // l'article est présent
        $_SESSION['panier']['quantite'][$position_article] += $quantite;
    }
}