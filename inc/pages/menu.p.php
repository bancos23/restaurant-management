<?php
/**
 * @file menu.p.php
 * @brief Menu Page
 * @details
 * This script fetches recipes and their ingredients from the database and displays them in a card layout.
 * 
 * The following steps are performed:
 * 1. Prepare and execute a SQL query to fetch recipe names, supply names, quantities, and unit names.
 * 2. Fetch all results as objects and group them by recipe name.
 * 3. Iterate over the grouped recipes and display each recipe and its ingredients in a card format.
 * 
 * Database Tables:
 * - recipies (r): Contains recipe information.
 * - recipies_content (rc): Contains the relationship between recipes and supplies, including quantities and units.
 * - supplies (s): Contains supply information.
 * - units (u): Contains unit information.
 * 
 * HTML Structure:
 * - A container with a row of cards, each representing a recipe.
 * - Each card displays the recipe name and a list of ingredients with their quantities and units.
 * - A pagination section at the bottom (currently static with only one page).
 * 
 * Dependencies:
 * - Config::getCon(): A method to get the database connection.
 * - PDO::FETCH_OBJ: Fetch mode to get results as objects.
 * - FontAwesome icons for displaying utensils icon.
 * 
 * @package RestaurantManagement
 * @author Eduard Haidu
 * @date 2024-11-30
 */
?>
<div class="app-content"> 
    <div class="container-fluid">
        <div class="row">

            <div class="container">
                <div class="main-content">
                    <div class="row">

                    <?php 

    $q = Config::getCon()->prepare("
        SELECT r.name as recipe_name, s.name as supply_name, rc.quantity, u.name as unit_name
        FROM recipies r
        JOIN recipies_content rc ON r.id = rc.recipie
        JOIN supplies s ON rc.supply = s.id
        JOIN units u ON rc.unit = u.id
    ");

    $q->execute();
    $recipies = $q->fetchAll(PDO::FETCH_OBJ);

    $groupedRecipies = [];

    foreach ($recipies as $row) 
    {
        $groupedRecipies[$row->recipe_name][] = $row;
    }

    foreach ($groupedRecipies as $recipeName => $ingredients) {
?>

                        <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column mb-3">
                            <div class="card bg-light d-flex flex-fill">
                                <div class="card-header text-muted border-bottom-0"><?php echo $recipeName; ?></div>
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-12">
                                            <h2 class="lead"><b>Recipe Ingredients:</b></h2>
                                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                                <?php foreach ($ingredients as $ingredient) { ?>
                                                    <li class="small">
                                                        <span class="fa-li"><i class="fas fa-lg fa-utensils"></i></span> 
                                                        <?php echo $ingredient->quantity . '' . $ingredient->unit_name . ' ' . lcfirst($ingredient->supply_name); ?>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

<?php 
                    } 
?>
                    </div>
                </div>

                <div class="card-footer">
                    <nav aria-label="Recipe Page Navigation">
                        <ul class="pagination justify-content-center m-0">
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        </ul>
                    </nav>
                </div>

            </div>
        </section>
    </div>
</div>
