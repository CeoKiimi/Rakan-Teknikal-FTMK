const loginForm = document.getElementById("loginForm");
const userIdInput = document.getElementById("userId");
const passwordInput = document.getElementById("password");
const togglePassword = document.getElementById("togglePassword");
const errorMessage = document.getElementById("errorMessage");

if (togglePassword && passwordInput) {
  togglePassword.addEventListener("click", () => {
    const isPassword = passwordInput.type === "password";

    passwordInput.type = isPassword ? "text" : "password";

    togglePassword.setAttribute(
      "aria-label",
      isPassword ? "Hide password" : "Show password"
    );
  });
}

if (loginForm) {
  loginForm.addEventListener("submit", (event) => {
    const userId = userIdInput.value.trim();
    const password = passwordInput.value.trim();

    if (userId === "" || password === "") {
      event.preventDefault();
      errorMessage.textContent = "Please enter User Id and Password.";
    }
  });
}