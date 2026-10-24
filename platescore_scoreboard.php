<?php
include 'db_connection.php';

try {
    // Fetch Top groups based on total score in Plate
    $stmt = $pdo->prepare("
        SELECT g.Group_name, 
               SUM(s.TotalScore) AS TotalScore
        FROM platescore s
        JOIN `group` g ON s.group_id = g.Group_ID
        GROUP BY g.Group_name
        ORDER BY TotalScore DESC
    ");
    $stmt->execute();
    $topPlateScores = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    error_log("Error fetching Plate scores: " . $e->getMessage());
    echo "An error occurred. Please try again later.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plate Scoreboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav>
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="centrefire_scoreboard.php">Centre Fire Scoreboard</a></li>
            <li><a href="platescore_scoreboard.php">Plate Scoreboard</a></li>
            <li><a href="register.php">Register</a></li>
        </ul>
</nav>

<h2>Top Plate Group Scores</h2>
<table>
    <tr>
        <th>Rank</th>
        <th>Group Name</th>
        <th>Total Score</th>
    </tr>
    <?php
    $rank = 1;
    foreach ($topPlateScores as $row) {
        // Set class based on rank
        $class = '';
        if ($rank == 1) {
            $class = 'rank-1';
        } elseif ($rank == 2) {
            $class = 'rank-2';
        } elseif ($rank == 3) {
            $class = 'rank-3';
        }
        
        echo "<tr class='{$class}'>
            <td>{$rank}</td>
            <td>{$row['Group_name']}</td>
            <td>{$row['TotalScore']}</td>
        </tr>";
        $rank++;
    }
    ?>
</table>
</body>
</html>
