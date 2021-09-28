    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-indigo">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo URL; ?>index.php">Eshop</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <li class="nav-item">
                        <a class="nav-link <?php echo class_active('/index.php'); ?>" aria-current="page" href="<?php echo URL; ?>index.php">Boutique</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo class_active('/panier.php'); ?>" href="<?php echo URL; ?>panier.php">Panier</a>
                    </li>

                    <?php if( user_is_connected() ) { ?>

                    <li class="nav-item">
                        <a class="nav-link <?php echo class_active('/profil.php'); ?>" href="<?php echo URL; ?>profil.php">Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo class_active('/connexion.php'); ?>" href="<?php echo URL; ?>connexion.php?action=deconnexion">Déconnexion</a>
                    </li>

                    <?php } else { ?>    

                    <li class="nav-item">
                        <a class="nav-link <?php echo class_active('/connexion.php'); ?>" href="<?php echo URL; ?>connexion.php">Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo class_active('/inscription.php'); ?>" href="<?php echo URL; ?>inscription.php">Inscription</a>
                    </li>

                    <?php } ?>


                    <?php if( user_is_admin() ) { ?>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-bs-toggle="dropdown" aria-expanded="false">Administration</a>
                        <ul class="dropdown-menu " aria-labelledby="dropdown01">
                            <li><a class="dropdown-item" href="<?php echo URL; ?>admin/gestion_articles.php">Gestion articles</a></li>
                            <li><a class="dropdown-item" href="<?php echo URL; ?>admin/gestion_membres.php">Gestion membres</a></li>
                            <li><a class="dropdown-item" href="<?php echo URL; ?>admin/gestion_commandes.php">Gestion commandes</a></li>
                            <li><a class="dropdown-item" href="<?php echo URL; ?>admin/gestion_categories.php">Gestion catégories</a></li>
                            <li><a class="dropdown-item" href="<?php echo URL; ?>admin/statistiques.php">Statistiques</a></li>
                        </ul>
                    </li>

                    <?php } ?>


                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Rechercher" aria-label="Search">
                    <button class="btn btn-outline-light" type="submit">Rechercher</button>
                </form>
            </div>
        </div>
    </nav>