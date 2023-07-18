<?php
    include('config/constants.php');

    // Check task_id on URL
    if(isset($_GET['task_id'])) {
        // Delete the task from DB
        // Get the task_id
        $task_id = $_GET['task_id'];

        // Connect the DB
        $connect = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

        // Select DB
        $db_select = mysqli_select_db($connect, DB_NAME) or die(mysqli_error());

        // Query to Get list from table
        $sql = "DELETE FROM tbl_tasks WHERE task_id=$task_id";

        // Execute the query
        $res = mysqli_query($connect, $sql);

        // Check if query executed or not
        if($res == true) {
            // Query executed successfully and task Deleted
            $_SESSION['delete'] = "Task Deleted Successfully.";
            
            // Redirect to Homepage
            header('location:'.SITEURL);
        }
        else {
            // Failed to delete task
            $_SESSION['delete_fail'] = "Failed to Delete Task.";
            
            // Redirect to Homepage
            header('location:'.SITEURL);
        }
    }
?>

