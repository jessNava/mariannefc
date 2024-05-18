$(document).ready(function () {
    $("#submitNewAccount").click(function () {
        var adminUserName = $("#adminUserName").val();
        var adminPassword = $("#adminPassword").val();
        var adminPasswordTwo = $("#adminPasswordTwo").val();
        var adminFullName = $("#adminFullName").val();
        var userType = $("#userType").val();
        // create the obj of the data
        var adminInfo = {
            adminUserName: adminUserName,
            adminPassword: adminPassword,
            adminPasswordTwo: adminPasswordTwo,
            adminFullName: adminFullName,
            userType: userType
        }
        // a alert show if input types are null
        if (adminUserName.length === 0 || adminPassword.length === 0 || adminPasswordTwo.length === 0 || adminFullName.length === 0 || userType.length === 0) {
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Oopss!!!',
                text: 'Fill out all the fields!',
                showConfirmButton: false,
                timer: 2000
            });
            // a alert show if password and retype password does not match
        } else if (adminPassword != adminPasswordTwo) {
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Oops!!!',
                text: 'Passwords are not matched!',
                showConfirmButton: false,
                timer: 3000
            });
            // a alert show if all of the requirements meet. The data will push to database
        } else {
            $.ajax({
                type: "POST",
                url: "insertToAdminAccountDB.php",
                data: adminInfo,
                success: function (data) {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Success!!',
                        text: 'Admin Account created!',
                        showConfirmButton: false,
                        timer: 3000
                    }).then(() => {
                        window.location.reload();
                    });
                }
            });
        }
    });
});
// jquery to show a alert after the user type on retype password a alert show if pass is now same
$(document).ready(function () {
    $('#adminPasswordTwo').on('change', function () {
        if ($('#adminPassword').val() == $('#adminPasswordTwo').val()) {
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Success!!',
                text: 'Password is match!',
                showConfirmButton: false,
                timer: 2000
            });
        } else
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Oops!!',
                text: 'Password is mis-match!',
                showConfirmButton: false,
                timer: 2000
            });
    });
});
// show hide password via changing the input type
$(document).ready(function () {
    $("#passwordTwoShow").click(function () {
        // get the attribute value
        var type = $("#adminPassword,#adminPasswordTwo").attr("type");
        // now test it's value
        if (type === 'password') {
            $("#adminPassword,#adminPasswordTwo").attr("type", "text");
        } else {
            $("#adminPassword,#adminPasswordTwo").attr("type", "password");
        }
    });
});