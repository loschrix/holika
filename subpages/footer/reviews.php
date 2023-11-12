<?php
require("../../connect.php");
$basePath = '../../';
$query = 'SELECT ROUND(AVG(stars), 2) AS stars_avg, SUM(reviews) as reviews_sum FROM cosmetics;';
$countQuery = 'SELECT rate, COUNT(ID) as stars_count, ROUND(COUNT(ID)/(SELECT COUNT(ID) FROM reviews)*100) AS stars_percent FROM reviews GROUP BY rate ORDER BY rate DESC;';
$reviews_sum = mysqli_fetch_assoc(mysqli_query($connect, $query))['reviews_sum'];
$stars_avg = mysqli_fetch_assoc(mysqli_query($connect, $query))['stars_avg'];
$stars_count = mysqli_query($connect, $countQuery);
$optionsQuery = 'SELECT cosmetics.ID, cosmetics.name FROM cosmetics JOIN cosmetics_ordered ON cosmetics_ordered.cosmetics_ID = cosmetics.ID JOIN orders ON orders.ID = cosmetics_ordered.orders_ID WHERE orders.state = "dostarczono" AND cosmetics_ordered.user_ID LIKE "%%" ORDER BY LENGTH(cosmetics.name) DESC';
$reviewsQuery = 'SELECT reviews.ID, LEFT(user.name,1) AS letter, user.name AS username, rate, cosmetics.name AS name, DATE(reviews.date) AS date, title, content, GROUP_CONCAT(reviews_img.img) as imgs FROM reviews JOIN user ON user.ID = reviews.user_ID JOIN cosmetics ON cosmetics.ID = reviews.cosmetics_ID LEFT JOIN reviews_img ON reviews_img.reviews_ID = reviews.ID GROUP BY reviews.ID';
$show_reviews = mysqli_query($connect, $reviewsQuery);




$tempQuery = "SELECT cosmetics.ID, cosmetics.name FROM cosmetics ORDER BY LENGTH(cosmetics.name) DESC LIMIT 5;";
$temp_result = mysqli_query($connect, $tempQuery);


$pageName = "Recenzje";
$text = "
    <span style='
    display: flex;
    flex-direction: column;'>
        <h1>Recenzje</h1>
    </span>
    <div class='reviews-container'>
        <div class='reviews-upper-container'>
            <div class='reviews-upper-left'>
                <div class='reviews-left-left'>
                    <div class='stars' id='stars-main' data-rating='$stars_avg'>
                        <i class='fa-regular fa-star'></i>
                        <i class='fa-regular fa-star'></i>
                        <i class='fa-regular fa-star'></i>
                        <i class='fa-regular fa-star'></i>
                        <i class='fa-regular fa-star'></i>
                    </div>
                    <p>Na podstawie $reviews_sum recenzji</p>
                </div>
                <div class='reviews-left-right'>";
if ($stars_count) {
    while ($row = mysqli_fetch_assoc($stars_count)) {
        $rate = $row['rate'];
        $text .= "  <div class='count-container'>
                    <div class='white-overlay'></div>
                        <div class='stars'>";
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $rate) {
                $text .= '  <i class="fa-solid fa-star fa-sm"></i>';
            } else {
                $text .= '  <i class="fa-regular fa-star fa-sm"></i>';
            }
        }
        $text .= "      </div>
                        <div class='percentage-bar'>
                            <div class='percentage-filled' style='width: {$row['stars_percent']}%;'></div>
                        </div>
                        <p>{$row['stars_percent']}%</p>
                        <p>({$row['stars_count']})</p>
                    </div>";
    }
}
$text .= "      </div>
            </div>
            <div class='reviews-upper-right'>";
$text .=    "   <div class='show-field'>
                    <p>Oceń produkt</p>
                </div>";
$text .= "  </div>";
$text .= "
        </div>
        <select name='sortby-reviews' id='sortby-reviews'>
            <option value='pics'>Tylko ze zdjęciami</option>
            <option value='most-recent'>Najnowsze</option>
            <option value='oldest'>Najstarsze</option>
            <option value='rating-desc'>Najwyższa ocena</option>
            <option value='rating-asc'>Najniższa ocena</option>
        </select>";
