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

$('#accountType').select2({
    dropdownParent: $('#offcanvasRight')
});

$('#customer').select2({
    dropdownParent: $('#offcanvasRight')
});

$('#configType').select2({
    dropdownParent: $('#offcanvasRight')
});

$('#configFormat').select2({
    dropdownParent: $('#newCustomFees')
});

$('#postTerminal').select2({
    dropdownParent: $('#assignTerminal')
});

$('#model').select2({
    dropdownParent: $('#offcanvasRight')
});

$('#gender').select2({
    dropdownParent: $('#offcanvasRight')
});

$('#country').select2({
    dropdownParent: $('#offcanvasRight')
});

$('#state').select2({
    dropdownParent: $('#offcanvasRight')
});


$('#role').select2({
    dropdownParent: $('#offcanvasRight')
});

$('#subject').select2({});
$('#exam').select2({});
$('#session').select2({});
$('#computation').select2({});
$('#terminal').select2({});
$('#event').select2({});
$('#month').select2({});
$('#year').select2({});

$(document).ready(function() {
       $('#example').DataTable({
           paging: true,
           searching: true,
           ordering: false,
           lengthMenu: [10, 25, 50, 100],
       });
   });


$('#editRole').on('show.bs.offcanvas', function(event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var myid = button.data('myid') // Extract info from data-* attributes
    var role = button.data('role') // Extract info from data-* attributes

    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var offcanvas = $(this)
    // modal.find('.modal-body #myid').val(myid)
    offcanvas.find('.offcanvas-body #myid').val(myid)
    offcanvas.find('.offcanvas-body #role').val(role)
})

$('#editCustomer').on('show.bs.offcanvas', function(event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var myid = button.data('myid') // Extract info from data-* attributes
    var surname = button.data('lastname') // Extract info from data-* attributes
    var firstname = button.data('firstname') // Extract info from data-* attributes
    var othernames = button.data('othernames') // Extract info from data-* attributes
    var email = button.data('email') // Extract info from data-* attributes
    var phone = button.data('phone') // Extract info from data-* attributes
    var accounttype = button.data('accounttype') // Extract info from data-* attributes

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
    $('#accountType').select2({
        dropdownParent: $('#editCustomer'),
    }).val(accounttype).trigger('change');
})

$('#editAccountType').on('show.bs.offcanvas', function(event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var myid = button.data('myid') // Extract info from data-* attributes
    var accountType = button.data('level') // Extract info from data-* attributes
    var utilityLimit = button.data('utility') // Extract info from data-* attributes
    var transferLimit = button.data('transfer') // Extract info from data-* attributes
    var withdrawalLimit = button.data('withdrawal') // Extract info from data-* attributes

    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var offcanvas = $(this)
    // modal.find('.modal-body #myid').val(myid)
    offcanvas.find('.offcanvas-body #myid').val(myid)
    offcanvas.find('.offcanvas-body #accountType').val(accountType)
    offcanvas.find('.offcanvas-body #utilityLimit').val(utilityLimit)
    offcanvas.find('.offcanvas-body #transferLimit').val(transferLimit)
    offcanvas.find('.offcanvas-body #withdrawalLimit').val(withdrawalLimit)

})

$('#editFeeAmount').on('show.bs.offcanvas', function(event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var myid = button.data('myid') // Extract info from data-* attributes
    var transtype = button.data('transtype') // Extract info from data-* attributes
    var configType = button.data('config') // Extract info from data-* attributes
    var amount = button.data('amount') // Extract info from data-* attributes
    var narration = button.data('narration') // Extract info from data-* attributes

    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var offcanvas = $(this)
    // modal.find('.modal-body #myid').val(myid)
    offcanvas.find('.offcanvas-body #myid').val(myid)
    offcanvas.find('.offcanvas-body #transType').val(transtype)
    offcanvas.find('.offcanvas-body #feeAmount').val(amount)
    offcanvas.find('.offcanvas-body #narration').val(narration)
    $('#configType').select2({
        dropdownParent: $('#editFeeAmount'),
    }).val(configType).trigger('change');
})

