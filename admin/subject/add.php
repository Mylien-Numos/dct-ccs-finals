<?php

include '../../functions.php'; // Include your functions.php for database access and session management
guardDashboard(); // Ensure the user is logged in

// Define page URLs for the sidebar
$dashboardPage = '../dashboard.php';   // Adjust the path to the dashboard
$registerStudentPage = '../student/register.php';  // Path to the 'register student' page
$logoutPage = '../logout.php';   // Path for logging out

include '../partials/header.php'; 
include '../partials/side-bar.php';

$errorMessage = ''; // Initialize error message variable

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize inputs
    $subjectCode = trim($_POST['subject_code']);
    $subjectName = trim($_POST['subject_name']);

    // Basic validation
    if (empty($subjectCode) || empty($subjectName)) {
        $errorMessage = 'Both subject code and name are required.';
    } else {
        // Proceed to add the subject to the database
        try {
            $conn = getConnection();
            $query = "INSERT INTO subjects (subject_code, subject_name) VALUES (:subject_code, :subject_name)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':subject_code', $subjectCode);
            $stmt->bindParam(':subject_name', $subjectName);

            if ($stmt->execute()) {
                // Redirect with a success parameter if the subject was added
                header("Location: add.php?success=true");
                exit;
            } else {
                $errorMessage = 'Failed to add the subject. Please try again.';
            }
        } catch (Exception $e) {
            $errorMessage = 'Error: ' . $e->getMessage(); // Display error if database query fails
        }
    }
}

// Function to fetch subjects from the database
function fetchSubjects() {
    // Get the database connection
    $conn = getConnection();

    // Prepare the SQL query to fetch all subjects
    $query = "SELECT * FROM subjects"; // Adjust table and column names if needed
    $stmt = $conn->prepare($query);

    // Execute the query
    $stmt->execute();

    // Fetch all rows as an associative array
    $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the fetched subjects
    return $subjects;
}

?>

<!-- Main Content -->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">
    <h1 class="h2">Add New Subject</h1>

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Subject</li>
        </ol>
    </nav>

    <!-- Display error message if exists -->
    <?php if ($errorMessage): ?>
        <div class="alert alert-danger mt-3">
            <?php echo htmlspecialchars($errorMessage); ?>
        </div>
    <?php endif; ?>

    <!-- Success message after adding a subject -->
    <?php if (isset($_GET['success']) && $_GET['success'] == 'true'): ?>
        <div class="alert alert-success mt-3">
            Subject added successfully!
        </div>
    <?php endif; ?>

    <!-- Subject Form -->
    <div class="card p-4 mb-5">
        <form method="POST">
            <div class="mb-3">
                <label for="subject_code" class="form-label">Subject Code</label>
                <input type="text" class="form-control" id="subject_code" name="subject_code">
            </div>
            <div class="mb-3">
                <label for="subject_name" class="form-label">Subject Name</label>
                <input type="text" class="form-control" id="subject_name" name="subject_name">
            </div>
            <button type="submit" class="btn btn-primary w-100">Add Subject</button>
        </form>
    </div>

    <!-- Subject List Table -->
    <div class="card p-4">
        <h3 class="card-title text-center">Subject List</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php
            // Fetch subjects from database
            $allSubjects = fetchSubjects();
            if (!empty($allSubjects)):
                foreach ($allSubjects as $subjectDetails):
            ?>
                <tr>
                    <td><?= htmlspecialchars($subjectDetails['subject_code']) ?></td>
                    <td><?= htmlspecialchars($subjectDetails['subject_name']) ?></td>
                    <td>
                        <!-- Edit Option -->
                        <a href="edit.php?subject_code=<?= urlencode($subjectDetails['subject_code']) ?>" class="btn btn-info btn-sm">Edit</a>

                        <!-- Remove Option -->
                        <a href="delete.php?subject_code=<?= urlencode($subjectDetails['subject_code']) ?>" class="btn btn-danger btn-sm">Remove</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3" class="text-center">No subjects found.</td>
            </tr>
        <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

<?php include '../partials/footer.php'; ?>
