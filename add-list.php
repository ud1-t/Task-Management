<?php
    include('config/constants.php');
    session_start();
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
            <a class="menu-link" href="<?php echo SITEURL; ?>manage-list.php">Manage Lists</a>

            <h3>Add Lists Page</h3>

            <p>

            <?php

                // Check whether the session is created or not
                if(isset($_SESSION['add_fail'])) {
                    // display session message
                    echo $_SESSION['add_fail'];
                    // Remove the message after displaying once
                    unset ($_SESSION['add_fail']);
                }
            ?>

            </p>
            
            <!-- Form to add lists Start -->

            <form class="all-lists" method="POST" action=""> 
                <table>
                    <tr>
                        <td>List Name : </td>
                        <td><input type="text" name="list_name" placeholder="Type list name here"  required="required"/></td>
                    </tr>
                    
                    <tr>
                        <td>List Description : </td>
                        <td><textarea name="list_description" placeholder="Type list description here"></textarea></td>
                    </tr>

                    <tr>
                        <td><input type="submit" name="submit" value="SAVE"/></td>
                    </tr>
                </table>
            </form>

            <!-- Form to add lists End -->
        </div>
    </body>
</html>

<?php

    // Check whether the form is submitted or not
    if(isset($_POST['submit'])) {
        // echo "Form Submitted";

        // Get values from form and save in variables
        $list_name = $_POST['list_name'];
        $list_description = $_POST['list_description'];

        // Connect DB
        $connect = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

        // Check if DB is connected or not
        /*  if($connect == true) {
            echo "Database Connected";
        }   */
        

        // Select DB
        $db_select = mysqli_select_db($connect, DB_NAME);

        // Check if DB is connected or not
        /*  if($db_select == true) {
            echo "Database Selected";
        }   */
        
        // SQL Query to insert into DB
        $sql = "INSERT INTO tbl_lists SET
                list_name = '$list_name',
                list_description = '$list_description'
        ";

        // Execute Query and insert into DB
        $res = mysqli_query($connect, $sql);

        // Check if query executed successfully or not
        if($res == true) {
            // Data inserted successfully
            // echo "Data Inserted";

            // Create a SESSION variable to Display message
            $_SESSION['add'] = "List Added Successfully";

            // Redirect to Manage List Page
            header('location:'.SITEURL.'manage-list.php');

        }
        else {
            // Failed to Insert Data
            echo "Failed to Insert Data";

            // Create a SESSION variable to save message
            $_SESSION['add_fail'] = "Failed to add List";

            // Redirect to Manage List Page
            header('location:'.SITEURL.'add-list.php');
        }
    }

?>