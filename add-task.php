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

            <a class="menu-link" href="<?php echo SITEURL; ?>">Home</a>

            <h3>Add Task Page</h3>

            <p>
                <?php

                if(isset($_SESSION['add_fail'])) {
                    echo $_SESSION['add_fail'];
                    unset($_SESSION['add_fail']);
                }

                ?>
            </p>
            <form class="all-lists" method="POST" action="">

                <table>
                    <tr>
                        <td>Task Name: </td>
                        <td><input type="text" name="task_name" placeholder="Type your Task Name" required="required" /></td>
                    </tr>

                    <tr>
                        <td>Task Description: </td>
                        <td><textarea name="task_description" placeholder="Type Task Description"></textarea></td>
                    </tr>

                    <tr>
                        <td>Select List: </td>
                        <td>
                            <select name="list_id">

                            <?php

                                // Connect the DB
                                $connect = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

                                // Select DB
                                $db_select = mysqli_select_db($connect, DB_NAME) or die(mysqli_error());

                                // Query to Get list from table
                                $sql = "SELECT * FROM tbl_lists";

                                // Execute the query
                                $res = mysqli_query($connect, $sql);

                                // Check if query executed or not
                                if($res == true) {
                                    // Create variable to count rows
                                    $count_rows = mysqli_num_rows($res);

                                    // If there is data in DB then display all in dropdown else display none as option
                                    if($count_rows > 0) {
                                        // Display all lists in dropdown
                                        while($row = mysqli_fetch_assoc($res)) {
                                            $list_id = $row['list_id'];
                                            $list_name = $row['list_name'];
                                            ?>
                                            <option value="<?php echo $list_id; ?>"><?php echo $list_name; ?></option>
                                            <?php
                                        }
                                    }
                                    else {
                                        // Display none in option
                                        ?>
                                        <option value="0">None</option>p
                                        <?php  
                                    }
                                }

                            ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Priority: </td>
                        <td>
                            <select name="priority">
                                <option value="High">High</option>
                                <option value="Medium">Medium</option>
                                <option value="Low">Low</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Deadline: </td>
                        <td><input type="date" name="deadline"></td>
                    </tr>

                    <tr>
                        <td class="confirm"><input type="submit" name="submit" value="SAVE"></td>
                    </tr>
                </table>

            </form>
        </div>
    </body>

</html>

<?php

    //Check if save button is clicked or not
    if(isset($_POST['submit'])) {
        // echo "Button Clicked";
        // Get all values from form
        $task_name = $_POST['task_name'];
        $task_description = $_POST['task_description'];
        $list_id = $_POST['list_id'];
        $priority = $_POST['priority'];
        $deadline = $_POST['deadline'];

        // Connect DB
        $connect2 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

        // Select DB
        $db_select2 = mysqli_select_db($connect2, DB_NAME) or die(mysqli_error());

        // Create SQL Query to Insert data into DB
        $sql2 = "INSERT INTO tbl_tasks SET
                task_name = '$task_name',
                task_description = '$task_description',
                list_id = $list_id,
                priority = '$priority',
                deadline = '$deadline'
        ";

        // Execute Query
        $res2 = mysqli_query($connect2, $sql2);

        // Check if query executed or not
        if($res2 == true) {
            // Query executed and task inserted successfully
            $_SESSION['add'] = "Task Added Successfully.";

            // REdirect to  page
            header('location:'.SITEURL);
        }
        else {
            // Failed to add task
            $_SESSION['add_fail'] = "Failed to Add Task";
            header('location:'.SITEURL.'add-task.php');
        }
    }

?>