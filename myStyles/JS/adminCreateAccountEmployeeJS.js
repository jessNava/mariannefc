$(document).ready(function () {
    $("#submitNewAccount").click(function () {
        var employeeNumber = $("#employeeNumber").val();
        var employeeFullName = $("#employeeFullName").val();
        var employeeDepartment = $("#employeeDepartment").val();z
        var employeePosition = $("#employeePosition").val();
        var employeeSex = $("#employeeSex").val();
        var userType = $("#userType").val();

        var employeeInfo = {
            employeeNumber: employeeNumber,
            employeeFullName: employeeFullName,
            employeeDepartment: employeeDepartment,
            employeePosition: employeePosition,
            employeeSex: employeeSex,
            userType: userType
        }

        if (employeeNumber.length === 0 || employeeFullName.length === 0 || employeeDepartment.length === 0 || employeePosition.length === 0 || employeeSex.length === 0 || userType.length === 0) {
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Oopss!!!',
                text: 'Fill out all the fields!',
                showConfirmButton: false,
                timer: 2000
            });
        } else {
            $.ajax({
                type: "POST",
                url: "insertToEmployeeAccountDB.php",
                data: employeeInfo,
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