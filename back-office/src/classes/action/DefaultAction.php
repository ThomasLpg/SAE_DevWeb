<?php 

namespace backoffice\admin\action;

class DefaultAction extends Action {
    public function execute() : string {
        return "<p>Bienvenue</p>
                <a href='?action=afficher-stats-users'>Afficher les statistiques des utilisateurs</a><br>
                <a href='?action=afficher-stats-tags'>Afficher les statistiques des tags</a>";
    }
}