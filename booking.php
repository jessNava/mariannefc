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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script> 
    <title>Admin_Page</title>
    <style>
        .small-text {
            font-size: 0.85em; /* Adjust the font size as needed */
        }
        .dropdown-toggle::after {
            display: none !important;
        }
        .dropdown-menu {
            min-width: auto;
        }
        .dropdown-menu a {
            font-size: 0.9em;
        }
        .btn-secondary {
            padding: 0;
            border: none;
            background: none;
        }
         /* Hide scrollbar for Chrome, Safari and Opera */
        .instructors-overview::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for IE, Edge and Firefox */
        .instructors-overview {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
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
        <?php
        // Check if there's a success message in the URL parameters
        if (isset($_GET['success']) && $_GET['success'] == 1) {
            // Display Bootstrap alert for success
            echo '<div id="membership-success-alert" class="alert alert-success" role="alert" style="position: absolute; top: 60px; left: 50%; transform: translateX(-50%); z-index: 9999;">
                Membership successful!
            </div>';
            unset($_SESSION['success']);
        }
        ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Find the alert element
                var alertElement = document.getElementById('membership-success-alert');
                // If the alert element exists
                if (alertElement) {
                    // Hide the alert after 1.5 seconds
                    setTimeout(function () {
                        alertElement.style.display = 'none';
                    }, 1500); // 1.5 seconds
                }
            });
        </script>
            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include('topbar.php'); ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid"> 
                    <!-- Page Heading --> 
                    <div class="card mb-3 shadow" style="border:none">
                        <div class="card-body border-white d-flex justify-content-between align-items-center">
                            <h5 class="text-gray-800">All bookings</h5>
                            <a href="#" data-toggle="modal" data-target="#reservationModal" class="btn btn-success">Add Session</a>
                        </div>
                        <div class="card-body bg-white">
                            <div class="input-group">
                                <input  type="text" id="searchInput" class="form-control" placeholder="Search booking...">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" id="search-member">Search</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card shadow mb-4" style="border:none">
                                <div class="card-body">
                                    <div class="table-responsive">
                                    <table class="table table-sm" id="myTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Room Type</th>
                                                <th>Booking no.</th>
                                                <th>Check-in</th>
                                                <th>Check-out</th>
                                                <th>Status</th>
                                                <th>Total</th>
                                                <th>Payment</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $sql = "SELECT *, CONCAT(firstname, ' ', lastname) AS fullname FROM membership";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $age = $row['age'];
                                                $gender = $row['gender'];
                                                $membership = $row['membership'];

                                                $fullname = $row['fullname'] . "<br><span class='small-text'>(age: " . $age . ")</span><br><span class='small-text'>(" . $gender . ")</span>";

                                                $statusBadge = $row['status'] == 'Pending' ? 'badge-warning' : 'badge-success';
                                                $paymentBadge = $row['payment'] == 'Unpaid' ? 'badge-danger' : 'badge-success';


                                                echo "<tr>";
                                                echo "<td>" . $fullname . "</td>";
                                                echo "<td>" . $row['class'] . "</td>";
                                                echo "<td>" . $row['contactnumber'] . "</td>";
                                                echo "<td>" . $row['goal'] . "</td>";
                                                echo "<td>" . $row['startingdate'] . "</td>";
                                                echo "<td><span class='badge badge-pill " . $statusBadge . "'>" . ucfirst($row['status']) . "</span></td>";
                                                echo "<td>" . $row['total'] . "</td>";
                                                echo "<td><span class='badge badge-pill " . $paymentBadge . "'>" . ucfirst($row['payment']) . "</span></td>";
                                                echo "<td>
                                                <button type=\"button\" class=\"btn btn-sm edit-membership-btn\" style=\"color: black; background-color: white;\" data-toggle=\"modal\" data-target=\"#editmembershipmodal\" 
                                                    data-id=\"" . $row["id"] . "\" 
                                                    data-firstname=\"" . $row["firstname"] . "\" 
                                                    data-class=\"" . $row["class"] . "\" 
                                                    data-contactnumber=\"" . $row["contactnumber"] . "\"
                                                    data-goal=\"" . $row["goal"] . "\"
                                                    data-startingdate=\"" . $row["startingdate"] . "\"
                                                    data-membership=\"" . $row["membership"] . "\"
                                                    data-status=\"" . $row["status"] . "\"
                                                    data-total=\"" . $row["total"] . "\"
                                                    data-payment=\"" . $row["payment"] . "\">
                                                    <i class='fas fa-pen'></i>
                                                </button>
                                                <!-- View Button -->
                                                <button type=\"button\" class=\"btn btn-sm view-membership-btn\" style=\"color: black; background-color: white;\" data-toggle=\"modal\" data-target=\"#viewmembershipmodal" . $row['id'] . "\">
                                                    <i class='fas fa-eye'></i>
                                                </button>
                                                <!-- View Membership Modal -->
                                                <div class=\"modal fade bd-example-modal-lg\" id=\"viewmembershipmodal" . $row['id'] . "\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"viewmembershipmodalLabel" . $row['id'] . "\" aria-hidden=\"true\">
                                                    <div class=\"modal-dialog modal-dialog-centered modal-lg\" role=\"document\">
                                                        <div class=\"modal-content\">
                                                            <div class=\"modal-header\">
                                                                <h5 class=\"modal-title\" id=\"viewmembershipmodalLabel" . $row['id'] . "\">Membership Receipt</h5>
                                                                <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                                                                    <span aria-hidden=\"true\">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class=\"modal-body\">
                                                                <!-- Receipt -->
                                                                <div class=\"container\">
                                                                    <div class=\"row\">
                                                                        <div class=\"col\">
                                                                            <p><strong>Username:</strong> " . $row['username'] . "</p>
                                                                            <p><strong>Email:</strong> " . $row['email'] . "</p>
                                                                            <p><strong>Full Name:</strong> " . $fullname . "</p>
                                                                            <p><strong>Gender:</strong> " . $gender . "</p>
                                                                            <p><strong>Age:</strong> " . $age . "</p>
                                                                            <p><strong>Contact Number:</strong> " . $row['contactnumber'] . "</p>
                                                                        </div>
                                                                        <div class=\"col\">
                                                                            <p><strong>Class:</strong> " . $row['class'] . "</p>
                                                                            <p><strong>Goal:</strong> " . $row['goal'] . "</p>
                                                                            <p><strong>Current Weight:</strong> " . $row['currentweight'] . "</p>
                                                                            <p><strong>Current Height:</strong> " . $row['currentheight'] . "</p>
                                                                            <p><strong>Starting Date:</strong> " . $row['startingdate'] . "</p>
                                                                            <p><strong>Membership:</strong> " . $row['membership'] . "</p>
                                                                        </div>
                                                                        <div class=\"col\">
                                                                            <p><strong>Status:</strong> " . ucfirst($row['status']) . "</p>
                                                                            <p><strong>Payment:</strong> " . ucfirst($row['payment']) . "</p>
                                                                            <p><strong>Total:</strong> " . $row['total'] . "</p>
                                                                            <p><strong>Date Paid:</strong> " . $row['datepaid'] . "</p>
                                                                            <p><strong>Trainer:</strong> John Babel Bisnar</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- End of Receipt -->
                                                            </div>
                                                            <div class=\"modal-footer\">
                                                                <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End of View Membership Modal -->
                                                <button type=\"button\" class=\"btn btn-sm delete-membership-btn\" style=\"color: black; background-color:white\" data-toggle=\"modal\" data-target=\"#deletemembershipmodal\" data-membership-id=\"".$row["id"]."\">
                                                    <i class='fas fa-trash'></i>
                                                </button>
                                            </td>";

                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='12'>No records found</td></tr>";
                                        }
                                        ?>

                                        </tbody>

                                    </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
                <!-- /.container-fluid --> 
            </div>
            <!-- End of Main Content -->
        <!-- Create member Modal -->
        <div class="modal fade" id="reservationModal" tabindex="-1" role="dialog" aria-labelledby="reservationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reservationModalLabel"><i class="bi bi-calendar-check"></i> Reserve a Session</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="createmembership.php" method="POST">
                        <div class="row">
                                    <div class="col-5" style="margin-left: 55px;">
                                        <!-- Left Column -->
                                        <input style="display: none;" type="text" class="form-control" id="username" name="username" value="<?php echo $_SESSION['username']; ?>" readonly>
                                        <div class="form-group">
                                            <label for="email">Email address</label>
                                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $_SESSION['email']; ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="firstname">First name</label>
                                            <input type="text" class="form-control" id="firstname" name="firstname">
                                        </div>
                                        <div class="form-group">
                                            <label for="lastname">Last name</label>
                                            <input type="text" class="form-control" id="lastname" name="lastname">
                                        </div>
                                        <div class="form-group">
                                            <label for="gender">Gender</label>
                                            <select class="form-control" id="gender" name="gender">
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="age">Age</label>
                                            <input type="text" class="form-control" id="age" name="age">
                                        </div>
                                        <div class="form-group">
                                            <label for="contact">Contact number</label>
                                            <input type="text" class="form-control" id="contact" name="contact">
                                        </div>
                                    </div>
                                    <div class="col-5 ml-4 mr-4">
                                        <!-- Middle Column -->
                                        <div class="form-group">
                                            <label for="class">Class</label>
                                            <select class="form-control" id="class" name="class" required>
                                                <option value="Bulking">Bulking</option>
                                                <option value="Cutting">Cutting</option>
                                                <option value="Strenth Training">Strenth Training</option>
                                                <option value="Fat Burning">Fat Burning</option>
                                                <option value="Weight Gaining">Weight Gaining</option>
                                                <option value="Flexibility Training">Flexibility Training</option>
                                                <option value="Sports-specific Training">Sports-specific Training</option>
                                                <option value="Mental Health Training">Mental Health Training</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="gender">Goal</label>
                                            <select class="form-control" id="goal" name="goal">
                                                <option value="Lose Weight">Lose Weight</option>
                                                <option value="Build Muscle">Build Muscle</option>
                                                <option value="Learning">Learning</option>
                                                <option value="Gain Weight">Gain Weight</option>
                                                <option value="Healthy">Healthy</option>
                                                <option value="Body Cut">Body Cut</option>
                                                <option value="Bulking">Bulking</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="weight">Current Weight</label>
                                            <input type="text" class="form-control" id="weight" name="weight">
                                        </div>
                                        <div class="form-group">
                                            <label for="height">Current Height</label>
                                            <input type="text" class="form-control" id="height" name="height">
                                        </div>
                                        <div class="form-group">
                                            <label for="startdate">Starting Date</label>
                                            <input type="date" class="form-control" id="startdate" name="startdate">
                                        </div>
                                        <div class="form-group">
                                            <label for="membership">Membership</label>
                                            <select class="form-control" id="membership" name="membership" required>
                                                <option value="monthly">Monthly</option>
                                                <option value="sixmonths">6 months</option>
                                                <option value="yearly">Yearly</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <button style="background-color: #E74C3C; color: aliceblue; width: 100px;" type="submit" class="float-right btn mt-3">Reserve</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Membership Modal -->
        <div class="modal fade" id="deletemembershipmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #dc3545; color: white">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Member</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this Member?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger confirm-delete-btn">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Delete Branch Modal -->

        <!-- Edit Membership Modal -->
        <div class="modal fade" id="editmembershipmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-m" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: white; color: black">
                        <h5 class="modal-title" id="exampleModalLabel">Edit record!</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="editmembershipform" action="update_membership.php" method="POST">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="edit_ip_name">Name:</label>
                                <input type="text" name="edit_name" id="edit_name" class="form-control form-control-sm" readonly>
                                <label for="edit_ip_name">Gym Type:</label>
                                <input type="text" name="edit_gymtype" id="edit_gymtype" class="form-control form-control-sm" >
                                <label for="edit_ip_name">Contact:</label>
                                <input type="text" name="edit_contact" id="edit_contact" class="form-control form-control-sm" >
                                <label for="edit_ip_name">Date of Joining:</label>
                                <input type="text" name="edit_dateofjoining" id="edit_dateofjoining" class="form-control form-control-sm" >
                                <label for="edit_ip_name">Membership:</label>
                                <select class="form-control form-control-sm" id="edit_membership" name="edit_membership">
                                    <option value="monthly">monthly</option>
                                    <option value="sixmonths">sixmonths</option>
                                    <option value="yearly">yearly</option>
                                </select>
                                <label for="edit_status">Status:</label>
                                <select class="form-control form-control-sm" id="edit_status" name="edit_status">
                                    <option value="Pending">Pending</option>
                                    <option value="Approved">Approved</option>
                                </select>
                                <label for="edit_ip_name">Total:</label>
                                <input type="text" name="edit_total" id="edit_total" class="form-control form-control-sm" >
                                <label for="edit_ip_name">Payment:</label>
                                <select class="form-control form-control-sm" id="edit_payment" name="edit_payment">
                                    <option value="Unpaid">Unpaid</option>
                                    <option value="Paid">Paid</option>
                                </select>
                                <input type="hidden" name="edit_membership_Id" id="edit_membership_Id">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End of Edit Membership Modal -->

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
    <div class="container">
    <!-- Alert -->
    <?php
    if (isset($_SESSION['status'])) {
        $alertType = ($_SESSION['status_code'] == 'success') ? 'success' : 'danger';
        echo '<div id="registration-success-alert" class="alert alert-' . $alertType . '" role="alert" style="position: absolute; top: 60px; left: 50%; transform: translateX(-50%); z-index: 9999;">
                ' . $_SESSION['status'] . '
            </div>';
        // Reset session variables
        unset($_SESSION['status']);
        unset($_SESSION['status_code']);
    }
    ?>
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
        $('.edit-membership-btn').click(function() {
            var membershipid = $(this).data('id');
            var membershipname = $(this).data('firstname');
            var membershipgymtype = $(this).data('class');
            var membershipcontact = $(this).data('contactnumber');
            var membershipjoining = $(this).data('startingdate');
            var membership = $(this).data('membership');
            var membershipstatus = $(this).data('status');
            var membershiptotal = $(this).data('total');
            var membershippayment = $(this).data('payment');

            $('#edit_membership_Id').val(membershipid);
            $('#edit_name').val(membershipname);
            $('#edit_gymtype').val(membershipgymtype);
            $('#edit_contact').val(membershipcontact);
            $('#edit_dateofjoining').val(membershipjoining);
            $('#edit_membership').val(membership);
            $('#edit_status').val(membershipstatus);
            $('#edit_total').val(membershiptotal);
            $('#edit_payment').val(membershippayment);
        });
    </script>
   <script>
    function filterTable() {
        var searchText = document.getElementById("searchInput").value.toUpperCase();
        var statusText = document.getElementById("filterStatus").value.toUpperCase(); // Get selected status
        var paymentText = document.getElementById("filterPayment").value.toUpperCase(); // Get selected payment status
        var table = document.getElementById("myTable");
        var tr = table.getElementsByTagName("tr");

        for (var i = 1; i < tr.length; i++) {
            var tdStatus = tr[i].getElementsByTagName("td")[6]; // Index of Status column
            var tdPayment = tr[i].getElementsByTagName("td")[8]; // Index of Payment column
            var tdmembername = tr[i].getElementsByTagName("td")[0]; // Index of Name column

            if (tdStatus && tdPayment && tdmembername) {
                var statusMatch = tdStatus.textContent.toUpperCase().indexOf(statusText) > -1;
                var paymentMatch = tdPayment.textContent.toUpperCase().indexOf(paymentText) > -1;
                var nameMatch = tdmembername.textContent.toUpperCase().indexOf(searchText) > -1;

                if (statusMatch && paymentMatch && nameMatch) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    document.getElementById("searchInput").addEventListener("input", filterTable);
    document.getElementById("filterStatus").addEventListener("change", filterTable); // Add event listener for status dropdown change
    document.getElementById("filterPayment").addEventListener("change", filterTable); // Add event listener for payment dropdown change
</script>




    <script>
    $(document).ready(function() {
        $('.delete-membership-btn').click(function() {
            var membershipId = $(this).data('membership-id');
            $('#deletemembershipmodal').find('.confirm-delete-btn').data('membership-id', membershipId);
        });

        $('.confirm-delete-btn').click(function() {
            var membershipId = $(this).data('membership-id');
            // AJAX request to delete the branch
            $.ajax({
                url: 'deletemember.php',
                type: 'POST',
                data: {membershipId: membershipId},
                success: function(response) {
                    // Handle success, like updating the table
                    $('#deletemembershipmodal').modal('hide');
                    // You might want to reload the table or remove the deleted row
                    location.reload();
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>

</div>

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
