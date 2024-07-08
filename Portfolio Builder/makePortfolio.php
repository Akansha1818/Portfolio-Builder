<?php include 'dbconnect.php' ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $skill = intval($_POST['skill']); // Number of skills
    $project = htmlspecialchars($_POST['project']);
    $role = htmlspecialchars($_POST['role']);
    $about = htmlspecialchars($_POST['about']);
    $gender = htmlspecialchars($_POST['gender']);

    // Check if 'users' table exists
    $sql = "SHOW TABLES LIKE 'users'";
    $result2 = mysqli_query($conn, $sql);
    $tableExist = (mysqli_num_rows($result2) > 0);

    if (!$tableExist) {
        // Create 'users' table if it doesn't exist
        $sql = "CREATE TABLE `users` (
            `s.no.` INT(11) NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(100) NOT NULL,
            `email` VARCHAR(100) NOT NULL,
            `gender` VARCHAR(100) NOT NULL,
            `skill` INT(11) NOT NULL,
            `project` VARCHAR(100) NOT NULL,
            `role` VARCHAR(100) NOT NULL,
            `about` TEXT NOT NULL,
            PRIMARY KEY(`s.no.`)
        )";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            echo "Error creating users table: " . mysqli_error($conn);
            exit();
        }
    }

    // Insert user data into 'users' table
    $sql = "INSERT INTO `users` (`name`, `email`, `gender`, `skill`, `project`, `role`, `about`)
            VALUES ('$name', '$email', '$gender', '$skill', '$project', '$role', '$about')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Get the last inserted ID
        $userId = mysqli_insert_id($conn);
        // Redirect to skills form with user ID and number of skills
        header("Location: skill.php?user_id=$userId&skill=$skill");
        exit();
    } else {
        echo "The record was not inserted successfully because of this error ---> " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make Portfolio</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="make">
    <section id="contact">
        <h1>Make your portfolio</h1>
        <form action="makePortfolio.php" method="post" id="contact">
            <label for="name">Name:</label>
            <input type="text" placeholder="Name" id="name" name="name" required>
            
            <label for="email">Email:</label>
            <input type="email" placeholder="Email" id="email" name="email" required>
            
            <label for="role">Role:</label>
            <input type="text" placeholder="Role" id="role" name="role" required>
            <label for="role">Gender:</label>
            <input type="text" placeholder="Gender" id="gender" name="gender" required>
            
            <label for="project">Projects:</label>
            <input type="text" placeholder="Projects" id="project" name="project" required>
            
            <label for="skill">Skills:</label>
            <input type="number" placeholder="No of Skills" id="skill" name="skill" required>
            
            <label for="about">About:</label>
            <textarea placeholder="Tell about yourself" id="about" name="about" required></textarea>
            
            <button type="submit">Send</button>
        </form>
    </section>
    </div>
</body>
</html>
