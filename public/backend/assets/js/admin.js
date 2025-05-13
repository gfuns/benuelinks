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

$('#scheduleConfig').select2({
    dropdownParent: $('#offcanvasRight')
});

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

$('#depTime').select2({
    dropdownParent: $('#offcanvasRight')
});

$('#channel').select2({
    dropdownParent: $('#offcanvasRight')
});

$('#vehChoice').select2({
    dropdownParent: $('#offcanvasRight')
});

$('#seat').select2({
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

$('#takeoff').select2({
    dropdownParent: $('#offcanvasRight')
});

$('#destination').select2({
    dropdownParent: $('#offcanvasRight')
});

$('#station').select2({
    dropdownParent: $('#offcanvasRight')
});

$('#role').select2({
    dropdownParent: $('#offcanvasRight')
});


$('#fdeparture').select2({});
$('#fdestination').select2({});
$('#fterminal').select2({});
$('#event').select2({});
$('#month').select2({});

$(document).ready(function() {
       $('#example').DataTable({
           paging: true,
           searching: true,
           ordering: false,
           lengthMenu: [10, 25, 50, 100],
       });
   });

   $(document).ready(function() {
       $('#pagedexample').DataTable({
           paging: true,
           searching: false,
           ordering: false,
           lengthChange: false,
           lengthMenu: [10, 25, 50, 100],
       });
   });


   $('#editRole').on('show.bs.offcanvas', function(event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var myid = button.data('myid') // Extract info from data-* attributes
    var role = button.data('role') // Extract info from data-* attributes
    var category = button.data('category') // Extract info from data-* attributes

    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var offcanvas = $(this)
    // modal.find('.modal-body #myid').val(myid)
    offcanvas.find('.offcanvas-body #myid').val(myid)
    offcanvas.find('.offcanvas-body #urole').val(role)
    $('#category').select2({
        dropdownParent: $('#editRole'),
    }).val(category).trigger('change');
})

$('#editUser').on('show.bs.offcanvas', function(event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var myid = button.data('myid') // Extract info from data-* attributes
    var lastname = button.data('lastname') // Extract info from data-* attributes
    var othernames = button.data('othernames') // Extract info from data-* attributes
    var email = button.data('email') // Extract info from data-* attributes
    var phone = button.data('phone') // Extract info from data-* attributes
    var station = button.data('station') // Extract info from data-* attributes
    var role = button.data('role') // Extract info from data-* attributes

    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var offcanvas = $(this)
    // modal.find('.modal-body #myid').val(myid)
    offcanvas.find('.offcanvas-body #myid').val(myid)
    offcanvas.find('.offcanvas-body #lastname').val(lastname)
    offcanvas.find('.offcanvas-body #othernames').val(othernames)
    offcanvas.find('.offcanvas-body #email').val(email)
    offcanvas.find('.offcanvas-body #phone').val(phone)
    $('#usrstation').select2({
        dropdownParent: $('#editUser'),
    }).val(station).trigger('change');
    $('#usrrole').select2({
        dropdownParent: $('#editUser'),
    }).val(role).trigger('change');
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
    var state = button.data('state') // Extract info from data-* attributes
    var terminal = button.data('terminal') // Extract info from data-* attributes
    var lga = button.data('lga') // Extract info from data-* attributes
    var state = button.data('state') // Extract info from data-* attributes
    var address = button.data('address') // Extract info from data-* attributes

    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var offcanvas = $(this)
    // modal.find('.modal-body #myid').val(myid)
    offcanvas.find('.offcanvas-body #myid').val(myid)
    offcanvas.find('.offcanvas-body #terminal').val(terminal)
    offcanvas.find('.offcanvas-body #lga').val(lga)
    offcanvas.find('.offcanvas-body #state').val(state)
    offcanvas.find('.offcanvas-body #address').val(address)
    $('#ustate').select2({
        dropdownParent: $('#editTerminal'),
    }).val(state).trigger('change');
})

$('#editVehicle').on('show.bs.offcanvas', function(event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var myid = button.data('myid') // Extract info from data-* attributes
    var model = button.data('model') // Extract info from data-* attributes
    var year = button.data('year') // Extract info from data-* attributes
    var color = button.data('color') // Extract info from data-* attributes
    var manufacturer = button.data('manufacturer') // Extract info from data-* attributes
    var enginenumber = button.data('enginenumber') // Extract info from data-* attributes
    var chassisnumber = button.data('chassisnumber') // Extract info from data-* attributes
    var vehiclenumber = button.data('vehiclenumber') // Extract info from data-* attributes
    var platenumber = button.data('platenumber') // Extract info from data-* attributes
    var seats = button.data('seats') // Extract info from data-* attributes

    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var offcanvas = $(this)
    // modal.find('.modal-body #myid').val(myid)
    offcanvas.find('.offcanvas-body #myid').val(myid)
    offcanvas.find('.offcanvas-body #model').val(model)
    offcanvas.find('.offcanvas-body #color').val(color)
    offcanvas.find('.offcanvas-body #year').val(year)
    offcanvas.find('.offcanvas-body #plateno').val(platenumber)
    offcanvas.find('.offcanvas-body #engno').val(enginenumber)
    offcanvas.find('.offcanvas-body #chasno').val(chassisnumber)
    offcanvas.find('.offcanvas-body #pmtno').val(vehiclenumber)
    offcanvas.find('.offcanvas-body #manufacturer').val(manufacturer)
    offcanvas.find('.offcanvas-body #seats').val(seats)
})

$('#editRoute').on('show.bs.offcanvas', function(event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var myid = button.data('myid') // Extract info from data-* attributes
    var destination = button.data('destination') // Extract info from data-* attributes
    var departure = button.data('departure') // Extract info from data-* attributes
    var tp = button.data('tp') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var offcanvas = $(this)
    offcanvas.find('.offcanvas-body #myid').val(myid)
    offcanvas.find('.offcanvas-body #tp').val(tp)
    $('#utakeoff').select2({
        dropdownParent: $('#editRoute'),
    }).val(departure).trigger('change');
    $('#udestination').select2({
        dropdownParent: $('#editRoute'),
    }).val(destination).trigger('change');

})


$('#vehicleDetails').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var model = button.data('model') // Extract info from data-* attributes
    var year = button.data('year') // Extract info from data-* attributes
    var color = button.data('color') // Extract info from data-* attributes
    var manufacturer = button.data('manufacturer') // Extract info from data-* attributes
    var enginenumber = button.data('enginenumber') // Extract info from data-* attributes
    var chassisnumber = button.data('chassisnumber') // Extract info from data-* attributes
    var status = button.data('status') // Extract info from data-* attributes
    var vehiclenumber = button.data('vehiclenumber') // Extract info from data-* attributes
    var platenumber = button.data('platenumber') // Extract info from data-* attributes
    var driver = button.data('driver') // Extract info from data-* attributes
    var seats = button.data('seats') // Extract info from data-* attributes
    var dp = button.data('dp') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var modal = $(this)
    document.getElementById("vmodel").innerHTML = model;
    document.getElementById("vyear").innerHTML = year;
    document.getElementById("vcolor").innerHTML = color;
    document.getElementById("vmanufacturer").innerHTML = manufacturer;
    document.getElementById("venginenumber").innerHTML = enginenumber;
    document.getElementById("vchassisnumber").innerHTML = chassisnumber;
    document.getElementById("vstatus").innerHTML = status;
    document.getElementById("vvehiclenumber").innerHTML = vehiclenumber;
    document.getElementById("vplatenumber").innerHTML = platenumber;
    document.getElementById("vdriver").innerHTML = driver;
    document.getElementById("vseats").innerHTML = seats;
    document.getElementById("vdp").src = dp;
})

