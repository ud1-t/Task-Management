<?php
    include('config/constants.php');

    // Get the current value of Selected list
    if(isset($_GET['list_id'])) {
        // Get the list_id value
        $list_id = $_GET['list_id'];

        // Connect the DB
        $connect = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());
        
        // Select DB
        $db_select = mysqli_select_db($connect, DB_NAME) or die(mysqli_error());
        
        // Query to get values from DB
        $sql = "SELECT * FROM tbl_lists WHERE list_id=$list_id";

        // Execute the query
        $res = mysqli_query($connect, $sql);
        
        // Check whether the query executed successfully or not
        if($res == true) {
            // Get value from DB
            $row = mysqli_fetch_assoc($res);     // Value is in array

            // Print $row array
            // print_r($row);

            // Create Individual Variable to save the data
            $list_name = $row['list_name'];
            $list_description = $row['list_description'];
        }
        else {
            // Go back to Manage List page
            header('location:'.SITEURL.'manage-list.php');
        }
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

            <div class="menu">
                <a class="menu-link" href="<?php echo SITEURL; ?>">Home</a>
                <a class="menu-link" href="<?php echo SITEURL; ?>manage-list.php">Manage Lists</a>
            </div>

            <h3>Update List Page</h3>

            <p>
                <?php

                    // Check if session is set or not
                    if(isset($_SESSION['update_fail'])) {
                        echo $_SESSION['update_fail'];
                        unset($_SESSION['update_fail']);
                    }

                ?>
            </p>

            <form class="all-lists" method="POST" action="">
                <table>
                    <tr>
                        <td>List Name: </td>
                        <td><input type="text" name="list_name" value="<?php echo $list_name; ?>" required="required" /></td>
                    </tr>

                    <tr>
                        <td>List Description: </td>
                        <td>
                            <textarea name="list_description">
                                <?php echo $list_description; ?>
                            </textarea>
                        </td>
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

    // Check if Update is clicked or not
    if(isset($_POST['submit'])) {
        //echo "Button Clicked";

        // Get updated values from our form
        $list_name = $_POST['list_name'];
        $list_description = $_POST['list_description'];

        // Connect DB
        $connect2 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

        // Select the DB
        $db_select2 = mysqli_select_db($connect2, DB_NAME);

        // Query to update List
        $sql2 = "UPDATE tbl_lists SET
                      list_name = '$list_name',
                      list_description = '$list_description'
                      WHERE list_id = $list_id
        ";

        // Execute the Query
        $res2 = mysqli_query($connect2, $sql2);

        // Check is query executed successfully or not
        if($res2 == true) {
            // Update Success
            // Set the message
            $_SESSION['update'] = "List Updated Successfully";

            // Redirect to Manage List Page
            header('location:'.SITEURL.'manage-list.php');
        }
        else {
            // Failed to update
            // Set session message
            $_SESSION['update_fail'] = "Failed to Update List";
            // Redirect to Update List Page
            header('location:'.SITEURL.'update-list.php?list_id='.$list_id);
        }
    }

?>