$text .= "
        <form class='review-field'>
            <label for='rating'>Ocena</label>
            <div class='rating stars'>
                <i class='fa-regular fa-star' data-index='1'></i>
                <i class='fa-regular fa-star' data-index='2'></i>
                <i class='fa-regular fa-star' data-index='3'></i>
                <i class='fa-regular fa-star' data-index='4'></i>
                <i class='fa-regular fa-star' data-index='5'></i>
            </div>
            <input type='hidden' name='rate' id='rating' value='0'>
            <label for='cosmetics'>Produkt</label>
            <select name='cosmetics' id='choose-cosmetics'>";

if ($temp_result) {
    while ($row = mysqli_fetch_assoc($temp_result)) {
        $text .= "<option value='{$row['ID']}'>{$row['name']}</option>";
    }
}

$text .= "  </select>
            <label for='title'>Tytuł</label>
            <input type='text' name='title' placeholder='Wpisz tytuł'>
            <label for='content' id='label_review'>Recenzja (1000)</label>
            <textarea name='content' class='textarea-content' placeholder='Wpisz treść recenzji' maxlength='1000'></textarea>
            <label for='imgs'>Zdjęcia (opcjonalnie)</label>
            <div class='img-wrapper'>
                <div class='input-redirect' onclick=\"document.querySelector('#imgs').click()\">
                    <i class='fa-solid fa-camera fa-2xl'></i>
                </div>
                <input type='file' id='imgs' name='imgs[]' accept='image/*' multiple>
                <div class='img-container'></div>
            </div>
            <p style='margin-top: -.1%; font-size: 0.8em;'>max 5 zdjęć</p>
            <div id='error-box'>
            <div id='error-review'>
                <p class='error-contact'></p>
            </div>
            </div>
            <button type='submit' id='add-review'>Wstaw recenzję</button>
        </form>
        <div class='uploaded-reviews'>";
if ($show_reviews) {

    while ($row = mysqli_fetch_assoc($show_reviews)) {
        $content = nl2br($row['content']);
        $imgsArray = explode(",", $row['imgs']) ?? null;

        $polishChars = ['ą', 'ć', 'ę', 'ł', 'ń', 'ó', 'ś', 'ź', 'ż'];
        $englishChars = ['a', 'c', 'e', 'l', 'n', 'o', 's', 'z', 'z'];
        $productName = str_replace($polishChars, $englishChars, $row['name']);
        $productName = strtolower(str_replace(' ', '', $productName));

        $text .= "
            <div class='review'>
                <div class='top-review'>
                    <div class='avatar'><p>{$row['letter']}</p></div>
                    <div class='top-right-review'>
                        <div class='top-top-review'>
                            <div class='stars' data-rate='{$row['rate']}'>";
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $row['rate']) {
                $text .= '      <i class="fa-solid fa-star fa-sm"></i>';
            } else {
                $text .= '      <i class="fa-regular fa-star fa-sm"></i>';
            }
        }
        $text .= "          </div>
                            <div class='review-info'>
                                <p data-reviewDate='{$row['date']}'>{$row['date']} o <a href='$productName'>{$row['name']}</a></p>
                            </div>";
        $text .= "              <i class='fa-regular fa-circle-xmark fa-xl delete-review' data-id='{$row['ID']}' style='color: #f27474; position: absolute; right: .2%; top: 1%; cursor: pointer;'></i>";
        $text .=            "</div>
                        <strong>{$row['username']}</strong>
                    </div>
                </div>
                <div class='review-text'>
                    <strong>{$row['title']}</strong>
                    <p>$content</p>
                </div>";
        if ($imgsArray[0] != null) {
            $text .= "
                <div class='review-imgs'>";
            foreach ($imgsArray as $imgPath) {
                $imgPath = $basePath . $imgPath;
                $text .= "
                    <div class='img-shown-wrapper'>
                        <div class='white-overlay'></div>
                        <img src='$imgPath' class='img-shown-review'>
                    </div>";
            }
            $text .= "
                </div>";
        }
        $text .= "
            </div>";
    }
}
$text .= "
        </div>
    </div>"; ?>

