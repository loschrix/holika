<div class="footer">
    <div class="footer-content">
        <div>
            <p>INFORMACJE</p>
            <ul>
                <li><a href="<?= $basePath ?>subpages/footer/reviews.php">Recenzje</a></li>
            </ul>

        </div>
        <div>
            <p>SERWIS</p>
            <ul>
                <li><a href="<?= $basePath ?>subpages/footer/orderTrack.php">Śledz moje zamówienie</a></li>
                <li><a href="<?= $basePath ?>subpages/footer/faq.php">FAQ</a></li>
                <li><a href="<?= $basePath ?>subpages/footer/shipping.php">Polityka dostaw</a></li>
                <li><a href="<?= $basePath ?>subpages/footer/privacy.php">Polityka prywatności</a></li>
                <li><a href="<?= $basePath ?>subpages/footer/refund.php">Polityka zwrotów</a></li>
                <li><a href="<?= $basePath ?>subpages/footer/tos.php">Warunki użytkowania</a></li>
                <li><a href="<?= $basePath ?>subpages/footer/contact.php">Skontaktuj się z nami</a></li>
            </ul>
        </div>
        <div>
            <p>ZAOBSERWUJ NAS</p>
            <div class="icons">
                <i class="fa-brands fa-facebook-f fa-2xl"><a href="" id="fb"></a></i>
                <i class="fa-brands fa-twitter fa-2xl"><a href="" id="twitter"></a></i>
                <i class="fa-brands fa-instagram fa-2xl"><a href="" id="ig"></a></i>
                <i class="fa-brands fa-tiktok fa-2xl"><a href="" id="tiktok"></a></i>
            </div>
        </div>
        <div>
            <p>ZAPISZ SIĘ</p>
            <div>
                <p>Zapisz się do naszego comiesięcznego biuletynu, aby otrzymywać informacje o nadchodzących promocjach
                </p>
                <form action="" method="post" id="subForm">
                    <div class="subscribe">
                        <i class="fa-regular fa-envelope fa-xl"></i>
                        <input type="text" placeholder="Wpisz Email" id="subscribe" name="username" required>
                    </div>
                    <button type="submit">ZASUBSKRYBUJ</button>
                </form>
            </div>
        </div>
    </div>
    <div class="footer-payments">
        <img src="<?= $basePath ?>images/payments/amex.svg" alt="">
        <img src="<?= $basePath ?>images/payments/applepay.png" alt="">
        <img src="<?= $basePath ?>images/payments/mastercard.svg" alt="">
        <img src="<?= $basePath ?>images/payments/paypal.png" alt="">
        <img src="<?= $basePath ?>images/payments/visa.svg" alt="">
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#searchForm").on("input", function() {
            let query = $(this).val().trim();
            $(".tWrapper").empty();
            $(".cWrapper").empty();
            if (query) {
                search(query);
            }
        });
    });

    function search(query) {
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                let results = JSON.parse(xhr.responseText);
                displayResults(results);
            }
        };

        xhr.open("GET", `<?= $basePath ?>subpages/search.php?searchTerm=${query}`, true);
        xhr.send();
    }

    function displayResults(results) {
        document.querySelector("#searchResults").style.display = "flex";
        document.querySelector("#cosmeticsResults").style.display = "none";
        document.querySelector("#typeResults").style.display = "none";

        let cosmeticsResults = [];
        let typeResults = [];

        for (let i = 0; i < results.length; i++) {
            if (results[i].source === 'cosmetics') {
                cosmeticsResults.push(results[i]);
            } else if (results[i].source === 'type') {
                typeResults.push(results[i]);
            }
        }

        cosmeticsResults = cosmeticsResults.map(function(result) {
            let r = Object.assign({}, result);
            delete r.source;
            return r;
        });

        typeResults = typeResults.map(function(result) {
            let r = Object.assign({}, result);
            delete r.source;
            return r;
        });

        if (typeResults.length > 0) {
            document.querySelector("#typeResults").style.display = "flex";
        }

        if (cosmeticsResults.length > 0) {
            document.querySelector("#cosmeticsResults").style.display = "flex";
        }

        let groupedResults = [];
        for (let i = 0; i < cosmeticsResults.length; i += 2) {
            groupedResults.push(cosmeticsResults.slice(i, i + 2));
        }

        groupedResults.forEach((group) => {
            let cRow = document.createElement('div');
            cRow.className = 'cRow';

            group.forEach((result) => {
                const polishChars = ['ą', 'ć', 'ę', 'ł', 'ń', 'ó', 'ś', 'ź', 'ż'];
                const englishChars = ['a', 'c', 'e', 'l', 'n', 'o', 's', 'z', 'z'];
                let productName = result.name;

                for (let i = 0; i < polishChars.length; i++) {
                    const regex = new RegExp(polishChars[i], 'g');
                    productName = productName.replace(regex, englishChars[i]);
                }

                productName = productName.toLowerCase().replace(/\s/g, '');
                productName = `<?= $basePath ?>${productName}`;
                result.img = `<?= $basePath ?>${result.img}`;


                let newDiv = document.createElement('div');
                newDiv.className = 'cosmeticsResult';
                innerHTML = `
                <div class='left-cosmetic'>
                    <img src="${result.img}" alt="${result.name}">
                </div>
                <div class='right-cosmetic'>
                    <a href='${productName}'>${result.name}</a>`;

                if (result.price_after == null) {
                    innerHTML += `<p>${result.price}zł</p></div>`;
                } else {
                    innerHTML += `<div class='prices' style='display: flex; flex-direction: row;'><s>${result.price}zł</s><p>${result.price_after}zł</p></div></div>`;
                }
                newDiv.innerHTML = innerHTML;
                cRow.appendChild(newDiv);
            });

            document.querySelector(".cWrapper").appendChild(cRow);
        });

        let href = `<?= $basePath ?>subpages/products/searchsite.php?q=${$("#searchForm").val().trim()}`;
        document.querySelector(".cWrapper").innerHTML += `<a href='${href}' style='cursor: pointer;'>Wszystkie wyniki <i class='fa-solid fa-arrow-right-long' style='cursor: pointer;'></i></a>`;
        document.querySelector(".mglass").href = href;

        typeResults.forEach((result) => {
            console.log(result.name)
            let matchingLink = document.querySelector(`a[data-type="${result.name}"]`);
            document.querySelector(".tWrapper").innerHTML += `<a href=${matchingLink}>${result.name}</a>`;
        });
    }
</script>