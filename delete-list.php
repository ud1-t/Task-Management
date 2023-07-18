<?php
    // Include constants.php
    include('config/constants.php');

    // echo "Delete List Page"

    // Check if list_id is asigned or not
    if(isset($_GET['list_id'])) {
        // Delete list from DB

        // Get the list_id value from URL or Get Method
        $list_id = $_GET['list_id'];

        // Connect the DB
        $connect = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

        // Select DB
        $db_select = mysqli_select_db($connect, DB_NAME) or die(mysqli_error());

        // Query to Delete list from DB
        $sql = "DELETE FROM tbl_lists WHERE list_id=$list_id";

        // Execute the query
        $res = mysqli_query($connect, $sql);

        // Check whether the query executed successfully or not
        if($res == true) {
            // Query Executed successfully which means list is deleted duccessfully
            $_SESSION['delete'] = "List Deleted Successfully";

            // Redirect to manage list page
            header('location:'.SITEURL.'manage-list.php');
        }
        else {
            // Failed to Delete List
            $_SESSION['delete_fail'] = "Failed to Delete List";
            header('location:'.SITEURL.'manage-list.php');
        }
    }
    else {
        // Redirect to Manage List Page
        header('location:'.SITEURL.'manage-list.php');
    }


    

?>