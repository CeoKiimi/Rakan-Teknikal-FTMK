const loginForm = document.getElementById("loginForm");
const registerForm = document.getElementById("registerForm");
const userIdInput = document.getElementById("userId");
const passwordInput = document.getElementById("password");
const confirmPasswordInput = document.getElementById("confirm_password");
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

if (registerForm && passwordInput && confirmPasswordInput) {
  registerForm.addEventListener("submit", (event) => {
    const password = passwordInput.value.trim();
    const confirmPassword = confirmPasswordInput.value.trim();

    if (password.length < 6) {
      event.preventDefault();
      alert("Password must be at least 6 characters.");
      return;
    }

    if (password !== confirmPassword) {
      event.preventDefault();
      alert("Password and confirm password do not match.");
    }
  });
}
