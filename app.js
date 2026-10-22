const form = document.querySelector("#feedback");
const error = document.querySelector("#error");

form.addEventListener("submit", (e) => {
    const name = document.querySelector("#name").value.trim();
    const email = document.querySelector("#email").value.trim();
    const message = document.querySelector("#message").value.trim();

    error.textContent = "";

    if (name === "" || email === "" || message === "") {
        e.preventDefault(); 
        error.textContent = "Please fill in all fields.";
    } else if (!email.includes("@")) {
        e.preventDefault(); 
        error.textContent = "Please enter a valid email address.";
    } else if (message.length < 10) {
        e.preventDefault(); 
        error.textContent = "Your message must be at least 10 characters long.";
    }
});