<?php
session_start();

// Redirect if not logged in or not an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6f8;
        }

        /* Navbar */
        .navbar {
            background-color: #2c3e50;
            padding: 15px 30px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h1 {
            font-size: 20px;
        }

        .navbar a {
            color: #f1f1f1;
            text-decoration: none;
            padding: 8px 16px;
            background-color: #e74c3c;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .navbar a:hover {
            background-color: #c0392b;
        }

        .container {
            max-width: 900px;
            margin: 80px auto 40px;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            text-align: center;
        }

        .container h2 {
            color: #2c3e50;
            margin-bottom: 30px;
        }

        .dashboard-actions {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .action-btn {
            display: inline-block;
            padding: 15px 25px;
            width: 220px;
            background-color: #3498db;
            color: white;
            font-weight: bold;
            text-decoration: none;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .action-btn:hover {
            background-color: #2980b9;
        }

        @media (max-width: 600px) {
            .action-btn {
                width: 90%;
            }
        }
    </style>
</head>
<body>

    <div class="navbar">
        <h1>Admin Panel - Online Voting System</h1>
        <a href="../logout.php">Logout</a>
    </div>

    <div class="container">
        <h2>Welcome, Admin!</h2>
        <div class="dashboard-actions">
            <a href="add_candidate.php" class="action-btn">Add Candidate</a>
            <a href="view_candidates.php" class="action-btn">View Candidates</a>
            <a href="delete_candidate.php" class="action-btn">Delete Candidate</a>
            <a href="view_results.php" class="action-btn">View Results</a>
            <a href="add_election.php" class="action-btn">Add Election</a>
            <a href="view_elections.php" class="action-btn">View Elections</a>
        </div>
    </div>

</body>
</html>
