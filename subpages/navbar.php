<div class="navbar">
    <div class="navbar-left">
        <div class="navbar-products">
            <a href='<?= $basePath ?>subpages/products/allproducts.php'>Wszystkie produkty</a> <i class="fa-solid fa-chevron-down"></i>
            <div class="products-dropdown">
                <ul class="products-dropdown-list">
                    <li><a href="<?= $basePath ?>subpages/products/moisture.php" data-type='Nawilżenie'>Nawilżenie 🌊</a></li>
                    <li id="oczyszczanie">
                        <a href="<?= $basePath ?>subpages/products/cleansing.php" data-type='Oczyszczanie'>Oczyszczanie ✨</a>
                        <ul class="oczyszczanie">
                            <li><a href="<?= $basePath ?>subpages/products/eggsoap.php" data-type='Egg soap'>Egg Soap 🥚</a></li>
                            <li><a href="<?= $basePath ?>subpages/products/foam.php" data-type='Pianka'>Pianka 🧼</a></li>
                        </ul>
                    </li>
                    <li id="maseczki">
                        <a href="<?= $basePath ?>subpages/products/masks.php" data-type='Maseczki'>Maseczki 🎭</a>
                        <ul class="maseczki">
                            <li><a href="<?= $basePath ?>subpages/products/pureessence.php" data-type='Pure essence'>Pure Essence 🌺</a></li>
                            <li><a href="<?= $basePath ?>subpages/products/after.php" data-type='After'>After 🌙</a></li>
                            <li><a href="<?= $basePath ?>subpages/products/honey.php" data-type='Honey'>Honey 🍯</a></li>
                        </ul>
                    </li>
                    <li><a href="<?= $basePath ?>subpages/products/other.php" data-type="Inne">Inne 🌈</a></li>
                </ul>
            </div>
        </div>
        <div class="navbar-collection">
            <a href="<?= $basePath ?>subpages/products/amongus.php" data-type='Among us'>Among Us 🚀</a>
            <a href="<?= $basePath ?>subpages/products/pureessence.php" data-type='Pure essence'>Pure Essence 🌺</a>
        </div>
    </div>
    <div class="navbar-center">
        <div class="navbar-center-img">
            <a id="hov" href="<?= $basePath ?>index.php">&nbsp;</a>
        </div>
    </div>
    <div class="navbar-right">
        <div class="navbar-search">
            <i class="fa-solid fa-magnifying-glass fa-xl"></i>
        </div>
        <div class="navbar-account">
            <i class="fa-solid fa-user fa-xl"></i>
        </div>
        <div class="navbar-cart">
            <span id="counter">0</span>
            <i class="fa-solid fa-cart-shopping fa-xl"></i>
        </div>
    </div>
</div>