<?php
/**
 * @file employees.p.php
 * @brief Displays a list of users with their details.
 * @details
 * This script generates a table displaying a list of users with their details.
 * 
 * The table includes the following columns:
 * - ID (#)
 * - Name (with a link to the user's profile)
 * - Group
 * - Days off
 * 
 * The data is fetched from the `users` table in the database and ordered by the `group` column in descending order.
 * 
 * If no users are found, a message "No users found." is displayed in the table.
 * 
 * @author Mirth Kevin
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