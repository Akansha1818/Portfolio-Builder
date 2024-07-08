<?php include 'dbconnect.php' ?>
<?php
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    if (!isset($_POST['user_id'])) {
        echo "User ID is not set.";
        exit();
    }

    $userId = intval($_POST['user_id']);
    
    // Retrieve user's name from the 'users' table using $userId
    $sql = "SELECT `name` FROM `users` WHERE `s.no.` = $userId";
    $result = mysqli_query($conn, $sql);
    
    if (!$result) {
        echo "Error fetching user data: " . mysqli_error($conn);
        exit();
    }
    
    $row = mysqli_fetch_assoc($result);
    if (!$row) {
        echo "User not found.";
        exit();
    }

    $name = $row['name'];
    
    // Create a table for the user's skills if it doesn't exist
    $sql = "CREATE TABLE IF NOT EXISTS `$name` (
        `s.no.` INT(11) NOT NULL AUTO_INCREMENT,
        `skill` VARCHAR(100) NOT NULL,
        `percent` VARCHAR(100) NOT NULL,
        PRIMARY KEY(`s.no.`)
    )";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo "Error creating skills table: " . mysqli_error($conn);
        exit();
    }

    // Insert each skill into the user's skills table
    for ($i = 1; isset($_POST['skill' . $i]); $i++) {
        $skill = htmlspecialchars($_POST['skill' . $i]);
        $percent = htmlspecialchars($_POST['percent' . $i]);
        $sql = "INSERT INTO `$name` (`skill`, `percent`) VALUES ('$skill', '$percent')";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            echo "The record was not inserted successfully because of this error ---> " . mysqli_error($conn);
        }
    }

    header("Location: index.php?user_id=$userId");
    exit();
}
?>

<?php
// Retrieve user_id and skill count from the URL
if (isset($_GET['user_id']) && isset($_GET['skill'])) {
    $userId = intval($_GET['user_id']);
    $skillCount = intval($_GET['skill']);
} else {
    echo "Invalid request";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Skills</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="make">
        <section id="contact">
            <h1>Add Your Skills</h1>
            <form action="skill.php" method="post" id="contact">
                <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
                <?php
                for ($i = 1; $i <= $skillCount; $i++) {
                    echo '<label for="skill' . $i . '">Skill ' . $i . ':</label>';
                    echo '<input type="text" placeholder="Name" id="skill' . $i . '" name="skill' . $i . '" required>';
                    echo '<input type="text" placeholder="%" id="percent' . $i . '" name="percent' . $i . '" required>';
                }
                ?>
                <button type="submit">Submit Skills</button>
            </form>
        </section>
    </div>
</body>
</html>
