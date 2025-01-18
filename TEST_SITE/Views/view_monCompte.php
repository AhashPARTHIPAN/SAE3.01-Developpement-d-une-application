<?php require_once "view_begin.php"; ?>

<section id="monCompte">
    <h1>Mon Compte</h1>


    <!-- Bouton d'administration visible uniquement pour les rôles autorisés -->
    <?php if ($_SESSION['utilisateur']['role'] === 'Admin' || $_SESSION['utilisateur']['role'] === 'Gestionnaire'): ?>
        <div class="admin-button">
            <a href="index.php?controller=administration&action=administration" class="Bouton">Accéder au panneau
                d'administration</a>
        </div>
    <?php endif; ?>


    <!-- Informations générales -->
    <h2>Informations générales</h2>
    <form action="?controller=monCompte&action=updateGenerale" method="post">
        <label for="nom">Nom</label>
        <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($utilisateur['nom']) ?>" required>
        <?php if (!empty($erreur) && strpos($erreur, 'Nom') !== false): ?>
            <p class="error-message"><?= htmlspecialchars($erreur) ?></p>
        <?php endif; ?>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($utilisateur['email']) ?>" required>
        <?php if (!empty($erreur) && strpos($erreur, 'Email') !== false): ?>
            <p class="error-message"><?= htmlspecialchars($erreur) ?></p>
        <?php endif; ?>

        <button type="submit" class="Bouton">Mettre à jour</button>
    </form>


    <!-- Informations complémentaires -->
    <h2>Informations complémentaires</h2>
    <form action="?controller=monCompte&action=updateComplementaire" method="post">
        <label for="telephone">Téléphone</label>
        <input type="text" id="telephone" name="telephone"
            value="<?= htmlspecialchars($utilisateur['telephone'] ?? '') ?>">
        <?php if (!empty($erreur) && strpos($erreur, 'Numéro de téléphone') !== false): ?>
            <p class="error-message"><?= htmlspecialchars($erreur) ?></p>
        <?php endif; ?>

        <label for="adresse">Adresse</label>
        <textarea id="adresse" name="adresse"><?= htmlspecialchars($utilisateur['adresse'] ?? '') ?></textarea>

        <label for="date_naissance">Date de naissance</label>
        <input type="date" id="date_naissance" name="date_naissance"
            value="<?= htmlspecialchars($utilisateur['date_naissance'] ?? '') ?>">
        <?php if (!empty($erreur) && strpos($erreur, 'Date de naissance') !== false): ?>
            <p class="error-message"><?= htmlspecialchars($erreur) ?></p>
        <?php endif; ?>

        <button type="submit" class="Bouton">Mettre à jour</button>
    </form>

    <!-- Modification du mot de passe -->
    <h3>Modifier le mot de passe</h3>
    <form action="?controller=monCompte&action=updatePassword" method="post">
        <label for="ancien_mot_de_passe">Ancien mot de passe</label>
        <input type="password" id="ancien_mot_de_passe" name="ancien_mot_de_passe" required>

        <label for="nouveau_mot_de_passe">Nouveau mot de passe</label>
        <input type="password" id="nouveau_mot_de_passe" name="nouveau_mot_de_passe" required>

        <label for="confirmation_mot_de_passe">Confirmer le nouveau mot de passe</label>
        <input type="password" id="confirmation_mot_de_passe" name="confirmation_mot_de_passe" required>

        <button type="submit" class="Bouton">Modifier le mot de passe</button>
    </form>

    <br /><br /><br />
</section>

<?php require_once "view_end.php"; ?>
