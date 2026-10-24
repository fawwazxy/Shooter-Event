<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shooting Event Scoreboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
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

    <h1>Welcome to the Shooting Event Scoreboard</h1>
    <p>Submit and view scores for the Centre Fire and Plate shooting events below.</p>

    <h2>Submit Scores</h2>
    <div class="score-forms">
        <div class="score-form">
            <h3>Centre Fire Score</h3>
            <form method="POST" action="centrefire.php">
                Participant Name:
                <select name="participant_id" required>
                    <option value="">Select Participant</option>
                    <?php
                    // Include the database connection using PDO
                    include 'db_connection.php';

                    // Fetch participant names and IDs from the database
                    $stmt = $pdo->query("SELECT Participant_ID, name FROM participant");

                    // Output data for each participant
                    while ($row = $stmt->fetch()) {
                        echo '<option value="' . $row["Participant_ID"] . '">' . $row["name"] . '</option>';
                    }
                    ?>
                </select><br>
                Score 1: <input type="number" name="score1" required><br>
                Score 2: <input type="number" name="score2" required><br>
                Score 3: <input type="number" name="score3" required><br>
                Score 4: <input type="number" name="score4" required><br>
                Score 5: <input type="number" name="score5" required><br>
                Score 6: <input type="number" name="score6" required><br>
                Score 7: <input type="number" name="score7" required><br>
                <input type="submit" value="Submit Centre Fire Score">
            </form>
        </div>

        <div class="score-form">
            <h3>Plate Score</h3>
            <form method="POST" action="platescore.php">
                Group Name:
                <select name="group_id" required>
                    <option value="">Select Group</option>
                    <?php
                    // Fetch group names and IDs from the database
                    $stmt = $pdo->query("SELECT Group_ID, Group_name FROM `group`");

                    // Output data for each group
                    while ($row = $stmt->fetch()) {
                        echo '<option value="' . $row["Group_ID"] . '">' . $row["Group_name"] . '</option>';
                    }
                    ?>
                </select><br>
                Score 1: <input type="number" name="score1" required><br>
                Score 2: <input type="number" name="score2" required><br>
                Score 3: <input type="number" name="score3" required><br>
                Score 4: <input type="number" name="score4" required><br>
                Score 5: <input type="number" name="score5" required><br>
                Score 6: <input type="number" name="score6" required><br>
                Score 7: <input type="number" name="score7" required><br>
                <input type="submit" value="Submit Plate Score">
            </form>
        </div>
    </div>

</body>
</html>
