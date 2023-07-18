<?php
    include('config/constants.php');

    // Check the task-id in URL
    if(isset($_GET['task_id'])) {
        // Get the value from DB
        $task_id = $_GET['task_id'];

        // Connect the DB
        $connect = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

        // Select DB
        $db_select = mysqli_select_db($connect, DB_NAME) or die(mysqli_error());

        // Query to Get detail of selected task
        $sql = "SELECT * FROM tbl_tasks WHERE task_id=$task_id";

        // Execute the query
        $res = mysqli_query($connect, $sql);
        

        // Check if query executed or not
        if($res == true) {
            // Query executed
            $row = mysqli_fetch_assoc($res);

            // Get the individual value
            $task_name = $row['task_name'];
            $task_description = $row['task_description'];
            $list_id = $row['list_id'];
            $priority = $row['priority'];
            $deadline = $row['deadline'];
        }
    }
    else {
        // Redirect to Homepage
        header('location:'.SITEURL);
    }

?>

<html>
    <head>
        <title>Task Manager with PHP and MySQL</title>
        <link rel="stylesheet" href="<?php echo SITEURL; ?>css/style.css" />
    </head>

    <body>

        <div class="wrapper">
        
            <h1>TASK MANAGER</h1>

            <p>
                <a class="menu-link" href="<?php echo SITEURL; ?>">Home</a>
            </p>

            <h3>Update task Page</h3>

            <p>
                <?php

                    if(isset($_SESSION['update_fail'])) {
                        echo $_SESSION['update_fail'];
                        unset($_SESSION['update_fail']);
                    }

                ?>
            </p>

            <form  class="all-lists" method="POST" action="">

                <table>
                    <tr>
                        <td>Task Name: </td>
                        <td><input type="text" name="task_name" value="<?php echo $task_name; ?>" required="required" /></td>
                    </tr>
                    
                    <tr>
                        <td>Task Description: </td>
                        <td>
                            <textarea name="task_description">
                            <?php echo $task_description; ?>
                            </textarea>
                        </td>
                    </tr>

                    <tr>
                        <td>Select List: </td>
                        <td>
                            <select name="list_id">

                                <?php 
                                
                                    // Connect the DB
                                    $connect2 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

                                    // Select DB
                                    $db_select2 = mysqli_select_db($connect2, DB_NAME) or die(mysqli_error());

                                    // Query to Get detail of selected task
                                    $sql2 = "SELECT * FROM tbl_lists";

                                    // Execute the query
                                    $res2 = mysqli_query($connect2, $sql2);
                                    

                                    // Check if query executed or not
                                    if($res2 == true) {
                                        // Display the list
                                        // Count row
                                        $count_rows2 = mysqli_num_rows($res2);

                                        // Check if list is added or not
                                        if($count_rows2 > 0) {
                                            // List added
                                            while($row2 = mysqli_fetch_assoc($res2)) {
                                                // Get individual value
                                                $list_id_db = $row2['list_id'];
                                                $list_name = $row2['list_name'];
                                                ?>

                                                <option <?php if($list_id == $list_id_db) {echo "selected='selected' ";} ?> value="<?php echo $list_id_db; ?>"><?php echo $list_name; ?></option>

                                                <?php
                                            }
                                        }
                                        else {
                                            // List not added
                                            // Display none as option
                                            ?>
                                            <option <?php if($list_id==0) {echo "selected='selected' ";} ?> value="0">None</option>p
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
                                <option <?php if($priority=="High") {echo "selected='selected' ";} ?> value="High">High</option>
                                <option <?php if($priority=="Medium") {echo "selected='selected' ";} ?> value="Medium">Medium</option>
                                <option <?php if($priority=="Low") {echo "selected='selected' ";} ?> value="Low">Low</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Deadline: </td>
                        <td><input type="data" name="deadline" value="<?php echo $deadline; ?>" /></td>
                    </tr>

                    <tr>
                        <td class="confirm"><input type="submit" name="submit" value="UPDATE" /></td>
                    </tr>
                </table>
            </form>
         </div>
    </body>
</html>

<?php

    // Check if the button is clicked
    if(isset($_POST['submit'])) {
        // echo "Clicked";

        // Get values from form
        $task_name = $_POST['task_name'];
        $task_description = $_POST['task_description'];
        $list_id = $_POST['list_id'];
        $priority = $_POST['priority'];
        $deadline = $_POST['deadline'];

        // Connect DB
        $connect3 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

        // Select DB
        $db_select3 = mysqli_select_db($connect3, DB_NAME) or die(mysqli_error());

        // Create SQL Query to Insert data into DB
        $sql3 = "UPDATE tbl_tasks SET
                task_name = '$task_name',
                task_description = '$task_description',
                list_id = '$list_id',
                priority = '$priority',
                deadline = '$deadline'
                WHERE
                task_id = $task_id
        ";

        // Execute Query
        $res3 = mysqli_query($connect3, $sql3);

        // Check if query executed or not
        if($res3 == true) {
            // Query executed and task updated successfully
            $_SESSION['update'] = "Task Updated Successfully.";

            // REdirect to  Homepage
            header('location:'.SITEURL);
        }
        else {
            // Failed to update task
            $_SESSION['update_fail'] = "Failed to Update Task";
            header('location:'.SITEURL.'update-task.php?task_id='.$task_id);
        }

    }

?>