$('#viewDispute').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var customer = button.data('customer') // Extract info from data-* attributes
    var reference = button.data('reference') // Extract info from data-* attributes
    var description = button.data('description') // Extract info from data-* attributes
    var date = button.data('date') // Extract info from data-* attributes
    var feedback = button.data('feedback') // Extract info from data-* attributes
    var status = button.data('status') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var modal = $(this)
    document.getElementById("vcustomer").innerHTML = customer;
    document.getElementById("vreference").innerHTML = reference;
    document.getElementById("vdescription").innerHTML = description;
    document.getElementById("vdate").innerHTML = date;
    document.getElementById("vfeedback").innerHTML = feedback;
    document.getElementById("vstatus").innerHTML = status;
})



$('#closeDispute').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var myid = button.data('myid') // Extract info from data-* attributes

    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var modal = $(this)
    // modal.find('.modal-body #myid').val(myid)
    modal.find('.modal-body #myid').val(myid)
})

$('#editTerminal').on('show.bs.offcanvas', function(event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var myid = button.data('myid') // Extract info from data-* attributes
    var model = button.data('model') // Extract info from data-* attributes
    var terminalid = button.data('terminalid') // Extract info from data-* attributes
    var serialno = button.data('serialno') // Extract info from data-* attributes
    var sim = button.data('sim') // Extract info from data-* attributes
    var ip = button.data('ip') // Extract info from data-* attributes
    var port = button.data('port') // Extract info from data-* attributes

    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var offcanvas = $(this)
    // modal.find('.modal-body #myid').val(myid)
    offcanvas.find('.offcanvas-body #myid').val(myid)
    offcanvas.find('.offcanvas-body #terminalid').val(terminalid)
    offcanvas.find('.offcanvas-body #serialno').val(serialno)
    offcanvas.find('.offcanvas-body #sim').val(sim)
    offcanvas.find('.offcanvas-body #ip').val(ip)
    offcanvas.find('.offcanvas-body #port').val(port)
    $('#model').select2({
        dropdownParent: $('#editTerminal'),
    }).val(model).trigger('change');
})


$('#viewTerminal').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var model = button.data('model') // Extract info from data-* attributes
    var terminalid = button.data('terminalid') // Extract info from data-* attributes
    var serialno = button.data('serialno') // Extract info from data-* attributes
    var assigned = button.data('assigned') // Extract info from data-* attributes
    var status = button.data('status') // Extract info from data-* attributes
    var sim = button.data('sim') // Extract info from data-* attributes
    var date = button.data('date') // Extract info from data-* attributes
    var ip = button.data('ip') // Extract info from data-* attributes
    var port = button.data('port') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var modal = $(this)
    document.getElementById("vmodel").innerHTML = model;
    document.getElementById("vterminalid").innerHTML = terminalid;
    document.getElementById("vserialno").innerHTML = serialno;
    document.getElementById("vassigned").innerHTML = assigned;
    document.getElementById("vstatus").innerHTML = status;
    document.getElementById("vsim").innerHTML = sim;
    document.getElementById("vdate").innerHTML = date;
    document.getElementById("vip").innerHTML = ip;
    document.getElementById("vport").innerHTML = port;
})



$('#viewBusiness').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var bizid = button.data('bizid') // Extract info from data-* attributes
    var name = button.data('name') // Extract info from data-* attributes
    var address = button.data('address') // Extract info from data-* attributes
    var email = button.data('email') // Extract info from data-* attributes
    var phone = button.data('phone') // Extract info from data-* attributes
    var acctno = button.data('acctno') // Extract info from data-* attributes
    var model = button.data('model') // Extract info from data-* attributes
    var tid = button.data('tid') // Extract info from data-* attributes
    var sno = button.data('sno') // Extract info from data-* attributes
    var status = button.data('status') // Extract info from data-* attributes
    var operator = button.data('operator') // Extract info from data-* attributes
    var date = button.data('date') // Extract info from data-* attributes
    var balance = button.data('balance') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var modal = $(this)
    document.getElementById("vbizid").innerHTML = bizid;
    document.getElementById("vname").innerHTML = name;
    document.getElementById("vaddress").innerHTML = address;
    document.getElementById("vemail").innerHTML = email;
    document.getElementById("vphone").innerHTML = phone;
    document.getElementById("voperator").innerHTML = operator;
    document.getElementById("vacctno").innerHTML = acctno;
    document.getElementById("vmodel").innerHTML = model;
    document.getElementById("vterminalid").innerHTML = tid;
    document.getElementById("vserialno").innerHTML = sno;
    document.getElementById("vstatus").innerHTML = status;
    document.getElementById("vdate").innerHTML = date;
    document.getElementById("vbalance").innerHTML = balance;
})


