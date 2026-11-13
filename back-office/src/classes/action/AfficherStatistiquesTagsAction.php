<?php

namespace backoffice\admin\action;

use backoffice\admin\repo\StatistiquesRepository;

class AfficherStatistiquesTagsAction extends Action {
    public function execute() : string{
        try {

            $repo = StatistiquesRepository::getInstance();

            $lim = ($_GET['limite'] ?? 10);

            if($lim <= 0){
                $lim = 1;
            }

            $tabAssoc = $repo->tendances($lim);


            if ($tabAssoc === []){
                return "<p>Il n'y pas de données car aucun tag n'a été mentionné...</p>";
            }


            
            $i = count($tabAssoc);
            $html = "<form method='GET' action='index.php'>
                        <input type='hidden' name='action' value='afficher-stats-tags'>
                        <label>Afficher le top :</label>
                        <input type='number' name='limite' min='1' value='$lim' required>
                        <button type='submit'>Valider</button>
                     </form>
                     <h2>Top $i des tags les plus mentionnés (ordre croissant) :";

            
            $html .= "<table>
                      <tr>
                        <th>Classement</th>
                        <th>Tag</th>
                        <th>Nombre de mentions</th>
                      </tr>";


            foreach($tabAssoc as $elt){
                $libelle = $elt['libellé'];
                $nbMentions = $elt['nbmentions'];
                $html .= "<tr>
                          <td>$i</td>
                          <td>$libelle</td>
                          <td>$nbMentions</td>
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