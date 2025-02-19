<?php
session_start();
require 'config/connection.php';

$error = '';

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare the SQL statement to fetch the user based on the provided username
    $stmt = $pdo->prepare("SELECT id, password FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();

    // Check if a user with that username exists
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $id = $user['id'];
        $hashed_password = $user['password'];

        // Verify if the password matches
        if (hash('sha256', $password) === $hashed_password) {
            $_SESSION['user_id'] = $id;
            header('Location: manage_faculty.php');
            exit();
        } else {
            $error = 'Invalid username or password.';
        }
    } else {
        $error = 'Invalid username or password.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="assets/output.css" rel="stylesheet">
</head>
<body>
    <div class="font-[sans-serif]">
        <div class="min-h-screen flex flex-col items-center justify-center py-6 px-4 bg-gray-900">
            <div class="max-w-md w-full">
                <div class="p-8 rounded-2xl bg-gray-800 shadow-md">
                    <h2 class="text-white text-center text-2xl font-bold">Log in</h2>
                    
                    <!-- Display error message if authentication fails -->
                    <?php if (isset($error)): ?>
                        <div class="text-red-500 text-sm text-center mb-4"><?= $error ?></div>
                    <?php endif; ?>

                    <form method="POST" class="mt-8 space-y-4">
                        <div>
                            <label class="text-gray-300 text-sm mb-2 block">User name</label>
                            <div class="relative flex items-center">
                                <input 
                                    name="username" 
                                    type="text" 
                                    required 
                                    class="w-full text-white text-sm border border-gray-600 bg-gray-700 px-4 py-3 rounded-md focus:ring-2 focus:ring-blue-500 outline-none" 
                                    placeholder="Enter user name" 
                                />
                                <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-4 h-4 absolute right-4" viewBox="0 0 24 24">
                                    <circle cx="10" cy="7" r="6" data-original="#000000"></circle>
                                    <path d="M14 15H6a5 5 0 0 0-5 5 3 3 0 0 0 3 3h12a3 3 0 0 0 3-3 5 5 0 0 0-5-5zm8-4h-2.59l.3-.29a1 1 0 0 0-1.42-1.42l-2 2a1 1 0 0 0 0 1.42l2 2a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42l-.3-.29H22a1 1 0 0 0 0-2z" data-original="#000000"></path>
                                </svg>
                            </div>
                        </div>

                        <div>
                            <label class="text-gray-300 text-sm mb-2 block">Password</label>
                            <div class="relative flex items-center">
                                <input 
                                    name="password" 
                                    type="password" 
                                    required 
                                    class="w-full text-white text-sm border border-gray-600 bg-gray-700 px-4 py-3 rounded-md focus:ring-2 focus:ring-blue-500 outline-none" 
                                    placeholder="Enter password" 
                                />
                                <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-4 h-4 absolute right-4 cursor-pointer" viewBox="0 0 128 128">
                                    <path d="M64 104C22.127 104 1.367 67.496.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24s62.633 36.504 63.496 38.057a4 4 0 0 1 0 3.887C126.633 67.496 105.873 104 64 104zM8.707 63.994C13.465 71.205 32.146 96 64 96c31.955 0 50.553-24.775 55.293-31.994C114.535 56.795 95.854 32 64 32 32.045 32 13.447 56.775 8.707 63.994zM64 88c-13.234 0-24-10.766-24-24s10.766-24 24-24 24 10.766 24 24-10.766 24-24 24zm0-40c-8.822 0-16 7.178-16 16s7.178 16 16 16 16-7.178 16-16-7.178-16-16-16z" data-original="#000000"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="!mt-8">
                            <button 
                                type="submit" 
                                class="w-full py-3 px-4 text-sm tracking-wide rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300">
                                Sign in
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
