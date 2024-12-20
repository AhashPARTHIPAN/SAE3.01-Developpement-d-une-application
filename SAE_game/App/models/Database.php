<?php

/**
 * Classe Model
 * 
 * Gère la connexion à la base de données avec le design pattern Singleton.
 */
class Model
{
    private $bd; // Connexion à la base de données
    private static $instance = null; // Instance unique de la classe

    /**
     * Constructeur privé
     * 
     * Configure la connexion à la base de données (DSN, utilisateur, mot de passe).
     */
    private function __construct()
    {
        $dsn = ''; // Ajouter le DSN (exemple : 'mysql:dbname=;host=') 
        $username = ''; // Ajouter le nom d'utilisateur
        $password = ''; // Ajouter le mot de passe

        try {
            // Tentative de connexion à la base de données
            $this->bd = new PDO($dsn, $username, $password);

            // Configure PDO pour afficher des exceptions en cas d'erreur
            $this->bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Définit l'encodage UTF-8 pour la connexion
            $this->bd->query("SET NAMES 'utf8'");
        } catch (PDOException $e) {
            // Si la connexion échoue, affiche un message d'erreur et termine le script
            die('Erreur de connexion : ' . $e->getMessage());
        }
    }

    /**
     * Retourne l'instance unique de la classe.
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Model();
        }
        return self::$instance;
    }

    public function getNbJeux(){
        $req = $this->bd->prepare('SELECT COUNT(*) FROM Jeux');
        $req->execute();
        $tab = $req->fetch(PDO::FETCH_NUM);
        return $tab[0];
    }

    public function getJeu($name){
        $req = $this->bd->prepare('SELECT * FROM Jeux WHERE titre = :name');
        $req->bindParam(':name', $name, PDO::PARAM_STR);
        $req->execute();
        $tab = $req->fetchAll(PDO::FETCH_ASSOC);
        return $tab; // Ajout du point-virgule manquant
    }

    public function getNbExemplaire($jeux)
    {
        $req = $this->bd->prepare('SELECT COUNT(*) FROM exemplaires WHERE id_jeu = :jeux');
        $req->bindParam(':jeux', $jeux, PDO::PARAM_INT);
        $req->execute();
        $tab = $req->fetch(PDO::FETCH_NUM);
        return $tab[0]; 
    }

    public function getJeuParCategorie($categorie)
    {
        $req = $this->bd->prepare('
            SELECT j.* 
            FROM jeux j
            JOIN jeux_categories jc ON j.id_jeu = jc.id_jeu
            JOIN categories c ON jc.id_categorie = c.id_categorie
            WHERE c.nom_categorie = :categorie
        ');
        $req->bindParam(':categorie', $categorie, PDO::PARAM_STR);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getToutesLesBoitesJeu($id_jeu)
    {
        $req = $this->bd->prepare('SELECT * FROM exemplaires WHERE id_jeu = :id_jeu');
        $req->bindParam(':id_jeu', $id_jeu, PDO::PARAM_INT);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBoiteAttributSpecifique($id_boite)
    {
        $req = $this->bd->prepare('SELECT * FROM exemplaires WHERE id_boite = :id_boite');
        $req->bindParam(':id_boite', $id_boite, PDO::PARAM_INT);
        $req->execute();
        return $req->fetch(PDO::FETCH_ASSOC);
    }
}

// Test du code
$model = Model::getInstance();

try {
    // Test simple pour vérifier la connexion à la base de données
    $nbJeux = $model->getNbJeux();
    echo "Le nombre de jeux dans la base de données est : $nbJeux";
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
