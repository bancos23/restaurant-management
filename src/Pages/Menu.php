<?php
/**
 * @file profile.p.php
 * @brief Displays a user's profile information.
 * @details
 * This script retrieves and displays a user's profile information based on the username provided in the URL.
 * 
 * - It prepares and executes a SQL query to fetch user data from the `users` table where the username matches the provided parameter.
 * - If no user is found, it redirects to a 404 page.
 * - If a user is found, it displays the user's profile information including their full name, group, phone number, and email.
 * 
 * @author Bancos Gabriel
 * @date 2024-11-30
 */

use App\Config\Config;
use App\Config\Database;
use App\Controller\MenuController;

$dbConnection = Config::getDatabase();
$menuController = new MenuController($dbConnection);
$groupedRecipies = $menuController->getGroupedRecipes();
?>

<div class="app-content"> 
    <div class="container-fluid">
        <div class="row">

            <div class="container">
                <div class="main-content">
                    <div class="row">

                    <?php 
                    foreach ($groupedRecipies as $recipeName => $ingredients) {
                    ?>
                        <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column mb-3">
                            <div class="card bg-light d-flex flex-fill">
                                <div class="card-header text-muted border-bottom-0">
                                    <?php echo $recipeName; ?>
                                </div>
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
