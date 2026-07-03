<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>sdfgd</h1>

    <?php
    $date = "2026/06/01";
    echo date("d/m/Y", strtotime($date));


    $results = [];
        foreach($results as $result){
            echo "<article>";
            echo "<h2>".$result['title_event']."</h2>";
            echo "<span>".$result['date_event']."</span>";
            echo "<p>".$result['description_event']."</p>";
            echo "</article>";
        }
    ?>

    <?php foreach($results as $result): ?>
        <article>
            <h2><?= $result['title_event'] ?></h2>
            <span><?= $result['date_event'] ?></span>
            <p><?= $result['description_event'] ?></p>
        </article>
    <?php endforeach; ?>

</body>
</html>