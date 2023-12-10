<!-- @WillFourTwenty -->
<?php
session_start();

// Check if the admin is already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    // Admin is already logged in, show the admin panel
    include 'admin_panel.php'; // Create a separate admin panel file
    exit();
}

// Check if the login form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database connection information
    $host = "localhost";
    $username = "root";
    $password = ""; // Add your database password here
    $database = "filmnest";

    // Create connection
    $conn = new mysqli($host, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get username and password from the login form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // SQL query to check if the admin credentials are valid
    $sql = "SELECT * FROM admins WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Admin login successful, set session variable
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin_panel.php"); // Redirect to admin panel
        exit();
    } else {
        // Invalid credentials, show login form with a random funny error message
        $funny_error_messages = [
            "Did you try entering 'OOF' as the password?",
            "Looks like a ROBLOX noob is trying to hack in!",
            "Your username is too advanced for this admin panel. Try something simpler.",
            "Error 404: Bacon hair not found in the admin database.",
            "Are you using the guest account? Admins only, please!",
            "You need a VIP pass to access this admin zone. Sorry!",
            "Insert more Robux to continue the login process.",
            "Username not accepted. Try 'BloxyMaster123' instead.",
            "Oops! You stepped on a virtual banana peel. Try again!",
            "Error: Too many ROBLOX toys on your desk. Clear some for access.",
            "Are you a hacker? We prefer scripters here!",
            "Admin access denied. Adopt a Meep instead.",
            "Try entering 'DanceParty' as the password for an exclusive login experience!",
            "Password strength insufficient. Add more ROBUX for extra security!",
            "Username not recognized. Are you hiding behind a bacon hair disguise?",
            "404 Error: ROBLOX Studio not found. This is the admin zone!",
            "Invalid password. Did you check if your character is T-posed?",
            "You need a ROBLOX hat with admin powers to log in. Upgrade now!",
            "Error: Your character's walk animation is too noobish for admin privileges.",
            "Access denied. You must own the Dominus to proceed.",
            "This admin panel requires a ROBLOX face with sunglasses. Try again!",
            "Username not accepted. It must contain at least one 'xD'.",
            "Error: Too much bacon hair in the password. Keep it crispy, not furry!",
            "Password rejected. It's not as legendary as a ROBLOX egg.",
            "Did you try shouting 'Admin!' in the chat? That might work.",
            "Sorry, only ROBLOX legends allowed beyond this point.",
            "Error: Too many ROBLOX toys cluttering the admin server room.",
            "Invalid username. Does it come with a ROBLOX accessory?",
            "You need to wear a ROBLOX fedora to access this admin console.",
            "Username not recognized. Did you forget to equip your ROBLOX hat?",
            "Access denied. You must perform a ROBLOX dance to continue.",
            "Password too short. It must be at least as long as a ROBLOX obby.",
            "Error: Bacon hair overload! Reduce the bacon for access.",
            "Invalid password. Did you try 'ROBLOX123'?",
            "You need to have a ROBLOX pet following you to access admin controls.",
            "Error 404: Admin commands not found. Are you sure this is the right game?",
            "Access denied. You need to have a ROBLOX skateboard equipped.",
            "Username not accepted. Add more ROBUX for a cooler one.",
            "Invalid password. It's not as strong as a ROBLOX tycoon wall.",
            "This admin panel only responds to emotes. Try waving in real life!",
            "Error: Too many ROBLOX badges, not enough admin badges.",
            "Username not recognized. Did you try turning into a ROBLOX noob?",
            "Access denied. Your character's hair is too fancy for admin privileges.",
            "Password rejected. It's not as legendary as a ROBLOX mythic sword.",
            "Invalid username. Did you try 'BloxxerMaster'?",
            "This admin zone is for ROBLOX legends only. Are you legendary?",
            "Error: You need a ROBLOX DJ booth for access. Start a party!",
            "Username not accepted. Does it come with a ROBLOX pet?",
            "Access denied. You need a ROBLOX VIP pass to proceed.",
            "Invalid password. It's not as secure as a ROBLOX jailbreak.",
            "This admin panel requires a ROBLOX ninja animation. Show your skills!",
            "Error: Too many ROBLOX shirts, not enough admin attire.",
            "Username not recognized. Did you try 'ProBuilder'?",
            "You must own a ROBLOX tycoon to access this admin console.",
            "Password rejected. It's not as legendary as a ROBLOX adventure.",
            "Access denied. You need a ROBLOX sword to proceed.",
            "This admin panel only responds to ROBLOX memes. Got any?",
            "Error: Too many ROBLOX faces, not enough admin faces.",
            "Username not accepted. Add more ROBUX for a cooler one.",
            "Invalid password. It's not as strong as a ROBLOX tycoon wall.",
            "This admin panel only responds to emotes. Try waving in real life!",
            "Error: Too many ROBLOX badges, not enough admin badges.",
            "Username not recognized. Did you try turning into a ROBLOX noob?",
            "Access denied. Your character's hair is too fancy for admin privileges.",
            "Password rejected. It's not as legendary as a ROBLOX mythic sword.",
            "Invalid username. Did you try 'BloxxerMaster'?",
            "This admin zone is for ROBLOX legends only. Are you legendary?",
            "Error: You need a ROBLOX DJ booth for access. Start a party!",
            "Username not accepted. Does it come with a ROBLOX pet?",
            "Access denied. You need a ROBLOX VIP pass to proceed.",
            "Invalid password. It's not as secure as a ROBLOX jailbreak.",
            "This admin panel requires a ROBLOX ninja animation. Show your skills!",
            "Error: Too many ROBLOX shirts, not enough admin attire.",
            "Username not recognized. Did you try 'ProBuilder'?",
            "You must own a ROBLOX tycoon to access this admin console.",
            "Password rejected. It's not as legendary as a ROBLOX adventure.",
            "Access denied. You need a ROBLOX sword to proceed.",
            "This admin panel only responds to ROBLOX memes. Got any?",
            "Error: Too many ROBLOX faces, not enough admin faces.",
        ];
        

        $error_message = $funny_error_messages[array_rand($funny_error_messages)];
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head> 
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <?php if (isset($error_message)) { ?>
            <p class="error-message"><?php echo $error_message; ?></p>
        <?php } ?>
        <form method="post" action="admin.php">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
<!-- @WillFourTwenty -->