$('#bookingDetails').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var bookingno = button.data('bookingno') // Extract info from data-* attributes
    var passenger = button.data('passenger') // Extract info from data-* attributes
    var phoneno = button.data('phoneno') // Extract info from data-* attributes
    var route = button.data('route') // Extract info from data-* attributes
    var date = button.data('date') // Extract info from data-* attributes
    var vehicletype = button.data('vehicletype') // Extract info from data-* attributes
    var bookingstatus = button.data('bookingstatus') // Extract info from data-* attributes
    var paymentchannel = button.data('paymentchannel') // Extract info from data-* attributes
    var bookingmethod = button.data('bookingmethod') // Extract info from data-* attributes
    var boarding = button.data('boarding') // Extract info from data-* attributes
    var amount = button.data('amount') // Extract info from data-* attributes
    var seat = button.data('seat') // Extract info from data-* attributes
    var nok = button.data('nok') // Extract info from data-* attributes
    var nokphone = button.data('nokphone') // Extract info from data-* attributes
    var paystatus = button.data('paystatus') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var modal = $(this)
    document.getElementById("vbookingno").innerHTML = bookingno;
    document.getElementById("vpassenger").innerHTML = passenger;
    document.getElementById("vphoneno").innerHTML = phoneno;
    document.getElementById("vroute").innerHTML = route;
    document.getElementById("vdate").innerHTML = date;
    document.getElementById("vvehicletype").innerHTML = vehicletype;
    document.getElementById("vbookingstatus").innerHTML = bookingstatus;
    document.getElementById("vpaymentchannel").innerHTML = paymentchannel;
    document.getElementById("vbookingmethod").innerHTML = bookingmethod;
    document.getElementById("vboarding").innerHTML = boarding;
    document.getElementById("vamount").innerHTML = amount;
    document.getElementById("vseat").innerHTML = seat;
    document.getElementById("vnok").innerHTML = nok;
    document.getElementById("vnokphone").innerHTML = nokphone;
    document.getElementById("vpaystatus").innerHTML = paystatus;
})


