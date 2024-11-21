<!-- Template Files here -->
<?php
require '../functions.php'; // Include your functions.php for session checks
guardDashboard(); 

// Define page routes
$logoutPage = 'logout.php';
$addSubjectPage = './subject/add.php';
$registerStudentPage = './student/register.php';

// Include header and sidebar partials
require './partials/header.php';
require './partials/side-bar.php';

// Fetch data (example PHP logic, replace with actual database queries)
$numSubjects = 0; // Replace with actual query for subjects count
$numStudents = 0; // Replace with actual query for students count
$numFailedStudents = 0; // Replace with actual query for failed students count
$numPassedStudents = 0; // Replace with actual query for passed students count
?>

<!-- Main Content -->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">    
    <h1 class="h2">Dashboard</h1>        
    
    <div class="row mt-5">
        <!-- Number of Subjects -->
        <div class="col-12 col-xl-3 mb-3">
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">Number of Subjects:</div>
                <div class="card-body text-primary">
                    <h5 class="card-title"><?php echo $numSubjects; ?></h5>
                </div>
            </div>
        </div>

        <!-- Number of Students -->
        <div class="col-12 col-xl-3 mb-3">
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">Number of Students:</div>
                <div class="card-body text-primary">
                    <h5 class="card-title"><?php echo $numStudents; ?></h5>
                </div>
            </div>
        </div>

        <!-- Number of Failed Students -->
        <div class="col-12 col-xl-3 mb-3">
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">Number of Failed Students:</div>
                <div class="card-body text-danger">
                    <h5 class="card-title"><?php echo $numFailedStudents; ?></h5>
                </div>
            </div>
        </div>

        <!-- Number of Passed Students -->
        <div class="col-12 col-xl-3 mb-3">
            <div class="card border-success">
                <div class="card-header bg-success text-white">Number of Passed Students:</div>
                <div class="card-body text-success">
                    <h5 class="card-title"><?php echo $numPassedStudents; ?></h5>
                </div>
            </div>
        </div>
    </div>    
</main>

<!-- Include Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<?php
require './partials/footer.php'; // Include footer partial
?>
<!-- Template Files here -->
