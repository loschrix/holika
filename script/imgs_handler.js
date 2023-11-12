//Multiple imgs handler start
const fileInput = document.querySelector("#imgs");
const previewContainer = document.querySelector(".img-container");

fileInput.addEventListener("change", handleFileSelect);

function handleFileSelect(event) {
  const files = event.target.files;

  if (files.length + previewContainer.childElementCount > 5) {
    Swal.fire({
      icon: "error",
      title: "Błąd!",
      text: "Limit 5 plików został osiągnięty!",
      confirmButtonColor: "#ff7bac",
      color: "#000",
      confirmButtonText: "OK",
    }).then((result) => {
      if (result.isConfirmed) {
        fileInput.value = "";
      }
    });
    return;
  }

  for (const file of files) {
    const fileType = file.type.split("/")[0];

    if (fileType === "image") {
      const reader = new FileReader();
      reader.onload = function (e) {
        const img = document.createElement("img");
        img.src = e.target.result;
        img.alt = file.name;
        img.style.cssText = "width: 100%; height: 100%; object-fit: cover;";

        const buttonWrapper = document.createElement("div");
        buttonWrapper.style.cssText =
          "display: flex; flex-direction: row; justify-content: center; align-items: center; border: 1px solid #e0e0e0; background-color: #fff; width: 20%; height: 20%; position: absolute; top: 1%; right: 1%; cursor:pointer;";
        const deleteButton = document.createElement("i");
        deleteButton.style.color = "#000";
        deleteButton.classList.add("fa-solid", "fa-trash-can");
        deleteButton.addEventListener("click", () => handleDelete(img));
        buttonWrapper.appendChild(deleteButton);

        const overlay = document.createElement("div");
        overlay.classList.add("white-overlay");

        const container = document.createElement("div");
        container.style.cssText =
          "width: 8vw; height: 100%; position: relative; cursor: pointer;";
        container.appendChild(overlay);
        container.appendChild(img);
        container.appendChild(buttonWrapper);

        previewContainer.appendChild(container);
      };

      reader.readAsDataURL(file);
    } else {
      Swal.fire({
        icon: "warning",
        title: "Uwaga!",
        color: "#000",
        text: `Plik ${file.name} nie jest obrazem i nie zostanie dodany.`,
        confirmButtonColor: "#ff7bac",
        confirmButtonText: "OK",
      });
    }
  }

  fileInput.value = "";
}

function handleDelete(img) {
  // Usuń podgląd z kontenera
  img.parentNode.remove();
  // Usuń plik z listy
  fileInput.value = "";
}
//Multiple imgs handler end
