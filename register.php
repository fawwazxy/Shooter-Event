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

    <h2>Register Participant</h2>
    <div class="registration-form">
        <form method="POST" action="register.php">
            Participant Name: <input type="text" name="participant_name" required><br>
            Group Name: 
            <select name="group_name" required>
                <option value="">Select Group</option>
                <?php
                    // Include the database connection using PDO
                    include 'db_connection.php';

                    // Fetch group names and IDs from the database
                    $stmt = $pdo->query("SELECT Group_ID, Group_name FROM `group`");

                    // Fetch and output data for each group
                    while ($row = $stmt->fetch()) {
                        // Display Group_name but submit Group_ID as value
                        echo '<option value="' . $row["Group_ID"] . '">' . $row["Group_name"] . '</option>';
                    }
                ?>
            </select><br>
            <input type="submit" value="Register Participant">
        </form>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $participant_name = $_POST['participant_name'];
        $group_id = $_POST['group_name'];  // This will now hold the Group_ID

        // Include the database connection
        include 'db_connection.php';

        // Prepare and execute the statement using PDO
        $stmt = $pdo->prepare("INSERT INTO participant (name, group_id) VALUES (?, ?)");

        if ($stmt->execute([$participant_name, $group_id])) {
            echo "Participant registered successfully!";
        } else {
            echo "Error: Could not register participant.";
        }
    }
    ?>

</body>
</html>
