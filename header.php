<div class="site-header">
    <div class="header-inner">

        <a href="index.php" class="site-logo">
            Suivi Jellyfin
        </a>

        <nav class="site-nav">

            <a href="index.php" class="nav-link">
                Accueil
            </a>

            <?php
            if (isset($_SESSION['is_utilisateur_connecte']) && $_SESSION['is_utilisateur_connecte'] === true) {
            ?>
                <?php
                if (isset($_SESSION['grade'])&& ($_SESSION['grade'] === 'admin'|| $_SESSION['grade'] === 'super_admin')) {
                ?>
                    <a href="page_moderation.php" class="nav-link">
                        Modération
                    </a>
                <?php
                }
                ?>

                <a href="deconnexion.php" class="nav-button secondary">
                    Déconnexion
                </a>

            <?php
            } else {
            ?>

                <a href="inscription.php" class="nav-link">
                    Inscription
                </a>

                <a href="connexion.php" class="nav-button">
                    Connexion
                </a>

            <?php
            }
            ?>

        </nav>

    </div>
</div>