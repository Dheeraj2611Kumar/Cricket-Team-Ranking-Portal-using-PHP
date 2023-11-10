<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Cricket Team Rankings</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <h1>Cricket Team Rankings</h1>
  <div class="tbl-header">
  <table cellpadding="0" cellspacing="0" border="0">
        <tr>
            <th>Team Name</th>
            <th>Matches Played</th>
            <th>Matches Won</th>
            <th>Matches Lost</th>
            <th>Points</th>
        </tr>
        <?php
        // Connect to the database
        $conn = mysqli_connect("localhost", "root", "", "cricket");

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Retrieve and display team data sorted by points in descending order
        $sql = "SELECT * FROM teams";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                // Calculate points based on the logic (matches_won * 3) - matches_lost
                $points = ($row["matches_won"] * 3) - $row["matches_lost"];
                echo "<tr>";
                echo "<td>" . $row["team_name"] . "</td>";
                echo "<td>" . $row["matches_played"] . "</td>";
                echo "<td>" . $row["matches_won"] . "</td>";
                echo "<td>" . $row["matches_lost"] . "</td>";
                echo "<td>" . $points . "</td>";
                echo "</tr>";
            }
        } else {
            echo "0 results";
        }

        mysqli_close($conn);
        ?>
    </table>
  </div>
    

    <br><br>
    <div >
      <a href="add_team.php">Add New Team</a>
      <a href="update_stats.php">Update Stats</a>
    </div>
    
</body>

</html>
