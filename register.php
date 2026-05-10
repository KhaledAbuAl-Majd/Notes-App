<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = $_POST['password'];
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

    $sql = "INSERT INTO Users (UserName, Password) VALUES ('$user', '$hashed_password')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Account created successfully!'); window.location.href='login.php';</script>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Notes App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background-color: #f4f7f6; height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Segoe UI', sans-serif; }
        .register-card { width: 100%; max-width: 420px; border: none; border-radius: 12px; padding: 20px; }
        .input-group-text { cursor: pointer; background-color: white; border-left: none; }
        .form-control:focus { box-shadow: none; border-color: #dee2e6; }
        .password-input { border-right: none; }
    </style>
</head>
<body>

    <div class="card register-card shadow-sm">
        <div class="card-body">
            <h2 class="text-center fw-bold mb-3">Create Account</h2>
            <p class="text-muted text-center mb-4">Join us to start organizing your daily notes.</p>

            <form action="register.php" method="POST">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Type your username here..." required>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control password-input" placeholder="Enter a strong password..." required>
                        <span class="input-group-text" onclick="togglePassword()">
                            <i class="bi bi-eye-slash" id="toggleIcon"></i>
                        </span>
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">Sign Up</button>
                </div>

                <div class="text-center mt-4">
                    <span class="text-secondary">Already have an account? <a href="login.php" class="text-decoration-none fw-bold">Login here</a></span>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.replace('bi-eye-slash', 'bi-eye'); // يغير شكل العين
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.replace('bi-eye', 'bi-eye-slash'); // يرجع العين مقفولة
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>