<?php
session_start();
include('../db.php');

// Ensure only admin can access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

// Fetch all elections
$stmt = $pdo->query("SELECT * FROM elections");
$elections = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Elections</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 50px auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 25px;
        }

        a {
            color: #2980b9;
            text-decoration: none;
            margin-right: 15px;
            display: inline-block;
        }

        a:hover {
            text-decoration: underline;
        }

        p {
            text-align: center;
            color: #e74c3c;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 12px 16px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #3498db;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .btn {
            padding: 8px 14px;
            border-radius: 6px;
            background-color: #e74c3c;
            color: white;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #c0392b;
        }

        .top-links {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>List of Elections</h2>

        <div class="top-links">
            <a href="dashboard.php">← Back to Dashboard</a>
            <a href="add_election.php">➕ Add New Election</a>
        </div>

        <!-- Display session message -->
        <?php if (isset($_SESSION['message'])): ?>
            <p><?= $_SESSION['message']; unset($_SESSION['message']); ?></p>
        <?php endif; ?>

        <?php if (count($elections) > 0): ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($elections as $election): ?>
                    <tr>
                        <td><?= $election['id']; ?></td>
                        <td><?= htmlspecialchars($election['title']); ?></td>
                        <td>
                            <a class="btn" href="delete_election.php?id=<?= $election['id']; ?>" onclick="return confirm('Are you sure you want to delete this election?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No elections found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
