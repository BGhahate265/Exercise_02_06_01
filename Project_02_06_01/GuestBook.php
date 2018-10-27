<!DOCTYPE html>
<html>

<head>
    <title>Guest Board</title>
    <meta name="viewport" content="initial-scale=1.0">
    <script src="modernizr.custom.65897.js"></script>
</head>

<body>
    <!-- HTML form -->
    <h1>Guest Board</h1>
    <?php
    if (isset($_GET['action'])) {
       if (file_exists("guest.txt") && filesize("guest.txt") != 0) {
        $guestArray = file("guest.txt");
            switch ($_GET['action']) {
            case 'Delete First':
                array_shift($guestArray);
                break;
            case 'Delete Last':
                array_pop($guestArray);
                break;
            case 'Sort Ascending':
                sort($guestArray);
                break;
            case 'Sort Descending':
                rsort($guestArray);
                break;
                case 'Delete Guest':
                    array_splice($guestArray, $_GET['guest'], 1);
                    break;
            }
           if(count($guestArray) > 0) {
               $newGuest = implode($guestArray);
               $fileHandle = fopen("guest.txt", "wb");
               if (!$fileHandle) {
                   echo "There was an error updating the guest file.\n";
               }
               else {
                   fwrite($fileHandle, $newGuest);
                   fclose($fileHandle);
               }
           }
           else {
               unlink("guest.txt");
           }
       }
    }
    if (!file_exists("guest.txt") || filesize("guest.txt") == 0) {
        echo "<p>There are no guests posted.</p>\n";
    }
    else {
        $guestArray = file("guest.txt");
        echo "<table style=\"background-color: azure\" border=\"1\" width=\"100%\">\n";
        $count = count($guestArray);
        for ($i = 0; $i < $count; $i++) {
            $currGuest = explode("~", $guestArray[$i]);
            $keyGuestArray[$currGuest[0]] = $currGuest[1];
        } 
        $index = 1;
        $key = key($keyGuestArray);
        foreach ($keyGuestArray as $guests) {
            $currGuest = explode("~", $guests);
            echo "<tr>\n";
            echo "<td width=\"5%\" style=\"text-align: center; font-weight: bold\">" . $index . "</td>\n";
            echo "<td width=\"85%\"><span style=\"font-weight: bold\">Guest: </span>" . htmlentities($key) . "<br>\n";
            echo "<span style=\"font-weight: bold\">E-mail: </span>" . htmlentities($currGuest[0]) . "<br>\n";
            echo "<td width=\"10%\" style=\"text-align: center\">" . "<a href='GuestBook.php?" . "action=Delete%20Guest&" . "guest=" . ($index - 1) . "'>" . "Check Out</a></td>\n";
            echo "</tr>\n";
            ++$index;
            next($keyGuestArray);
            $key = key($keyGuestArray);
        }
        echo "</table>";
    }
?>
    <p>
        <a href="PostGuest.php">Post New Guest</a><br>
        <a href="GuestBook.php?action=Sort%20Ascending">Sort Subjects A-Z</a><br>
        <a href="GuestBook.php?action=Sort%20Descending">Sort Subjects Z-A</a><br>
        <a href="GuestBook.php?action=Delete%20First">Delete First Message</a><br>
        <a href="GuestBook.php?action=Delete%20Last">Delete Last Message</a><br>
    </p>
</body>

</html>
