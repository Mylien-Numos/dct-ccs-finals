<?php
require '../functions.php'; // Include your session and database utility functions
guardDashboard(); // Protect the page with session check

// Database connection (modify credentials)
$conn = new mysqli("localhost", "root", "", "your_database_name");

// Handle Add Subject Form Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_subject'])) {
    $subjectCode = $_POST['subject_code'];
    $subjectName = $_POST['subject_name'];
    $stmt = $conn->prepare("INSERT INTO subjects (subject_code, subject_name) VALUES (?, ?)");
    $stmt->bind_param("ss", $subjectCode, $subjectName);
    $stmt->execute();
    $stmt->close();
}

// Handle Delete Subject
if (isset($_GET['delete'])) {
    $subjectId = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM subjects WHERE id = ?");
    $stmt->bind_param("i", $subjectId);
    $stmt->execute();
    $stmt->close();
}

// Fetch all subjects
$result = $conn->query("SELECT * FROM subjects");

// Include partials for layout
require './partials/header.php';
require './partials/side-bar.php';
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">
    <h1 class="h2">Add a New Subject</h1>

    <!-- Add Subject Form -->
    <div class="card my-4">
        <div class="card-body">
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="subject_code" class="form-label">Subject Code</label>
                    <input type="text" class="form-control" id="subject_code" name="subject_code" required>
                </div>
                <div class="mb-3">
                    <label for="subject_name" class="form-label">Subject Name</label>
                    <input type="text" class="form-control" id="subject_name" name="subject_name" required>
                </div>
                <button type="submit" name="add_subject" class="btn btn-primary">Add Subject</button>
            </form>
        </div>
    </div>

    <!-- Subject List -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Subject List</h5>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Subject Code</th>
                        <th>Subject Name</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['subject_code']; ?></td>
                            <td><?php echo $row['subject_name']; ?></td>
                            <td>
                                <a href="edit_subject.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info">Edit</a>
                                <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
<?php
require './partials/footer.php';
$conn->close();
?>
