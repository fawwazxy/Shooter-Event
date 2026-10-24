<?php
include 'db_connection.php';

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Fetch Top 10 Centre Fire participants based on total score
try {
    $stmt = $pdo->prepare("
        SELECT p.name, 
               SUM(c.TotalScore) AS TotalScore, 
               SUM(s1.Score) AS Score1, 
               SUM(s2.Score) AS Score2, 
               SUM(s3.Score) AS Score3, 
               SUM(s4.Score) AS Score4, 
               SUM(s5.Score) AS Score5, 
               SUM(s6.Score) AS Score6, 
               SUM(s7.Score) AS Score7
        FROM centrefire c
        JOIN participant p ON c.Participant_ID = p.Participant_ID
        LEFT JOIN score s1 ON s1.Participant_ID = p.Participant_ID AND s1.ScoreName = 'Score1'
        LEFT JOIN score s2 ON s2.Participant_ID = p.Participant_ID AND s2.ScoreName = 'Score2'
        LEFT JOIN score s3 ON s3.Participant_ID = p.Participant_ID AND s3.ScoreName = 'Score3'
        LEFT JOIN score s4 ON s4.Participant_ID = p.Participant_ID AND s4.ScoreName = 'Score4'
        LEFT JOIN score s5 ON s5.Participant_ID = p.Participant_ID AND s5.ScoreName = 'Score5'
        LEFT JOIN score s6 ON s6.Participant_ID = p.Participant_ID AND s6.ScoreName = 'Score6'
        LEFT JOIN score s7 ON s7.Participant_ID = p.Participant_ID AND s7.ScoreName = 'Score7'
        GROUP BY p.name
        ORDER BY TotalScore DESC
        LIMIT 10
    ");
    $stmt->execute();
    $topCentreFireScores = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($topCentreFireScores)) {
        echo "<p>No data found.</p>";
    }
} catch (PDOException $e) {
    error_log("Database query error: " . $e->getMessage());
    echo "<p>An error occurred while fetching the scores. Please try again later.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centre Fire Scoreboard</title>
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

<h2>Top 10 Centre Fire Scores</h2>
<table>
    <tr>
        <th>Rank</th>
        <th>Name</th>
        <th>Score 1</th>
        <th>Score 2</th>
        <th>Score 3</th>
        <th>Score 4</th>
        <th>Score 5</th>
        <th>Score 6</th>
        <th>Score 7</th>
        <th>Total Score</th>
    </tr>
    <?php
    $rank = 1;
    foreach ($topCentreFireScores as $row) {
        echo "<tr>
            <td>{$rank}</td>
            <td>{$row['name']}</td>
            <td>{$row['Score1']}</td>
            <td>{$row['Score2']}</td>
            <td>{$row['Score3']}</td>
            <td>{$row['Score4']}</td>
            <td>{$row['Score5']}</td>
            <td>{$row['Score6']}</td>
            <td>{$row['Score7']}</td>
            <td>{$row['TotalScore']}</td>
        </tr>";
        $rank++;
    }
    ?>
</table>
</body>
</html>
