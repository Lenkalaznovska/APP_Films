<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/x-icon" href="favicon/favicon.png">
</head>

<body>
    <!-- Form for entering movie information -->
    <div class="form">
        <form action="" method="POST">
            <label for="nazevFilmu">Movie Title</label><br>
            <input type="text" name="nazevFilmu"><br>

            <label for="autor">Author</label><br>
            <input type="text" name="autor"><br>

            <!-- Buttons for search, insert, and return -->
            <input class="vyhledat" type="submit" value="Search" name="Vyhledat">
            <input class="vyhledat" type="submit" value="Insert" name="Vlozit">
            <input class="zpet" type="submit" value="Back to movie list" name="VratSeNaSeznamFilmu">
        </form>
    </div>
    
<?php
// Database connection
include "conn.php";

// Inserting a new movie
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["Vlozit"])) {
    $nazevFilmu = mysqli_real_escape_string($conn, $_POST["nazevFilmu"]);
    $autor = mysqli_real_escape_string($conn, $_POST["autor"]);

    // Check if required fields are filled
    if (!empty($nazevFilmu) && !empty($autor)) {
        // Check if a movie with the given title already exists in the database
        $sqlDuplicateCheck = "SELECT COUNT(*) as pocet FROM filmy WHERE `Název filmu` = ?";
        $stmt = $conn->prepare($sqlDuplicateCheck);
        $stmt->bind_param("s", $nazevFilmu);
        $stmt->execute();
        $stmt->bind_result($duplicateResult);
        $stmt->fetch();
        $stmt->close();

        // If the movie already exists, show confirmation alert for updating the record
        if ($duplicateResult > 0) {
            echo "<p>This movie already exists in the database with a different author.</p>";
            echo "<p>Do you really want to update the existing record with the new author?</p>";
            echo '<form action="" method="POST">
                    <input type="hidden" name="confirmUpdate" value="true">
                    <input type="hidden" name="nazevFilmu" value="' . htmlspecialchars($nazevFilmu) . '">
                    <input type="hidden" name="autor" value="' . htmlspecialchars($autor) . '">
                    <input class="vyhledat" type="submit" value="Confirm Update" name="Potvrdit aktualizaci">
                </form>';
        } else {
            // If the movie does not exist, insert a new record
            $sql = "INSERT INTO filmy (`Název filmu`, `Autor`) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $nazevFilmu, $autor);
            $stmt->execute();
            $stmt->close();
        }
    } else {
        // If required fields are not filled, show error message
        echo "<p>Fill in all required fields.</p>";
    }
}

// Handling confirmation for updating an existing record
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["confirmUpdate"])) {
    $nazevFilmu = mysqli_real_escape_string($conn, $_POST["nazevFilmu"]);
    $newAutor = mysqli_real_escape_string($conn, $_POST["autor"]);

    // Updating the author for an existing movie
    $sql = "UPDATE filmy SET `Autor` = ? WHERE `Název filmu` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $newAutor, $nazevFilmu);
    $stmt->execute();
    $stmt->close();
}

// Processing the movie search form
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["Vyhledat"])) {
    $nazevFilmu = $_POST["nazevFilmu"];
    $autor = $_POST["autor"];

    // Prevent SQL injection
    $nazevFilmu = mysqli_real_escape_string($conn, $nazevFilmu);
    $autor = mysqli_real_escape_string($conn, $autor);

    // Construct SQL query to search for a movie by title and author
    $sql = "SELECT * FROM filmy WHERE `Název filmu` LIKE ? AND `Autor` LIKE ?";
    $stmt = $conn->prepare($sql);
    $nazevFilmuParam = "%$nazevFilmu%";
    $autorParam = "%$autor%";
    $stmt->bind_param("ss", $nazevFilmuParam, $autorParam);
    $stmt->execute();

    // Fetch results and display them in a table
    $result = $stmt->get_result();
    $filmy = $result->fetch_all(MYSQLI_ASSOC);

    if (empty($filmy)) {
        echo "<p>This movie is not in the database.</p>";
    } else {
        echo "<table>
                <tr>
                    <th>Movie Title</th>
                    <th>Author</th>
                </tr>";

        foreach ($filmy as $f) {
            echo "<tr>
                    <td>" . htmlspecialchars($f["Název filmu"]) . "</td>
                    <td>" . htmlspecialchars($f["Autor"]) . "</td>
                </tr>";
        }

        echo "</table>";
    }
} else {
    // Display all movies
    $sql = "SELECT * FROM filmy";
    $filmy = fetchAll($sql, $conn);

    echo "<table>
            <tr>
                <th>Movie Title</th>
                <th>Author</th>
            </tr>";

    foreach ($filmy as $f) {
        echo "<tr>
                <td>" . htmlspecialchars($f["Název filmu"]) . "</td>
                <td>" . htmlspecialchars($f["Autor"]) . "</td>
            </tr>";
    }

    echo "</table>";
}
?>

    <footer>
        <!-- Tawk.to chat -->
        <script type="text/javascript">
            var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
            (function(){
                var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
                s1.async=true;
                s1.src='https://embed.tawk.to/65dcd4538d261e1b5f65849b/1hnj9qq2j';
                s1.charset='UTF-8';
                s1.setAttribute('crossorigin','*');
                s0.parentNode.insertBefore(s1,s0);
            })();
        </script>
    </footer>
</body>
</html>