$('#viewDrwDetails').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var reference = button.data('reference') // Extract info from data-* attributes
    var status = button.data('status') // Extract info from data-* attributes
    var amount = button.data('amount') // Extract info from data-* attributes
    var fee = button.data('fee') // Extract info from data-* attributes
    var total = button.data('total') // Extract info from data-* attributes
    var bank = button.data('bank') // Extract info from data-* attributes
    var maskedpan = button.data('maskedpan') // Extract info from data-* attributes
    var stan = button.data('stan') // Extract info from data-* attributes
    var gateway = button.data('gateway') // Extract info from data-* attributes
    var description = button.data('description') // Extract info from data-* attributes
    var status = button.data('status') // Extract info from data-* attributes
    var date = button.data('date') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var modal = $(this)
    document.getElementById("vreference").innerHTML = reference;
    document.getElementById("vamount").innerHTML = amount;
    document.getElementById("vfee").innerHTML = fee;
    document.getElementById("vtotal").innerHTML = total;
    document.getElementById("vbank").innerHTML = bank;
    document.getElementById("vmaskedpan").innerHTML = maskedpan;
    document.getElementById("vstan").innerHTML = stan;
    document.getElementById("vgateway").innerHTML = gateway;
    document.getElementById("vdescription").innerHTML = description;
    document.getElementById("vstatus").innerHTML = status;
    document.getElementById("vdate").innerHTML = date;
})

$('#editBusiness').on('show.bs.offcanvas', function(event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var myid = button.data('myid') // Extract info from data-* attributes
    var bizname = button.data('bizname') // Extract info from data-* attributes
    var bizaddress = button.data('bizaddress') // Extract info from data-* attributes
    var email = button.data('email') // Extract info from data-* attributes
    var phone = button.data('phone') // Extract info from data-* attributes
    var oln = button.data('oln') // Extract info from data-* attributes
    var ofn = button.data('ofn') // Extract info from data-* attributes
    var oon = button.data('oon') // Extract info from data-* attributes

    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var offcanvas = $(this)
    // modal.find('.modal-body #myid').val(myid)
    offcanvas.find('.offcanvas-body #myid').val(myid)
    offcanvas.find('.offcanvas-body #bizname').val(bizname)
    offcanvas.find('.offcanvas-body #bizaddress').val(bizaddress)
    offcanvas.find('.offcanvas-body #email').val(email)
    offcanvas.find('.offcanvas-body #phone').val(phone)
    offcanvas.find('.offcanvas-body #oln').val(oln)
    offcanvas.find('.offcanvas-body #ofn').val(ofn)
    offcanvas.find('.offcanvas-body #oon').val(oon)
})

$('#assignTerminal').on('show.bs.offcanvas', function(event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var myid = button.data('myid') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var offcanvas = $(this)
    // modal.find('.modal-body #myid').val(myid)
    offcanvas.find('.offcanvas-body #myid').val(myid)
})


$('#viewAuthDetails').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var surname = button.data('surname') // Extract info from data-* attributes
    var firstname = button.data('firstname') // Extract info from data-* attributes
    var othernames = button.data('othernames') // Extract info from data-* attributes
   var role = button.data('role') // Extract info from data-* attributes
    var datecreated = button.data('datecreated') // Extract info from data-* attributes
    var event = button.data('event') // Extract info from data-* attributes
    var ip = button.data('ip') // Extract info from data-* attributes
    var agent = button.data('agent') // Extract info from data-* attributes
    var description = button.data('description') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var modal = $(this)
    document.getElementById("vsurname").innerHTML = surname;
    document.getElementById("vfirstname").innerHTML = firstname;
    document.getElementById("vothernames").innerHTML = othernames;
    document.getElementById("vrole").innerHTML = role;
    document.getElementById("vdatecreated").innerHTML = datecreated;
    document.getElementById("vevent").innerHTML = event;
    document.getElementById("vdescription").innerHTML = description;
    document.getElementById("vip").innerHTML = ip;
    document.getElementById("vagent").innerHTML = agent;
})

