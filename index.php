<?php
    include('config/constants.php');
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
            <div>
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

            <!-- Task Start --> 

            <p>

                <?php

                    if(isset($_SESSION['add'])) {
                        echo $_SESSION['add'];
                        unset($_SESSION['add']);
                    }

                    if(isset($_SESSION['delete'])) {
                        echo $_SESSION['delete'];
                        unset($_SESSION['delete']);
                    }

                    if(isset($_SESSION['update'])) {
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                    }

                    if(isset($_SESSION['delete_fail'])) {
                        echo $_SESSION['delete_fail'];
                        unset($_SESSION['delete_fail']);
                    }

                ?>

            </p>

            <div class="all-task">
                <a class="add-task" href="<?php SITEURL; ?>add-task.php">Add Task</a>


                <table>
                    <tr>
                        <th>S No.</th>
                        <th>Task Name</th>
                        <th>Priority</th>
                        <th>Deadline</th>
                        <th>Actions</th>
                    </tr>

                    <?php

                        // Connect the DB
                        $connect = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

                        // Select DB
                        $db_select = mysqli_select_db($connect, DB_NAME) or die(mysqli_error());

                        // Query to Get list from table
                        $sql = "SELECT * FROM tbl_tasks";

                        // Execute the query
                        $res = mysqli_query($connect, $sql);

                        // Check if query executed or not
                        if($res == true) {
                            // Display tasks from DB
                            // Count the tasks on DB first
                            $count_rows = mysqli_num_rows($res);

                            // Create Sno variable
                            $sn = 1;
                            
                            // Check if there is task on DB
                            if($count_rows > 0) {
                                // Data is in DB
                                while($row = mysqli_fetch_assoc($res)) {
                                    $task_id = $row['task_id'];
                                    $task_name = $row['task_name'];
                                    $priority = $row['priority'];
                                    $deadline = $row['deadline'];
                                    ?>

                                    <tr>
                                        <td><?php echo $sn++; ?>.</td>
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
                                //  No data in DB
                                ?>
                                <tr>
                                    <td colspan="5">No Task Added Yet.</td>
                                </tr>
                                <?php  
                            }
                        }
                        else {
                            
                        }

                    ?>

                    
                </table>
            </div>
            <!-- Task End -->
        </div>
    </body>

</html>