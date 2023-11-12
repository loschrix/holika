<?php
$basePath = '../../';
require("../../connect.php");

$query = "SELECT cosmetics.id, cosmetics.stars, cosmetics.quantity, cosmetics.name, cosmetics.img, cosmetics.price, cosmetics.price_after, cosmetics.reviews, cosmetics.date FROM `cosmetics` INNER JOIN `type` ON type.ID = cosmetics.id_type1 LEFT JOIN `type` AS type2 ON type2.ID = cosmetics.id_type2 LEFT JOIN `type` AS type3 ON type3.ID = cosmetics.id_type3 WHERE type.name LIKE '%$product_type%' OR type2.name LIKE '%$product_type%' OR type3.name LIKE '%$product_type%';";

$maxQuery = "SELECT CEIL(MAX(cosmetics.price)) as max FROM `cosmetics` INNER JOIN `type` ON type.ID = cosmetics.id_type1 LEFT JOIN `type` AS type2 ON type2.ID = cosmetics.id_type2 LEFT JOIN `type` AS type3 ON type3.ID = cosmetics.id_type3 WHERE type.name LIKE '%$product_type%' OR type2.name LIKE '%$product_type%' OR type3.name LIKE '%$product_type%'";
$maxSaleQuery = "SELECT CEIL(MAX(cosmetics.price_after)) as max FROM `cosmetics` INNER JOIN `type` ON type.ID = cosmetics.id_type1 LEFT JOIN `type` AS type2 ON type2.ID = cosmetics.id_type2 LEFT JOIN `type` AS type3 ON type3.ID = cosmetics.id_type3 WHERE type.name LIKE '%$product_type%' OR type2.name LIKE '%$product_type%' OR type3.name LIKE '%$product_type%'";

$minQuery = "SELECT FLOOR(MIN(LEAST(price, price_after))) as min FROM `cosmetics` INNER JOIN `type` ON type.ID = cosmetics.id_type1 LEFT JOIN `type` AS type2 ON type2.ID = cosmetics.id_type2 LEFT JOIN `type` AS type3 ON type3.ID = cosmetics.id_type3 WHERE (type.name LIKE '%$product_type%' OR type2.name LIKE '%$product_type%' OR type3.name LIKE '%$product_type%') AND price_after IS NOT NULL";
$elseQuery = "SELECT FLOOR(MIN(price)) as min FROM `cosmetics` INNER JOIN `type` ON type.ID = cosmetics.id_type1 LEFT JOIN `type` AS type2 ON type2.ID = cosmetics.id_type2 LEFT JOIN `type` AS type3 ON type3.ID = cosmetics.id_type3 WHERE (type.name LIKE '%$product_type%' OR type2.name LIKE '%$product_type%' OR type3.name LIKE '%$product_type%')";

$result = mysqli_query($connect, $query);
$minResult = mysqli_fetch_assoc(mysqli_query($connect, $minQuery))['min'];
if ($minResult == null) {
    $minResult = mysqli_fetch_assoc(mysqli_query($connect, $elseQuery))['min'];
}
$maxResult = mysqli_fetch_assoc(mysqli_query($connect, $maxQuery))['max'];
$maxSaleResult = mysqli_fetch_assoc(mysqli_query($connect, $maxSaleQuery))['max'];
if ($maxSaleResult == null) {
    $maxSaleResult = $maxResult;
}

$arrayRegular = [($minResult + (($maxResult - $minResult) / 4)), ($minResult + (($maxResult - $minResult) / 2)), ($minResult + ((3 * ($maxResult - $minResult)) / 4))];
$arraySale = [($minResult + (($maxSaleResult - $minResult) / 4)), ($minResult + (($maxSaleResult - $minResult) / 2)), ($minResult + ((3 * ($maxSaleResult - $minResult)) / 4))];

foreach ($arrayRegular as &$value) {
    $value = round($value, 1);
}

