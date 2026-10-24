<?php
include 'db_connection.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $participant_id = $_POST['participant_id'];
    $scores = [
        $_POST['score1'],
        $_POST['score2'],
        $_POST['score3'],
        $_POST['score4'],
        $_POST['score5'],
        $_POST['score6'],
        $_POST['score7'],
    ];

    $total_score = array_sum($scores);

    try {
        // Insert or update the participant's scores
        $pdo->beginTransaction();

        // Delete old scores
        $delete_stmt = $pdo->prepare("DELETE FROM score WHERE Participant_ID = :participant_id");
        $delete_stmt->execute(['participant_id' => $participant_id]);

        // Insert new scores
        $insert_stmt = $pdo->prepare("INSERT INTO score (Participant_ID, Score, ScoreName) VALUES (:participant_id, :score, :score_name)");
        foreach ($scores as $index => $score) {
            $insert_stmt->execute([
                'participant_id' => $participant_id,
                'score' => $score,
                'score_name' => 'Score' . ($index + 1),
            ]);
        }

        // Update the centrefire table
        $update_stmt = $pdo->prepare("INSERT INTO centrefire (Participant_ID, TotalScore) VALUES (:participant_id, :total_score)
                                      ON DUPLICATE KEY UPDATE TotalScore = :total_score");
        $update_stmt->execute([
            'participant_id' => $participant_id,
            'total_score' => $total_score,
        ]);

        $pdo->commit();

        echo "<p>Scores submitted successfully.</p>";
    } catch (PDOException $e) {
        $pdo->rollBack();
        error_log("Database error: " . $e->getMessage());
        echo "<p>An error occurred while submitting the scores. Please try again later.</p>";
    }
}

// Fetch all scores from the score table
try {
    $stmt = $pdo->prepare("SELECT Participant_ID, Score FROM score ORDER BY Participant_ID ASC");
    $stmt->execute();
    $scores = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    echo "An error occurred while retrieving the scores: " . $e->getMessage();
    exit();
}
?>
