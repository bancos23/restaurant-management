<?php
/**
 * @file employees.p.php
 * @brief Employees Page
 * @details
 * This file generates an HTML table displaying a list of employees.
 * 
 * The table includes the following columns:
 * - Employee number
 * - Name (with a link to the employee's profile)
 * - Group
 * - Days off
 * 
 * The data is fetched from the `users` table in the database, ordered by the `group` column in descending order.
 * 
 * If no users are found, a message indicating "No users found" is displayed.
 * 
 * @package RestaurantManagement
 * @author Gavris Nicolae
 * @date 2024-11-30
 */
?>
<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-1">
                    <div class="card-header">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Name</th>
                                    <th>Group</th>
                                    <th>Days off</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $q = Config::getCon()->prepare("SELECT * FROM users ORDER BY `group` DESC");
                                $q->execute();

                                $users = $q->fetchAll(PDO::FETCH_OBJ);
                                $count = 0;

                                if (count($users) > 0) {
                                    foreach ($users as $row) {
                                        $count++;
                                        ?>
                                        <tr class="align-middle">
                                            <td><?php echo $count; ?></td>
                                            <td><a href="<?php echo BASE_URL . 'profile/' . htmlspecialchars($row->username); ?>">
                                                    <?php echo htmlspecialchars(join(" ", [$row->first_name, $row->last_name])); ?></a>
                                            </td>
                                            <td><?php echo htmlspecialchars(Config::getData("groups", "name", $row->group)); ?></td>
                                            <td><?php echo $row->days_off; ?></td>    
                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="3" class="text-center">No users found.</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>