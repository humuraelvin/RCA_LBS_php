$(document).ready(function() {
    $('#submitButton').on("click", function () {


        var formData = {
            name: $('#name').val(),
            email: $('#email').val(),
            phone: $('#phone').val()
        };

        console.log(formData.name);
        console.log(formData.email);
        console.log(formData.phone);

        $.post('api.php', formData, function (response) {
            console.log('Form submitted successfully', response);
            showMessage(response.message);
            loadStudents();
            clearForm();
        })
        .fail(function (xhr, status, error) {
            console.error("Error submitting form", error);
        });
    });

    function showMessage(message) {
        $('#message').text(message);
    }


    function clearForm() {
        $('#name').val('');
        $('#email').val('');
        $('#phone').val('');
    }

});