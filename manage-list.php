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
        
            <h1>Task Manager</h1>
            <a class="menu-link" href="<?php echo SITEURL; ?>">Home</a>
            <h3>Manage Lists Page</h3>

            <p>
                <?php

                    // Check if the session is set
                    if(isset($_SESSION['add'])) {
                        // display message
                        echo $_SESSION['add'];
                        // Remove the message after displaying once
                        unset($_SESSION['add']);
                    }

                    // Check the session for Delete
                    if(isset($_SESSION['delete'])) {
                        echo $_SESSION['delete'];
                        unset($_SESSION['delete']);
                    }

                    // Check session for Update
                    if(isset($_SESSION['update'])) {
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                    }

                    // Check for Delete Fail
                    if(isset($_SESSION['delete_fail'])) {
                        echo $_SESSION['delete_fail'];
                        unset ($_SESSION['delete_fail']);
                    }
                
                ?>
            </p>

            <!-- Table to display lists Start -->
            <div class="all-lists">
                <a class="add-task" href="<?php echo SITEURL; ?>add-list.php">Add List</a>

                <table class="tablelist">
                    <tr>
                        <th>S No.</th>
                        <th>List Name</th>
                        <th>Actions</th>
                    </tr>

                    <?php

                        // Connect the DB 
                        $connect = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

                        // Select DB
                        $db_select = mysqli_select_db($connect, DB_NAME) or die(mysqli_error());

                        // SQL Query to display all data from database
                        $sql = "SELECT * FROM tbl_lists";

                        // Execute the Query
                        $res = mysqli_query($connect, $sql);

                        // Check if query executed successfully or not
                        if($res == true) {
                            // Work on displaying area
                            // echo "Executed";

                            // Count the rows fo data in DB
                            $count_rows = mysqli_num_rows($res);

                            // Create a serial number variable
                            $sn = 1;

                            // Check if there is data in database or not
                            if($count_rows > 0){
                                // There's data in database, Display in table

                                while($row = mysqli_fetch_assoc($res)) {
                                    // Getting data from DB
                                    $list_id = $row['list_id'];
                                    $list_name = $row['list_name'];
                                    ?>

                                        <tr>
                                            <td><?php echo $sn++; ?>.</td>
                                            <td><?php echo $list_name; ?></td>
                                            <td>
                                                <a class="upd-del" href="<?php echo SITEURL; ?>update-list.php?list_id=<?php echo $list_id; ?>">Update /</a>
                                                <a class="upd-del" href="<?php echo SITEURL; ?>delete-list.php?list_id=<?php echo $list_id; ?>">Delete</a>
                                            </td>
                                        </tr>

                                    <?php
                                    
                                }
                            }
                            else {
                                // No data in DB
                                ?>

                                <tr>
                                    <td colspan="3">No List Added Yet.</td>
                                </tr>

                                <?php
                            }
                        }

                    ?>

                </table>
            </div>


            <!-- Table to display lists End -->
        </div>
    </body>
</html>