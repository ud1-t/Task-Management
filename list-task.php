<?php
    include('config/constants.php');

    // Get list_id form URL
    $list_id_url = $_GET['list_id'];
?>

<html>
    <head>
        <title>Task Manager with PHP and MySQL</title>
        <link rel="stylesheet" href="<?php echo SITEURL; ?>css/style.css" />
    </head>

    <body>

        <div class="wrapper">
        
            <h1>TASK MANAGER</h1>

            <!-- Menu Start -->
            <div class="menu">
                <a class="menu-link" href="<?php echo SITEURL; ?>">Home</a>

                <?php

                    // Comment Displaying Lists from DB in Menu
                    // Connect the DB
                    $connect2 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

                    // Select DB
                    $db_select2 = mysqli_select_db($connect2, DB_NAME) or die(mysqli_error());

                    // Query to Get list from table
                    $sql2 = "SELECT * FROM tbl_lists";

                    // Execute the query
                    $res2 = mysqli_query($connect2, $sql2);

                    // Check if query executed or not
                    if($res2 == true) {
                        // Display the lists in menu
                        while($row2 = mysqli_fetch_assoc($res2)) {
                            $list_id = $row2['list_id'];
                            $list_name = $row2['list_name'];
                            ?>

                            <a class="menu-link" href="<?php echo SITEURL; ?>list-task.php?list_id=<?php echo $list_id; ?>"><?php echo $list_name; ?></a>

                            <?php
                        }
                    }

                ?>

                <a class="menu-link" href="<?php echo SITEURL; ?>manage-list.php">Manage Lists</a>
            </div>
            <!-- Menu End -->

            <div class="all-task">
                <a class="add-task" href="<?php echo SITEURL; ?>add-task.php">Add Task</a>

                <table>
                    <tr>
                        <th>S No.</th>
                        <th>Task Name</th>
                        <th>Priority</th>
                        <th>Deadline</th>
                        <th>Actions</th>

                        <?php

                            $connect = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

                            $db_select = mysqli_select_db($connect, DB_NAME) or die(mysqli_error());

                            // Query to display task from list selected
                            $sql = "SELECT * FROM tbl_tasks WHERE list_id=$list_id_url";

                            // Execute the query
                            $res = mysqli_query($connect, $sql);

                            // Check if executed
                            if($res == true) {
                                // Display Tasks based on list
                                // Count the rows
                                $count_rows = mysqli_num_rows($res);

                                if($count_rows > 0) {
                                    // No tasks on this list
                                    while($row = mysqli_fetch_assoc($res)) {
                                        $task_id = $row['task_id'];
                                        $task_name = $row['task_name'];
                                        $priority = $row['priority'];
                                        $deadline = $row['deadline'];
                                        ?>

                                            <tr>
                                                <td>1. </td>
                                                <td><?php echo $task_name; ?></td>
                                                <td><?php echo $priority; ?></td>
                                                <td><?php echo $deadline; ?></td>
                                                <td>
                                                    <a class="upd-del" href="<?php echo SITEURL; ?>update-task.php?task_id=<?php echo $task_id; ?>">Update /</a> 
                                                    <a class="upd-del" href="<?php echo SITEURL; ?>delete-task.php?task_id=<?php echo $task_id; ?>">Delete</a> 
                                                </td>
                                            </tr>

                                        <?php
                                    }
                                }
                                else {
                                    ?>

                                    <tr>
                                        <td>No Tasks added on this list.</td>
                                    </tr>

                                    <?php
                                }
                            }
                        ?>

                    </tr>
                </table>
            </div>
        </div>
    </body>
</html>