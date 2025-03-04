<?php
session_start();
require('connect.php');
include 'header.php';

// Fetch latest match insights
$sql = "SELECT * FROM insights ORDER BY created_at DESC LIMIT 5";
$stmt = $db->prepare($sql);
$stmt->execute();
$insights = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Match Insights - T.O Blog</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Match Insights</h2>
        <p class="text-center">Stay updated with match reviews, analyses, and predictions.</p>

        <!-- Display insights -->
        <?php if (count($insights) > 0): ?>
            <div class="row">
                <?php foreach ($insights as $insight): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <?php if (!empty($insight['image_url'])): ?>
                                <img src="<?php echo htmlspecialchars($insight['image_url']); ?>" class="card-img-top" alt="Match Image">
                            <?php endif; ?>
                            <div class="card-body">
                                <h3 class="card-title"><?php echo htmlspecialchars($insight['title']); ?></h3>
                                <p class="card-text"><?php echo nl2br(htmlspecialchars($insight['content'])); ?></p>
                                <p><strong>Category:</strong> <?php echo htmlspecialchars($insight['category']); ?></p>
                                <p><strong>Author:</strong> <?php echo htmlspecialchars($insight['author']); ?></p>
                                <small class="text-muted">Published on <?php echo date("F j, Y", strtotime($insight['created_at'])); ?></small>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-center">No insights available yet. Stay tuned!</p>
        <?php endif; ?>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
