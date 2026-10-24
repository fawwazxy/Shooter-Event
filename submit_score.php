<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $participant_id = $_POST['Participant_ID'];
    $score = $_POST['Score'];
    $score_name = $_POST['ScoreName'];

    try {
        // Masukkan data ke dalam tabel score
        $stmt = $pdo->prepare("INSERT INTO score (Participant_ID, Score, ScoreName) VALUES (:participant_id, :score, :score_name)");
        $stmt->bindParam(':participant_id', $participant_id);
        $stmt->bindParam(':score', $score);
        $stmt->bindParam(':score_name', $score_name);

        // Eksekusi query
        $stmt->execute();

        echo "Data berhasil disimpan!";
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        echo "Terjadi kesalahan saat menyimpan data: " . $e->getMessage();
    }
}
?>

<form method="post" action="">
    <label for="Participant_ID">Participant ID:</label>
    <input type="text" id="Participant_ID" name="Participant_ID" required><br>
    <label for="Score">Score:</label>
    <input type="text" id="Score" name="Score" required><br>
    <label for="ScoreName">Score Name:</label>
    <input type="text" id="ScoreName" name="ScoreName" required><br>
    <input type="submit" value="Submit">
</form>