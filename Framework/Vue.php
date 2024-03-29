<?php
require_once "Configuration.php";
class Vue {
 // Nom du fichier associé à la vue
 private $fichier;
 // Titre de la vue (défini dans le fichier vue)
 private $titre;
 public function __construct($action, $controleur = "") {
   // Détermination du nom du fichier vue à partir de l'action et du constructeur
   $fichier = "Vue/";
   if ($controleur != "") {
   $fichier = $fichier . $controleur . "/";
   }
   $this->fichier = $fichier . $action . ".php";
   }
  // Génère et affiche la vue
  public function generer($donnees) {
  // Génération de la partie spécifique de la vue
  $contenu = $this->genererFichier($this->fichier, $donnees);
  $racineWeb = Configuration::get("racineWeb", "/");
  // Génération du gabarit commun utilisant la partie spécifique
  $vue = $this->genererFichier('Vue/gabarit.php',
  array('titre' => $this->titre, 'contenu' => $contenu,
  'racineWeb' => $racineWeb));
  // Renvoi de la vue générée au navigateur
  echo $vue;
  }
  private function nettoyer($valeur) {
   return htmlspecialchars($valeur, ENT_QUOTES, 'UTF-8', false);
   }
  

 // Génère un fichier vue et renvoie le résultat produit
 private function genererFichier($fichier, $donnees) {
 if (file_exists($fichier)) {
 // Rend les éléments du tableau $donnees accessibles dans la vue
 extract($donnees);
 // Démarrage de la temporisation de sortie
 ob_start();
 // Inclut le fichier vue
 // Son résultat est placé dans le tampon de sortie
 require $fichier;
 // Arrêt de la temporisation et renvoi du tampon de sortie
 return ob_get_clean();
 }
 else {
    throw new Exception("Fichier '$fichier' introuvable");
    }
    }
   }
?>   