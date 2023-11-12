//Navbar different on scrollY value start
let navbar = document.querySelector(".navbar");

window.addEventListener("scroll", function () {
  if (scrollY > 0) {
    navbar.classList.add("scroll");
  } else {
    navbar.classList.remove("scroll");
  }
});
//Navbar end

//Sidecart (search, account, cart) start
function openElement(element) {
  element.style.right = 0;
  document.body.classList.add("no-scroll");
  const overlay = document.createElement("div");
  overlay.classList.add("overlay");
  document.body.appendChild(overlay);
  overlay.addEventListener("click", () => closeElement(element));
}

function closeElement(element) {
  element.style.right = "-50%";
  document.body.classList.remove("no-scroll");
  const overlay = document.querySelector(".overlay");
  if (overlay) overlay.remove();

  // Setting sidecart back to login, when closing the sidecart
  setTimeout(() => {
    const lC = document.querySelector(".login-container");
    const rC = document.querySelector(".register-container");
    const pC = document.querySelector(".password-container");
    rC.classList.remove("active");
    pC.classList.remove("active");
    lC.classList.add("active");
  }, 300);
}

const elements = {
  search: document.querySelector(".search"),
  account: document.querySelector(".account"),
  cart: document.querySelector(".cart"),
};

document
  .querySelector(".navbar-search")
  .addEventListener("click", () => openElement(elements.search));
document
  .querySelector(".navbar-account")
  .addEventListener("click", () => openElement(elements.account));
document
  .querySelector(".navbar-cart")
  .addEventListener("click", () => openElement(elements.cart));

const close_btns = document.querySelectorAll(".close-btn");
close_btns.forEach((close_btn) => {
  close_btn.addEventListener("click", (event) => {
    const target = event.target;
    const parent = target.parentNode;
    closeElement(parent);
  });
});

document.body.addEventListener("click", (event) => {
  if (event.target.classList.contains("overlay")) {
    for (const key in elements) {
      closeElement(elements[key]);
    }
  }
});
//Sidecart end

//Account sidecart switch start
const toggleDiv = (containerId) => {
  const containers = [
    ".login-container",
    ".register-container",
    ".password-container",
  ];
  containers.forEach((container) => {
    const div = document.querySelector(container);
    div.classList.toggle("active", container === "." + containerId);
  });
};

document
  .querySelector("#toRegister")
  .addEventListener("click", () => toggleDiv("register-container"));
document
  .querySelector("#toLogin")
  .addEventListener("click", () => toggleDiv("login-container"));
document
  .querySelector("#toPassword")
  .addEventListener("click", () => toggleDiv("password-container"));
//Account sidecart switch end

//toTheTop button start
let toTheTop = document.querySelector("#toTheTop");

window.addEventListener("scroll", function () {
  if (scrollY > 0) {
    toTheTop.classList.add("show");
  } else {
    toTheTop.classList.remove("show");
  }
});

toTheTop.addEventListener("click", function (event) {
  event.preventDefault();
  window.scrollTo({ top: 0, behavior: "smooth" });
});
//toThetTop button end
