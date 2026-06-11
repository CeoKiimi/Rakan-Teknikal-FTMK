document.querySelectorAll(".delete-btn").forEach(button => {

    button.addEventListener("click", () => {

        let card = button.closest(".job-card");

        if(confirm("Delete this job?")){

            card.remove();

        }

    });

});