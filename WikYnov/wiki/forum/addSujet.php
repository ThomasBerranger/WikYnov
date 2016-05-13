<?php
session_start();
$bdd = new PDO ('mysql:host=localhost;dbname=wikiynov','root','');
if(!isset($_SESSION['session']))
{
    header("Location: index.php");
}

class addSujet{

    private $name;
    private $sujet;
    private $categories;
    private $bdd;

    public function __construct($name,$sujet,$categories) {

        $this->name = htmlspecialchars($name);
        $this->sujet = htmlspecialchars($sujet);
        $this->categories = htmlspecialchars($categories);
        $this->bdd = bdd();

    }


    public function verif(){

        if(strlen($this->name) > 5 AND strlen($this->name) < 60 ){ /*Si le nom du sujet est bon**/

            if(strlen($this->sujet) > 0){ /*Si on a bien un sujet*/

                return 'ok';
            }
            else {/*Si on a pas de contenu*/
                $erreur = 'Veuillez entrer le contenu du sujet';
                return $erreur;
            }

        }
        else { /*Si le nom du sujet est mauvais*/
            $erreur = 'Le nom du sujet doit contenir entre 5 et 20 caractères';
            return $erreur;
        }

    }

    public function insert(){

        $requete = $this->bdd->prepare('INSERT INTO sujet(name,categories) VALUES(:name,:categories)');
        $requete->execute(array('name'=> $this->name,'categories'=>  $this->categories));

        $requete2 = $this->bdd->prepare('INSERT INTO postsujet(propri,contenu,date,sujet) VALUES(:propri,:contenu,NOW(),:sujet)');
        $requete2->execute(array('propri'=>$_SESSION['id'],'contenu'=>  $this->sujet,'sujet'=>  $this->name));

        return 1;
    }

}