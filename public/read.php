<?php
if (isset($_POST['submit'])) {
    try {
        require "common.php"; 
        require_once 'C:/Users/tonym/Sites/PDO CRUD App Lab/public/src/DBconnect.php';

        // SQL Query
        $sql = "SELECT * FROM users WHERE location = :location";
        $location = $_POST['location'];
        $statement = $connection->prepare($sql);
        $statement->bindParam(':location', $location, PDO::PARAM_STR);
        $statement->execute();
        $result = $statement->fetchAll();
    } catch (PDOException $error) {
        echo "<p style='color:red;'>Error: " . $error->getMessage() . "</p>";
    }
}
?>

<?php include "templates/header.php"; ?>

<?php if (isset($_POST['submit'])): ?>
    <?php if (!empty($result) && $statement->rowCount() > 0): ?>
        <h2>Results</h2>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email Address</th>
                    <th>Age</th>
                    <th>Location</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row): ?>
                    <tr>
                        <td><?php echo escape($row["id"]); ?></td>
                        <td><?php echo escape($row["firstname"]); ?></td>
                        <td><?php echo escape($row["lastname"]); ?></td>
                        <td><?php echo escape($row["email"]); ?></td>
                        <td><?php echo escape($row["age"]); ?></td>
                        <td><?php echo escape($row["location"]); ?></td>
                        <td><?php echo escape($row["date"]); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No results found for <?php echo escape($_POST['location']); ?>.</p>
    <?php endif; ?>
<?php endif; ?>

<h2>Find user based on location</h2>
<form method="post">
    <label for="location">Location</label>
    <input type="text" id="location" name="location" required>
    <input type="submit" name="submit" value="View Results">
</form>

<a href="index.php">Back to home</a>
<?php include "templates/footer.php"; ?>
