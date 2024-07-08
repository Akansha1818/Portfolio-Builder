<?php include 'dbconnect.php'?>
<?php
    if($_SERVER["REQUEST_METHOD"] == 'POST'){
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $message = htmlspecialchars($_POST['message']);

        if (isset( $_POST['name'])){
            $existSql = "SHOW TABLES LIKE '$email'";
            $result = mysqli_query($conn, $existSql);
            $row = mysqli_num_rows($result);
            if( $row > 0 ){
                $sql = "INSERT INTO `$email` (`name`, `message`) VALUES ('$name','$message')";
                $result = mysqli_query($conn, $sql);
            }
            else{
                $sql = "CREATE TABLE `$email` ( `s.no.` INT(11) NOT NULL AUTO_INCREMENT , `name` VARCHAR(100) NOT NULL, `message` VARCHAR(100) NOT NULL, PRIMARY KEY(`s.no.`))";
                $result = mysqli_query($conn , $sql);
                $sql = "INSERT INTO `$email` (`name`, `message`) VALUES ('$name','$message')";
                $result = mysqli_query($conn, $sql);
            }
            $insert=false;
            if($result){ 
                $insert = true;
                // echo "<p>Thank you, $name. Your message has been received.</p>";
            }
            else{
                echo "The record was not inserted successfully because of this error ---> ". mysqli_error($conn);
            } 
        }
        
        
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <footer>
        <section id="contact">
            <h1>Contact Me</h1>
            <form action="contact.php" method="post" id="contact">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                
                <label for="message">Message:</label>
                <textarea id="message" name="message" required></textarea>
                
                <button type="submit">Send</button>
            </form>
        </section>
    </footer>
    <div class="copy">Copyright © akankshasportfoliobuilder.com|All rights reserved</div>
</body>
</html>