const addJobForm = document.getElementById('addJobForm');

if (addJobForm) {
    addJobForm.addEventListener('submit', function (event) {
        const requiredInputs = addJobForm.querySelectorAll('input[required]');
        let hasEmptyInput = false;

        requiredInputs.forEach((input) => {
            if (input.value.trim() === '') {
                hasEmptyInput = true;
            }
        });

        if (hasEmptyInput) {
            event.preventDefault();
            alert('Please fill all fields.');
        }
    });
}
