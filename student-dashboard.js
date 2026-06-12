const dateText = document.getElementById("dateText");

if (dateText) {
  const today = new Date();

  const formattedDate = today.toLocaleDateString("en-GB", {
    day: "2-digit",
    month: "long",
    year: "numeric"
  });

  dateText.textContent = formattedDate;
}