$('#viewAuditDetails').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var surname = button.data('surname') // Extract info from data-* attributes
    var firstname = button.data('firstname') // Extract info from data-* attributes
    var othernames = button.data('othernames') // Extract info from data-* attributes
    var role = button.data('role') // Extract info from data-* attributes
    var datecreated = button.data('datecreated') // Extract info from data-* attributes
    var event = button.data('event') // Extract info from data-* attributes
    var ip = button.data('ip') // Extract info from data-* attributes
    var agent = button.data('agent') // Extract info from data-* attributes
    var model = button.data('table') // Extract info from data-* attributes
    var newvalues = button.data('newrecord') // Extract info from data-* attributes
    var oldvalues = button.data('oldrecord') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var modal = $(this)
    document.getElementById("vsurname").innerHTML = surname;
    document.getElementById("vfirstname").innerHTML = firstname;
    document.getElementById("vothernames").innerHTML = othernames;
    document.getElementById("vrole").innerHTML = role;
    document.getElementById("vdatecreated").innerHTML = datecreated;
    document.getElementById("vevent").innerHTML = event;
    document.getElementById("vip").innerHTML = ip;
    document.getElementById("vagent").innerHTML = agent;
    document.getElementById("vmodel").innerHTML = model;
    document.getElementById("voldvalues").innerHTML = oldvalues;
    document.getElementById("vnewvalues").innerHTML = newvalues;
})


$('#newCustomFees').on('show.bs.offcanvas', function(event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var myid = button.data('myid') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var offcanvas = $(this)
    // modal.find('.modal-body #myid').val(myid)
    offcanvas.find('.offcanvas-body #myid').val(myid)
})

$('#updateCustomFees').on('show.bs.offcanvas', function(event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var myid = button.data('myid') // Extract info from data-* attributes
    var configtype = button.data('configtype') // Extract info from data-* attributes
    var airtime = button.data('airtime') // Extract info from data-* attributes
    var data = button.data('data') // Extract info from data-* attributes
    var electricity = button.data('electricity') // Extract info from data-* attributes
    var tv = button.data('tv') // Extract info from data-* attributes
    var inward = button.data('inward') // Extract info from data-* attributes
    var outward = button.data('outward') // Extract info from data-* attributes
    var withdrawal = button.data('withdrawal') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var offcanvas = $(this)
    // modal.find('.modal-body #myid').val(myid)
    offcanvas.find('.offcanvas-body #myid').val(myid)
    offcanvas.find('.offcanvas-body #airtime').val(airtime)
    offcanvas.find('.offcanvas-body #data').val(data)
    offcanvas.find('.offcanvas-body #electricity').val(electricity)
    offcanvas.find('.offcanvas-body #tv').val(tv)
    offcanvas.find('.offcanvas-body #inward').val(inward)
    offcanvas.find('.offcanvas-body #outward').val(outward)
    offcanvas.find('.offcanvas-body #withdrawal').val(withdrawal)
    $('#configtype').select2({
        dropdownParent: $('#updateCustomFees'),
    }).val(configtype).trigger('change');
})

$('#viewAdmin').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var surname = button.data('surname') // Extract info from data-* attributes
    var firstname = button.data('firstname') // Extract info from data-* attributes
    var othernames = button.data('othernames') // Extract info from data-* attributes
    var email = button.data('email') // Extract info from data-* attributes
    var phone = button.data('phone') // Extract info from data-* attributes
    var role = button.data('role') // Extract info from data-* attributes
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
    var datecreated = button.data('datecreated') // Extract info from data-* attributes

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

