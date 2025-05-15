<?php
session_start();
include('../db.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $election_id = $_POST['election_id'];

    try {
        $stmt = $pdo->prepare("INSERT INTO candidates (name, election_id) VALUES (?, ?)");
        $stmt->execute([$name, $election_id]);
        $success = "Candidate added successfully!";
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}

// Fetch available elections for the dropdown
$elections = $pdo->query("SELECT id, title FROM elections ORDER BY id DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Candidate</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f2f5;
            padding: 40px;
        }

        .form-box {
            background: #fff;
            max-width: 500px;
            margin: auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            margin-bottom: 8px;
            display: block;
        }

        input[type="text"], select {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 20px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            width: 100%;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .msg {
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .msg.success {
            color: green;
        }

        .msg.error {
            color: red;
        }
    </style>
</head>
<body>

    <div class="form-box">
        <h2>Add Candidate</h2>

        <?php if (isset($success)): ?>
            <div class="msg success"><?= $success ?></div>
        <?php elseif (isset($error)): ?>
            <div class="msg error"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" action="add_candidate.php">
            <label for="name">Candidate Name:</label>
            <input type="text" name="name" required>

            <label for="election_id">Select Election:</label>
            <select name="election_id" required>
                <option value="">-- Select Election --</option>
                <?php foreach ($elections as $election): ?>
                    <option value="<?= $election['id'] ?>"><?= htmlspecialchars($election['title']) ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Add Candidate</button>
        </form>
    </div>

</body>
</html>
