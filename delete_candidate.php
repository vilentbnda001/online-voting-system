<?php
session_start();
include('../db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $candidate_id = $_POST['candidate_id'];

    // Check if the candidate is not linked to any vote
    $stmt = $pdo->prepare("SELECT * FROM votes WHERE candidate_id = ?");
    $stmt->execute([$candidate_id]);
    $vote = $stmt->fetch();

    if (!$vote) {
        $stmt = $pdo->prepare("DELETE FROM candidates WHERE id = ?");
        $stmt->execute([$candidate_id]);
        $_SESSION['success'] = "Candidate deleted successfully!";
    } else {
        $_SESSION['error'] = "Cannot delete candidate as they have already been voted for.";
    }

    header('Location: delete_candidate.php');
    exit();
}

// Fetch candidates
$stmt = $pdo->query("SELECT * FROM candidates");
$candidates = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Candidate</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
        }

        .delete-candidate-container {
            max-width: 500px;
            margin: 80px auto;
            background-color: #ffffff;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            color: #2c3e50;
            margin-bottom: 30px;
        }

        select {
            width: 90%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }

        .delete-btn {
            background-color: #e74c3c;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .delete-btn:hover {
            background-color: #c0392b;
        }

        .back-btn {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            font-size: 14px;
            color: #555;
        }

        .back-btn:hover {
            color: #2980b9;
        }

        .success, .error {
            font-weight: bold;
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 6px;
            width: 90%;
            margin-left: auto;
            margin-right: auto;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="delete-candidate-container">
        <h2>Delete Candidate</h2>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php elseif (isset($_SESSION['error'])): ?>
            <div class="error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <form action="delete_candidate.php" method="POST">
            <select name="candidate_id" required>
                <option value="">Select Candidate</option>
                <?php foreach ($candidates as $candidate): ?>
                    <option value="<?= $candidate['id']; ?>"><?= htmlspecialchars($candidate['name']); ?></option>
                <?php endforeach; ?>
            </select>
            <br>
            <button type="submit" class="delete-btn">Delete Candidate</button>
        </form>

        <a href="dashboard.php" class="back-btn">← Back to Dashboard</a>
    </div>
</body>
</html>
