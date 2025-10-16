let list = document.querySelectorAll(".navigation li");

function activeLink() {
    list.forEach((item) => {
        item.classList.remove("hovered");
    });
    this.classList.add("hovered");
}

list.forEach((item) => item.addEventListener("mouseover", activeLink));

let toggle = document.querySelector(".toggle");
let navigation = document.querySelector(".navigation");
let main = document.querySelector(".main");

toggle.onclick = function () {
    navigation.classList.toggle("active");
    main.classList.toggle("active");
};

// Get the modal
var modal = document.getElementById("imageModal");

// Get the image elements
var images = document.querySelectorAll(".issue_img img");

// Get the modal image and caption
var modalImg = document.getElementById("modalImage");
var captionText = document.getElementById("caption");

// Loop through all the images and add a click event
images.forEach(function (image) {
    image.onclick = function () {
        modal.style.display = "block";
        modalImg.src = this.src; // Set the source of the modal image to the clicked image
        captionText.innerHTML = this.alt; // Set the caption to the alt text of the image
    };
});

// Get the <span> element that closes the modal
var closeBtn = document.getElementsByClassName("close")[0];

// When the user clicks on <span>, close the modal
closeBtn.onclick = function () {
    modal.style.display = "none";
};