<?php include "footerTemplate.php" ?>

<style>
    .swal2-popup .swal2-styled:focus {
        box-shadow: none !important;
    }

    #error-review {
        display: none;
    }

    .context {
        width: 80%;
    }

    #imgs {
        display: none;
    }

    .img-wrapper {
        display: flex;
        flex-direction: row;
        height: 15vh;
        width: 100%;
    }

    .review-imgs {
        display: flex;
        flex-direction: row;
        height: 15vh;
        width: 100%;
    }

    .img-shown-wrapper {
        position: relative;
        height: 100%;
        cursor: pointer;
        margin-right: 1%;
    }

    .img-shown-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        border-radius: 4px;
    }

    .img-container>* {
        margin-right: 1%;
    }

    .img-container {
        display: flex;
        flex-direction: row;
        height: 100%;
        width: 80%;
    }

    .input-redirect {
        background-color: #fff;
        box-sizing: border-box;
        border: 1px solid #e0e0e0;
        height: 100%;
        width: 8vw;
        margin-right: 2%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #000;
        cursor: pointer;
    }

    #add-review {
        margin-top: 2vh;
        box-sizing: border-box;
        border: 1px solid #ff7bac;
        text-align: center;
        color: #ff7bac;
        background-color: #fff;
        font-family: Poppins;
        width: 15%;
        padding: 1%;
        font-size: 1em;
        cursor: pointer;
    }

    .review-field,
    .review-field textarea {
        display: flex;
        flex-direction: column;
        border-top: 1px solid #e0e0e0;
        font-size: 1.2rem;
    }

    .review-field input,
    .review-field textarea {
        font-family: Poppins;
        height: 4vh;
        padding-left: 1%;
        border: 1px solid #e0e0e0;
    }

    .review-field textarea {
        box-sizing: border-box;
        height: 12vh;
        width: 100%;
        resize: none;
    }

    .review-field label {
        margin-bottom: 1vh;
        margin-top: 2vh;
    }

    .review-field input::placeholder {
        padding-left: .5%;
    }

    .review-field input,
    .rating {
        font-size: 1.2rem;
    }

    .rating * {
        cursor: pointer;
    }

    .rating {
        user-select: none;
    }

    #rating {
        display: none;
    }

    .stars {
        color: #d79614;
    }

    .show-field {
        box-sizing: border-box;
        border: 1px solid #ff7bac;
        width: 8vw;
        text-align: center;
        color: #ff7bac;
    }

    .show-field:hover {
        cursor: pointer;
    }

    .reviews-container,
    .reviews-left-right,
    .review,
    .review-text,
    .top-right-review {
        display: flex;
        flex-direction: column;
    }

    .reviews-upper-container,
    .reviews-upper-left,
    .count-container,
    .reviews-upper-container,
    .top-review,
    .top-top-review,
    .avatar {
        display: flex;
        flex-direction: row;
    }

    .uploaded-reviews {
        margin-top: 2vh;
        width: 90%;
        max-height: 130vh;
        overflow-y: auto;
        padding-right: 2px;
    }

    .review-field {
        margin-bottom: 2vh;
    }

    .review {
        border-top: 1px solid #e0e0e0;
        padding-top: 2vh;
        width: 100%;
        padding-bottom: 2vh;
    }

    .top-review {
        width: 100%;
        margin-bottom: 2vh;
        position: relative;
    }

    .top-right-review {
        width: 80%;
    }

    .review-text strong {
        font-size: 1.2rem;
    }

    .review-text p {
        margin-top: .5%;
    }

    .top-top-review,
    .avatar {
        align-items: center;
    }

    .top-right-review strong {
        margin-top: -1%;
    }

    .avatar {
        justify-content: center;
        background-color: #e0e0e0;
        border-radius: 50%;
        width: 3.5vw;
        height: 6.8vh;
        user-select: none;
        margin-right: .7%;
    }

    .review-info a {
        color: #ff7bac;
    }

    .top-top-review {
        margin-top: -1%;
        width: 60%;
    }



    .review .stars {
        margin-right: 1%;
        width: 16%;
    }

    .reviews-upper-container {
        width: 100%;
        height: 16vh;
        justify-content: space-between;
        padding-bottom: 2vh;
    }

    .reviews-upper-left {
        height: 100%;
    }

    .reviews-left-right {
        height: 100%;
        box-sizing: border-box;
        border-right: 1px solid #e0e0e0;
        padding-right: 1%;
    }

    .count-container {
        height: 3vh;
        align-items: center;
        margin-top: 1%;
        position: relative;
    }

    .count-container p:first-of-type {
        width: 2vw;
    }

    .count-container .stars {
        padding-left: 8px;
        width: 5.3vw;
    }

    .percentage-bar {
        height: 95%;
        width: 6vw;
        box-sizing: border-box;
        border: 1px solid #e0e0e0;
        position: relative;
    }

    .percentage-filled {
        position: absolute;
        background-color: #fbcd0a;
        height: 100%;
    }

    .count-container>* {
        margin-right: 10px;
    }

    .reviews-left-left {
        padding-right: 2%;
        margin-right: 2%;
        border-right: 1px solid #e0e0e0;
    }

    .white-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0);
        transition: background-color 0.3s ease;
        pointer-events: none;
    }

    .count-container:hover .white-overlay,
    .img-container div:hover .white-overlay,
    .img-shown-wrapper:hover .white-overlay {
        background-color: rgba(255, 255, 255, 0.3);
    }

    .count-container * {
        cursor: pointer;
    }

    #sortby-reviews,
    #choose-cosmetics {
        font-family: Poppins;
        width: 10%;
        background-color: #fff;
        border: 1px solid #e0e0e0;
        margin-bottom: 2vh;
    }

    #choose-cosmetics {
        margin-bottom: 0;
        width: 18%;
    }

    #sortby-reviews option,
    #choose-cosmetics option {
        background-color: #e0e0e0;
        box-shadow: none;
    }
