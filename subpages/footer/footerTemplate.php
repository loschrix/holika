<?php $basePath = '../../'; ?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Holika holika - Sklep</title>
    <link rel="stylesheet" href="<?= $basePath ?>style.css">
    <link rel="icon" type="image/x-icon" href="<?= $basePath ?>images/logo.svg">
    <script src="https://kit.fontawesome.com/e35f37da01.js" crossorigin="anonymous"></script>
    <script src="<?= $basePath ?>script/script.js" defer></script>
</head>

<body>
    <?php include "../sidecart.php" ?>

    <div class="navSlide" style="height: 10vh;">
        <?php include "../navbar.php" ?>
    </div>
    <div class="content">
        <div class="directory">
            <p><a href="../../index.php">Strona główna</a> > <?php echo $pageName ?></p>
        </div>
        <div class="context">
            <?php echo $text ?>
        </div>
    </div>
    <?php include "../footer.php" ?>
</body>

</html>