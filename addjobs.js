function checkForm()
{
    let job = document.getElementById("job").value;
    let location = document.getElementById("location").value;
    let start_date = document.getElementById("start_date").value;
    let end_date = document.getElementById("end_date").value;
    let allowance = document.getElementById("allowance").value;
    let todo = document.getElementById("todo").value;

    if (!job || !location || !start_date || !end_date || !allowance || !todo) {
        alert("Please fill all fields!");
        return false;
    }

    if (end_date < start_date) {
        alert("End date cannot be earlier than start date!");
        return false;
    }

    alert("Job submitted successfully!");
    return true;
}