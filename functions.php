<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();   
}

// Function to safely fetch POST data
function postData($key){
    return $_POST["$key"] ?? '';
}

// Redirect to the dashboard if logged in
function guardLogin(){
    $dashboardPage = 'admin/dashboard.php';

    if(isset($_SESSION['email'])){
        header("Location: $dashboardPage");
    } 
}

// Redirect to login if not logged in
function guardDashboard(){
    $loginPage = '../index.php';
    if(!isset($_SESSION['email'])){
        header("Location: $loginPage");
    }
}

// Database connection function
function getConnection() {
    $host = 'localhost'; 
    $dbName = 'dct-ccs-finals'; 
    $username = 'root'; 
    $password = ''; 
    $charset = 'utf8mb4'; 
    
    try {
        $dsn = "mysql:host=$host;dbname=$dbName;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        return new PDO($dsn, $username, $password, $options);
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}

// Function for user login
function login($email, $password) {
    $validateLogin = validateLoginCredentials($email, $password);

    if(count($validateLogin) > 0){
        echo displayErrors($validateLogin);
        return;
    }

    $conn = getConnection();
    $hashedPassword = md5($password);

    $query = "SELECT * FROM users WHERE email = :email AND password = :password";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashedPassword);
    
    $stmt->execute();
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['email'] = $user['email'];
        header("Location: admin/dashboard.php");
    } else {
        echo displayErrors(["Invalid email or password"]);
    }
}

// Validate login credentials
function validateLoginCredentials($email, $password) {
    $errors = [];
    
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    
    if (empty($password)) {
        $errors[] = "Password is required.";
    }
    
    return $errors;
}

// Display formatted error or success messages
function displayErrors($errors) {
    if (empty($errors)) return "";

    // Custom error style to match the desired design with top center positioning
    $errorHtml = '<div class="alert alert-danger alert-dismissible fade show error-message" role="alert" style="background-color: #f8d7da; color: #721c24; border-color: #f5c6cb; border-radius: 0.375rem; width: 350px; padding: 10px 20px; font-size: 1rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 9999;">';
    $errorHtml .= '<strong style="font-weight: 600;">System Errors</strong><ul style="margin-top: 10px;">';

    foreach ($errors as $error) {
        $errorHtml .= '<li>' . htmlspecialchars($error) . '</li>';
    }

    $errorHtml .= '</ul><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="font-size: 1.25rem;"></button></div>';

    return $errorHtml;
}

// Add a subject to the database
function addSubject($subjectCode, $subjectName) {
    $conn = getConnection();

    try {
        $query = "INSERT INTO subjects (subject_code, subject_name) VALUES (:subject_code, :subject_name)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':subject_code', $subjectCode);
        $stmt->bindParam(':subject_name', $subjectName);

        return $stmt->execute(); // Returns true on success
    } catch (PDOException $e) {
        return false; // Returns false on failure
    }
}

// Fetch all subjects from the database
function fetchSubjects() {
    $conn = getConnection();

    try {
        $query = "SELECT * FROM subjects ORDER BY subject_code ASC";
        $stmt = $conn->query($query);

        return $stmt->fetchAll(); // Returns an array of subjects
    } catch (PDOException $e) {
        return []; // Returns an empty array on failure
    }
}

// Show alert messages
function showAlert($type, $message) {
    $alertClass = $type === 'success' ? 'alert-success' : 'alert-danger';

    return "
    <div class='alert $alertClass alert-dismissible fade show' role='alert'>
        <strong>Notice:</strong> $message
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>
    ";
}
?>
