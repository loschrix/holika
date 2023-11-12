//Sorting products start
//Global declarations
let allProducts = Array.from(document.querySelectorAll(".products .product"));
let boldP = document.querySelector(
  '.sort-by-options p[style*="font-weight: bold;"]'
);

function sortProducts(key, order, selector, clickedElement, saleProducts) {
  saleProducts.sort((a, b) => {
    let valueA = getValue(a, selector);
    let valueB = getValue(b, selector);

    if (key === "date") {
      valueA = new Date(valueA);
      valueB = new Date(valueB);
    }

    if (key === "name") {
      return order === "asc"
        ? valueA.localeCompare(valueB)
        : valueB.localeCompare(valueA);
    }

    return order === "asc" ? valueA - valueB : valueB - valueA;
  });

  let currentIndex = 0;

  const productsContainers = document.querySelectorAll(".products");

  productsContainers.forEach((productsContainer) => {
    productsContainer.style.display = "flex";
    productsContainer.innerHTML = "";

    for (let i = 0; i < 3 && currentIndex < saleProducts.length; i++) {
      productsContainer.appendChild(saleProducts[currentIndex]);
      currentIndex++;
    }
  });

  document.querySelectorAll(".sort-by-options p").forEach((element) => {
    element.style.fontWeight = "normal";
  });

  clickedElement.style.fontWeight = "bold";
}
//Sorting products end

//Range slider functionality start

function getValue(element, selector) {
  if (selector === ".price") {
    return parseFloat(
      element.querySelector(selector).textContent.replace("zł", "")
    );
  } else if (selector === ".stars") {
    return parseInt(element.querySelector(selector).id.replace("stars_", ""));
  } else if (selector === "[data-date]") {
    return element.dataset.date;
  } else if (selector === ".product-name") {
    return element.querySelector(selector).textContent.toLowerCase();
  } else if (selector === "[data-rating]") {
    return parseFloat(element.dataset.rating);
  }
}

function controlFromInput(fromSlider, fromInput, toInput, controlSlider) {
  const [from, to] = getParsed(fromInput, toInput);
  fillSlider(fromInput, toInput, "#a1a1a1", "#000", controlSlider);
  if (from > to) {
    fromSlider.value = to;
    fromInput.value = to;
  } else {
    fromSlider.value = from;
  }
}

function controlToInput(toSlider, fromInput, toInput, controlSlider) {
  const [from, to] = getParsed(fromInput, toInput);
  fillSlider(fromInput, toInput, "#a1a1a1", "#000", controlSlider);
  setToggleAccessible(toInput);
  if (from <= to) {
    toSlider.value = to;
    toInput.value = to;
  } else {
    toInput.value = from;
  }
}

function controlFromSlider(fromSlider, toSlider, fromInput) {
  const [from, to] = getParsed(fromSlider, toSlider);
  fillSlider(fromSlider, toSlider, "#a1a1a1", "#000", toSlider);
  if (from > to) {
    fromSlider.value = to;
    fromInput.value = to;
  } else {
    fromInput.value = from;
  }
}

function controlToSlider(fromSlider, toSlider, toInput) {
  const [from, to] = getParsed(fromSlider, toSlider);
  fillSlider(fromSlider, toSlider, "#a1a1a1", "#000", toSlider);
  setToggleAccessible(toSlider);
  if (from <= to) {
    toSlider.value = to;
    toInput.value = to;
  } else {
    toInput.value = from;
    toSlider.value = from;
  }
}

function getParsed(currentFrom, currentTo) {
  const from = parseInt(currentFrom.value, 10);
  const to = parseInt(currentTo.value, 10);
  return [from, to];
}

function fillSlider(from, to, sliderColor, rangeColor, controlSlider) {
  const rangeDistance = to.max - to.min;
  const fromPosition = from.value - to.min;
  const toPosition = to.value - to.min;
  controlSlider.style.background = `linear-gradient(
          to right,
          ${sliderColor} 0%,
          ${sliderColor} ${(fromPosition / rangeDistance) * 100}%,
          ${rangeColor} ${(fromPosition / rangeDistance) * 100}%,
          ${rangeColor} ${(toPosition / rangeDistance) * 100}%, 
          ${sliderColor} ${(toPosition / rangeDistance) * 100}%, 
          ${sliderColor} 100%)`;
}

function setToggleAccessible(currentTarget) {
  const toSlider = document.querySelector("#toSlider");
  if (Number(currentTarget.value) <= 0) {
    toSlider.style.zIndex = 2;
  } else {
    toSlider.style.zIndex = 0;
  }
}

