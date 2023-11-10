<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add New Team</title>
    <link rel="stylesheet" href="style.css" />

</head>

<body>
    <h1>Add New Team</h1>
    <br><br><br>
    <?php
    // Initialize variables
    $teamName = "";
    $matchesPlayed = 0;
    $matchesWon = 0;
    $warningMessage = "";

    // Check if data is sent from the form
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve data from the form
        $teamName = $_POST["team_name"];
        $matchesPlayed = $_POST["matches_played"];
        $matchesWon = $_POST["matches_won"];

        // Calculate matches lost
        $matchesLost = $matchesPlayed - $matchesWon;

        // Validate matches won cannot be greater than matches played
        if ($matchesWon > $matchesPlayed) {
            $warningMessage = "Number of winnings cannot be greater than the number of matches played.";
        } else {
            // Connect to the database
            $conn = mysqli_connect("localhost", "root", "", "cricket");

            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Check if the team already exists
            $checkSql = "SELECT * FROM teams WHERE team_name='$teamName'";
            $result = mysqli_query($conn, $checkSql);

            if (mysqli_num_rows($result) > 0) {
                $warningMessage = "Team already exists!";
            } else {
                // Insert data into the database
                $insertSql = "INSERT INTO teams (team_name, matches_played, matches_won, matches_lost) VALUES ('$teamName', '$matchesPlayed', '$matchesWon', '$matchesLost')";

                if (mysqli_query($conn, $insertSql)) {
                    echo "New team added successfully!";
                    // Reset form values
                    $teamName = "";
                    $matchesPlayed = 0;
                    $matchesWon = 0;
                } else {
                    echo "Error: " . $insertSql . "<br>" . mysqli_error($conn);
                }
            }

            // Close the database connection
            mysqli_close($conn);
        }
    }
    ?>
    <div>
        
    <form method="post" action="add_team.php">
        <label for="team_name">Team Name:</label>
        <input type="text" id="team_name" name="team_name" value="<?php echo $teamName; ?>" required><br><br>

        <label for="matches_played">Matches Played:</label>
        <input type="number" id="matches_played" name="matches_played" value="<?php echo $matchesPlayed; ?>" required><br><br>

        <label for="matches_won">Matches Won:</label>
        <input type="number" id="matches_won" name="matches_won" value="<?php echo $matchesWon; ?>" required><br><br>

        <input type="submit" value="Add Team">

        <?php
        // Display warning message if applicable
        if (!empty($warningMessage)) {
            echo "<p style='color: red;'>$warningMessage</p>";
        }
        ?>
    </form>

    </div>
    <br><br>
    <div>
    <a href="index.php">Back to Team Rankings</a>
    </div>
</body>

</html>
