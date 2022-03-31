<?php

require_once 'connec.php';
$pdo = new PDO(DSN, USER, PASS);

$query = "SELECT * FROM friend";
$statement = $pdo->query($query);
$friends = $statement->fetchAll(PDO::FETCH_ASSOC);

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(!empty ($_POST['firstname']) && !empty($_POST['lastname'])) {
        $query = 'INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)';
        $statement = $pdo->prepare($query);
        $statement->bindValue(':firstname', $_POST['firstname'], PDO::PARAM_STR);
        $statement->bindValue(':lastname', $_POST['lastname'], PDO::PARAM_STR);
        $statement->execute();
        $friends = $statement->fetchAll();
    } else {
        $error = "Tous les champs sont requis.";
    }
header("Location: /");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of friends</title>
</head>
<body>
    <ul>
        <?php foreach($friends as $friend) : ?>
            <li><?= $friend['firstname'] . ' ' . $friend['lastname']; ?></li>
        <?php endforeach ?>
    </ul>

    <p><?= !empty($error) ? $error : ''; ?></p>

    <p>-------------------------------- <br><br> Add your own friends here</p>

    <form action="" method="post">
        <div>
            <label for="firstname">Firstname :</label>
            <input type="text" id="firstname" name="firstname" maxlength="45">
        </div>
        <div>
            <label for="lastname">Lastname :</label>
            <input type="text" id="lastname" name="lastname" maxlength="45">
        </div>
        <div>
            <button type="submit">Create new friend</button>
        </div>
    </form>
</body>
</html>