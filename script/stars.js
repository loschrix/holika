function setStarsRating(rating, starsId) {
  const starsContainer = document.getElementById(starsId);
  const stars = Array.from(starsContainer.children);

  const fullStars = Math.floor(rating);
  const decimalPart = rating - fullStars;

  stars.forEach((star, index) => {
    if (index < fullStars) {
      star.className = "";
      star.classList.add("fa-solid", "fa-star");
    } else if (
      index === fullStars &&
      decimalPart >= 0.33 &&
      decimalPart <= 0.66
    ) {
      star.className = "";
      star.classList.add("fa-solid", "fa-star-half-stroke");
    } else if (index === fullStars && decimalPart > 0.66) {
      star.className = "";
      star.classList.add("fa-solid", "fa-star");
    } else {
      star.className = "";
      star.classList.add("fa-regular", "fa-star");
    }
  });
}

document.addEventListener("DOMContentLoaded", function () {
  const products = document.querySelectorAll(".product");

  products.forEach((product) => {
    const rating = parseFloat(product.dataset.rating);
    const id = product.querySelector(".stars").id;
    setStarsRating(rating, id);
  });

  setStarsRating(
    document.querySelector("#stars-main").dataset.rating,
    "stars-main"
  );
});
