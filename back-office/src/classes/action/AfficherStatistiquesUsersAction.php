<?php

namespace backoffice\admin\action;

use backoffice\admin\repo\StatistiquesRepository;

class AfficherStatistiquesUsersAction extends Action {
    public function execute() : string{
        try {

            $repo = StatistiquesRepository::getInstance();

            $lim = ($_GET['limite'] ?? 10);

            if($lim <= 0){
                $lim = 1;
            }

            $tabAssoc = $repo->topInfluenceurs($lim);


            if ($tabAssoc === []){
                return "<p>Il n'y pas de données car aucun utilisateur n'est suivi...</p>";
            }


            
            $i = count($tabAssoc);
            $html = "<form method='GET' action='index.php'>
                        <input type='hidden' name='action' value='afficher-stats-users'>
                        <label>Afficher le top :</label>
                        <input type='number' name='limite' min='1' value='$lim' required>
                        <button type='submit'>Valider</button>
                     </form>
                     <h2>Top $i des utilisateurs les plus suivis (ordre croissant) :";

            
            $html .= "<table>
                      <tr>
                        <th>Classement</th>
                        <th>Pseudo</th>
                        <th>Nombre d'abonnés</th>
                      </tr>";


            foreach($tabAssoc as $elt){
                $pseudo = $elt['pseudo'];
                $nbFollow = $elt['nb_followers'];
                $html .= "<tr>
                          <td>$i</td>
                          <td>$pseudo</td>
                          <td>$nbFollow</td>
                          </tr>";
                $i--;
            }
            $html .= "</table>";
            return $html . "<a href='index.php'=>Accueil</a>";
        } catch (\Exception $e){
            return $e->getMessage();
        }
    }
}