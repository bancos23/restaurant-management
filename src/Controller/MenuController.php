<?php

namespace App\Controller;

use PDO;
use PDOException;

class MenuController
{
    private PDO $dbConnection;

    public function __construct(PDO $dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }
    
    public function getGroupedRecipes(): array
    {
        $query = $this->dbConnection->prepare(
            "SELECT r.name as recipe_name, s.name as supply_name, rc.quantity, u.name as unit_name
            FROM recipies r
            JOIN recipies_content rc ON r.id = rc.recipie
            JOIN supplies s ON rc.supply = s.id
            JOIN units u ON rc.unit = u.id"
        );
        $query->execute();
        $recipes = $query->fetchAll(PDO::FETCH_OBJ);

        $groupedRecipes = [];
        foreach ($recipes as $row) {
            $groupedRecipes[$row->recipe_name][] = $row;
        }
        return $groupedRecipes;
    }
}