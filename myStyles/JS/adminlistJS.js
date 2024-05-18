$(document).ready(function () {
    // data table attributes
    $('#adminTable').DataTable({
        dom: 'Blfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Export as Excel',
                title: 'Admin_Account_Lists',
                exportOptions: {
                    columns: [0, 1, 2, 3]
                }
            },
            {
                extend: 'pdfHtml5',
                text: 'Export as PDF',
                title: 'Admin_Account_Lists',
                exportOptions: {
                    columns: [0, 1, 2, 3]
                }
            }
        ]
    });
    //show the data when clicked
    $(".editModalBtn").on('click', function () {
        $('#editModal').modal("show");

        $tr = $(this).closest("tr");

        var data = $tr.children("td").map(function () {
            return $(this).text();
        }).get();

        console.log(data);

        $('#Table_ID').val(data[0]);
        $('#AdminUser').val(data[1]);
        $('#AdminPassword').val(data[2]);
        $('#AdminFullname').val(data[3]);
    });
    // edit modal prompt and show the info of target account to edit
    $('#submitEditAccount').click(function () {
        //alert(2);
        var AdminUser = $('#AdminUser').val();
        var AdminPassword = $('#AdminPassword').val();
        var AdminFullname = $('#AdminFullname').val();

        // create object of the data
        var editAdminInfo = {
            AdminUser: AdminUser,
            AdminPassword: AdminPassword,
            AdminFullname: AdminFullname
        }
        // a alert show if input types are null
        if (AdminUser.length === 0 || AdminPassword.length === 0 || AdminFullname.length === 0) {
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
                url: "AdminUpdateAdminAccountPHP.php",
                data: editAdminInfo,
                success: function (data) {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Success!!',
                        text: 'Admin Account Updated!',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        window.location.reload();
                    });
                }
            });
        }
    });
    // getting the value of the row selected
    $(".deleteModalBtn").on('click', function () {
        $('#deleteModal').modal("show");

        $tablerow = $(this).closest("tr");

        var data = $tablerow.children("td").map(function () {
            return $(this).text();
        }).get();

        console.log(data);

        $('#Table_ID').val(data[0]);
        $('#AdminUser').val(data[1]);
        $('#AdminPassword').val(data[2]);
        $('#AdminFullname').val(data[3]);
    });

    // when button delete confirm
    $("#deleteEmployeeButton").on('click', function () {
        //alert(2);
        var AdminUser = $('#AdminUser').val();

        // create object of the data
        var deleteAdminInfo = {
            AdminUser: AdminUser,
        }

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d9534f',
            cancelButtonColor: '#5cb85c',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "AdminDeleteAdminAccount.php",
                    data: deleteAdminInfo,
                    success: function (data) {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Success!!',
                            text: 'Admin Account has been deleted!',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            window.location.reload();
                        });
                    }
                })
            } else {
                Swal.fire({
                    position: 'center',
                    icon: 'info',
                    title: 'Notif!',
                    text: 'Admin Account is not deleted!',
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
                    window.location.reload();
                });
            }
        })
    });
    // export a csv file
    $('.btnExport').click(function () {
        $.ajax({
            url: "adminExportAdminLists.php",
            method: "POST",
            success: function (data) {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Success!',
                    text: 'Report downloaded.',
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        });
    });

});