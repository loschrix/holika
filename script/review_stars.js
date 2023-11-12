const stars = document.querySelectorAll(".rating i");
let selectedRating = 0;

stars.forEach((star) => {
  star.addEventListener("mouseover", starHover);
  star.addEventListener("mouseout", resetStars);
  star.addEventListener("click", starClick);
});

function starHover() {
  const index = this.getAttribute("data-index");
  highlightStars(index);
}

function resetStars() {
  if (selectedRating === 0) {
    highlightStars(0);
  } else {
    highlightStars(selectedRating);
  }
}

function starClick() {
  const index = this.getAttribute("data-index");
  setRating(index);
}

function highlightStars(index) {
  stars.forEach((star, i) => {
    if (i < index) {
      star.className = "";
      star.classList.add("fa-solid", "fa-star");
    } else {
      star.className = "";
      star.classList.add("fa-regular", "fa-star");
    }
  });
}

function setRating(index) {
  const ratingInput = document.getElementById("rating");
  ratingInput.value = index;
  selectedRating = index;
  highlightStars(index);
}
