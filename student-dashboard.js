const studentName = document.getElementById("studentName");
const dateText = document.getElementById("dateText");

const savedUser = JSON.parse(localStorage.getItem("loggedInUser"));

if (savedUser && savedUser.userId) {
  studentName.textContent = savedUser.userId;
} else {
  studentName.textContent = "Ain";
}

const today = new Date();

const formattedDate = today.toLocaleDateString("en-GB", {
  day: "2-digit",
  month: "long",
  year: "numeric"
});

dateText.textContent = formattedDate;

const applyButtons = document.querySelectorAll(".small-btn");

applyButtons.forEach((button) => {
  button.addEventListener("click", () => {
    alert("Application submitted.");
  });
});