<?php
require_once(__DIR__ . '/../../functions.php');
guard(); // Ensure the user is authenticated

// Initialize variables
$error_message = '';
$success_message = '';

// Handle Add Subject Request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_subject'])) {
    $subject_code = trim($_POST['subject_code']);
    $subject_name = trim($_POST['subject_name']);

    // Validate inputs
    if (empty($subject_code) || empty($subject_name)) {
        $error_message = "Both fields are required.";
    } else {
        // Insert new subject into the database
        $connection = db_connect();
        $query = "INSERT INTO subjects (subject_code, subject_name) VALUES (?, ?)";
        $stmt = $connection->prepare($query);
        $stmt->bind_param('ss', $subject_code, $subject_name);

        if ($stmt->execute()) {
            $success_message = "Subject added successfully!";
        } else {
            $error_message = "Error adding subject. Please try again.";
        }
    }
}

// Fetch subjects to display in the list
$connection = db_connect();
$query = "SELECT * FROM subjects";
$result = $connection->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Subject</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../partials/custom-dashboard.css">
</head>
<body class="bg-light">

    <?php require_once '../partials/header.php'; ?>
    <?php require_once '../partials/side-bar.php'; ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">
        <h1 class="h2">Add a New Subject</h1>

        <!-- Display messages -->
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($error_message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif (!empty($success_message)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($success_message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Form for adding a new subject -->
        <form method="post" action="">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="subject_code" name="subject_code" placeholder="Subject Code" value="<?php echo htmlspecialchars($subject_code ?? ''); ?>" required>
                <label for="subject_code">Subject Code</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="subject_name" name="subject_name" placeholder="Subject Name" value="<?php echo htmlspecialchars($subject_name ?? ''); ?>" required>
                <label for="subject_name">Subject Name</label>
            </div>
            <div class="mb-3">
                <button type="submit" name="add_subject" class="btn btn-primary w-100">Add Subject</button>
            </div>
        </form>

        <!-- Subject List -->
        <h3 class="mt-5">Subject List</h3>
        <table class="table">
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
                        <td><?php echo htmlspecialchars($row['subject_code']); ?></td>
                        <td><?php echo htmlspecialchars($row['subject_name']); ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">Edit</a>
                            <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>

    <?php require_once '../partials/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