const fromSlider = document.querySelector("#fromSlider");
const toSlider = document.querySelector("#toSlider");
const fromInput = document.querySelector("#fromInput");
const toInput = document.querySelector("#toInput");
fillSlider(fromSlider, toSlider, "#a1a1a1", "#000", toSlider);
setToggleAccessible(toSlider);

fromSlider.oninput = () => controlFromSlider(fromSlider, toSlider, fromInput);
toSlider.oninput = () => controlToSlider(fromSlider, toSlider, toInput);

fromSlider.addEventListener("mouseup", () => start());
toSlider.addEventListener("mouseup", () => start());

fromInput.onblur = () => {
  controlFromInput(fromSlider, fromInput, toInput, toSlider);
  start();
};
toInput.onblur = () => {
  controlToInput(toSlider, fromInput, toInput, toSlider);
  start();
};

fromInput.addEventListener("input", function () {
  this.value = this.value.replace(/[^0-9]/g, "");
});

toInput.addEventListener("input", function () {
  this.value = this.value.replace(/[^0-9]/g, "");
});
//Range slider functionality end

//Range price start
function rangePrice() {
  let fitProducts = [];

  allProducts.forEach(function (product) {
    const productPrice = product
      .querySelector(".price")
      .textContent.replace("zł", "");
    if (
      Math.floor(productPrice) >= parseInt(fromInput.value) &&
      Math.ceil(productPrice) <= parseInt(toInput.value)
    ) {
      fitProducts.push(product);
    }
  });

  return fitProducts;
}

function filterBySale(fitProducts) {
  let saleProducts = [];

  fitProducts.forEach(function (product) {
    const isOnSale = product.querySelector("s") !== null;

    if (isOnSale) {
      saleProducts.push(product);
    }
  });

  return saleProducts;
}

function start() {
  all(...bold());
}

function all(by, order, id, p) {
  let fitProducts = rangePrice();
  let abProducts = ab(fitProducts);
  if (document.querySelector("#sale").checked) {
    let saleProducts = filterBySale(abProducts);
    sortProducts(by, order, id, p, saleProducts);
  } else {
    sortProducts(by, order, id, p, abProducts);
  }

  const productsContainers = document.querySelectorAll(".products");

  productsContainers.forEach((productsContainer) => {
    if (productsContainer.childNodes.length === 0) {
      productsContainer.style.display = "none";
    }
  });
}

function bold() {
  boldP = document.querySelector(
    '.sort-by-options p[style*="font-weight: bold;"]'
  );
  if (boldP) {
    let arguments = [];
    arguments.push(boldP.dataset.sortby);
    arguments.push(boldP.dataset.sortorder);
    arguments.push(boldP.dataset.selector);
    arguments.push(boldP);
    return arguments;
  } else {
    const arguments = ["id", "asc", ".stars", document.querySelector("#def")];
    return arguments;
  }
}

const allPElements = document.querySelectorAll(".sort-by-options p");

allPElements.forEach(function (pElement) {
  pElement.addEventListener("click", function () {
    const sortBy = this.dataset.sortby;
    const sortOrder = this.dataset.sortorder;
    const selector = this.dataset.selector;
    const clickedElement = this;

    all(sortBy, sortOrder, selector, clickedElement);
  });
});

document.querySelector("#sale").addEventListener("change", function () {
  start();
  controlToInput(toSlider, fromInput, toInput, toSlider);
  controlFromInput(fromSlider, fromInput, toInput, toSlider);
});

document.querySelector("#availability").addEventListener("change", function () {
  start();
});

document.querySelector("#clear").addEventListener("click", function (event) {
  event.stopPropagation();
  fromInput.value = fromInput.min;
  toInput.value = toInput.max;
  fromSlider.value = fromSlider.min;
  toSlider.value = toSlider.max;
  controlToInput(toSlider, fromInput, toInput, toSlider);
  controlFromInput(fromSlider, fromInput, toInput, toSlider);
  start();
});

function ab(fitProducts) {
  let abProducts = [];
  if (document.querySelector("#availability").checked) {
    fitProducts.forEach(function (product) {
      if (parseInt(product.dataset.quantity) > 0) {
        abProducts.push(product);
      }
    });
    return abProducts;
  } else {
    return fitProducts;
  }
}

if (window.location.pathname.includes("searchsite.php")) {
  const searchQuery = getSearchQuery();
  allProducts = allProducts.filter((product) =>
    product
      .querySelector(".product-name")
      .textContent.toLowerCase()
      .includes(searchQuery.toLowerCase())
  );
  start();
}

function getSearchQuery() {
  const urlParams = new URLSearchParams(window.location.search);
  return urlParams.get("q") || "";
}
//Range price end
