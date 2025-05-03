$('#recordExamScore').on('show.bs.offcanvas', function(event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var myid = button.data('myid') // Extract info from data-* attributes

    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var offcanvas = $(this)
    // modal.find('.modal-body #myid').val(myid)
    offcanvas.find('.offcanvas-body #myid').val(myid)
})

$('#uploadExamScores').on('show.bs.offcanvas', function(event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var taskid = button.data('taskid') // Extract info from data-* attributes
    var subjectid = button.data('subjectid') // Extract info from data-* attributes
    var template = button.data('template') // Extract info from data-* attributes

    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var offcanvas = $(this)
    // modal.find('.modal-body #myid').val(myid)
    offcanvas.find('.offcanvas-body #taskid').val(taskid)
    offcanvas.find('.offcanvas-body #subjectid').val(subjectid)
    document.getElementById("templateid").href = template;
})

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
