

   
document.addEventListener("DOMContentLoaded", function() {
    const menuBtn = document.querySelector(".menu-btn");
    const navLinks = document.querySelector(".mobile-menu");

    menuBtn.addEventListener("click", () => {
        navLinks.classList.toggle("show");
    })
    const form = document.querySelector("form");
    const nameInput = document.getElementById("name");
    const emailInput = document.getElementById("email");
    const messageInput = document.getElementById("message");

    form.addEventListener("submit", function(event) {
        let isValid = true;

        if (nameInput.value.trim() === "") {
            isValid = false;
            setErrorFor(nameInput, "Name is required");
        } else {
            setSuccessFor(nameInput);
        }

        if (emailInput.value.trim() === "") {
            isValid = false;
            setErrorFor(emailInput, "Email is required");
        } else if (!isValidEmail(emailInput.value)) {
            isValid = false;
            setErrorFor(emailInput, "Invalid email format");
        } else {
            setSuccessFor(emailInput);
        }

        if (messageInput.value.trim() === "") {
            isValid = false;
            setErrorFor(messageInput, "Message is required");
        } else {
            setSuccessFor(messageInput);
        }

        if (!isValid) {
            event.preventDefault();
        }
    });

    function setErrorFor(input, message) {
        const formControl = input.parentElement;
        const errorMsg = formControl.querySelector("small");

        formControl.className = "form-control error";
        errorMsg.innerText = message;
    }

    function setSuccessFor(input) {
        const formControl = input.parentElement;
        formControl.className = "form-control success";
    }

    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    const bookTourForm = document.querySelector(".book-tour-form form");
    const tourNameInput = document.getElementById("tour-name");
    const tourDateInput = document.getElementById("tour-date");
    const participantsInput = document.getElementById("participants");

    bookTourForm.addEventListener("submit", function(event) {
        let isValid = true;

        if (tourNameInput.value.trim() === "") {
            isValid = false;
            setErrorFor(tourNameInput, "Tour name is required");
        } else {
            setSuccessFor(tourNameInput);
        }

        if (tourDateInput.value === "") {
            isValid = false;
            setErrorFor(tourDateInput, "Tour date is required");
        } else {
            setSuccessFor(tourDateInput);
        }

        const participantsValue = parseInt(participantsInput.value);
        if (isNaN(participantsValue) || participantsValue <= 0) {
            isValid = false;
            setErrorFor(participantsInput, "Enter a valid number of participants");
        } else {
            setSuccessFor(participantsInput);
        }

        if (!isValid) {
            event.preventDefault();
        }
    });

    function setErrorFor(input, message) {
        const formControl = input.parentElement;
        const errorMsg = formControl.querySelector(".small");

        formControl.classList.add("error");
        errorMsg.innerText = message;
    }

    function setSuccessFor(input) {
        const formControl = input.parentElement;
        formControl.classList.remove("error");
    }



    
});


// bookTourForm.addEventListener("submit", function(event) {
//     // ... (existing form validation code) ...

//     if (isValid) {
//         showThankYouMessage();
//         event.preventDefault(); // Prevent default form submission
//     }
// });

// function showThankYouMessage() {
//     const thankYouSection = document.querySelector(".thank-you");
//     thankYouSection.style.display = "block";
// }


// // document.addEventListener("DOMContentLoaded", load);

// // function load() {
// //     const menuBtn = document.querySelector(".menu-btn");
// //     const navLinks = document.querySelector(".nav-links");

// //     menuBtn.addEventListener("click",()=> {
// //         navLinks.classList.toggle("mobile-menu"); // Toggle the mobile-menu class
// //     });

// // }

// document.addEventListener("DOMContentLoaded", () => {
   

        // console.log("Script is running!");

        // if (navLinks.classList.contains("mobile-menu")) {
        //     menuBtn.textContent = "Menu";
        // } else {
        //     menuBtn.textContent = "Close Menu";
        // }
    

// function myFunction() {
//     document.getElementById("myDropdown").classList.toggle("show");
//   }
  
//   // Close the dropdown if the user clicks outside of it
//   window.onclick = function(event) {
//     if (!event.target.matches('.dropbtn')) {
//       var dropdowns = document.getElementsByClassName("dropdown-content");
//       var i;
//       for (i = 0; i < dropdowns.length; i++) {
//         var openDropdown = dropdowns[i];
//         if (openDropdown.classList.contains('show')) {
//           openDropdown.classList.remove('show');
//         }
//       }
//     }
//   }
  