<?php
session_start();
include('../db.php');

// Ensure only admin can access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

// Handle form submission to add election
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['title']) && !empty(trim($_POST['title']))) {
        $title = trim($_POST['title']);

        try {
            $stmt = $pdo->prepare("INSERT INTO elections (title) VALUES (?)");
            $stmt->execute([$title]);

            $_SESSION['message'] = "Election added successfully!";
            header('Location: view_elections.php');
            exit();
        } catch (PDOException $e) {
            $_SESSION['message'] = "Error: Could not add election.";
        }
    } else {
        $_SESSION['message'] = "Election title is required.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Election</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 500px;
            margin: 60px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 25px;
        }

        a {
            display: block;
            text-align: center;
            margin-bottom: 20px;
            color: #3498db;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            margin-bottom: 15px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus {
            border-color: #2980b9;
            outline: none;
        }

        button {
            background-color: #2980b9;
            color: #fff;
            padding: 12px;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #1f618d;
        }

        p {
            text-align: center;
            color: #e74c3c;
            font-weight: bold;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add New Election</h2>
        <a href="dashboard.php">← Back to Dashboard</a>

        <?php if (isset($_SESSION['message'])): ?>
            <p><?= $_SESSION['message']; unset($_SESSION['message']); ?></p>
        <?php endif; ?>

        <form action="add_election.php" method="POST">
            <label for="title">Election Title:</label>
            <input type="text" name="title" id="title" placeholder="Enter election name" required>
            <button type="submit">Add Election</button>
        </form>
    </div>
</body>
</html>
