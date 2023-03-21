
const imageLinks = document.querySelectorAll("[data-bs-toggle='modal']");
if(imageLinks){
imageLinks.forEach((link) => {
    link.addEventListener("click", (event) => {
        event.preventDefault();
        const modalTarget = link.getAttribute("data-bs-target");
        const modal = document.querySelector(modalTarget);
        const modalBody = modal.querySelector(".modal-body");
        const image = link.querySelector("img");

        // Remove old image from modal
        const oldImage = modalBody.querySelector("img");
        if (oldImage) {
            oldImage.remove();
        }

        // Create new image element
        const newImage = document.createElement("img");
        newImage.src = image.src;
        newImage.classList.add("img-fluid");

        // Add new image to modal
        modalBody.querySelector(".col-md-8").appendChild(newImage);

        // Show modal
        const modalInstance = new bootstrap.Modal(modal);
        modalInstance.show();
    });
});
}