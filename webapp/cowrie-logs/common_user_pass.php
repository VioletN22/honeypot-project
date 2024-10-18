<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Common Usernames and Passwords</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="common_user_pass.php">Common Usernames & Passwords</a></li>
        </ul>
    </nav>
    
    <h1>Common Usernames and Passwords</h1>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th class="username-column">Username</th>
                    <th class="count-column">Count</th>
                    <th class="password-column">Password</th>
                    <th class="count-column">Count</th>
                </tr>
            </thead>
            <tbody>
            <?php
            error_reporting(E_ALL);
            ini_set('display_errors', 1);

            // Database connection settings
            $servername = "localhost";
            $username = "cowrie_user";
            $password = "Violet1234*";
            $dbname = "honeypot_logs";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Query for common usernames with their count
            $usernames_query = "SELECT username, COUNT(username) as count FROM login_attempts GROUP BY username ORDER BY count DESC";
            $result_usernames = $conn->query($usernames_query);

            // Query for common passwords with their count
            $passwords_query = "SELECT password, COUNT(password) as count FROM login_attempts GROUP BY password ORDER BY count DESC";
            $result_passwords = $conn->query($passwords_query);

            // Display usernames
            $usernames_data = [];
            if ($result_usernames->num_rows > 0) {
                while ($row = $result_usernames->fetch_assoc()) {
                    $usernames_data[] = $row;
                }
            }

            // Display passwords
            $passwords_data = [];
            if ($result_passwords->num_rows > 0) {
                while ($row = $result_passwords->fetch_assoc()) {
                    $passwords_data[] = $row;
                }
            }

            // Display the combined table (common usernames and passwords)
            $max_rows = max(count($usernames_data), count($passwords_data));
            for ($i = 0; $i < $max_rows; $i++) {
                echo "<tr>";
                // Username row
                if (isset($usernames_data[$i])) {
                    $username = htmlspecialchars($usernames_data[$i]['username']);
                    $username_count = htmlspecialchars($usernames_data[$i]['count']);
                    // Highlight the top 3 usernames
                    $style = $i < 3 ? 'style="color:red;"' : '';
                    echo "<td $style>$username</td>";
                    echo "<td $style>$username_count</td>";
                } else {
                    echo "<td></td><td></td>";
                }

                // Password row
                if (isset($passwords_data[$i])) {
                    $password = htmlspecialchars($passwords_data[$i]['password']);
                    $password_count = htmlspecialchars($passwords_data[$i]['count']);
                    // Highlight the top 3 passwords
                    $style = $i < 3 ? 'style="color:red;"' : '';
                    echo "<td $style>$password</td>";
                    echo "<td $style>$password_count</td>";
                } else {
                    echo "<td></td><td></td>";
                }

                echo "</tr>";
            }

            // Close the connection
            $conn->close();
            ?>
            </tbody>
        </table>
    </div>
</body>
</html>