foreach ($arraySale as &$value) {
    $value = round($value, 1);
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Holika holika - Sklep</title>
    <link rel="stylesheet" href="<?= $basePath ?>style.css">
    <link rel="stylesheet" href="<?= $basePath ?>subpages/products/product.css">
    <link rel="icon" type="image/x-icon" href="<?= $basePath ?>images/logo.svg">
    <script src="https://kit.fontawesome.com/e35f37da01.js" crossorigin="anonymous"></script>
    <script src="<?= $basePath ?>script/script.js" defer></script>
    <script src="<?= $basePath ?>script/stars.js" defer></script>
    <script src="<?= $basePath ?>script/order_products.js" defer></script>
</head>

<body>
    <?php include "../sidecart.php" ?>

    <div class="navSlide" style="height: 10vh;">
        <?php include "../navbar.php" ?>
    </div>

    <div class="box-directory">
        <div class="directory">
            <p><a href="../../index.php">Strona główna</a> > <span id='category-name'><?php echo $product_type ?></span></p>
        </div>
        <h1 style="font-size: 3rem;"><?php echo $product_type ?></h1>
    </div>

    <div class="content">
        <div class="filter">
            <div class="filter-content">
                <h1 style="font-size: 2.5rem;">Filtr</h1>
                <div class="sort-by">
                    <span class="toggle-section">
                        <i class="fa-solid fa-caret-up fa-xl"></i>
                        <p>Sortuj po:</p>
                    </span>
                    <div class="sort-by-options">
                        <p data-sortby="id" data-sortorder="asc" data-selector=".stars" id="def" style='font-weight: bold;'>Trafność</p>
                        <p data-sortby="price" data-sortorder="asc" data-selector=".price">Cenie rosnąco</p>
                        <p data-sortby="price" data-sortorder="desc" data-selector=".price">Cenie malejąco</p>
                        <p data-sortby="date" data-sortorder="asc" data-selector="[data-date]">Dacie rosnąco</p>
                        <p data-sortby="date" data-sortorder="desc" data-selector="[data-date]">Dacie malejąco</p>
                        <p data-sortby="name" data-sortorder="asc" data-selector=".product-name">Nazwie rosnąco</p>
                        <p data-sortby="name" data-sortorder="desc" data-selector=".product-name">Nazwie malejąco</p>
                        <p data-sortby="review" data-sortorder="asc" data-selector="[data-rating]">Ocenie rosnąco</p>
                        <p data-sortby="review" data-sortorder="desc" data-selector="[data-rating]">Ocenie malejąco</p>
                    </div>
                </div>
                <div class="price-range">
                    <span class="toggle-section" style="position: relative;">
                        <i class="fa-solid fa-caret-up fa-xl"></i>
                        <p>Cena:</p>
                        <p id="clear" style="position: absolute; right: 0; font-size: 0.9rem; color:#a1a1a1;">Wyczyść</p>
                    </span>
                    <div class="range-container">
                        <div class="form-control">
                            <input type="text" id="fromInput" value="<?php echo $minResult; ?>" min="<?php echo $minResult; ?>" max="<?php echo $maxResult; ?>" />
                            <input type="text" id="toInput" value="<?php echo $maxResult; ?>" min="<?php echo $minResult; ?>" max="<?php echo $maxResult; ?>" />
                        </div>
                        <div class="sliders-control">
                            <input id="fromSlider" type="range" value="<?php echo $minResult; ?>" min="<?php echo $minResult; ?>" max="<?php echo $maxResult; ?>" />
                            <div class="range-markers">
                                <div>
                                    <p><?php echo $minResult; ?></p>
                                </div>
                                <div>
                                    <p><?php echo $arrayRegular[0]; ?></p>
                                </div>
                                <div>
                                    <p><?php echo $arrayRegular[1]; ?></p>
                                </div>
                                <div>
                                    <p><?php echo $arrayRegular[2]; ?></p>
                                </div>
                                <div>
                                    <p><?php echo $maxResult; ?></p>
                                </div>
                            </div>
                            <input id="toSlider" type="range" value="<?php echo $maxResult; ?>" min="<?php echo $minResult; ?>" max="<?php echo $maxResult; ?>" />
                        </div>
                    </div>
                </div>
                <div class="stan">
                    <span class="toggle-section">
                        <i class="fa-solid fa-caret-up fa-xl"></i>
                        <p>Stan:</p>
                    </span>
                    <div class="checkbox-options">
                        <div class="checkbox">
                            <label for="">Promocja</label>
                            <input type="checkbox" id="sale">
                        </div>
                        <div class="checkbox">
                            <label for="">Dostępność</label>
                            <input type="checkbox" id="availability">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="products-box">
            <?php
            $counter = 0;
            if ($result) {
                echo "<div class='products'>";
                while ($row = mysqli_fetch_assoc($result)) {
                    $row['img'] = $basePath . $row['img'];
                    $rating = round($row['stars'], 2);

                    $polishChars = ['ą', 'ć', 'ę', 'ł', 'ń', 'ó', 'ś', 'ź', 'ż'];
                    $englishChars = ['a', 'c', 'e', 'l', 'n', 'o', 's', 'z', 'z'];
                    $productName = str_replace($polishChars, $englishChars, $row['name']);
                    $productName = strtolower(str_replace(' ', '', $productName));
                    $productNameLink = ($row['quantity'] == 0) ? "#" : $productName;

                    echo "<div class='product' data-date='{$row['date']}' data-rating='{$row['stars']}' data-quantity='{$row['quantity']}'>
                    <div class='product-img' style='position: relative; overflow:hidden;'>";
                    if ($row['quantity'] == 0) {
                        echo "
                            <div style='background-color: rgba(0,0,0,0.3); position: absolute; top: 0; left: 0; width: 100%; height: 100%;'></div>
                            <div style='position: absolute; overflow:hidden; height:100%; width:100%; display: flex; flex-direction: row; justify-content: center; align-items: center;'>
                                <p class='unavailable' style='padding: 5%; position:absolute; z-index: 1; background-color: #fff; font-size: 1.2rem; cursor: arrow; box-sizing: border-box; border:1px solid transparent; user-select:none; border-radius: 10px;'>NIEDOSTĘPNY</p>
                            </div>";
                    } else if (!is_null($row['price_after'])) {
                        $sale = strval(ROUND((1 - $row['price_after'] / $row['price']) * 100));

                        if (strlen($sale) > 1 || $sale[0] == "1") {
                            $saleStyle = "
                                    position: absolute;
                                    top: 16%;
                                    right: 6%;
                                    color: #fff;
                                    font-size: 2rem;
                                    transform: rotate(50deg);
                                    transform-origin: center center;
                                ";
                        } else {
                            $saleStyle = "
                                    position: absolute;
                                    top: 15%;
                                    right: 10%;
                                    color: #fff;
                                    font-size: 2rem;
                                    transform: rotate(50deg);
                                    transform-origin: center center;
                                ";
                        }
                        echo "<div style='position: absolute; top:-12%; right: 0; width: 20%; height: 90%; transform: skewX(40deg) scaleY(cos(40deg)); background-color: red;'></div>
                            <p style='$saleStyle'>$sale%</p>
                            ";
                    }
                    echo
                    "<a href='{$productNameLink}' title='{$row['name']}'>
                            <img src='{$row['img']}'>
                        </a>
                        </div>
                        <div class='product-rest'>
                            <a class='product-name' href='{$productNameLink}'>{$row['name']}</a>
                            <div class='starviews-box'>
                                <div class='stars' id='stars_{$row['id']}'>
                                    <i class='fa-regular fa-star'></i>
                                    <i class='fa-regular fa-star'></i>
                                    <i class='fa-regular fa-star'></i>
                                    <i class='fa-regular fa-star'></i>
                                    <i class='fa-regular fa-star'></i>
                                </div>
                                <p>({$row['reviews']})</p>
                            </div>
                            <div class='prices'>";
                    if (!is_null($row['price_after'])) {
                        echo "<s class='sale'>{$row['price']}zł</s>
                        <p class='price'>{$row['price_after']}zł</p>";
                    } else {
                        echo "<p class='price'>{$row['price']}zł</p>";
                    }
                    echo "</div>
                        </div>
                    </div>"; ?>

            <?php
                    $counter++;

                    if ($counter % 3 == 0) {
                        echo "</div><div class='products'>";
                    }
                }
                echo "</div>";
            }
            ?>
            <script>
                const nodes = document.querySelectorAll('.products');
                const last = nodes[nodes.length - 1];
                if (last.childNodes.length === 0) {
                    last.remove();
                }
            </script>
        </div>
    </div>

    <?php include "../footer.php" ?>
    <script>
        let minResult = <?php echo $minResult; ?>;
        let maxResult = <?php echo $maxResult; ?>;
        let priceRange = document.querySelector('.price-range');

        if (minResult === maxResult) {
            priceRange.style.display = "none";
        }

        const toggleSections = document.querySelectorAll('.toggle-section');

        toggleSections.forEach((span) => {
            const container = span.nextElementSibling;
            container.style.maxHeight = container.maxHeight = null;
            if (container.className == "checkbox-options") {
                container.classList.add("unvisi");
            }
            span.addEventListener('click', () => {
                const container = span.nextElementSibling;

                if (container.style.maxHeight) {
                    container.style.maxHeight = null;
                    span.querySelector('i').classList.remove('fa-caret-down');
                    span.querySelector('i').classList.add('fa-caret-up');
                    if (container.className == "checkbox-options") {
                        container.classList.add("unvisi");
                    }
                } else {
                    container.style.maxHeight = container.scrollHeight + 'px';
                    span.querySelector('i').classList.remove('fa-caret-up');
                    span.querySelector('i').classList.add('fa-caret-down');
                    if (container.className == "checkbox-options unvisi") {
                        container.classList.remove("unvisi");
                    }
                }
            });
        });

        const rangeMarkers = document.querySelectorAll('.range-markers p');

        document.querySelector("#sale").addEventListener("change", function() {
            if (this.checked) {
                toInput.max = <?php echo $maxSaleResult; ?>;
                toInput.value = <?php echo $maxSaleResult; ?>;
                toSlider.max = <?php echo $maxSaleResult; ?>;
                toSlider.value = <?php echo $maxSaleResult; ?>;
                rangeMarkers[1].textContent = <?php echo $arraySale[0]; ?>;
                rangeMarkers[2].textContent = <?php echo $arraySale[1]; ?>;
                rangeMarkers[3].textContent = <?php echo $arraySale[2]; ?>;
                rangeMarkers[4].textContent = <?php echo $maxSaleResult; ?>;
            } else {
                toInput.max = <?php echo $maxResult; ?>;
                toSlider.max = <?php echo $maxResult; ?>;
                rangeMarkers[1].textContent = <?php echo $arrayRegular[0]; ?>;
                rangeMarkers[2].textContent = <?php echo $arrayRegular[1]; ?>;
                rangeMarkers[3].textContent = <?php echo $arrayRegular[2]; ?>;
                rangeMarkers[4].textContent = <?php echo $maxResult; ?>;
            }
        });
    </script>
</body>

</html>