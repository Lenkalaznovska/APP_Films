<!DOCTYPE html>
<html lang="cs-cz">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/x-icon" href="favicon/favicon.png">

</head>

<body>
    <!-- Formulář pro zadání informací o filmu -->
    <div class="form">
        <form action="" method="POST">
            <label for="nazevFilmu">Název filmu</label><br>
            <input type="text" name="nazevFilmu"><br>

            <label for="autor">Autor</label><br>
            <input type="text" name="autor"><br>

            <!-- Tlačítka pro vyhledávání, vložení a návrat zpět -->
            <input class="vyhledat" type="submit" value="Vyhledat" name="Vyhledat">
            <input class="vyhledat" type="submit" value="Vložit" name="Vlozit">
            <input class="zpet" type="submit" value="Zpět na výpis filmů" name="VratSeNaSeznamFilmu">
        </form>
    </div>
    
<?php
// Připojení k databázi
include "conn.php";

// Vložení nového filmu
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["Vlozit"])) {
    $nazevFilmu = mysqli_real_escape_string($conn, $_POST["nazevFilmu"]);
    $autor = mysqli_real_escape_string($conn, $_POST["autor"]);

    // Kontrola, zda jsou vyplněna povinná pole
    if (!empty($nazevFilmu) && !empty($autor)) {
        // Kontrola, zda film s daným názvem již existuje v databázi
        $sqlDuplicateCheck = "SELECT COUNT(*) as pocet FROM filmy WHERE `Název filmu` = ?";
        $stmt = $conn->prepare($sqlDuplicateCheck);
        $stmt->bind_param("s", $nazevFilmu);
        $stmt->execute();
        $stmt->bind_result($duplicateResult);
        $stmt->fetch();
        $stmt->close();

        // Pokud film již existuje, zobrazí se upozornění potvrzení o aktualizaci záznamu
        if ($duplicateResult > 0) {
            echo "<p>Tento film již existuje v databázi s jiným autorem.</p>";
            echo "<p>Opravdu chcete aktualizovat existující záznam s novým autorem?</p>";
            echo '<form action="" method="POST">
                    <input type="hidden" name="confirmUpdate" value="true">
                    <input type="hidden" name="nazevFilmu" value="' . htmlspecialchars($nazevFilmu) . '">
                    <input type="hidden" name="autor" value="' . htmlspecialchars($autor) . '">
                    <input class="vyhledat" type="submit" value="Potvrdit aktualizaci" name="Potvrdit aktualizaci">
                </form>';
        } else {
            // Pokud film neexistuje, provede se vložení nového záznamu
            $sql = "INSERT INTO filmy (`Název filmu`, `Autor`) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $nazevFilmu, $autor);
            $stmt->execute();
            $stmt->close();
        }
    } else {
        // Pokud nejsou vyplněna povinná pole, zobrazí se chybové hlášení
        echo "<p>Vyplňte všechna povinná pole.</p>";
    }
}

// Zpracování potvrzení o aktualizaci existujícího záznamu
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["confirmUpdate"])) {
    $nazevFilmu = mysqli_real_escape_string($conn, $_POST["nazevFilmu"]);
    $newAutor = mysqli_real_escape_string($conn, $_POST["autor"]);

    // Aktualizace autora pro existující film
    $sql = "UPDATE filmy SET `Autor` = ? WHERE `Název filmu` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $newAutor, $nazevFilmu);
    $stmt->execute();
    $stmt->close();
}

// Zpracování formuláře pro vyhledání filmu
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["Vyhledat"])) {
    $nazevFilmu = $_POST["nazevFilmu"];
    $autor = $_POST["autor"];

    // Prevence SQL injection
    $nazevFilmu = mysqli_real_escape_string($conn, $nazevFilmu);
    $autor = mysqli_real_escape_string($conn, $autor);

    // Sestavení SQL dotazu pro vyhledání filmu podle názvu a autora
    $sql = "SELECT * FROM filmy WHERE `Název filmu` LIKE ? AND `Autor` LIKE ?";
    $stmt = $conn->prepare($sql);
    $nazevFilmuParam = "%$nazevFilmu%";
    $autorParam = "%$autor%";
    $stmt->bind_param("ss", $nazevFilmuParam, $autorParam);
    $stmt->execute();

    // Získání výsledků a jejich zobrazení ve formě tabulky
    $result = $stmt->get_result();
    $filmy = $result->fetch_all(MYSQLI_ASSOC);

    if (empty($filmy)) {
        echo "<p>Tento film není v databázi.</p>";
    } else {
        echo "<table>
                <tr>
                    <th>Název filmu</th>
                    <th>Autor</th>
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
    // Zobrazení všech filmů
    $sql = "SELECT * FROM filmy";
    $filmy = fetchAll($sql, $conn);

    echo "<table>
            <tr>
                <th>Název filmu</th>
                <th>Autor</th>
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
        <!-- Chat Tawk.to -->
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
