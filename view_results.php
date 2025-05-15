<?php
session_start();
include('../db.php');

// Admin access check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

// Fetch candidates with vote counts
$stmt = $pdo->query("
    SELECT c.name, COUNT(v.id) AS vote_count
    FROM candidates c
    LEFT JOIN votes v ON c.id = v.candidate_id
    GROUP BY c.id
    ORDER BY vote_count DESC
");
$results = $stmt->fetchAll();

// Calculate total votes
$totalVotes = array_sum(array_column($results, 'vote_count'));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Election Results</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fc;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 60px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th {
            background-color: #34495e;
            color: white;
            padding: 12px;
        }

        td {
            padding: 12px;
            text-align: center;
        }

        .bar-container {
            background-color: #ecf0f1;
            border-radius: 20px;
            overflow: hidden;
            height: 24px;
            margin-top: 8px;
        }

        .bar {
            height: 100%;
            background-color: #27ae60;
            color: white;
            line-height: 24px;
            padding-right: 10px;
            text-align: right;
            font-size: 14px;
            font-weight: bold;
        }

        button {
            background-color: #2980b9;
            color: white;
            padding: 10px 20px;
            border: none;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #1f618d;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #333;
        }

        a:hover {
            color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Election Results</h2>

        <table>
            <tr>
                <th>Candidate Name</th>
                <th>Votes</th>
                <th>Percentage</th>
            </tr>
            <?php foreach ($results as $row): 
                $percentage = $totalVotes > 0 ? ($row['vote_count'] / $totalVotes) * 100 : 0;
            ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']); ?></td>
                    <td><?= $row['vote_count']; ?></td>
                    <td>
                        <?= round($percentage, 2); ?>%
                        <div class="bar-container">
                            <div class="bar" style="width: <?= $percentage; ?>%;">
                                <?= round($percentage); ?>%
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <form action="download_results.php" method="post">
            <button type="submit">Download Results as CSV</button>
        </form>

        <a href="dashboard.php">← Back to Dashboard</a>
    </div>
</body>
</html>
