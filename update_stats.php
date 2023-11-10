<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update Team Stats</title>
    <link rel="stylesheet" href="style.css" />

</head>

<body>
    <h1>Update Team Stats</h1>

    <?php
    // Connect to the database
    $conn = mysqli_connect("localhost", "root", "", "cricket");

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if a valid outcome is chosen
        if (isset($_POST["outcome"]) && ($_POST["outcome"] == "win" || $_POST["outcome"] == "loss")) {
            $teamId = $_POST["team_id"];
            $outcome = $_POST["outcome"];

            // Update matches won or lost based on outcome
            if ($outcome == "win") {
                $updateOutcomeSql = "UPDATE teams SET matches_won = matches_won + 1, matches_played = matches_played + 1, matches_lost = matches_played - matches_won WHERE id = $teamId";
            } else {
                $updateOutcomeSql = "UPDATE teams SET matches_lost = matches_lost + 1, matches_played = matches_played + 1, matches_won = matches_played - matches_lost WHERE id = $teamId";
            }

            if (mysqli_query($conn, $updateOutcomeSql)) {
                echo "Outcome updated successfully!";
            } else {
                echo "Error updating outcome: " . mysqli_error($conn);
            }
        } else {
            echo "Please choose a valid outcome (win or loss)!";
        }

        // Check if delete team button is clicked
        if (isset($_POST["delete_team"])) {
            $teamId = $_POST["team_id"];

            $deleteSql = "DELETE FROM teams WHERE id = $teamId";
            if (mysqli_query($conn, $deleteSql)) {
                echo "Team deleted successfully!";
            } else {
                echo "Error deleting team: " . mysqli_error($conn);
            }
        }
    }

    // Fetch team names from the database for dropdown list
    $teamsSql = "SELECT id, team_name FROM teams";
    $teamsResult = mysqli_query($conn, $teamsSql);
    ?>

    <div class="parent-div ">
    <div style="child-div">
    <h2>Update Team Statistics </h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="team_id">Select Team:</label>
        <select id="team_id" name="team_id" required>
            <?php
            while ($row = mysqli_fetch_assoc($teamsResult)) {
                echo "<option value='" . $row["id"] . "'>" . $row["team_name"] . "</option>";
            }
            ?>
        </select>
        <br><br>

        <label>Outcome:</label>
        <br><br>
        <input type="radio" id="win" name="outcome" value="win" required>
        <label for="win">Win</label>
        <input type="radio" id="loss" name="outcome" value="loss" required>
        <label for="loss">Loss</label>
        <br><br>

        <input class="button" style="font-size:15px" type="submit" value="Update Team Stats">
    </form>
    </div>
    

    <br><br>

    <div style="child-div">
    <h2>Delete Team </h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="team_id">Select Team to Delete:</label>
        <select id="team_id" name="team_id" required>
            <?php
            mysqli_data_seek($teamsResult, 0);
            while ($row = mysqli_fetch_assoc($teamsResult)) {
                echo "<option value='" . $row["id"] . "'>" . $row["team_name"] . "</option>";
            }
            ?>
        </select>
        <br><br>

        <input class="button" style="font-size:15px" type="submit" name="delete_team" value="Delete Team">
    </form>
    </div>
    </div>
    
    

    <br><br><br>
    <div>
        <a href="index.php">Back to Team Rankings</a>   
    </div>

    <?php
    // Close the database connection
    mysqli_close($conn);
    ?>
</body>

</html>
