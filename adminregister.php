<?php 
include 'connection.php';
session_start();
if(!isset($_SESSION["username"])) {
    header("location: AdminPortal.php");
}
?>
<!DOCTYPE html>
<html lang="en">  
<head>   
    <!-- plugin css -->
    <link rel="stylesheet" href="myStyles/CSS/sb-admin-2.min.css"> 
    <link href="myStyles/CSS/AdminPage.css" rel="stylesheet" type="text/css"> 
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">   
    <!-- CSS only --> 
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> 
    <!-- Ajax  -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> 
    <!-- jquery and datatable plugin -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <!-- alert plugin sweetalert2  -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script> 
    <title>Admin_Page</title>
    <style>
        .card {
            margin: 1rem 0;
        }
    </style>
</head>
<body id="page-top">
    <!-- Alert -->
    <?php
        if (isset($_SESSION['registration_success']) && $_SESSION['registration_success']) {
            echo '<div id="registration-success-alert" class="alert alert-success" role="alert" style="position: absolute; top: 60px; left: 50%; transform: translateX(-50%); z-index: 9999;">
                    Admin added !
                </div>';
            // Reset session variable
            unset($_SESSION['registration_success']);
    }
    ?>
    <!-- JavaScript to hide the alert after 1.5 seconds -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Find the alert element
            var alertElement = document.getElementById('registration-success-alert');
            // If the alert element exists
            if (alertElement) {
                // Hide the alert after 1.5 seconds
                setTimeout(function () {
                    alertElement.style.display = 'none';
                }, 1500); // 1.5 seconds
            }
        });
    </script>
   <?php
if (isset($_GET['delete_success']) && $_GET['delete_success'] == 'true') {
    echo '<div id="registration-success-alert" class="alert alert-success" role="alert" style="position: absolute; top: 60px; left: 50%; transform: translateX(-50%); z-index: 9999;">
            Delete successful!
        </div>';
}
?>
<!-- JavaScript to hide the alert after 1.5 seconds -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Find the alert element
        var alertElement = document.getElementById('registration-success-alert');
        // If the alert element exists
        if (alertElement) {
            // Hide the alert after 1.5 seconds
            setTimeout(function () {
                alertElement.style.display = 'none';
            }, 1500); // 1.5 seconds
        }
    });
</script>

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include('sidebar.php'); ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include('topbar.php'); ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid"> 
                    <!-- Page Heading --> 
                    <h1 class="h3 text-gray-800">Admin list</h1> 
                    
                    <!-- Content Row -->
                    <div class="row">

                        <!-- Add Admin Column -->
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="bg-secondary text-white">
                                    <h5 class="p-2">Add Admin</h5>
                                </div>
                                <div class="card-body">
                                    <form action="adminregisteraccount.php" method="POST">
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter admin name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Add Admin</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                       <!-- Admin List Column -->
<div class="col-lg-8">
    <div class="card">
        <div class="bg-secondary text-white">
            <h5 class="p-2">Admin List</h5>
        </div>
        <div class="card-body">
            <div class="list-group">
                <?php
                // Fetch data from the database
                $sql = "SELECT username FROM adminaccount";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo '<div class="list-group-item d-flex justify-content-between align-items-center">';
                        echo '<div>' . $row["username"] . '</div>';
                        echo '<form action="deleteadmin.php" method="POST">';
                        echo '<input type="hidden" name="username" value="' . $row["username"] . '">';
                        echo '<button type="submit" class="btn badge badge-danger badge-pill">Delete</button>';
                        echo '</form>';
                        echo '</div>';
                    }
                } else {
                    echo "0 results";
                }
                ?>
            </div>
        </div>
    </div>
</div>




                    </div>  
                </div>
                <!-- /.container-fluid --> 
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Company 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body text-center">Are you sure you want to "Logout"?<br> Select "Logout" below if you want to logout.</div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="button" data-dismiss="modal"><i class="far fa-times-circle"></i> Cancel</button>
                    <a class="btn btn-danger" href="logout.php"><i class="far fa-check-circle"></i> Logout</a>
                </div>
            </div>
        </div>
    </div>  
    <!-- End of Logout Modal -->

    <!-- start of page loader -->
    <div class="loader-wrapper">
        <h2 id="description">Loading...</h2>
        <div id="loadingIndicator">
            <div class="loadingBar" id="loadingBar1"></div>
            <div class="loadingBar" id="loadingBar2"></div>
            <div class="loadingBar" id="loadingBar3"></div>
            <div class="loadingBar" id="loadingBar4"></div> 
        </div>
    </div>
    <script>
        <?php if (isset($_SESSION['status'])) {
            echo "Swal.fire({
                icon: '" . ($_SESSION['status_code'] == 'success' ? 'success' : 'error') . "',
                title: '" . $_SESSION['status'] . "',
                showConfirmButton: false,
                timer: 1500
            });";
            unset($_SESSION['status']); // Clear the session variable
            unset($_SESSION['status_code']); // Clear the session variable
        }
        ?>
    </script>
    <!-- end of page loader -->   
    <!-- Bootstrap 5 plugin -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
    <!-- jquery and datatable plugin -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <!-- Bootstrap core JavaScript--> 
    <script src="myStyles/JS/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="myStyles/JS/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="myStyles/JS/sb-admin-2.min.js"></script> 
    <script src="myStyles/JS/adminlistJS.js"></script> 
    <script src="myStyles/JS/loader.js"></script>
</body> 
</html>
