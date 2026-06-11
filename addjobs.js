function checkForm()
{
    let job = document.getElementById("job").value;
    let location = document.getElementById("location").value;
    let start_date = document.getElementById("start_date").value;
    let end_date = document.getElementById("end_date").value;
    let allowance = document.getElementById("allowance").value;
    let todo = document.getElementById("todo").value;

    alert("Job added successfully!");
    return true;
}