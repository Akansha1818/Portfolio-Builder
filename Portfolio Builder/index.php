<?php include 'dbconnect.php' ?>
<?php
if ($_SERVER["REQUEST_METHOD"] == 'GET') {
    if (isset($_GET['user_id'])) {
        $userId = intval($_GET['user_id']);

        // Retrieve user information
        $sql = "SELECT * FROM `users` WHERE `s.no.` = $userId";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            $name = htmlspecialchars($user['name']);
            $email = htmlspecialchars($user['email']);
            $project = htmlspecialchars($user['project']);
            $role = htmlspecialchars($user['role']);
            $about = htmlspecialchars($user['about']);
            $gender = htmlspecialchars($user['gender']);
            // Retrieve user skills
            $sql = "SELECT * FROM `$name`";
            $result = mysqli_query($conn, $sql);
            $skills = [];
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $skills[] = [
                        'skill' => htmlspecialchars($row['skill']),
                        'percent' => htmlspecialchars($row['percent'])
                    ];
                }
            } else {
                echo "Error retrieving skills: " . mysqli_error($conn);
                exit();
            }
        } else {
            echo "User not found.";
            exit();
        }
    } else {
        echo "User ID is not set.";
        exit();
    }
} else {
    echo "Invalid request method.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        <?php foreach ($skills as $index => $skill): ?>
            .f<?php echo $index + 1; ?> {
                width: <?php echo $skill['percent']; ?>%;
                height: 100%;
                background-color: green;
            }
            .t<?php echo $index + 1; ?> {
                margin-left: <?php echo ($skill['percent'] - 54); ?>%;
                color: white;
            }
        <?php endforeach; ?>
    </style>
</head>
<body>
    <main>
        <div class="black"></div>
        <div class="intro">
            <p>Hey! I am</p>
            <p><?php echo $name; ?></p>
            <p>I'm a <?php echo $role; ?></p>
        </div>
        <div class="bg"></div>
        <div class="about">
            <?php 
            if(($gender=='Male') || ($gender=='male')){
                echo'<div class="img"><img src="images/me.png" alt="Me" width="90%"></div>';
            }
            else if(($gender=='Female') || ($gender=='female')){
                echo'<div class="img"><img src="images/me1.png" alt="Me" width="50%"></div>';
            }
            ?>
            <div class="me">
                <p>A Quick Background</p>
                <p><?php echo $about; ?></p>
            </div>
        </div>
        <div class="sep"></div>
        <div class="about-me about">
            <div class="me1">
                <p>About Me</p>
                <p><?php echo $about; ?></p>
            </div>
        </div>
        <p class="alive foot1">Knowledge that I gained so far :)</p>
        <div class="lang">
            <?php foreach ($skills as $index => $skill): ?>
                <div class="t<?php echo $index + 1; ?>"><?php echo $skill['skill']; ?> = <?php echo $skill['percent']; ?>%</div>
                <div class="java">
                    <div class="f<?php echo $index + 1; ?>"></div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="project">
            <p>My Projects :)</p>
            <p><?php echo $project; ?></p>
        </div>
    </main>

    <div class="sep"></div>
    <footer>
        <div class="foot">
            <p>Work With Me</p>
            <ul>
                <a class="nav-link" href="mailto:<?php echo $email; ?>"><i class="fa-solid fa-square-envelope"></i>Email</a>
                <a class="nav-link" href="#"><i class="fa-brands fa-telegram"></i>Telegram</a>
                <a class="nav-link" href="#"><i class="fa-brands fa-instagram"></i>Instagram</a>
                <a class="nav-link" href="#"><i class="fa-brands fa-linkedin"></i>Linkedin</a>
            </ul>
        </div>
        <button><a class="nav-link" href="/Portfolio Builder/contact.php">Message</a></button>
    </footer>
    <div class="copy">Copyright © akankshasportfoliobuilder.com|All rights reserved</div>
</body>
</html>
