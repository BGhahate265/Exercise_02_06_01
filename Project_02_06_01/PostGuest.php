<!DOCTYPE html>
<html>
<!--
Author: Braddock Ghahate
Date: 10.22.18
File: PostGuest.php
-->

<head>
    <title>Post New Guest</title>
    <meta name="viewport" content="initial-scale=1.0">
    <script src="modernizr.custom.65897.js"></script>
<!--Embedded CSS-->
    <style>
        h1, form, a {
            font-family: sans-serif;
        }
        html {
            background-color: cornflowerblue;
        }
        a:link {
            color: black;
        }
        a:visited {
            color: darkorchid;
        }
    </style>
</head>

<body>
    <?php
    //entry point
    //data submited? Yes - process. No - display form
    if (isset($_POST['submit'])) {
        $guest = stripslashes($_POST['guest']);
        $email = stripslashes($_POST['email']);
        $guest = str_replace("~", "-", $guest); 
        $email = str_replace("~", "-", $email);
        $existingGuests = array();
        if (file_exists("guest.txt") && filesize("guest.txt") > 0) {
            $guestArray = file("guest.txt");
            $count = count($guestArray);
            for ($i = 0; $i < $count; $i++) {
                $currGuest = explode("~", $guestArray[$i]);
                $existingGuests[] = $currGuest[0];
            }
        }
        //Bulletproving users from entering the same name
        if (in_array($guest, $existingGuests)) {
            echo "<p>The guest name <em>\"$guest\"</em> you entered already exists!<br>\n";
            echo "Please enter a new name and try again.<br>\n";
            echo "Your guest was not saved</p>";
            $guest = "";
        }
        // Fail/success on tampering with user's disk drive to store text files
        else {
            $guestRecord = "$guest~$email\n";
        $fileHandle = fopen("guest.txt", "ab");
        if (!$fileHandle) {
            echo "There was an error saving your guest!\n";
        }
            else {
                fwrite($fileHandle, $guestRecord);
                fclose($fileHandle);
                echo "Your guest has been saved.\n"; 
                $guest = "";
                $email = "";
            }
        }
    }
    else {
        $guest = "";
        $email = "";
    }
?>
    <!-- HTML form -->
    <h1>Post New Guest</h1>
    <hr>
    <form action="PostGuest.php" method="post">
        <span style="font-weight: bold">
            Name: <input type="text" name="guest" value="<?php echo $guest;?>">
        </span>
        <span style="font-weight: bold">
            Email: <input type="email" name="email" value="<?php echo $email;?>">
        </span>
        <input type="reset" name="reset" value="Reset Form">
        <input type="submit" name="submit" value="Post Guest">
    </form>
    <hr>
    <p>
        <a href="GuestBook.php">View Guest List</a>
    </p>

</body>

</html>
