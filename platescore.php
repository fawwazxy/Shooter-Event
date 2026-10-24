<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Group_ID = $_POST['group_id'];

    // Retrieve individual scores
    $Score1 = $_POST['score1'];
    $Score2 = $_POST['score2'];
    $Score3 = $_POST['score3'];
    $Score4 = $_POST['score4'];
    $Score5 = $_POST['score5'];
    $Score6 = $_POST['score6'];
    $Score7 = $_POST['score7'];

    // Calculate total score
    $TotalScore = $Score1 + $Score2 + $Score3 + $Score4 + $Score5 + $Score6 + $Score7;

    // Insert into plate_score table
    $stmt = $pdo->prepare("INSERT INTO platescore (Group_ID, TotalScore) VALUES (?, ?)");
    $stmt->execute([$Group_ID, $TotalScore]);

    // Insert individual scores into the score table
    $scores = [
        ['Score1', $Score1], ['Score2', $Score2], ['Score3', $Score3],
        ['Score4', $Score4], ['Score5', $Score5], ['Score6', $Score6], ['Score7', $Score7]
    ];

    foreach ($scores as $score) {
        $stmt = $pdo->prepare("INSERT INTO score (ScoreName, Score, Participant_ID) VALUES (?, ?, ?)");
        $stmt->execute([$score[0], $score[1], $Group_ID]);
    }

    echo "Plate scores saved successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Plate Scores</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Submit Plate Scores</h2>
    <form action="platescore.php" method="POST">
        <label for="group_id">Group ID:</label>
        <input type="text" id="group_id" name="group_id" required><br>

        <label for="score1">Score 1:</label>
        <input type="number" id="score1" name="score1" required><br>

        <label for="score2">Score 2:</label>
        <input type="number" id="score2" name="score2" required><br>

        <label for="score3">Score 3:</label>
        <input type="number" id="score3" name="score3" required><br>

        <label for="score4">Score 4:</label>
        <input type="number" id="score4" name="score4" required><br>

        <label for="score5">Score 5:</label>
        <input type="number" id="score5" name="score5" required><br>

        <label for="score6">Score 6:</label>
        <input type="number" id="score6" name="score6" required><br>

        <label for="score7">Score 7:</label>
        <input type="number" id="score7" name="score7" required><br>

        <input type="submit" value="Submit Scores">
    </form>
</body>
</html>
