$("#viewSeats").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var myid = button.data("myid"); // Extract info from data-* attributes
    var vehicletype = button.data("vehicletype"); // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var modal = $(this);
    // modal.find('.modal-body #myid').val(myid)
    modal.find(".modal-body #myid").val(myid);
    modal.find(".modal-body #vehicletype").val(vehicletype);

    var bookedSeats;

    $.ajax({
        url: '/ajax/get-bookedSeats/' + myid,
        method: 'GET',
        success: function(data) {
             bookedSeats = data.bookedSeats;
               // Reset all seats before applying booked logic
                modal.find('input[name="seatnumber[]"]').each(function () {
                    this.disabled = false;
                    var label = modal.find(`label[for="${this.id}"]`);

                    var seatId = this.id; // e.g. "seat-1"
                    var seatNumber = seatId.split('-')[1]; // "1"
                    var seatWord = numberToWord(seatNumber); // "one"

                    var className = `seat-${seatWord}`;

                    label.removeClass().addClass(className); // Restore label class to match input
                });

              // Now apply the 'disable-seat' class and disable the input
             bookedSeats.forEach(function (seatNumber) {
                var inputId = `seat-${seatNumber}`;
                var input = modal.find(`#${inputId}`);
                var label = modal.find(`label[for="${inputId}"]`);

                if (input.length && label.length) {
                    input.prop("disabled", true);
                    label.removeClass().addClass("disable-seat");
                }
            });
        }
    });

});


function numberToWord(num) {
    const map = {
        "1": "one",
        "2": "two",
        "3": "three",
        "4": "four",
        "5": "five",
        "6": "six",
        "7": "seven",
        "8": "eight",
        "9": "nine",
        "10": "ten",
        "11": "eleven",
        "12": "twelve",
        // Add more mappings as needed
    };

    return map[num] || num; // fallback to number if not found
}
