<?php
    include 'connection.php';
    session_start();
    if(!isset($_SESSION["username"])) {
        header("location: adminloginform.php");
    }
     // Fetch total number of members
     $sql = "SELECT COUNT(*) AS total_members FROM membership";
     $result = $conn->query($sql);
     $row = $result->fetch_assoc();
     $totalMembers = $row['total_members'];

     // Fetch total number of paid members
    $sql = "SELECT COUNT(*) AS total_paid_members FROM membership WHERE payment = 'Paid'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $totalPaidMembers = $row['total_paid_members'];

    // Fetch total number of unpaid members
    $sql = "SELECT COUNT(*) AS total_unpaid_members FROM membership WHERE payment = 'Unpaid'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $totalUnpaidMembers = $row['total_unpaid_members'];

    // Fetch total number of trainers
    $sql = "SELECT COUNT(*) AS total_trainers FROM trainers";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $totalTrainers = $row['total_trainers'];

    // Fetch total revenue
    $sql = "SELECT SUM(total) AS total_revenue FROM membership";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $totalRevenue = $row['total_revenue'];

    // Fetch revenue data for each month
    $sql = "SELECT DATE_FORMAT(startingdate, '%Y-%m') AS month_year, SUM(total) AS monthly_revenue FROM membership GROUP BY DATE_FORMAT(startingdate, '%Y-%m')";
    $result = $conn->query($sql);

    // Initialize arrays to store labels (months) and revenue data
    $labels = [];
    $revenueData = [];

    // Process query results
    while ($row = $result->fetch_assoc()) {
        $labels[] = $row['month_year'];
        $revenueData[] = $row['monthly_revenue'];
    }
?>
    <html>
    <head>
<!-- CSS only --> 
<link rel="stylesheet" href="myStyles/CSS/sb-admin-2.min.css"> 
<link href="myStyles/CSS/adminDashboard.css" rel="stylesheet" type="text/css"> 
<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
<link href="myStyles/CSS/css/all.min.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> 
<!-- Ajax  -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> 
<!-- alert plugin sweetalert2  -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<link rel="icon" href="Images/logofinal.png" type="image/png">

<title>Admin_Page</title>
    </head>
    <body id="page-top">
    <div id="wrapper">

<!-- Sidebar -->
<?php
    include('sidebar.php');
?>
<!-- End of Sidebar -->

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content"> 
        <!-- Topbar -->
       <?php include ('topbar.php');?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid"> 
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Dashboard</h1> 
            </div> 
        <div class="row">
           
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow-lg h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Members
                            </div>
                            <div class="h1 ml-1 font-weight-bold text-gray-800">
                                <?php echo $totalMembers; ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-600 mt-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow-lg h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Paid Members
                            </div>
                            <div class="h1 ml-1 font-weight-bold text-gray-800">
                                <?php echo $totalPaidMembers; ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-600 mt-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow-lg h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Unpaid Members
                            </div>
                            <div class="h1 ml-1 font-weight-bold text-gray-800">
                                <?php echo $totalUnpaidMembers; ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-600 mt-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow-lg h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Trainers
                            </div>
                            <div class="h1 ml-1 font-weight-bold text-gray-800">
                                <?php echo $totalTrainers; ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-tie fa-2x text-gray-600 mt-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card shadow">
                <div class="card-body">
                    <canvas id="revenueChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card shadow">
                <div class="card-body" style="width:fit-content">
                    <canvas id="membershipPieChart"></canvas>
                </div>
            </div>
        </div>


<script>
    var ctx = document.getElementById('revenueChart').getContext('2d');
    var revenueChart = new Chart(ctx, {
        type: 'bar', // Change to 'bar' for bar graph
        data: {
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{
                label: 'Revenue',
                data: <?php echo json_encode($revenueData); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    var ctx = document.getElementById('membershipPieChart').getContext('2d');
    var membershipPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Paid Members', 'Unpaid Members'],
            datasets: [{
                data: [<?php echo $totalPaidMembers; ?>, <?php echo $totalUnpaidMembers; ?>],
                backgroundColor: ['rgba(54, 162, 235, 0.2)', 'rgba(255, 99, 132, 0.2)'],
                borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
    });
</script>

        
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->
    <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; BizMaTech 2024</span>
                    </div>
                </div>
            </footer>
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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
                    <button class="btn btn-success" type="button" data-dismiss="modal"><i class="far fa-times-circle"></i>  Cancel</button>
                    <a class="btn btn-danger" href="logout.php"><i class="far fa-check-circle"></i>  Logout</a>
                </div>
            </div>
        </div>
    </div>   
    <!-- start of page loader -->
    <div class="loader-wrapper">
    <h2 id="description">
	    Loading...
    </h2>
    <div id="loadingIndicator">
        <div class="loadingBar" id="loadingBar1"></div>
        <div class="loadingBar" id="loadingBar2"></div>
        <div class="loadingBar" id="loadingBar3"></div>
        <div class="loadingBar" id="loadingBar4"></div> 
    </div>
    </div>
    <!-- end of page loader -->
    <script src="myStyles/JS/loader.js"></script>
    <!-- Bootstrap core JavaScript-->
    <script src="myStyles/JS/jquery.min.js"></script>
    <script src="myStyles/JS/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="myStyles/JS/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="myStyles/JS/sb-admin-2.min.js"></script>

    <!-- jqeury for page laoder -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" 2
    integrity="sha384-tsQFqpEReu7ZLhBV2VZlAu7zcOV+rXbYlF2cqB8txI/8aZajjp4Bqd+V6D5IgvKT" 3
    crossorigin="anonymous"></script>
  <script src="dist/js/jquery.preloadinator.min.js"></script>

    <!-- Page level plugins -->
    <script src="myStyles/JS/Chart.min.js"></script>
    <script src="myStyles/JS/all.min.js"></script>
    </body>
    </html>
