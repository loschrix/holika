<?php $basePath = ''; ?>

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
    <script src="<?= $basePath ?>script/carousel.js" defer></script>
</head>

<body>
    <?php include "subpages/sidecart.php" ?>

    <div class="navSlide">

        <?php include "subpages/navbar.php" ?>

        <div class="slide">
            <img src="images/slideshow/img1.jpg" style="width:100%; height:100%; object-fit: cover;">
        </div>

        <div class="slide">
            <img src="images/slideshow/img2.jpg" style="width:100%; height:100%; object-fit: cover;">
        </div>

        <div class="slide">
            <img src="images/slideshow/img3.jpg" style="width:100%; height:100%; object-fit: cover;">
        </div>

        <i class="fa-solid fa-chevron-left fa-2xl prev" onclick="plusSlides(-1)"></i>
        <i class="fa-solid fa-chevron-right fa-2xl next" onclick="plusSlides(1)"></i>

        <div class="dots">
            <i class="fa-regular fa-circle dot" onclick="currentSlide(1)"></i>
            <i class="fa-regular fa-circle dot" onclick="currentSlide(2)"></i>
            <i class="fa-regular fa-circle dot" onclick="currentSlide(3)"></i>
        </div>
    </div>

    <div class="content">

    </div>

    <?php include "subpages/footer.php" ?>

</body>

</html>