</style>

<script src="<?= $basePath ?>script/stars.js"></script>
<script src="<?= $basePath ?>script/review_stars.js"></script>
<script src="<?= $basePath ?>script/imgs_handler.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/validate.js/0.13.1/validate.min.js"></script>
<script>
    //Review field show start
    const showFieldButton = document.querySelector('.show-field');
    const reviewField = document.querySelector('.review-field');
    reviewField.style.transition = 'opacity 0.3s ease-in-out';
    reviewField.style.opacity = '0';
    reviewField.style.display = 'none';

    showFieldButton.addEventListener('click', () => toggleSection(reviewField));

    function toggleSection(container) {
        if (container.style.opacity === '1') {
            container.style.opacity = '0';
            container.style.display = 'none';
            showFieldButton.innerHTML = "<p>Oceń produkt</p>";
        } else {
            container.style.display = 'flex';
            container.style.opacity = '1';
            showFieldButton.innerHTML = "<p>Anuluj recenzję</p>";
        }
    }
    //Review field show end


    //Update max characters start
    document.querySelector(".textarea-content").addEventListener("input", function() {
        const textarea = document.querySelector(".textarea-content");
        let remainingCharacters = textarea.maxLength - textarea.value.length;
        document.querySelector("#label_review").textContent = `Recenzja (${remainingCharacters})`;
    });
    //Update max characters end

    //Handle errors when submitting review start
    const constraints = {
        rate: {
            numericality: {
                greaterThan: 0,
                message: 'Ocena nie może być pusta. Wybierz ocenę'
            }
        },
        title: {
            presence: {
                allowEmpty: false,
                message: 'Tytuł jest nieuzupełniony. Uzupełnij tytuł'
            }
        },
        content: {
            presence: {
                allowEmpty: false,
                message: 'Recenzja nie może być pusta. Uzupełnij recenzję'
            }
        },
    };

    const form = document.querySelector('.review-field');
    // const thankYouBox = document.querySelector('#thankyou-box');


    form.addEventListener('submit', function(event) {
        const formValues = {
            rate: form.elements.rate.value,
            title: form.elements.title.value,
            content: form.elements.content.value
        };

        const errors = validate(formValues, constraints);

        if (errors) {
            event.preventDefault();
            document.querySelector('#error-review').style.display = "block";
            document.querySelector('#error-review').innerHTML = Object.values(errors)
                .map(fieldValues => fieldValues.map(error => `<p class="error-contact">${error.split(' ').slice(1).join(' ')}</p>`).join(''))
                .join('');
        } else {
            document.querySelector('#error-review').style.display = "none";
            document.querySelector('#error-review').innerHTML = '';
        }

    });
    //Handle errors when submitting review end

    //Sort reviews start
    const sortSelect = document.querySelector('#sortby-reviews');
    const reviewsContainer = document.querySelector('.uploaded-reviews');

    sortSelect.addEventListener('change', function() {
        const selectedValue = sortSelect.value;
        const reviews = document.querySelectorAll('.review');

        reviews.forEach((review) => {
            review.style.display = 'flex';
        });

        if (selectedValue === 'pics') {
            filterReviewsByImages();
        } else if (selectedValue === 'rating-desc' || selectedValue === 'rating-asc') {
            sortReviewsByRating(selectedValue);
        } else if (selectedValue === 'most-recent' || selectedValue === 'oldest') {
            sortReviewsByDate(selectedValue);
        }

        function filterReviewsByImages() {
            const reviewsWithImages = document.querySelectorAll('.review:has(.review-imgs)');
            const reviewsWithoutImages = document.querySelectorAll('.review:not(:has(.review-imgs))');

            reviewsWithImages.forEach((review) => {
                review.style.display = 'flex';
            });

            reviewsWithoutImages.forEach((review) => {
                review.style.display = 'none';
            });
        }

        function sortReviewsByRating(order) {
            const sortedReviews = Array.from(reviews).sort((a, b) => {
                const ratingA = parseInt(a.querySelector('.stars').getAttribute('data-rate'));
                const ratingB = parseInt(b.querySelector('.stars').getAttribute('data-rate'));

                return order === 'rating-desc' ? ratingB - ratingA : ratingA - ratingB;
            });

            updateReviewsContainer(sortedReviews);
        }

        function sortReviewsByDate(order) {
            const sortedReviews = Array.from(reviews).sort((a, b) => {
                const dateA = new Date(a.querySelector('.review-info p').getAttribute('data-reviewDate'));
                const dateB = new Date(b.querySelector('.review-info p').getAttribute('data-reviewDate'));

                return order === 'most-recent' ? dateB - dateA : dateA - dateB;
            });

            updateReviewsContainer(sortedReviews);
        }

        function updateReviewsContainer(reviews) {
            reviewsContainer.innerHTML = '';
            reviews.forEach((review) => {
                reviewsContainer.appendChild(review);
            });
        }
    });
    //Sort reviews end

    //Delete review start
    let deleteBTNS = document.querySelectorAll(".delete-review");

    deleteBTNS.forEach((deleteBTN) => {
        deleteBTN.addEventListener("click", function() {
            const reviewId = this.getAttribute('data-id');

            Swal.fire({
                title: "Jesteś pewny?",
                text: "Tego procesu nie można odwrócić!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Tak, usuń to!",
                cancelButtonText: "Nie, anuluj!",
                confirmButtonColor: "#f27474",
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', 'deleteReview.php', true);
                    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            const response = JSON.parse(xhr.responseText);
                            if (response.success) {
                                Swal.fire({
                                    title: 'Usunięto!',
                                    text: 'Recenzja została usunięta.',
                                    icon: 'success',
                                    confirmButtonColor: '#ff7bac',
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: 'Błąd',
                                    text: 'Wystąpił błąd podczas usuwania recenzji.',
                                    icon: 'error',
                                    confirmButtonColor: '#ff7bac',
                                });
                            }
                        }
                    };
                    xhr.send(`reviewId=${reviewId}`);
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire({
                        title: "Anulowano",
                        text: "Anulowano usunięcie recenzji.",
                        icon: "error",
                        confirmButtonColor: "#ff7bac",
                    });
                }
            });
        });
    });

    //Delete review end
</script>