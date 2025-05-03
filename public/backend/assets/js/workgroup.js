function allowOnlyNumbersAndDecimal(event) {
    const keyCode = event.keyCode ? event.keyCode : event.which;
    const inputValue = event.target.value;

    // Allow numbers (0-9), one decimal point, Backspace, Delete, and Arrow keys
    if (
        (keyCode < 48 || keyCode > 57) && // Top row numbers
        (keyCode < 96 || keyCode > 105) && // Numpad numbers
        keyCode !== 46 && // Delete key
        keyCode !== 8 && // Backspace key
        keyCode !== 190 && // Decimal point
        keyCode !== 110 && // Numpad decimal point
        (keyCode < 37 || keyCode > 40) // Arrow keys
    ) {
        event.preventDefault();
    }

    // Prevent more than one decimal point
    if ((keyCode === 190 || keyCode === 110) && inputValue.includes('.')) {
        event.preventDefault();
    }
}

$('#wgId').select2({
    dropdownParent: $('#offcanvasRight')
});

$('#role').select2({});

$('#location').select2({});

$('#documentTitle').select2({});

$('#bank').select2({});

$('#paymentType').select2({});

$('#gender').select2({});

$('#lifeStatus').select2({});

$('#lgao').select2({});

$('#lgar').select2({});

$('#classification').select2({});

$('#payrollStatus').select2({});

$('#nokRelationship').select2({});

$(document).ready(function() {
    $('#example').DataTable({
        paging: true,
        searching: true,
        ordering: false,
        lengthMenu: [10, 25, 50, 100],
    });
});

$('#viewAdmin').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var surname = button.data('surname') // Extract info from data-* attributes
    var firstname = button.data('firstname') // Extract info from data-* attributes
    var othernames = button.data('othernames') // Extract info from data-* attributes
    var email = button.data('email') // Extract info from data-* attributes
    var phone = button.data('phone') // Extract info from data-* attributes
    var role = button.data('role') // Extract info from data-* attributes
    var location = button.data('location') // Extract info from data-* attributes
    var datecreated = button.data('datecreated') // Extract info from data-* attributes
    var photo = button.data('photo') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var modal = $(this)
    document.getElementById("vsurname").innerHTML = surname;
    document.getElementById("vfirstname").innerHTML = firstname;
    document.getElementById("vothernames").innerHTML = othernames;
    document.getElementById("vemail").innerHTML = email;
    document.getElementById("vphone").innerHTML = phone;
    document.getElementById("vrole").innerHTML = role;
    document.getElementById("vlocation").innerHTML = location;
    document.getElementById("vdatecreated").innerHTML = datecreated;
    document.getElementById("vphoto").src = photo;
})

$('#editAdmin').on('show.bs.offcanvas', function(event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var myid = button.data('myid') // Extract info from data-* attributes
    var surname = button.data('surname') // Extract info from data-* attributes
    var firstname = button.data('firstname') // Extract info from data-* attributes
    var othernames = button.data('othernames') // Extract info from data-* attributes
    var email = button.data('email') // Extract info from data-* attributes
    var phone = button.data('phone') // Extract info from data-* attributes
    var role = button.data('role') // Extract info from data-* attributes
    var location = button.data('location') // Extract info from data-* attributes

    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var offcanvas = $(this)
    // modal.find('.modal-body #myid').val(myid)
    offcanvas.find('.offcanvas-body #myid').val(myid)
    offcanvas.find('.offcanvas-body #surname').val(surname)
    offcanvas.find('.offcanvas-body #firstname').val(firstname)
    offcanvas.find('.offcanvas-body #othernames').val(othernames)
    offcanvas.find('.offcanvas-body #email').val(email)
    offcanvas.find('.offcanvas-body #phone').val(phone)
    $('#assignedrole').select2({
        dropdownParent: $('#editAdmin'),
    }).val(role).trigger('change');
    $('#assignedloc').select2({
        dropdownParent: $('#editAdmin'),
    }).val(location).trigger('change');
})


$("#viewDocument").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var image = button.data("document"); // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this);
    // modal.find('.modal-body #myid').val(myid)
    document.getElementById("image").src = image;
});

$("#uploadComment").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var comment = button.data("comment"); // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this);
    // modal.find('.modal-body #myid').val(myid)
    document.getElementById("comment").innerHTML = comment;
});

$("#resolveUploadIssue").on("show.bs.offcanvas", function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var myid = button.data("myid"); // Extract info from data-* attributes
    var accountnumber = button.data("accountno"); // Extract info from data-* attributes
    var filenumber = button.data("fileno"); // Extract info from data-* attributes

    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var offcanvas = $(this);
    // modal.find('.modal-body #myid').val(myid)
    offcanvas.find('.offcanvas-body #myid').val(myid)
    offcanvas.find('.offcanvas-body #accountnumber').val(accountnumber)
    offcanvas.find('.offcanvas-body #filenumber').val(filenumber)

});
