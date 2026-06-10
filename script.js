const loginForm = document.getElementById("loginForm");
const userIdInput = document.getElementById("userId");
const passwordInput = document.getElementById("password");
const togglePassword = document.getElementById("togglePassword");
const errorMessage = document.getElementById("errorMessage");

togglePassword.addEventListener("click", () => {
  const isPassword = passwordInput.type === "password";

  passwordInput.type = isPassword ? "text" : "password";

  togglePassword.setAttribute(
    "aria-label",
    isPassword ? "Hide password" : "Show password"
  );
});

loginForm.addEventListener("submit", (event) => {
  event.preventDefault();

  const userId = userIdInput.value.trim();
  const password = passwordInput.value.trim();

  errorMessage.textContent = "";

  if (userId === "" || password === "") {
    errorMessage.textContent = "Please enter User Id and Password.";
    return;
  }

  if (userId === "admin" && password === "admin") {
    localStorage.setItem(
      "loggedInUser",
      JSON.stringify({
        userId: "admin",
        role: "Admin"
      })
    );

    window.location.href = "admin-dashboard.html";
  } 
  
  else if (userId === "student" && password === "student") {
    localStorage.setItem(
      "loggedInUser",
      JSON.stringify({
        userId: "student",
        role: "Student"
      })
    );

    window.location.href = "student-dashboard.html";
  } 
  
  else {
    errorMessage.textContent = "Invalid User Id or Password.";
  }
});