$('#viewScheduleDetails').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var departure = button.data('departure') // Extract info from data-* attributes
    var destination = button.data('destination') // Extract info from data-* attributes
    var date = button.data('date') // Extract info from data-* attributes
    var time = button.data('time') // Extract info from data-* attributes
    var vehicle = button.data('vehicle') // Extract info from data-* attributes
    var driver = button.data('driver') // Extract info from data-* attributes
    var status = button.data('status') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var modal = $(this)
    document.getElementById("vdeparture").innerHTML = departure;
    document.getElementById("vdestination").innerHTML = destination;
    document.getElementById("vdate").innerHTML = date;
    document.getElementById("vtime").innerHTML = time;
    document.getElementById("vvehicle").innerHTML = vehicle;
    document.getElementById("vdriver").innerHTML = driver;
    document.getElementById("vstatus").innerHTML = status;
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

$('#adjustDepartureTime').on('show.bs.offcanvas', function(event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var myid = button.data('myid') // Extract info from data-* attributes
    var time = button.data('time') // Extract info from data-* attributes

    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var offcanvas = $(this)
    // modal.find('.modal-body #myid').val(myid)
    offcanvas.find('.offcanvas-body #myid').val(myid)
    offcanvas.find('.offcanvas-body #adepartureTime').val(time)
})

$('#assignVehicle').on('show.bs.offcanvas', function(event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var myid = button.data('myid') // Extract info from data-* attributes
    var vehicle = button.data('vehicle') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var offcanvas = $(this)
    // modal.find('.modal-body #myid').val(myid)
    offcanvas.find('.offcanvas-body #myid').val(myid)
    $('#vehicle').select2({
        dropdownParent: $('#assignVehicle'),
    }).val(vehicle).trigger('change');

})

$('#assignDriver').on('show.bs.offcanvas', function(event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var myid = button.data('myid') // Extract info from data-* attributes
    var driver = button.data('driver') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var offcanvas = $(this)
    // modal.find('.modal-body #myid').val(myid)
    offcanvas.find('.offcanvas-body #myid').val(myid)
    $('#driver').select2({
        dropdownParent: $('#assignDriver'),
    }).val(driver).trigger('change');

})


$('#viewAuthDetails').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var surname = button.data('surname') // Extract info from data-* attributes
    var terminal = button.data('terminal') // Extract info from data-* attributes
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
    document.getElementById("vstation").innerHTML = terminal;
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
    var terminal = button.data('terminal') // Extract info from data-* attributes
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
    document.getElementById("vstation").innerHTML = terminal;
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

