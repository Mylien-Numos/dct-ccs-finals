<?php    
    // Database Connection
function db_connect() {
    $host = 'localhost';
    $user = 'root';
    $password = ''; // Default for Laragon
    $database = 'dct-ccs-finals';

    $connection = new mysqli($host, $user, $password, $database);

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    return $connection;
}

// Authenticate User
function authenticate_user($email, $password) {
    $connection = db_connect();
    $password_hash = md5($password); // Hash the password

    $query = "SELECT * FROM users WHERE email = ? AND password = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param('ss', $email, $password_hash);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_assoc(); // Return user data
    }

    return false; // Login failed
}

// Start Session for Authenticated User
function login_user($user) {
    session_start();
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['name'] = $user['name'];
    $_SESSION['email'] = $user['email'];
}

// Check if User is Logged In
function is_logged_in() {
    session_start();
    return isset($_SESSION['user_id']);
}

// Logout Function
function logout_user() {
    session_start();
    session_destroy();
    header("Location: index.php");
    exit();
}
?>