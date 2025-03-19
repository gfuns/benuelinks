$("#userrole").select2({
    dropdownParent: $("#addUser"),
});

$("#bank").select2({});


$("#uploadComment").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var comment = button.data("comment"); // Extract info from data-* attributes

    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this);
    // modal.find('.modal-body #myid').val(myid)
    document.getElementById("comment").innerHTML = comment;
});


$("#resolveUploadIssue").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var myid = button.data("myid"); // Extract info from data-* attributes
    var accname = button.data("accname"); // Extract info from data-* attributes
    var accno = button.data("accno"); // Extract info from data-* attributes
    var amount = button.data("amount"); // Extract info from data-* attributes
    var bank = button.data("bank"); // Extract info from data-* attributes

    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var modal = $(this);
    // modal.find('.modal-body #myid').val(myid)
    modal.find(".popup-body #myid").val(myid);
    modal.find(".popup-body #accno").val(accno);
    modal.find(".popup-body #accname").val(accname);
    modal.find(".popup-body #amount").val(amount);
    $("#bank")
        .select2({
            dropdownParent: $("#resolveUploadIssue"),
        })
        .val(bank)
        .trigger("change");
});

function validateInput(event) {
    const input = event.target;
    let value = input.value;

    // Remove commas from the input value
    value = value.replace(/,/g, "");

    // Regular expression to match non-numeric and non-decimal characters
    const nonNumericDecimalRegex = /[^0-9.]/g;

    if (nonNumericDecimalRegex.test(value)) {
        // If non-numeric or non-decimal characters are found, remove them from the input value
        value = value.replace(nonNumericDecimalRegex, "");
    }

    // Ensure there is only one decimal point in the value
    const decimalCount = value.split(".").length - 1;
    if (decimalCount > 1) {
        value = value.replace(/\./g, "");
    }

    // Assign the cleaned value back to the input field
    input.value = value;
}

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

$("#editUser").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var userid = button.data("userid"); // Extract info from data-* attributes
    var fname = button.data("fname"); // Extract info from data-* attributes
    var sname = button.data("sname"); // Extract info from data-* attributes
    var email = button.data("email"); // Extract info from data-* attributes
    var phone = button.data("phone"); // Extract info from data-* attributes
    var role = button.data("role"); // Extract info from data-* attributes
     // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var modal = $(this);
    modal.find(".popup-body #userid").val(userid);
    modal.find(".popup-body #fname").val(fname);
    modal.find(".popup-body #sname").val(sname);
    modal.find(".popup-body #email").val(email);
    modal.find(".popup-body #phone").val(phone);
    $("#utaskrole")
        .select2({
            dropdownParent: $("#editUser"),
        })
        .val(role)
        .trigger("change");



});

$("#updateUserRole").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var roleid = button.data("roleid"); // Extract info from data-* attributes
    var role = button.data("role"); // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var modal = $(this);
    modal.find(".popup-body #roleid").val(roleid);
    modal.find(".popup-body #role").val(role);
});

$("#updateWrkGrp").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var wgid = button.data("wgid"); // Extract info from data-* attributes
    var wrkgrp = button.data("wrkgrp"); // Extract info from data-* attributes
    var classification = button.data("classification"); // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var modal = $(this);
    modal.find(".popup-body #wgid").val(wgid);
    modal.find(".popup-body #wrkgrp").val(wrkgrp);
    $("#class")
        .select2({
            dropdownParent: $("#updateWrkGrp"),
        })
        .val(classification)
        .trigger("change");
});


$(".clearCache").click(function (e) {
    e.preventDefault();

    Swal.fire({
        title: "You are about to clear cache",
        titleColor: "#342d6e",
        text: "This will take some time depending on the size of the cache file",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, clear cache!",
    }).then((result) => {
        if (result.isConfirmed) {
            var logid = $(this).data("id");

            $.ajax({
                type: "GET",
                url: cacheRoute,
                dataType: "json",
                data: {
                    logid: logid,
                },
                success: function (data) {
                    Swal.fire(data.title, data.message, data.status);
                },
            });
        }
    });
});

$(".suspendUser").click(function (e) {
    e.preventDefault();

    Swal.fire({
        title: "Are you sure?",
        titleColor: "#342d6e",
        text: "Once suspended, this user will no longer be able to perform any operation.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Suspend User!",
    }).then((result) => {
        if (result.isConfirmed) {
            var userid = $(this).data("userid");

            $.ajax({
                type: "GET",
                url: suspendUserRoute,
                dataType: "json",
                data: {
                    userid: userid,
                },
                success: function (data) {
                    Swal.fire(data.title, data.message, data.status).then(
                        function () {
                            location.reload();
                        }
                    );
                },
            });
        }
    });
});

$(".activateUser").click(function (e) {
    e.preventDefault();

    Swal.fire({
        title: "Are you sure?",
        titleColor: "#342d6e",
        text: "Once activated, this user will now be able to perform all customer related operations.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Activate User!",
    }).then((result) => {
        if (result.isConfirmed) {
            var userid = $(this).data("userid");

            $.ajax({
                type: "GET",
                url: activateUserRoute,
                dataType: "json",
                data: {
                    userid: userid,
                },
                success: function (data) {
                    Swal.fire(data.title, data.message, data.status).then(
                        function () {
                            location.reload();
                        }
                    );
                },
            });
        }
    });
});
