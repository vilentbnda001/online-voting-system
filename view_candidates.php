<?php
session_start();
include('../db.php');

// Ensure only admin can access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

// Fetch all elections for dropdown
$elections = $pdo->query("SELECT id, title FROM elections ORDER BY id DESC")->fetchAll();

// Default election selection
$selectedElectionId = isset($_GET['election_id']) ? $_GET['election_id'] : '';

// Fetch candidates for selected election
$candidates = [];
if (!empty($selectedElectionId)) {
    $stmt = $pdo->prepare("SELECT * FROM candidates WHERE election_id = ?");
    $stmt->execute([$selectedElectionId]);
    $candidates = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Candidates</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 900px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 2px 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: #2c3e50;
            text-align: center;
        }
        a {
            text-decoration: none;
            color: #3498db;
        }
        a:hover {
            text-decoration: underline;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }
        th, td {
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #3498db;
            color: white;
        }
        .back-link {
            display: inline-block;
            margin-bottom: 15px;
            background: #2980b9;
            color: #fff;
            padding: 8px 16px;
            border-radius: 5px;
        }
        .back-link:hover {
            background: #1e5c85;
        }
        .message {
            color: green;
            margin-bottom: 10px;
            text-align: center;
        }
        form {
            margin-bottom: 20px;
        }
        select {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-right: 10px;
        }
        button {
            padding: 10px 16px;
            font-size: 16px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>List of Candidates</h2>
        <a class="back-link" href="dashboard.php">← Back to Dashboard</a>

        <!-- Display session message -->
        <?php if (isset($_SESSION['message'])): ?>
            <p class="message"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></p>
        <?php endif; ?>

        <!-- Election selection form -->
        <form method="GET" action="">
            <label for="election_id">Select Election:</label>
            <select name="election_id" required>
                <option value="">-- Choose Election --</option>
                <?php foreach ($elections as $election): ?>
                    <option value="<?= $election['id'] ?>" <?= ($election['id'] == $selectedElectionId) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($election['title']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">View Candidates</button>
        </form>

        <?php if (!empty($selectedElectionId)): ?>
            <?php if (count($candidates) > 0): ?>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                    <?php foreach ($candidates as $candidate): ?>
                        <tr>
                            <td><?= $candidate['id']; ?></td>
                            <td><?= htmlspecialchars($candidate['name']); ?></td>
                            <td>
                                <a href="delete_candidate.php?id=<?= $candidate['id']; ?>" onclick="return confirm('Are you sure you want to delete this candidate?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p>No candidates found for this election.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>
