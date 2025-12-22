<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Peace Mass Transit (PMT)</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="{{ asset('backend/assets/img/kaiadmin/favicon.ico') }}" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Fonts and icons -->
    <script src="{{ asset('backend/assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["{{ asset('backend/assets/css/fonts.min.css') }}"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('backend/assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('backend/assets/css/kaiadmin.min.css') }}?version={{ date('his') }}" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/demo.css') }}" />

    <script src="{{ asset('backend/assets/countries/js/countries.js') }}"></script>

    <link href="{{ asset('backend/assets/select2/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/assets/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
        integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    <style type="text/css">
        .back-to-home-label {
            display: inline-flex;
            align-items: center;
            padding: 8px 15px;
            font-size: 12px;
            font-weight: 600;
            color: black;
            background-color: #f0f0f0;
            border: 1px solid #dcdcdc;
            border-radius: 20px;
            text-decoration: none;
            transition: background-color 0.3s, color 0.3s;
        }

        .back-to-home-label i {
            margin-right: 8px;
            /* Space between icon and text */
            font-size: 16px;
            color: #007bff;
        }

        .back-to-home-label:hover {
            background-color: #007bff;
            color: #ffffff;
        }

        .back-to-home-label:hover i {
            color: #ffffff;
        }

        .large-checkbox {
            transform: scale(1.3);
            /* Adjust to make it larger or smaller */
            -webkit-transform: scale(1.3);
            /* For Safari */
            margin-right: 6px;
            /* Optional: add space between the checkbox and label */
        }

        legend {
            display: block;
            width: 100%;
            padding: 0;
            margin-bottom: 20px;
            font-size: 21px;
            line-height: inherit;
            color: #333;
            border: 0;
            border-bottom: 1px solid #e5e5e5;
        }

        .vertical-text {
            writing-mode: vertical-rl;
            /* Vertical text from top to bottom, right to left */
            text-orientation: upright;
            /* Ensures characters remain upright */
            font-size: 16px;
            border: 1px solid #000;
            /* Optional, for visualization */
            height: 200px;
            /* Optional, adjusts based on your content */
        }

        .list-item {
            border-bottom: 1px solid #dee2e6 !important;
            padding-left: 15px;
            padding-top: 5px;
            padding-bottom: 5px;
            color: #494F55;
            font-weight: bold;
        }

        .list-item .text-danger {
            font-size: 9px;
        }

        .panel-heading {
            font-weight: bold;
            padding-left: 15px;
            padding-top: 8px;
            padding-bottom: 8px;
            border-bottom: 1px solid #dee2e6 !important;
        }

        .gradePecent {
            font-size: 11px;
            font-weight: bold;
        }

        .msubj {
            font-weight: bold;
        }

        .th {
            font-weight: bolder;
            white-space: nowrap;
            padding-left: 22px !important;
        }

        .thh {
            font-weight: bolder;
            padding-left: 22px !important;
        }

        .filterButton {
            padding-top: 35px;
        }

        .pillButton {
            padding-top: 12px;
        }

        .cstFilter {
            padding-top: 10px !important;
        }

        legend {
            background-color: #758698;
            /* Bootstrap primary color */
            color: #fff;
            /* Text color */
            /* padding: 5px 15px; */
            /* Padding around the text */
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
            /* Slightly rounded corners */
            display: inline-block;
            /* Fit content width */
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
            /* Optional shadow */
        }

        .gfuns {
            display: inline-block;
            width: 1.25rem;
            height: 1.25rem;
            border-radius: 3px;
            border: 1px solid rgba(0, 40, 100, .12);
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, .05);
        }
        th{

            font-size: 12px !important;
        }
        td{

            font-size: 13px !important;
        }
    </style>
</head>
