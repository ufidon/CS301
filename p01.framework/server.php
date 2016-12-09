
<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title > images or videos received</title>
    </head>
    <body>   

        <?php
        if (isset($_FILES['my_file'])) {
            $myFile = $_FILES['my_file'];
            $fileCount = count($myFile["name"]);

            for ($i = 0; $i < $fileCount; $i++) {
                ?>
                <p>File #<?= $i + 1 ?>:</p>
                <p>
                    Name: <?= $myFile["name"][$i] ?><br>
                    Temporary file: <?= $myFile["tmp_name"][$i] ?><br>
                    Type: <?= $myFile["type"][$i] ?><br>
                    Size: <?= $myFile["size"][$i] ?><br>
                    Error: <?= $myFile["error"][$i] ?><br>
                </p>
                <?php
            }
        }

        $servername = "localhost";
        $username = "ers";
        $password = "12345678";
        $dbname = "videoinfo";

// Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        $sql = "SELECT * FROM videos";
        $result = $conn->query($sql);
        
        $num_rows = $result->num_rows;
        echo "Number of records:"  + $num_rows;

        for ($i = 0; $i < $fileCount; $i++) {
            $vname = $myFile["name"][$i];
            $vtype = $myFile["type"][$i];
            $vsize = $myFile["size"][$i];
            $vid = $num_rows+1+$i;
        
            $sql = "INSERT INTO videos (ID, NAME, TYPE, SIZE)
    VALUES ('$vid', '$vname', '$vtype', '$vsize')";

            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        
        

        $conn->close();
        ?>

    </body>
</html>