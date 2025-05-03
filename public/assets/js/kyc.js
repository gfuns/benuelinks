$(document).ready(function() {
    $('#veridoc').select2({
        width: '100%' // Ensure it takes full width
    });
});

$(document).ready(function() {
    $('#designation').select2({
        width: '100%' // Ensure it takes full width
    });
});

$(document).ready(function() {
    $('#representative').select2({
        width: '100%' // Ensure it takes full width
    });
});

$(document).ready(function() {
    $('#currency').select2({
        width: '100%', // Ensure it takes full width
    });
});

$(document).ready(function() {
    $('#bank').select2({
        width: '100%', // Ensure it takes full width
        templateResult: formatBank,
        templateSelection: formatBank
    });

    function formatBank(bank) {
        if (!bank.id) {
            return bank.text;
        }

        var imageUrl = $(bank.element).data('image');
        if (!imageUrl) {
            return bank.text;
        }

        var $bank = $(
            '<span><img src="' + imageUrl + '" style="width: 20px; height: 20px; margin-right: 10px;"/> ' + bank.text + '</span>'
        );
        return $bank;
    }
});


$(document).ready(function() {
    $(".page-ath-form").css({
        "opacity": "0",
        "transform": "translateX(100%)"
    });

    $(".page-ath-form").animate({
        opacity: 1,
        marginLeft: "0"
    }, 500);
});


document.getElementById("changeLogoBtn").addEventListener("click", function() {
    document.getElementById("logoInput").click(); // Trigger file input
});

document.getElementById("logoInput").addEventListener("change", function() {
    var file = this.files[0];

     if (file) {

        // Preview the selected image
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById("logoPreview").src = e.target.result;
        };
        reader.readAsDataURL(this.files[0]);

        // Submit the form automatically

         // Prepare form data
         var formData = new FormData();
         formData.append("logo", file);

         $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

         // Send AJAX request
         $.ajax({
            url: "http://localhost:8000/business/settings/update-logo", // Update to match your actual route
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                // Swal.fire({
                //     toast: true,
                //     position: "top-end",
                //     icon: "success",
                //     title: "Logo updated successfully!",
                //     showConfirmButton: false,
                //     timer: 3000
                // });
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: "error",
                    title: "Error uploading logo!",
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        });
        // document.getElementById("logoUploadForm").submit();
    }
});



