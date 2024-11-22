<!-- Template Files here -->
<?php
require'../functions.php'; // Include your functions.php for session checks
guardDashboard(); 


$logoutPage = 'logout.php';
$addSubjectPage = './subject/add.php';
$registerStudentPage = './student/register.php';
require './partials/header.php';
require './partials/side-bar.php';


?>

<!-- Main Content -->

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">    
    <h1 class="h2">Dashboard</h1>        
    
    <div class="row mt-5">
        <div class="col-12 col-xl-3">
            <div class="card border-primary mb-3">
                <div class="card-header bg-primary text-white border-primary">Number of Subjects:</div>
                <div class="card-body text-primary">
                    <h5 class="card-title">0</h5>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-3">
            <div class="card border-primary mb-3">
                <div class="card-header bg-primary text-white border-primary">Number of Students:</div>
                <div class="card-body text-success">
                    <h5 class="card-title">0</h5>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-3">
            <div class="card border-danger mb-3">
                <div class="card-header bg-danger text-white border-danger">Number of Failed Students:</div>
                <div class="card-body text-danger">
                    <h5 class="card-title">0</h5>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-3">
            <div class="card border-success mb-3">
                <div class="card-header bg-success text-white border-success">Number of Passed Students:</div>
                <div class="card-body text-success">
                    <h5 class="card-title">0></h5>
                </div>
            </div>
        </div>
    </div>    
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<?php
require './partials/footer.php';
?>
<!-- Template Files here -->