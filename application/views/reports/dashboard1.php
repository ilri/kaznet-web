<!DOCTYPE html>
<html>

<head>
    <title>KAZNET</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" href="../assets/images/faavicon.webp" sizes="32x32">
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Poppins:wght@400;500&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
    <link rel="stylesheet" href="../assets/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.css">

    <!-- Include jQuery and SweetAlert2 JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.js"></script>

    <script src="../assets/js/jquery.slim.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/jquery.dataTables.min.js"></script>
    <script src="../assets/js/dataTables.bootstrap4.min.js"></script>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/heatmap.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>


    <style>
        .nav-tabs.dashboard-nav .nav-item.show .nav-link,
        .nav-tabs.dashboard-nav .nav-link.active {
            color: #495057;
            background-color: transparent !important;
            border-color: #84837E #84837E #84837E !important;
            font-family: 'Open Sans';
            font-style: normal;
            font-weight: 500;
            font-size: 18px;
            line-height: 25px;
            padding: 10px 30px !important;
            color: #6d1024 !important;
        }

        .nav-tabs.dashboard-nav .nav-link {
            margin-bottom: -1px;
            background: transparent;
            font-family: 'Poppins';
            font-style: normal;
            padding: 10px 30px !important;
            font-weight: 400;
            font-size: 16px !important;
            line-height: 24px;
            color: #6d10248c !important;
            border: 1px solid transparent;
            border-top-left-radius: 5px !important;
            border-top-right-radius: 5px !important;
        }

        .chart-title {
            font-family: 'Open Sans';
            font-style: normal;
            font-weight: 600;
            font-size: 18px;
            line-height: 25px;
            color: #000000;
        }

        .card-shadow {
            background: #FFFFFF;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .h-386px {
            height: 386px;
            min-height: 386px;
        }

        .map_height {
            width: 100%;
            height: 300px;
        }

        .primary-vl {
            border-left: 4px solid #5877A3;
            height: 30px;
        }

        .primary-v2 {
            border-left: 4px solid #E49443;
            height: 30px;
        }

        .primary-v3 {
            border-left: 4px solid #6A9F58;
            height: 30px;
        }

        .primary-v4 {
            border-left: 4px solid #F1A2A7;
            height: 30px;
        }

        .primary-v5 {
            border-left: 4px solid #6FA1E7;
            height: 30px;
        }

        .primary-v6 {
            border-left: 4px solid #FFB6BA;
            height: 30px;
        }

        .primary-v7 {
            border-left: 4px solid #C8E76F;
            height: 30px;
        }

        .primary-v8 {
            border-left: 4px solid #CDCDCD;
            height: 30px;
        }

        .primary-v9 {
            border-left: 4px solid #F7BA1E;
            height: 30px;
        }

        .primary-v10 {
            border-left: 4px solid #14C9C9;
            height: 30px;
        }

        .primary-v11 {
            border-left: 4px solid #FFB6BA;
            height: 30px;
        }

        .w-100px {
            width: 100px;
        }

        .chart-legend-title {
            width: 100px !important;
            font-style: normal;
            font-weight: 400;
            font-size: 14px;
            line-height: 22px;
            align-items: center;
            color: #4E5969;
        }

        .large-bold {
            font-style: normal;
            font-weight: 500;
            font-size: 20px;
            line-height: 28px;
            color: #1D2129;
        }
    </style>
</head>

<body>

    <div class="wrapper">
        <div id="mySidenav" class="sidenav">
            <a class="mt-mb-26px" href="#">
                <span class="logo-img"><img src="../assets/images/logo.png"></span>
                <span class="collapse-text-none mb-0">KAZNET</span>
            </a>
            <hr>
            <nav id="sidebar">
                <ul class="list-unstyled components">
                    <li>
                        <a href="dashboard.html">
                            <span class="logo-img-mt-4">
                                <svg width="26" height="26" viewBox="0 0 26 26" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="bg">
                                    <path
                                        d="M10.0208 0H1.89577C0.850388 0 0 0.850388 0 1.89577V6.77077C0 7.81635 0.850388 8.66673 1.89577 8.66673H10.0208C11.0663 8.66673 11.9167 7.81635 11.9167 6.77077V1.89577C11.9167 0.850388 11.0663 0 10.0208 0Z" />
                                    <path
                                        d="M10.0208 10.8333H1.89577C0.850388 10.8333 0 11.6836 0 12.7292V24.1042C0 25.1496 0.850388 26 1.89577 26H10.0208C11.0663 26 11.9167 25.1496 11.9167 24.1042V12.7292C11.9167 11.6836 11.0663 10.8333 10.0208 10.8333Z" />
                                    <path
                                        d="M24.1042 17.3333H15.9792C14.9336 17.3333 14.0833 18.1836 14.0833 19.2292V24.1042C14.0833 25.1496 14.9336 26 15.9792 26H24.1042C25.1496 26 26 25.1496 26 24.1042V19.2292C26 18.1836 25.1496 17.3333 24.1042 17.3333Z" />
                                    <path
                                        d="M24.1042 0H15.9792C14.9336 0 14.0833 0.850388 14.0833 1.89577V13.2708C14.0833 14.3163 14.9336 15.1667 15.9792 15.1667H24.1042C25.1496 15.1667 26 14.3163 26 13.2708V1.89577C26 0.850388 25.1496 0 24.1042 0V0Z" />
                                </svg>
                            </span>
                            <span class="collapse-text-none-nav mb-0">Dashboard</span>
                        </a>
                    </li>
                    <li class="">
                        <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <span class="logo-img-mt-4">
                                <svg width="26" height="22" viewBox="0 0 26 22" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="bg">
                                    <path
                                        d="M16.2501 5.04167C15.6521 5.04167 15.1667 4.55634 15.1667 3.95834V2.33334H10.8334V3.95834C10.8334 4.55634 10.3481 5.04167 9.75008 5.04167C9.15208 5.04167 8.66675 4.55634 8.66675 3.95834V2.33334C8.66675 1.13842 9.6385 0.166672 10.8334 0.166672H15.1667C16.3617 0.166672 17.3334 1.13842 17.3334 2.33334V3.95834C17.3334 4.55634 16.8481 5.04167 16.2501 5.04167Z" />
                                    <path
                                        d="M13.7692 14.6617C13.5742 14.7375 13.2925 14.7917 13 14.7917C12.7075 14.7917 12.4258 14.7375 12.1658 14.64L0 10.5883V18.8542C0 20.5008 1.3325 21.8333 2.97917 21.8333H23.0208C24.6675 21.8333 26 20.5008 26 18.8542V10.5883L13.7692 14.6617Z" />
                                    <path
                                        d="M26 6.39584V8.87667L13.26 13.1233C13.1733 13.1558 13.0867 13.1667 13 13.1667C12.9133 13.1667 12.8267 13.1558 12.74 13.1233L0 8.87667V6.39584C0 4.74917 1.3325 3.41667 2.97917 3.41667H23.0208C24.6675 3.41667 26 4.74917 26 6.39584Z" />
                                </svg>
                            </span>
                            <span class="collapse-text-none-nav mb-0">Tasks</span>
                        </a>
                        <ul class="collapse list-unstyled" id="homeSubmenu">
                            <li>
                                <a href="../dashboard/tasks/create-template.html" class="sub-menu">Create Template</a>
                            </li>
                            <li>
                                <a href="../dashboard/tasks/assign-tasks.html" class="sub-menu">Assign Tasks</a>
                            </li>
                            <li>
                                <a href="../dashboard/tasks/view-tasks.html" class="sub-menu">View Tasks</a>
                            </li>
                        </ul>
                    </li>
                    <li class="">
                        <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <span class="logo-img-mt-4">
                                <svg width="26" height="23" viewBox="0 0 26 23" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="bg">
                                    <path
                                        d="M22.2468 11.9072H20.2361C20.441 12.4683 20.553 13.0739 20.553 13.705V21.3045C20.553 21.5676 20.5072 21.8202 20.4239 22.0551H23.7481C24.9898 22.0551 26 21.0449 26 19.8032V15.6604C26.0001 13.5909 24.3164 11.9072 22.2468 11.9072Z" />
                                    <path
                                        d="M5.44705 13.7051C5.44705 13.0739 5.55902 12.4684 5.76398 11.9072H3.75324C1.6837 11.9072 0 13.5909 0 15.6605V19.8033C0 21.045 1.01019 22.0552 2.25195 22.0552H5.57619C5.49286 21.8202 5.44705 21.5677 5.44705 21.3045V13.7051Z" />
                                    <path
                                        d="M15.2983 9.95186H10.7015C8.63195 9.95186 6.94824 11.6356 6.94824 13.7051V21.3045C6.94824 21.719 7.28431 22.0552 7.69889 22.0552H18.3009C18.7155 22.0552 19.0515 21.7191 19.0515 21.3045V13.7051C19.0515 11.6356 17.3678 9.95186 15.2983 9.95186Z" />
                                    <path
                                        d="M13.0001 0C10.5112 0 8.48633 2.02485 8.48633 4.51379C8.48633 6.20202 9.41811 7.67645 10.7942 8.45056C11.4469 8.81771 12.1994 9.02754 13.0001 9.02754C13.8008 9.02754 14.5533 8.81771 15.206 8.45056C16.5821 7.67645 17.5138 6.20196 17.5138 4.51379C17.5138 2.0249 15.489 0 13.0001 0Z" />
                                    <path
                                        d="M4.07393 4.20717C2.21254 4.20717 0.698242 5.72147 0.698242 7.58285C0.698242 9.44424 2.21254 10.9585 4.07393 10.9585C4.54609 10.9585 4.99571 10.8607 5.40414 10.6849C6.1103 10.3809 6.69256 9.84272 7.05286 9.1686C7.30575 8.69547 7.44961 8.15572 7.44961 7.58285C7.44961 5.72152 5.93531 4.20717 4.07393 4.20717Z" />
                                    <path
                                        d="M21.926 4.20717C20.0646 4.20717 18.5503 5.72147 18.5503 7.58285C18.5503 8.15577 18.6942 8.69552 18.947 9.1686C19.3073 9.84277 19.8896 10.3809 20.5958 10.6849C21.0042 10.8607 21.4538 10.9585 21.926 10.9585C23.7874 10.9585 25.3017 9.44424 25.3017 7.58285C25.3017 5.72147 23.7874 4.20717 21.926 4.20717Z" />
                                </svg>
                            </span>
                            <span class="collapse-text-none-nav mb-0">Contributors</span>
                        </a>
                        <ul class="collapse list-unstyled" id="pageSubmenu">
                            <li>
                                <a href="../dashboard/contributor/index.html" class="sub-menu">Create Contributor</a>
                            </li>
                            <li>
                                <a href="../dashboard/contributor/manage-contributor.html" class="sub-menu">Manage
                                    Contributor</a>
                            </li>
                            <li>
                                <a href="../dashboard/contributor/mapping-contributor.html" class="sub-menu">Mapping
                                    Contributor</a>
                            </li>
                        </ul>
                    </li>

                    <li class="">
                        <a href="#pageSubmenu1" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <span class="logo-img-mt-4">
                                <svg width="20" height="26" viewBox="0 0 20 26" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="bg ">
                                    <path
                                        d="M13.2708 6.5H6.22909C5.18367 6.5 4.33325 5.64958 4.33325 4.60417V2.97917C4.33325 2.53067 4.69725 2.16667 5.14575 2.16667H6.88342C7.23875 0.917583 8.38817 0 9.74992 0C11.1117 0 12.2611 0.917583 12.6164 2.16667H14.3541C14.8026 2.16667 15.1666 2.53067 15.1666 2.97917V4.60417C15.1666 5.64958 14.3162 6.5 13.2708 6.5Z" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M16.5208 3.25H16.25V4.60417C16.25 6.24758 14.9142 7.58333 13.2708 7.58333H6.22917C4.58575 7.58333 3.25 6.24758 3.25 4.60417V3.25H2.97917C1.33575 3.25 0 4.58575 0 6.22917V23.0208C0 24.6643 1.33575 26 2.97917 26H16.5208C18.1643 26 19.5 24.6643 19.5 23.0208V6.22917C19.5 4.58575 18.1643 3.25 16.5208 3.25ZM15.4375 22.75H4.0625C3.614 22.75 3.25 22.386 3.25 21.9375C3.25 21.489 3.614 21.125 4.0625 21.125H15.4375C15.886 21.125 16.25 21.489 16.25 21.9375C16.25 22.386 15.886 22.75 15.4375 22.75ZM4.0625 19.5H15.4375C15.886 19.5 16.25 19.136 16.25 18.6875C16.25 18.239 15.886 17.875 15.4375 17.875H4.0625C3.614 17.875 3.25 18.239 3.25 18.6875C3.25 19.136 3.614 19.5 4.0625 19.5ZM15.4375 16.25H4.0625C3.614 16.25 3.25 15.886 3.25 15.4375C3.25 14.989 3.614 14.625 4.0625 14.625H15.4375C15.886 14.625 16.25 14.989 16.25 15.4375C16.25 15.886 15.886 16.25 15.4375 16.25ZM5.74768 13H13.7523C14.0679 13 14.3241 12.636 14.3241 12.1875C14.3241 11.739 14.0679 11.375 13.7523 11.375H5.74768C5.43207 11.375 5.17593 11.739 5.17593 12.1875C5.17593 12.636 5.43207 13 5.74768 13Z" />
                                </svg>
                            </span>
                            <span class="collapse-text-none-nav mb-0">Survey Data</span>
                        </a>
                        <ul class="collapse list-unstyled" id="pageSubmenu1">
                            <li>
                                <a href="../../dashboard/data/milk-production.html" class="sub-menu">Milk Production</a>
                            </li>
                            <li>
                                <a href="../../dashboard/data/bcaw.html" class="sub-menu">Body condition and weight</a>
                            </li>
                            <li>
                                <a href="../../dashboard/data/livestock-price.html" class="sub-menu">Livestock Prices &
                                    Quality</a>
                            </li>
                            <li>
                                <a href="../../dashboard/data/muac.html" class="sub-menu">MUAC</a>
                            </li>
                            <li>
                                <a href="#" class="sub-menu">Prices of Index commodities</a>
                            </li>
                            <li>
                                <a href="#" class="sub-menu">RCSI</a>
                            </li>
                            <li>
                                <a href="#" class="sub-menu">Transect forage conditions</a>
                            </li>
                            <li>
                                <a href="#" class="sub-menu">Livestock births and deaths trade</a>
                            </li>
                            <li>
                                <a href="#" class="sub-menu">Household profile</a>
                            </li>
                            <li>
                                <a href="#" class="sub-menu">Contributor profile</a>
                            </li>
                        </ul>
                    </li>

                    <!-- <li>
                        <a href="../dashboard/data/task-data.html">
                            <span class="logo-img-mt-4">
                                <svg width="20" height="26" viewBox="0 0 20 26" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="bg">
                                    <path
                                        d="M13.2708 6.5H6.22909C5.18367 6.5 4.33325 5.64958 4.33325 4.60417V2.97917C4.33325 2.53067 4.69725 2.16667 5.14575 2.16667H6.88342C7.23875 0.917583 8.38817 0 9.74992 0C11.1117 0 12.2611 0.917583 12.6164 2.16667H14.3541C14.8026 2.16667 15.1666 2.53067 15.1666 2.97917V4.60417C15.1666 5.64958 14.3162 6.5 13.2708 6.5Z" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M16.5208 3.25H16.25V4.60417C16.25 6.24758 14.9142 7.58333 13.2708 7.58333H6.22917C4.58575 7.58333 3.25 6.24758 3.25 4.60417V3.25H2.97917C1.33575 3.25 0 4.58575 0 6.22917V23.0208C0 24.6643 1.33575 26 2.97917 26H16.5208C18.1643 26 19.5 24.6643 19.5 23.0208V6.22917C19.5 4.58575 18.1643 3.25 16.5208 3.25ZM15.4375 22.75H4.0625C3.614 22.75 3.25 22.386 3.25 21.9375C3.25 21.489 3.614 21.125 4.0625 21.125H15.4375C15.886 21.125 16.25 21.489 16.25 21.9375C16.25 22.386 15.886 22.75 15.4375 22.75ZM4.0625 19.5H15.4375C15.886 19.5 16.25 19.136 16.25 18.6875C16.25 18.239 15.886 17.875 15.4375 17.875H4.0625C3.614 17.875 3.25 18.239 3.25 18.6875C3.25 19.136 3.614 19.5 4.0625 19.5ZM15.4375 16.25H4.0625C3.614 16.25 3.25 15.886 3.25 15.4375C3.25 14.989 3.614 14.625 4.0625 14.625H15.4375C15.886 14.625 16.25 14.989 16.25 15.4375C16.25 15.886 15.886 16.25 15.4375 16.25ZM5.74768 13H13.7523C14.0679 13 14.3241 12.636 14.3241 12.1875C14.3241 11.739 14.0679 11.375 13.7523 11.375H5.74768C5.43207 11.375 5.17593 11.739 5.17593 12.1875C5.17593 12.636 5.43207 13 5.74768 13Z" />
                                </svg>
                            </span>
                            <span class="collapse-text-none-nav mb-0">Survey Data</span>
                        </a>
                    </li> -->
                </ul>


            </nav>
        </div>

        <div id="main-content">
            <span class="btn btn-light expand-collapse-btn" id="sidebarCollapse"><span><img
                        src="../assets/images/collapse-arrow.svg"></span></span>
            <nav class="navbar navbar-expand-md bg-dark navbar-dark" height="110px">
                <a class="navbar-brand" href="javascript:void(0);">
                    <span class="nav-text">Profile</span>
                    <p class="mb-0 text-small">Sunday, <span class="text-date">18 December 2020</span></p>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="collapsibleNavbar">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span class="search-img"><span><img src="../assets/images/search.png"></span><input
                                        type="text" class="form-control search-input" name=""
                                        placeholder="Search"></span>
                            </a>
                        </li>
                        <li class="nav-item pr-4 pl-4">
                            <a class="nav-link" href="#">
                                <img src="../assets/images/notification1.png">
                            </a>
                        </li>

                        <li class="nav-item">
                            <div class="dropdown mt-3">
                                <span class="dropdown-toggle drop-arrow-one" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <img class="pr-3" src="../assets/images/user-1.png" height="30px"> John Millar
                                </span>
                                <div class="dropdown-menu tbl-drop-filter border-0 p-0"
                                    aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#" style="background: #6F1B28;">
                                        <div class="d-flex align-items-center">
                                            <div class="pr-3 mt-3 mb-3">
                                                <img src="../assets/images/user-1.png">
                                            </div>
                                            <div class="profile-title">
                                                <h6 class="mb-0">John Millar</h6>
                                                <p class="mb-0">johnmiller123@gmail.com</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="dropdown-item my-2" href="../dashboard/profile.html"><img class="pr-2"
                                            src="../assets/images/profile.svg" /> My Profile</a>
                                    <a class="dropdown-item my-2" href="#"><img class="pr-2"
                                            src="../assets/images/settings.svg" /> Settings</a>
                                    <a class="dropdown-item my-2" href="#"><img class="pr-2"
                                            src="../assets/images/logout.svg" /> Logout</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>



            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 mt-3">
                        <nav>
                            <ol class="breadcrumb mb-0 bg-transparent">
                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="card border-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs dashboard-nav">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab"
                                                    href="#dashboardUsers">Users</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab"
                                                    href="#dashboardHousehold">Household</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#dashboardMarket">Market</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab"
                                                    href="#dashboardRangeland">Rangeland</a>
                                            </li>
                                        </ul>
                                        <!-- Tab panes -->
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-11">
                                        <!-- <div class="d-flex justify-content-between align-items-center flex-wrap">
                                            <div class="form-group my-3 col">
                                                <label for="" class="label-text">Country</label>
                                                <select class="form-control">
                                                    <option>Country</option>
                                                </select>
                                            </div>  

                                            <div
                                            class="form-group my-3 d-flex justify-content-around align-items-center mt-4 pt-4 col">
                                            <div class="form-check form-check-inline mt-2">
                                                <input class="form-check-input" type="radio"
                                                    name="inlineRadioOptions" id="inlineRadio1" value="option1">
                                                <label class="form-check-label" for="inlineRadio1">UAI</label>
                                            </div>
                                            <div class="form-check form-check-inline mt-2">
                                                <input class="form-check-input" type="radio"
                                                    name="inlineRadioOptions" id="inlineRadio2" value="option2">
                                                <label class="form-check-label"
                                                    for="inlineRadio2">Cluster</label>
                                            </div>
                                        </div>

                                        <div class="form-group my-3 col">
                                            <label for="" class="label-text">Unit Area of
                                                Identification</label>
                                            <select class="form-control">
                                                <option>Data</option>
                                            </select>
                                        </div>

                                        <div class="form-group my-3 col">
                                            <label for="" class="label-text">Sub Location</label>
                                            <select class="form-control">
                                                <option>Data</option>
                                            </select>
                                        </div>


                                        <div class="form-group my-3 col">
                                            <label for="" class="label-text">Start Date</label>
                                            <input type="date" name="" class="form-control" placeholder="Date" />
                                        </div>

                                        <div class="form-group my-3 col">
                                            <label for="" class="label-text">End Date</label>
                                            <input type="date" name="" class="form-control"  placeholder="Date" />
                                        </div>
                                        </div> -->
                                        <div class="row">
                                            <div class="col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group my-3">
                                                    <label for="" class="label-text">Country</label>
                                                    <select class="form-control">
                                                        <option>Country</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-2 col-lg-3">
                                                <div
                                                    class="form-group my-3 d-flex justify-content-around align-items-center mt-4 pt-4">
                                                    <div class="form-check form-check-inline mt-2">
                                                        <input class="form-check-input" type="radio"
                                                            name="inlineRadioOptions" id="inlineRadio1" value="option1">
                                                        <label class="form-check-label" for="inlineRadio1">UAI</label>
                                                    </div>
                                                    <div class="form-check form-check-inline mt-2">
                                                        <input class="form-check-input" type="radio"
                                                            name="inlineRadioOptions" id="inlineRadio2" value="option2">
                                                        <label class="form-check-label"
                                                            for="inlineRadio2">Cluster</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group my-3">
                                                    <label for="" class="label-text">Unit Area of
                                                        Identification</label>
                                                    <select class="form-control">
                                                        <option>Data</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group my-3">
                                                    <label for="" class="label-text">Sub Location</label>
                                                    <select class="form-control">
                                                        <option>Data</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-md-3 col-lg-3">
                                                <label for="" class="label-text">Start Date</label>
                                                <input type="date" name="" class="form-control" placeholder="Date" />
                                            </div>
                                            <div class="col-sm-12 col-md-3 col-lg-3">
                                                <label for="" class="label-text">End Date</label>
                                                <input type="date" name="" class="form-control" placeholder="Date" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="tab-content mt-4">
                                            <div class="tab-pane active" id="dashboardUsers">
                                                <div class="row mt-4">
                                                    <div class="col-sm-12 col-md-8 col-lg-8">
                                                        <img src="../assets/images/dashboardusers.png" alt=""
                                                            width="100%" height="386px">
                                                    </div>
                                                    <div class="col-sm-12 col-md-3 col-lg-3">
                                                        <div class="card border-0 card-shadow h-386px">
                                                            <div class="card-body">
                                                                <ul class="list-group">
                                                                    <li class="list-group-item border-0"><img
                                                                            src="../assets/images/location-pin.svg">
                                                                        <span class="pl-2">Location 1</span>
                                                                    </li>
                                                                    <li class="list-group-item border-0"><img
                                                                            src="../assets/images/location-pin.svg">
                                                                        <span class="pl-2">Location 2</span>
                                                                    </li>
                                                                    <li class="list-group-item border-0"><img
                                                                            src="../assets/images/location-pin.svg">
                                                                        <span class="pl-2">Location 3</span>
                                                                    </li>
                                                                    <li class="list-group-item border-0"><img
                                                                            src="../assets/images/location-pin.svg">
                                                                        <span class="pl-2">Location 4</span>
                                                                    </li>
                                                                    <li class="list-group-item border-0"><img
                                                                            src="../assets/images/location-pin.svg">
                                                                        <span class="pl-2">Location 5</span>
                                                                    </li>
                                                                    <li class="list-group-item border-0"><img
                                                                            src="../assets/images/location-pin.svg">
                                                                        <span class="pl-2">Location 6</span>
                                                                    </li>
                                                                    <li class="list-group-item border-0"><img
                                                                            src="../assets/images/location-pin.svg">
                                                                        <span class="pl-2">Location 7</span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-4">
                                                    <div class="col-sm-12 col-md-11 col-lg-11">
                                                        <div class="row">
                                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                                <div class="card border-0 card-shadow">
                                                                    <div class="card-body">
                                                                        <h4 class="chart-title">No.of Contributors</h4>
                                                                        <div
                                                                            class="d-flex justify-content-around align-items-center flex-wrap">
                                                                            <div class="map_height"
                                                                                id="number_of_contributors"
                                                                                style="width:260px;height: 260px;">
                                                                            </div>
                                                                            <div class="">
                                                                                <div class="primary-vl mt-3">
                                                                                    <div class="mb-0 mt-1 pl-2">
                                                                                        <span
                                                                                            class="chart-legend-title">Approved</span>
                                                                                        <span
                                                                                            class="large-bold pl-3">30</span>%
                                                                                    </div>
                                                                                </div>
                                                                                <div class="primary-v2 mt-3">
                                                                                    <div class="mb-0 mt-1 pl-2">
                                                                                        <span
                                                                                            class="chart-legend-title">Rejected</span><span
                                                                                            class="large-bold pl-3">20</span>%
                                                                                    </div>
                                                                                </div>
                                                                                <div class="primary-v3 mt-3">
                                                                                    <div class="mb-0 mt-1 pl-2">
                                                                                        <span
                                                                                            class="chart-legend-title">Active</span><span
                                                                                            class="large-bold pl-3">30</span>%
                                                                                    </div>
                                                                                </div>
                                                                                <div class="primary-v4 mt-3">
                                                                                    <div class="mb-0 mt-1 pl-2">
                                                                                        <span
                                                                                            class="chart-legend-title">Inactive</span><span
                                                                                            class="large-bold pl-3">20</span>%
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                                <div class="card border-0 card-shadow">
                                                                    <div class="card-body">
                                                                        <h4 class="chart-title">Rejected Reasons</h4>
                                                                        <div
                                                                            class="d-flex justify-content-around align-items-center flex-wrap">
                                                                            <div class="map_height"
                                                                                id="rejected_reasons"
                                                                                style="width:260px;height: 260px;">
                                                                            </div>
                                                                            <div class="">
                                                                                <div class="primary-vl mt-3">
                                                                                    <div class="mb-0 mt-1 pl-2">
                                                                                        <span
                                                                                            class="chart-legend-title">Approved</span>
                                                                                        <span
                                                                                            class="large-bold pl-3">30%</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="primary-v2 mt-3">
                                                                                    <div class="mb-0 mt-1 pl-2">
                                                                                        <span
                                                                                            class="chart-legend-title">Rejected</span><span
                                                                                            class="large-bold pl-3">20%</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="primary-v3 mt-3">
                                                                                    <div class="mb-0 mt-1 pl-2">
                                                                                        <span
                                                                                            class="chart-legend-title">Active</span><span
                                                                                            class="large-bold pl-3">30%</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="primary-v4 mt-3">
                                                                                    <div class="mb-0 mt-1 pl-2">
                                                                                        <span
                                                                                            class="chart-legend-title">Inactive</span><span
                                                                                            class="large-bold pl-3">20%</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mt-4">
                                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                                <div class="card border-0 card-shadow">
                                                                    <div class="card-body">
                                                                        <h4 class="chart-title">Sex</h4>
                                                                        <div
                                                                            class="d-flex justify-content-around align-items-center flex-wrap">
                                                                            <div class="map_height" id="sex_dashboard"
                                                                                style="width:260px;height: 260px;">
                                                                            </div>
                                                                            <div class="">
                                                                                <div class="primary-v5 mt-3">
                                                                                    <div class="mb-0 mt-1 pl-2">
                                                                                        <span
                                                                                            class="chart-legend-title">Male</span>
                                                                                        <span
                                                                                            class="large-bold pl-3">30%</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="primary-v6 mt-3">
                                                                                    <div class="mb-0 mt-1 pl-2">
                                                                                        <span
                                                                                            class="chart-legend-title">Female</span><span
                                                                                            class="large-bold pl-3">20%</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                                <div class="card border-0 card-shadow">
                                                                    <div class="card-body">
                                                                        <h4 class="chart-title">Contributors</h4>
                                                                        <div class="map_height"
                                                                            id="contributors_dashboard"
                                                                            style="width:100%;height: 260px;">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mt-4">
                                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                                <div class="card border-0 card-shadow">
                                                                    <div class="card-body">
                                                                        <h4 class="chart-title">Account Details Status
                                                                        </h4>
                                                                        <div
                                                                            class="d-flex justify-content-around align-items-center flex-wrap">
                                                                            <div class="map_height"
                                                                                id="account_details_status"
                                                                                style="width:260px;height: 260px;">
                                                                            </div>
                                                                            <div class="">
                                                                                <div class="primary-v7 mt-3">
                                                                                    <div class="mb-0 mt-1 pl-2">
                                                                                        <span
                                                                                            class="chart-legend-title">Available</span>
                                                                                        <span
                                                                                            class="large-bold pl-3">30%</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="primary-v8 mt-3">
                                                                                    <div class="mb-0 mt-1 pl-2">
                                                                                        <span
                                                                                            class="chart-legend-title">Not
                                                                                            Available</span><span
                                                                                            class="large-bold pl-3">20%</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                                <div class="card border-0 card-shadow">
                                                                    <div class="card-body">
                                                                        <h4 class="chart-title">Respondents</h4>
                                                                        <div
                                                                            class="d-flex justify-content-around align-items-center flex-wrap">
                                                                            <div class="map_height"
                                                                                id="respondent_dashboard"
                                                                                style="width:260px;height: 260px;">
                                                                            </div>
                                                                            <div class="">
                                                                                <div class="primary-vl mt-3">
                                                                                    <div class="mb-0 mt-1 pl-2">
                                                                                        <span
                                                                                            class="chart-legend-title">Submitted</span>
                                                                                        <span
                                                                                            class="large-bold pl-3">30%</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="primary-v2 mt-3">
                                                                                    <div class="mb-0 mt-1 pl-2">
                                                                                        <span
                                                                                            class="chart-legend-title">Profile
                                                                                            Pending</span><span
                                                                                            class="large-bold pl-3">20%</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="primary-v3 mt-3">
                                                                                    <div class="mb-0 mt-1 pl-2">
                                                                                        <span
                                                                                            class="chart-legend-title">Approved</span><span
                                                                                            class="large-bold pl-3">30%</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="primary-v4 mt-3">
                                                                                    <div class="mb-0 mt-1 pl-2">
                                                                                        <span
                                                                                            class="chart-legend-title">Rejected</span><span
                                                                                            class="large-bold pl-3">20%</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mt-4">
                                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                                <div class="card border-0 card-shadow">
                                                                    <div class="card-body">
                                                                        <h4 class="chart-title">Sex</h4>
                                                                        <div
                                                                            class="d-flex justify-content-around align-items-center flex-wrap">
                                                                            <div class="map_height"
                                                                                id="sex_dashboard_one"
                                                                                style="width:260px;height: 260px;">
                                                                            </div>
                                                                            <div class="">
                                                                                <div class="primary-v5 mt-3">
                                                                                    <div class="mb-0 mt-1 pl-2">
                                                                                        <span
                                                                                            class="chart-legend-title">Male</span>
                                                                                        <span
                                                                                            class="large-bold pl-3">30%</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="primary-v6 mt-3">
                                                                                    <div class="mb-0 mt-1 pl-2">
                                                                                        <span
                                                                                            class="chart-legend-title">Female</span><span
                                                                                            class="large-bold pl-3">20%</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                                <div class="card border-0 card-shadow">
                                                                    <div class="card-body">
                                                                        <h4 class="chart-title">Houshold Profile</h4>
                                                                        <div class="map_height" id="household_profile"
                                                                            style="width:100%;height: 260px;">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mt-4">
                                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                                <div class="card border-0 card-shadow">
                                                                    <div class="card-body">
                                                                        <h4 class="chart-title">No.of Household members
                                                                            suffering from Disability, Chronic Illness
                                                                        </h4>
                                                                        <div class="map_height"
                                                                            id="number_of_household_members_suffering"
                                                                            style="width:100%;height: 260px;">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                                <div class="card border-0 card-shadow">
                                                                    <div class="card-body">
                                                                        <h4 class="chart-title">No.of Children</h4>
                                                                        <div class="map_height" id="number_of_children"
                                                                            style="width:100%;height: 260px;">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mt-4">
                                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                                <div class="card border-0 card-shadow">
                                                                    <div class="card-body">
                                                                        <h4 class="chart-title">Household Head</h4>
                                                                        <div class="map_height" id="household_head"
                                                                            style="width:100%;height: 260px;">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                                <div class="card border-0 card-shadow">
                                                                    <div class="card-body">
                                                                        <h4 class="chart-title">Livestock (Number)</h4>
                                                                        <div class="map_height" id="Livestock_Number"
                                                                            style="width:100%;height: 260px;">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mt-4">
                                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                                <div class="card border-0 card-shadow">
                                                                    <div class="card-body">
                                                                        <h4 class="chart-title">Task level</h4>
                                                                        <div
                                                                            class="d-flex justify-content-around align-items-center flex-wrap">
                                                                            <div class="map_height" id="task_level"
                                                                                style="width:260px;height: 260px;">
                                                                            </div>
                                                                            <div class="">
                                                                                <div class="primary-v9 mt-3">
                                                                                    <div class="mb-0 mt-1 pl-2">
                                                                                        <span
                                                                                            class="chart-legend-title">Submitted</span>
                                                                                        <span
                                                                                            class="large-bold pl-3">30%</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="primary-v10 mt-3">
                                                                                    <div class="mb-0 mt-1 pl-2">
                                                                                        <span
                                                                                            class="chart-legend-title">Approved</span><span
                                                                                            class="large-bold pl-3">20%</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="primary-v11 mt-3">
                                                                                    <div class="mb-0 mt-1 pl-2">
                                                                                        <span
                                                                                            class="chart-legend-title">Rejected</span><span
                                                                                            class="large-bold pl-3">20%</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                                <div class="card border-0 card-shadow">
                                                                    <div class="card-body">
                                                                        <h4 class="chart-title">Payment Details</h4>
                                                                        <div class="map_height" id="payment_details"
                                                                            style="width:100%;height: 260px;">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="dashboardHousehold">
                                                <div class="row mt-4">
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <div class="card border-0 card-shadow">
                                                            <div class="card-body">
                                                                <h4 class="chart-title">Milk Production & Sales</h4>
                                                                <div class="map_height" id="Milk_Production_and_Sales"
                                                                    style="width:100%;height: 350px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-4">
                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <div class="card border-0 card-shadow">
                                                            <div class="card-body">
                                                                <h4 class="chart-title">Milk Production</h4>
                                                                <div class="map_height" id="Milk_Production"
                                                                    style="width:100%;height: 260px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <div class="card border-0 card-shadow">
                                                            <div class="card-body">
                                                                <h4 class="chart-title">Milk Production</h4>
                                                                <div class="map_height" id="Milk_Production_1"
                                                                    style="width:100%;height: 260px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-4">
                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <div class="card border-0 card-shadow">
                                                            <div class="card-body">
                                                                <h4 class="chart-title">Average Selling Price</h4>
                                                                <div class="map_height" id="Average_Selling_Price"
                                                                    style="width:100%;height: 260px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <div class="card border-0 card-shadow">
                                                            <div class="card-body">
                                                                <h4 class="chart-title">No.of Animals</h4>
                                                                <div class="map_height" id="Number_of_Animals"
                                                                    style="width:100%;height: 260px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-4">
                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <div class="card border-0 card-shadow">
                                                            <div class="card-body">
                                                                <h4 class="chart-title">Sex</h4>
                                                                <div
                                                                    class="d-flex justify-content-around align-items-center flex-wrap">
                                                                    <div class="map_height" id="Sex_Household"
                                                                        style="width:260px;height: 260px;">
                                                                    </div>
                                                                    <div class="">
                                                                        <div class="primary-v5 mt-3">
                                                                            <div class="mb-0 mt-1 pl-2">
                                                                                <span
                                                                                    class="chart-legend-title">Male</span>
                                                                                <span class="large-bold pl-3">30%</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="primary-v6 mt-3">
                                                                            <div class="mb-0 mt-1 pl-2">
                                                                                <span
                                                                                    class="chart-legend-title">Female</span><span
                                                                                    class="large-bold pl-3">20%</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <div class="card border-0 card-shadow">
                                                            <div class="card-body">
                                                                <h4 class="chart-title">Age</h4>
                                                                <div
                                                                    class="d-flex justify-content-around align-items-center flex-wrap">
                                                                    <div class="map_height" id="Age_Household"
                                                                        style="width:260px;height: 260px;">
                                                                    </div>
                                                                    <div class="">
                                                                        <div class="primary-vl mt-3">
                                                                            <div class="mb-0 mt-1 pl-2">
                                                                                <span
                                                                                    class="chart-legend-title">0-5</span>
                                                                                <span class="large-bold pl-3">30</span>%
                                                                            </div>
                                                                        </div>
                                                                        <div class="primary-v2 mt-3">
                                                                            <div class="mb-0 mt-1 pl-2">
                                                                                <span
                                                                                    class="chart-legend-title">5-10</span><span
                                                                                    class="large-bold pl-3">20</span>%
                                                                            </div>
                                                                        </div>
                                                                        <div class="primary-v3 mt-3">
                                                                            <div class="mb-0 mt-1 pl-2">
                                                                                <span
                                                                                    class="chart-legend-title">10-15</span><span
                                                                                    class="large-bold pl-3">30</span>%
                                                                            </div>
                                                                        </div>
                                                                        <div class="primary-v4 mt-3">
                                                                            <div class="mb-0 mt-1 pl-2">
                                                                                <span
                                                                                    class="chart-legend-title">15-20</span><span
                                                                                    class="large-bold pl-3">20</span>%
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-4">
                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <div class="card border-0 card-shadow">
                                                            <div class="card-body">
                                                                <h4 class="chart-title">Grade</h4>
                                                                <div
                                                                    class="d-flex justify-content-around align-items-center flex-wrap">
                                                                    <div class="map_height" id="Grade_Household"
                                                                        style="width:260px;height: 260px;">
                                                                    </div>
                                                                    <div class="">
                                                                        <div class="primary-vl mt-3">
                                                                            <div class="mb-0 mt-1 pl-2">
                                                                                <span class="chart-legend-title">Body
                                                                                    Condition</span>
                                                                                <span class="large-bold pl-3">30</span>%
                                                                            </div>
                                                                        </div>
                                                                        <div class="primary-v2 mt-3">
                                                                            <div class="mb-0 mt-1 pl-2">
                                                                                <span class="chart-legend-title">Body
                                                                                    Condition</span><span
                                                                                    class="large-bold pl-3">20</span>%
                                                                            </div>
                                                                        </div>
                                                                        <div class="primary-v3 mt-3">
                                                                            <div class="mb-0 mt-1 pl-2">
                                                                                <span class="chart-legend-title">Body
                                                                                    Condition</span><span
                                                                                    class="large-bold pl-3">30</span>%
                                                                            </div>
                                                                        </div>
                                                                        <div class="primary-v4 mt-3">
                                                                            <div class="mb-0 mt-1 pl-2">
                                                                                <span class="chart-legend-title">Body
                                                                                    Condition</span><span
                                                                                    class="large-bold pl-3">20</span>%
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <div class="card border-0 card-shadow">
                                                            <div class="card-body">
                                                                <h4 class="chart-title">Cattle</h4>
                                                                <div class="map_height" id="Cattle_Household"
                                                                    style="width:100%;height: 260px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-4">
                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <div class="card border-0 card-shadow">
                                                            <div class="card-body">
                                                                <h4 class="chart-title">MUAC</h4>
                                                                <div class="map_height" id="Muac_Household"
                                                                    style="width:100%;height: 260px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <div class="card border-0 card-shadow">
                                                            <div class="card-body">
                                                                <h4 class="chart-title">No.of Children</h4>
                                                                <div class="map_height"
                                                                    id="Number_of_Children_Household"
                                                                    style="width:100%;height: 260px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-4">
                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <div class="card border-0 card-shadow">
                                                            <div class="card-body">
                                                                <h4 class="chart-title">Livestock</h4>
                                                                <div class="map_height" id="Livestock_Household"
                                                                    style="width:100%;height: 260px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <div class="card border-0 card-shadow">
                                                            <div class="card-body">
                                                                <h4 class="chart-title">Animal Type</h4>
                                                                <div class="map_height" id="Animal_Type"
                                                                    style="width:100%;height: 260px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-4">
                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <div class="card border-0 card-shadow">
                                                            <div class="card-body">
                                                                <h4 class="chart-title">Birth</h4>
                                                                <div
                                                                    class="d-flex justify-content-around align-items-center flex-wrap">
                                                                    <div class="map_height" id="Birth_Household"
                                                                        style="width:260px;height: 260px;">
                                                                    </div>
                                                                    <div class="">
                                                                        <div class="primary-v5 mt-3">
                                                                            <div class="mb-0 mt-1 pl-2">
                                                                                <span class="chart-legend-title">Still
                                                                                    Births</span>
                                                                                <span class="large-bold pl-3">30%</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="primary-v6 mt-3">
                                                                            <div class="mb-0 mt-1 pl-2">
                                                                                <span
                                                                                    class="chart-legend-title">Successful
                                                                                    Births</span><span
                                                                                    class="large-bold pl-3">20%</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <div class="card border-0 card-shadow">
                                                            <div class="card-body">
                                                                <h4 class="chart-title">Animal Deaths</h4>
                                                                <div class="map_height" id="Animal_Deaths"
                                                                    style="width:100%;height: 260px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-4">
                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <div class="card border-0 card-shadow">
                                                            <div class="card-body">
                                                                <h4 class="chart-title">Cause of death</h4>
                                                                <div
                                                                    class="d-flex justify-content-around align-items-center flex-wrap">
                                                                    <div class="map_height" id="Cause_of_death"
                                                                        style="width:260px;height: 260px;">
                                                                    </div>
                                                                    <div class="">
                                                                        <div class="primary-v5 mt-3">
                                                                            <div class="mb-0 mt-1 pl-2">
                                                                                <span class="chart-legend-title">Reason
                                                                                    1</span>
                                                                                <span class="large-bold pl-3">30%</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="primary-v6 mt-3">
                                                                            <div class="mb-0 mt-1 pl-2">
                                                                                <span class="chart-legend-title">Reason
                                                                                    2</span><span
                                                                                    class="large-bold pl-3">20%</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <div class="card border-0 card-shadow">
                                                            <div class="card-body">
                                                                <h4 class="chart-title">Sales</h4>
                                                                <div class="map_height" id="Sales_Household"
                                                                    style="width:100%;height: 260px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-4">
                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <div class="card border-0 card-shadow">
                                                            <div class="card-body">
                                                                <h4 class="chart-title">Purchases</h4>
                                                                <div class="map_height" id="Purchases_Household"
                                                                    style="width:100%;height: 260px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="dashboardMarket">

                                                <div class="row mt-4">
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <div class="card border-0 card-shadow">
                                                            <div class="card-body">
                                                                <h4 class="chart-title">Camel Milk</h4>
                                                                <div class="map_height" id="Camel_Milk"
                                                                    style="width:100%;height: 350px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <div class="card border-0 card-shadow">
                                                            <div class="card-body">
                                                                <h4 class="chart-title">Cattle Milk</h4>
                                                                <div class="map_height" id="Cattle_Milk"
                                                                    style="width:100%;height: 350px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <div class="card border-0 card-shadow">
                                                            <div class="card-body">
                                                                <h4 class="chart-title">Maize Flour</h4>
                                                                <div class="map_height" id="Maize_Flour"
                                                                    style="width:100%;height: 350px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-4">
                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <div class="card border-0 card-shadow">
                                                            <div class="card-body">
                                                                <h4 class="chart-title">Milk Production</h4>
                                                                <div class="map_height" id="Milk_Production_Market"
                                                                    style="width:100%;height: 260px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <div class="card border-0 card-shadow">
                                                            <div class="card-body">
                                                                <h4 class="chart-title">Final Selling Price</h4>
                                                                <div class="map_height" id="Final_Selling_Price"
                                                                    style="width:100%;height: 260px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-4">
                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <div class="card border-0 card-shadow">
                                                            <div class="card-body">
                                                                <h4 class="chart-title">Index Commodities</h4>
                                                                <div class="map_height" id="Index_Commodities_Market"
                                                                    style="width:100%;height: 260px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <div class="card border-0 card-shadow">
                                                            <div class="card-body">
                                                                <h4 class="chart-title">Index Commodities</h4>
                                                                <div class="map_height" id="Index_Commodities_Market_1"
                                                                    style="width:100%;height: 260px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-4">
                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <div class="card border-0 card-shadow">
                                                            <div class="card-body">
                                                                <h4 class="chart-title">Index Commodities</h4>
                                                                <div class="map_height" id="Index_Commodities_Market_2"
                                                                    style="width:100%;height: 260px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <div class="card border-0 card-shadow">
                                                            <div class="card-body">
                                                                <h4 class="chart-title">Dry Food</h4>
                                                                <div class="map_height" id="Dry_Food_Market"
                                                                    style="width:100%;height: 260px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-4">
                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <div class="card border-0 card-shadow">
                                                            <div class="card-body">
                                                                <h4 class="chart-title">Livestock Volumes</h4>
                                                                <div class="map_height" id="Livestock_Volumes_Market"
                                                                    style="width:100%;height: 260px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="tab-pane fade" id="dashboardRangeland">Rangeland</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div>
    </div>


    <script>
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('.wrapper').toggleClass('mini');
            });
        });
    </script>


    <script>
        // Create the chart
        Highcharts.chart('Milk_Production_and_Sales', {
            chart: {
                type: 'bar'
            },
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                type: 'category',
                // categories: ['category1', 'category2', 'category3']
            },
            legend: {
                reversed: true
            },
            plotOptions: {
                series: {
                    stacking: 'normal',
                    borderWidth: 0,
                    dataLabels: {
                        enabled: false
                    }
                }
            },

            series: [{
                name: 'Harweyu',
                color: '#5978A3',
                data: [{
                    name: 'March 2021',
                    y: 14,
                    drilldown: 'March-2021'
                }, {
                    name: 'April 2021',
                    y: 14,
                    drilldown: 'April-2021'
                }, {
                    name: 'May 2021',
                    y: 14,
                    drilldown: 'May-2021'
                }]
            }, {
                name: 'Higo',
                color: '#F7BA1E',
                data: [{
                    name: 'March 2021',
                    y: 15,
                    drilldown: 'March-2021'
                }, {
                    name: 'April 2021',
                    y: 12,
                    drilldown: 'April-2021'
                }, {
                    name: 'May 2021',
                    y: 14,
                    drilldown: 'May-2021'
                }]
            }, {
                name: 'Magole',
                color: '#6A9F58',
                data: [{
                    name: 'March 2021',
                    y: 14,
                    drilldown: 'March-2021'
                }, {
                    name: 'April 2021',
                    y: 14,
                    drilldown: 'April-2021'
                }, {
                    name: 'May 2021',
                    y: 14,
                    drilldown: 'May-2021'
                }]
            }, {
                name: 'Saba',
                color: '#165DFF',
                data: [{
                    name: 'March 2021',
                    y: 15,
                    drilldown: 'March-2021'
                }, {
                    name: 'April 2021',
                    y: 12,
                    drilldown: 'April-2021'
                }, {
                    name: 'May 2021',
                    y: 14,
                    drilldown: 'May-2021'
                }]
            },
            ],
            drilldown: {
                series: [{
                    id: 'March-2021',
                    data: [
                        ['1', 4],
                        ['2', 2],
                        ['3', 1],
                        ['4', 4]
                    ]
                }, {
                    id: 'April-2021',
                    data: [
                        ['1', 6],
                        ['2', 2],
                        ['3', 2],
                        ['4', 4]
                    ]
                }, {
                    id: 'May-2021',
                    data: [
                        ['1', 2],
                        ['2', 7],
                        ['3', 3],
                        ['4', 2]
                    ]
                }, {
                    id: 'March-2021',
                    data: [
                        ['1', 2],
                        ['2', 4],
                        ['3', 1],
                        ['4', 7]
                    ]
                }, {
                    id: 'April-2021',
                    data: [
                        ['1', 4],
                        ['2', 2],
                        ['3', 5],
                        ['4', 3]
                    ]
                }, {
                    id: 'May-2021',
                    data: [
                        ['1', 7],
                        ['2', 8],
                        ['3', 2],
                        ['4', 2]
                    ]
                }, {
                    id: 'March-2021',
                    data: [
                        ['1', 2],
                        ['2', 4],
                        ['3', 1],
                        ['4', 7]
                    ]
                }, {
                    id: 'April-2021',
                    data: [
                        ['1', 4],
                        ['2', 2],
                        ['3', 5],
                        ['4', 3]
                    ]
                }, {
                    id: 'May-2021',
                    data: [
                        ['1', 7],
                        ['2', 8],
                        ['3', 2],
                        ['4', 2]
                    ]
                }, {
                    id: 'March-2021',
                    data: [
                        ['1', 2],
                        ['2', 4],
                        ['3', 1],
                        ['4', 7]
                    ]
                }, {
                    id: 'April-2021',
                    data: [
                        ['1', 4],
                        ['2', 2],
                        ['3', 5],
                        ['4', 3]
                    ]
                }, {
                    id: 'May-2021',
                    data: [
                        ['1', 7],
                        ['2', 8],
                        ['3', 2],
                        ['4', 2]
                    ]
                }]
            }
        });

    </script>

    <script>
        Highcharts.chart('contributors_dashboard', {
            chart: {
                type: 'bar'
            },
            title: {
                text: '',
            },
            xAxis: {
                categories: ['contributors 1', 'contributors 2', 'contributors 3', 'contributors 4', 'contributors 5'],
                title: {
                    text: null
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: '',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                valueSuffix: ' millions'
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            credits: {
                enabled: false
            },
            exporting: {
                enabled: false
            },
            series: [{
                name: 'Highest level of education',
                color: '#165DFF',
                data: [3000, 2500, 2000, 1500, 1000]
            }, {
                name: 'Primary Occupation',
                color: '#14C9C9',
                data: [2800, 2300, 1800, 1300, 800]
            }]
        });
    </script>

    <script>
        Highcharts.chart('number_of_contributors', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: '',
                align: 'left'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            exporting: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                pie: {
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: false
                }
            },
            series: [{
                name: 'No.of Contributors',
                data: [{
                    name: 'Approved',
                    color: '#5877A3',
                    y: 30,
                }, {
                    name: 'Rejected',
                    color: '#E49443',
                    y: 20,
                }, {
                    name: 'Active',
                    color: '#6A9F58',
                    y: 30,
                }, {
                    name: 'Inactive',
                    color: '#F1A2A7',
                    y: 20,
                },]
            }]
        });
    </script>

    <script>
        Highcharts.chart('rejected_reasons', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: '',
                align: 'left'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            exporting: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                pie: {
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: false
                }
            },
            series: [{
                name: 'Rejected Reasons',
                data: [{
                    name: 'Approved',
                    color: '#5877A3',
                    y: 30,
                }, {
                    name: 'Rejected',
                    color: '#E49443',
                    y: 20,
                }, {
                    name: 'Active',
                    color: '#6A9F58',
                    y: 30,
                }, {
                    name: 'Inactive',
                    color: '#F1A2A7',
                    y: 20,
                },]
            }]
        });
    </script>

    <script>
        Highcharts.chart('sex_dashboard', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: '',
                align: 'left'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            exporting: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                pie: {
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: false
                }
            },
            series: [{
                name: 'Sex',
                data: [{
                    name: 'Male',
                    color: '#6FA1E7',
                    y: 30,
                }, {
                    name: 'Female',
                    color: '#FFB6BA',
                    y: 20,
                }]
            }]
        });
    </script>


    <script>
        Highcharts.chart('account_details_status', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: '',
                align: 'left'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            exporting: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                pie: {
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: false
                }
            },
            series: [{
                name: 'Account Details Status',
                data: [{
                    name: 'Available',
                    color: '#C8E76F',
                    y: 30,
                }, {
                    name: 'Not Available',
                    color: '#CDCDCD',
                    y: 20,
                }]
            }]
        });
    </script>

    <script>
        Highcharts.chart('respondent_dashboard', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: '',
                align: 'left'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            exporting: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                pie: {
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: false
                }
            },
            series: [{
                name: 'Respondents',
                data: [{
                    name: 'Submitted ',
                    color: '#5877A3',
                    y: 30,
                }, {
                    name: 'Profile Pending',
                    color: '#E49443',
                    y: 20,
                }, {
                    name: 'Approved',
                    color: '#6A9F58',
                    y: 30,
                }, {
                    name: 'Rejected',
                    color: '#F1A2A7',
                    y: 20,
                },]
            }]
        });
    </script>

    <script>
        Highcharts.chart('sex_dashboard_one', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: '',
                align: 'left'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            exporting: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                pie: {
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: false
                }
            },
            series: [{
                name: 'Sex',
                data: [{
                    name: 'Male',
                    color: '#6FA1E7',
                    y: 30,
                }, {
                    name: 'Female',
                    color: '#FFB6BA',
                    y: 20,
                }]
            }]
        });
    </script>

    <script>
        Highcharts.chart('household_profile', {
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            xAxis: {
                categories: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10']
            },
            yAxis: {
                min: 0,
                title: {
                    text: ''
                }
            },
            tooltip: {
                pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
                shared: true
            },
            plotOptions: {
                column: {
                    stacking: 'percent'
                }
            },
            exporting: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Age 66 and above',
                color: '#F7BA1E',
                data: [4, 4, 2, 4, 4, 3, 4, 5, 6, 4]
            }, {
                name: 'Age 18-65',
                color: '#14C9C9',
                data: [1, 2, 2, 1, 2, 3, 2, 4, 2, 3]
            }, {
                name: 'Age 5-17',
                color: '#FFB6BA',
                data: [5, 4, 3, 2, 3, 3, 4, 5, 4, 3]
            }, {
                name: 'Age 0-5',
                color: '#165DFF',
                data: [4, 4, 2, 4, 4, 5, 4, 6, 5, 7]
            },]
        });
    </script>


    <script>
        Highcharts.chart('number_of_household_members_suffering', {
            chart: {
                type: 'spline',
            },
            title: {
                text: ''
            },
            xAxis: {
                categories: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10']
            },
            yAxis: {
                min: 0,
                title: {
                    text: ''
                }
            },
            tooltip: {
                pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
                shared: true
            },
            // plotOptions: {
            //     column: {
            //         stacking: 'percent'
            //     }
            // },
            plotOptions: {
                series: {
                    marker: {
                        enabled: true,
                        radius: 2.5,
                        symbol: 'circle'
                    },
                    labels: {
                        enabled: false,
                        //radius: 2.5
                    }
                }
            },
            legend: {
                reversed: true,
            },
            exporting: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Age 66 and above',
                color: '#F7BA1E',
                data: [4, 4, 2, 4, 4, 3, 4, 5, 6, 4]
            }, {
                name: 'Age 18-65',
                color: '#14C9C9',
                data: [1, 2, 2, 1, 2, 3, 2, 4, 2, 3]
            }, {
                name: 'Age 5-17',
                color: '#FFB6BA',
                data: [5, 4, 3, 2, 3, 3, 4, 5, 4, 3]
            }, {
                name: 'Age 0-5',
                color: '#165DFF',
                data: [4, 4, 2, 4, 4, 5, 4, 6, 5, 7]
            },]
        });
    </script>

    <script>
        Highcharts.chart('number_of_children', {
            chart: {
                type: 'column'
            },
            title: {
                align: 'left',
                text: ''
            },
            subtitle: {
                align: 'left',
                text: ''
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: ''
                }

            },
            legend: {
                enabled: false
            },
            exporting: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    // dataLabels: {
                    //   enabled: true,
                    //   format: '{point.y:.1f}%'
                    // }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b><br/>'
            },

            series: [
                {
                    name: 'No.of Children',
                    data: [
                        {
                            name: 'B1',
                            color: '#165DFF',
                            y: 50.06,
                        },
                        {
                            name: 'G1',
                            color: '#FFB6BA',
                            y: 50.84,
                        },
                        {
                            name: 'G2',
                            y: 90.18,
                            color: '#FFB6BA',
                        },
                        {
                            name: 'B2',
                            color: '#165DFF',
                            y: 30.06,
                        },
                        {
                            name: 'G3',
                            y: 34.18,
                            color: '#FFB6BA',
                        },
                        {
                            name: 'B3',
                            color: '#165DFF',
                            y: 50.06,
                        },
                        {
                            name: 'B4',
                            color: '#165DFF',
                            y: 60.06,
                        },]
                }
            ],
        });
    </script>

    <script>
        Highcharts.chart('household_head', {
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            xAxis: {
                categories: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10']
            },
            yAxis: {
                min: 0,
                title: {
                    text: ''
                }
            },
            tooltip: {
                pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
                shared: true
            },
            plotOptions: {
                column: {
                    stacking: 'percent'
                }
            },
            exporting: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Age',
                color: '#F7BA1E',
                data: [4, 4, 2, 4, 4, 3, 4, 5, 6, 4]
            }, {
                name: 'Sex',
                color: '#14C9C9',
                data: [1, 2, 2, 1, 2, 3, 2, 4, 2, 3]
            }]
        });
    </script>


    <script>
        Highcharts.chart('Livestock_Number', {
            chart: {
                type: 'spline',
            },
            title: {
                text: ''
            },
            xAxis: {
                categories: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10']
            },
            yAxis: {
                min: 0,
                title: {
                    text: ''
                }
            },
            tooltip: {
                pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
                shared: true
            },
            plotOptions: {
                series: {
                    marker: {
                        enabled: true,
                        radius: 2.5,
                        symbol: 'circle'
                    },
                    labels: {
                        enabled: false,
                        //radius: 2.5
                    }
                }
            },
            legend: {
                reversed: true,
            },
            exporting: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Sheep',
                color: '#F7BA1E',
                data: [4, 4, 2, 4, 4, 3, 4, 5, 6, 4]
            }, {
                name: 'Goats',
                color: '#14C9C9',
                data: [1, 2, 2, 1, 2, 3, 2, 4, 2, 3]
            }, {
                name: 'Cattle',
                color: '#FFB6BA',
                data: [5, 4, 3, 2, 3, 3, 4, 5, 4, 3]
            }, {
                name: 'Camels',
                color: '#165DFF',
                data: [4, 4, 2, 4, 4, 5, 4, 6, 5, 7]
            },]
        });
    </script>

    <script>
        Highcharts.chart('task_level', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: '',
                align: 'left'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            exporting: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                pie: {
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: false
                }
            },
            series: [{
                name: 'Sex',
                data: [{
                    name: 'Submitted',
                    color: '#F7BA1E',
                    y: 30,
                }, {
                    name: 'Approved',
                    color: '#14C9C9',
                    y: 20,
                }, {
                    name: 'Rejected',
                    color: '#FFB6BA',
                    y: 20,
                }]
            }]
        });
    </script>

    <script>
        Highcharts.chart('payment_details', {
            chart: {
                type: 'bar'
            },
            title: {
                text: '',
            },
            subtitle: {
                text: '',
            },
            xAxis: {
                categories: ['Payment Details1', 'Payment Details 2', 'Payment Details 3', 'Payment Details 4', 'Payment Details 5'],
                title: {
                    text: null
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: '',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                valueSuffix: ' millions'
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            credits: {
                enabled: false
            },
            exporting: {
                enabled: false
            },
            series: [{
                name: 'Task Wise',
                color: '#165DFF',
                data: [1000, 900, 800, 700, 600]
            }, {
                name: 'Contributor Name',
                color: '#14C9C9',
                data: [900, 800, 700, 600, 500]
            }]
        });
    </script>


    <script>
        Highcharts.chart('Milk_Production', {
            chart: {
                type: 'column'
            },
            title: {
                align: 'left',
                text: ''
            },
            subtitle: {
                align: 'left',
                text: ''
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: ''
                }

            },
            legend: {
                enabled: true
            },
            exporting: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b><br/>'
            },

            series: [
                {
                    name: 'No.of Animals',
                    data: [
                        {
                            name: 'Lactating Type1',
                            color: '#165DFF',
                            y: 50.06,
                        },
                        {
                            name: 'Lactating Type2',
                            color: '#165DFF',
                            y: 50.84,
                        },
                        {
                            name: 'Lactating Type3',
                            y: 90.18,
                            color: '#165DFF',
                        },
                        {
                            name: 'Lactating Type4',
                            color: '#165DFF',
                            y: 30.06,
                        },
                        {
                            name: 'Lactating Type5',
                            y: 34.18,
                            color: '#165DFF',
                        },
                        {
                            name: 'Lactating Type6',
                            color: '#165DFF',
                            y: 50.06,
                        },
                        {
                            name: 'Lactating Type7',
                            color: '#165DFF',
                            y: 60.06,
                        },]
                }
            ],
        });
    </script>


    <script>
        Highcharts.chart('Milk_Production_1', {
            chart: {
                type: 'spline',
            },
            title: {
                text: ''
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'April', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
                min: 0,
                title: {
                    text: ''
                }
            },
            tooltip: {
                pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
                shared: true
            },
            plotOptions: {
                series: {
                    marker: {
                        enabled: true,
                        radius: 2.5,
                        symbol: 'circle'
                    },
                    labels: {
                        enabled: false,
                        //radius: 2.5
                    }
                }
            },
            legend: {
                reversed: true,
            },
            exporting: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Sheep',
                color: '#F7BA1E',
                data: [4, 4, 2, 4, 4, 3, 4, 5, 6, 4, 5, 7]
            }, {
                name: 'Goats',
                color: '#14C9C9',
                data: [1, 2, 2, 1, 2, 3, 2, 4, 2, 3, 4, 5]
            }, {
                name: 'Cattle',
                color: '#FFB6BA',
                data: [5, 4, 3, 2, 3, 3, 4, 5, 4, 3, 4, 5]
            }, {
                name: 'Camels',
                color: '#165DFF',
                data: [4, 4, 2, 4, 4, 5, 4, 6, 5, 7, 5, 3]
            },]
        });
    </script>

    <script>
        Highcharts.chart('Average_Selling_Price', {
            chart: {
                type: 'spline',
            },
            title: {
                text: ''
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'April', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
                min: 0,
                title: {
                    text: ''
                }
            },
            tooltip: {
                pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
                shared: true
            },
            plotOptions: {
                series: {
                    marker: {
                        enabled: true,
                        radius: 2.5,
                        symbol: 'circle'
                    },
                    labels: {
                        enabled: false,
                        //radius: 2.5
                    }
                }
            },
            legend: {
                reversed: true,
            },
            exporting: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Sheep',
                color: '#F7BA1E',
                data: [4, 4, 2, 4, 4, 3, 4, 5, 6, 4, 5, 7]
            }, {
                name: 'Goats',
                color: '#14C9C9',
                data: [1, 2, 2, 1, 2, 3, 2, 4, 2, 3, 4, 5]
            }, {
                name: 'Cattle',
                color: '#FFB6BA',
                data: [5, 4, 3, 2, 3, 3, 4, 5, 4, 3, 4, 5]
            }, {
                name: 'Camels',
                color: '#165DFF',
                data: [4, 4, 2, 4, 4, 5, 4, 6, 5, 7, 5, 3]
            },]
        });
    </script>

    <script>
        Highcharts.chart('Number_of_Animals', {
            chart: {
                type: 'column'
            },
            title: {
                align: 'left',
                text: ''
            },
            subtitle: {
                align: 'left',
                text: ''
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: ''
                }

            },
            legend: {
                enabled: true
            },
            exporting: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b><br/>'
            },

            series: [
                {
                    name: 'No.of Animals',
                    data: [
                        {
                            name: 'Lactating Type1',
                            color: '#165DFF',
                            y: 50.06,
                        },
                        {
                            name: 'Lactating Type2',
                            color: '#165DFF',
                            y: 50.84,
                        },
                        {
                            name: 'Lactating Type3',
                            y: 90.18,
                            color: '#165DFF',
                        },
                        {
                            name: 'Lactating Type4',
                            color: '#165DFF',
                            y: 30.06,
                        },
                        {
                            name: 'Lactating Type5',
                            y: 34.18,
                            color: '#165DFF',
                        },
                        {
                            name: 'Lactating Type6',
                            color: '#165DFF',
                            y: 50.06,
                        },
                        {
                            name: 'Lactating Type7',
                            color: '#165DFF',
                            y: 60.06,
                        },]
                }
            ],
        });
    </script>

    <script>
        Highcharts.chart('Sex_Household', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: '',
                align: 'left'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            exporting: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                pie: {
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: false
                }
            },
            series: [{
                name: 'Sex',
                data: [{
                    name: 'Male',
                    color: '#6FA1E7',
                    y: 30,
                }, {
                    name: 'Female',
                    color: '#FFB6BA',
                    y: 20,
                }]
            }]
        });
    </script>

    <script>
        Highcharts.chart('Age_Household', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: '',
                align: 'left'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            exporting: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                pie: {
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: false
                }
            },
            series: [{
                name: 'No.of Contributors',
                data: [{
                    name: 'Approved',
                    color: '#5877A3',
                    y: 30,
                }, {
                    name: 'Rejected',
                    color: '#E49443',
                    y: 20,
                }, {
                    name: 'Active',
                    color: '#6A9F58',
                    y: 30,
                }, {
                    name: 'Inactive',
                    color: '#F1A2A7',
                    y: 20,
                },]
            }]
        });
    </script>

    <script>
        Highcharts.chart('Grade_Household', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: '',
                align: 'left'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            exporting: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                pie: {
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: false
                }
            },
            series: [{
                name: 'No.of Contributors',
                data: [{
                    name: 'Approved',
                    color: '#5877A3',
                    y: 30,
                }, {
                    name: 'Rejected',
                    color: '#E49443',
                    y: 20,
                }, {
                    name: 'Active',
                    color: '#6A9F58',
                    y: 30,
                }, {
                    name: 'Inactive',
                    color: '#F1A2A7',
                    y: 20,
                },]
            }]
        });
    </script>

    <script>
        Highcharts.chart('Cattle_Household', {
            chart: {
                type: 'spline',
            },
            title: {
                text: ''
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'April', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
                min: 0,
                title: {
                    text: ''
                }
            },
            tooltip: {
                pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
                shared: true
            },
            plotOptions: {
                series: {
                    marker: {
                        enabled: true,
                        radius: 2.5,
                        symbol: 'circle'
                    },
                    labels: {
                        enabled: false,
                        //radius: 2.5
                    }
                }
            },
            legend: {
                reversed: true,
            },
            exporting: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Sheep',
                color: '#F7BA1E',
                data: [4, 4, 2, 4, 4, 3, 4, 5, 6, 4, 5, 7]
            }, {
                name: 'Goats',
                color: '#14C9C9',
                data: [1, 2, 2, 1, 2, 3, 2, 4, 2, 3, 4, 5]
            }, {
                name: 'Cattle',
                color: '#FFB6BA',
                data: [5, 4, 3, 2, 3, 3, 4, 5, 4, 3, 4, 5]
            }, {
                name: 'Camels',
                color: '#165DFF',
                data: [4, 4, 2, 4, 4, 5, 4, 6, 5, 7, 5, 3]
            },]
        });
    </script>

    <script>
        Highcharts.chart('Muac_Household', {
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            credits: {
                enabled: false
            },
            xAxis: {
                categories: [
                    '1',
                    '2',
                    '3',
                    '4',
                    '5',
                    '6',
                    '7',
                    '8',
                    '9',
                    '10',
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Rainfall (mm)'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:15px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0,
                    borderWidth: 0,
                },
            },
            series: [{
                name: 'Mom',
                color: '#165DFF',
                data: [49.9, 71.5, 106.4, 83.6, 78.8, 98.5, 49.9]

            }, {
                name: 'Contributor',
                color: '#F7BA1E',
                data: [83.6, 78.8, 98.5, 49.9, 71.5, 106.4, 83.6]

            }]
        });
    </script>

    <script>
        Highcharts.chart('Number_of_Children_Household', {
            chart: {
                type: 'column'
            },
            title: {
                align: 'left',
                text: ''
            },
            subtitle: {
                align: 'left',
                text: ''
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: ''
                }

            },
            legend: {
                enabled: true
            },
            exporting: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b><br/>'
            },

            series: [
                {
                    name: 'No.of Animals',
                    data: [
                        {
                            name: 'Animal Type1',
                            color: '#165DFF',
                            y: 50.06,
                        },
                        {
                            name: 'Animal Type2',
                            color: '#165DFF',
                            y: 50.84,
                        },
                        {
                            name: 'Animal Type3',
                            y: 90.18,
                            color: '#165DFF',
                        },
                        {
                            name: 'Animal Type4',
                            color: '#165DFF',
                            y: 30.06,
                        },
                        {
                            name: 'Animal Type5',
                            y: 34.18,
                            color: '#165DFF',
                        },
                        {
                            name: 'Animal Type6',
                            color: '#165DFF',
                            y: 50.06,
                        },
                        {
                            name: 'Animal Type7',
                            color: '#165DFF',
                            y: 60.06,
                        },]
                }
            ],
        });
    </script>

    <script>
        Highcharts.chart('Number_of_Children_Household', {
            chart: {
                type: 'column'
            },
            title: {
                align: 'left',
                text: ''
            },
            subtitle: {
                align: 'left',
                text: ''
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: ''
                }

            },
            legend: {
                enabled: true
            },
            exporting: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b><br/>'
            },

            series: [
                {
                    name: 'No.of Animals',
                    data: [
                        {
                            name: 'Animal Type1',
                            color: '#165DFF',
                            y: 50.06,
                        },
                        {
                            name: 'Animal Type2',
                            color: '#165DFF',
                            y: 50.84,
                        },
                        {
                            name: 'Animal Type3',
                            y: 90.18,
                            color: '#165DFF',
                        },
                        {
                            name: 'Animal Type4',
                            color: '#165DFF',
                            y: 30.06,
                        },
                        {
                            name: 'Animal Type5',
                            y: 34.18,
                            color: '#165DFF',
                        },
                        {
                            name: 'Animal Type6',
                            color: '#165DFF',
                            y: 50.06,
                        },
                        {
                            name: 'Animal Type7',
                            color: '#165DFF',
                            y: 60.06,
                        },]
                }
            ],
        });
    </script>

    <script>
        Highcharts.chart('Livestock_Household', {
            chart: {
                type: 'column'
            },
            title: {
                align: 'left',
                text: ''
            },
            subtitle: {
                align: 'left',
                text: ''
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: ''
                }

            },
            // legend: {
            //     enabled: true
            // },
            exporting: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b><br/>'
            },

            series: [
                {
                    name: 'Livestock',
                    data: [
                        {
                            name: 'Animal Type1',
                            color: '#165DFF',
                            y: 50.06,
                        },
                        {
                            name: 'Animal Type2',
                            color: '#FFB6BA',
                            y: 50.84,
                        },
                        {
                            name: 'Animal Type3',
                            y: 90.18,
                            color: '#14C9C9',
                        },
                        {
                            name: 'Animal Type4',
                            color: '#F7BA1E',
                            y: 30.06,
                        },
                        {
                            name: 'Animal Type5',
                            y: 34.18,
                            color: '#BFF71E',
                        },
                        {
                            name: 'Animal Type6',
                            color: '#B21EF7',
                            y: 50.06,
                        },
                        {
                            name: 'Animal Type7',
                            color: '#E49443',
                            y: 60.06,
                        },]
                }
            ],
        });
    </script>

    <script>
        Highcharts.chart('Animal_Type', {
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            credits: {
                enabled: false
            },
            xAxis: {
                categories: [
                    'Animal Type1',
                    'Animal Type2',
                    'Animal Type3',
                    'Animal Type4',
                    'Animal Type5',
                    'Animal Type6',
                    'Animal Type7',
                    'Animal Type8',
                    'Animal Type9',
                    'Animal Type10',
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Rainfall (mm)'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:15px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0,
                    borderWidth: 0,
                },
            },
            series: [{
                name: 'Mature Animal',
                color: '#165DFF',
                data: [49.9, 71.5, 106.4, 83.6, 78.8, 98.5, 49.9]

            }, {
                name: 'Young Animal',
                color: '#14C9C9',
                data: [83.6, 78.8, 98.5, 49.9, 71.5, 106.4, 83.6]

            }]
        });
    </script>

    <script>
        Highcharts.chart('Birth_Household', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: '',
                align: 'left'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            exporting: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                pie: {
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: false
                }
            },
            series: [{
                name: 'Births',
                data: [{
                    name: 'Still Births',
                    color: '#6FA1E7',
                    y: 30,
                }, {
                    name: 'Successful Births',
                    color: '#FFB6BA',
                    y: 20,
                }]
            }]
        });
    </script>

    <script>
        Highcharts.chart('Animal_Deaths', {
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            credits: {
                enabled: false
            },
            xAxis: {
                categories: [
                    'Animal Type1',
                    'Animal Type2',
                    'Animal Type3',
                    'Animal Type4',
                    'Animal Type5',
                    'Animal Type6',
                    'Animal Type7',
                    'Animal Type8',
                    'Animal Type9',
                    'Animal Type10',
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Rainfall (mm)'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:15px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0,
                    borderWidth: 0,
                },
            },
            series: [{
                name: 'Deaths occurred in your mature herded',
                color: '#165DFF',
                data: [49.9, 71.5, 106.4, 83.6, 78.8, 98.5, 49.9]

            }, {
                name: 'Deaths occurred in your young herded',
                color: '#F7BA1E',
                data: [83.6, 78.8, 98.5, 49.9, 71.5, 106.4, 83.6]

            }]
        });
    </script>

    <script>
        Highcharts.chart('Cause_of_death', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: '',
                align: 'left'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            exporting: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                pie: {
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: false
                }
            },
            series: [{
                name: 'Births',
                data: [{
                    name: 'Still Births',
                    color: '#6FA1E7',
                    y: 30,
                }, {
                    name: 'Successful Births',
                    color: '#FFB6BA',
                    y: 20,
                }]
            }]
        });
    </script>

    <script>
        Highcharts.chart('Sales_Household', {
            title: {
                text: '',
            },
            xAxis: {
                categories: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10']
            },
            yAxis: {
                title: {
                    text: ''
                }
            },
            exporting: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            tooltip: {
                valueSuffix: ''
            },
            series: [{
                type: 'column',
                color: '#165DFF',
                name: 'No.of sales in past 7days',
                data: [59, 83, 65, 228, 184, 123, 150, 190, 160, 200]
            }, {
                type: 'spline',
                color: '#14C9C9',
                name: 'Selling Price of the animal',
                data: [47, 83.33, 70.66, 239.33, 175.66, 80, 90, 100, 90, 80],
            },]
        });
    </script>

    <script>
        Highcharts.chart('Purchases_Household', {
            title: {
                text: '',
            },
            xAxis: {
                categories: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10']
            },
            yAxis: {
                title: {
                    text: ''
                }
            },
            tooltip: {
                valueSuffix: ''
            },
            exporting: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            series: [{
                type: 'column',
                color: '#165DFF',
                name: 'No.of sales in past 7days',
                data: [59, 83, 65, 228, 184, 123, 150, 190, 160, 200]
            }, {
                type: 'spline',
                color: '#14C9C9',
                name: 'Selling Price of the animal',
                data: [47, 83.33, 70.66, 239.33, 175.66, 80, 90, 100, 90, 80],
            },]
        });
    </script>

    <script>
        Highcharts.chart('Milk_Production_Market', {
            chart: {
                type: 'column'
            },
            title: {
                align: 'left',
                text: ''
            },
            subtitle: {
                align: 'left',
                text: ''
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: ''
                }

            },
            legend: {
                enabled: true
            },
            exporting: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b><br/>'
            },

            series: [
                {
                    name: 'No.of Animals',
                    data: [
                        {
                            name: 'Lactating Type1',
                            color: '#165DFF',
                            y: 50.06,
                        },
                        {
                            name: 'Lactating Type2',
                            color: '#165DFF',
                            y: 50.84,
                        },
                        {
                            name: 'Lactating Type3',
                            y: 90.18,
                            color: '#165DFF',
                        },
                        {
                            name: 'Lactating Type4',
                            color: '#165DFF',
                            y: 30.06,
                        },
                        {
                            name: 'Lactating Type5',
                            y: 34.18,
                            color: '#165DFF',
                        },
                        {
                            name: 'Lactating Type6',
                            color: '#165DFF',
                            y: 50.06,
                        },
                        {
                            name: 'Lactating Type7',
                            color: '#165DFF',
                            y: 60.06,
                        },]
                }
            ],
        });
    </script>

    <script>
        Highcharts.chart('Final_Selling_Price', {
            chart: {
                type: 'spline',
            },
            title: {
                text: ''
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'April', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
                min: 0,
                title: {
                    text: ''
                }
            },
            tooltip: {
                pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
                shared: true
            },
            plotOptions: {
                series: {
                    marker: {
                        enabled: true,
                        radius: 2.5,
                        symbol: 'circle'
                    },
                    labels: {
                        enabled: false,
                        //radius: 2.5
                    }
                }
            },
            legend: {
                reversed: true,
            },
            exporting: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Kenya Shillings',
                color: '#165DFF',
                data: [4, 4, 2, 4, 4, 3, 4, 5, 6, 4, 5, 7]
            }, {
                name: 'Ethiopian Birr',
                color: '#14C9C9',
                data: [1, 2, 2, 1, 2, 3, 2, 4, 2, 3, 4, 5]
            }]
        });
    </script>

    <script>
        Highcharts.chart('Camel_Milk', {

            chart: {
                type: 'heatmap',
                // marginTop: 40,
                // marginBottom: 80,
                // plotBorderWidth: 1
            },


            title: {
                text: ''
            },

            xAxis: {
                categories: ['Mar 21', 'Apr 21', 'May 21', 'Jun 21', 'Jul 21', 'Aug 21', 'Sep 21', 'Oct 21', 'Nv 21', 'Dec 21']
            },
            exporting: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            yAxis: {
                categories: ['Kargi', 'Korr', 'Merille', 'Ol turot'],
                title: null,
                reversed: true
            },

            accessibility: {
                point: {
                    descriptionFormatter: function (point) {
                        var ix = point.index + 1,
                            xName = getPointCategoryName(point, 'x'),
                            yName = getPointCategoryName(point, 'y'),
                            val = point.value;
                        return ix + '. ' + xName + ' sales ' + yName + ', ' + val + '.';
                    }
                }
            },

            // colorAxis: {
            //     min: 0,
            //     minColor: '#FFFFFF',
            //     maxColor: Highcharts.getOptions().colors[0]
            // },
            colorAxis: {
                stops: [
                    [0, '#C8E76F'], //  for values <= 10
                    [0.5, '#F7BA1E'], // green for values between 10 and 20
                    [1, '#5978A3'] // red for values > 20
                ]
            },

            tooltip: {
                formatter: function () {
                    return '<b>' + getPointCategoryName(this.point, 'x') + '</b> sold <br><b>' +
                        this.point.value + '</b> items on <br><b>' + getPointCategoryName(this.point, 'y') + '</b>';
                }
            },

            series: [{
                name: 'Camel Milk',
                borderWidth: 0,
                data: [[0, 0, 10], [0, 1, 19], [0, 2, 8], [0, 3, 24], [1, 0, 92], [1, 1, 58], [1, 2, 78], [1, 3, 117], [2, 0, 35], [2, 1, 15], [2, 2, 123], [2, 3, 64], [3, 0, 72], [3, 1, 132], [3, 2, 114], [3, 3, 19], [4, 0, 38], [4, 1, 5], [4, 2, 8], [4, 3, 117], [5, 0, 88], [5, 1, 32], [5, 2, 12], [5, 3, 6], [6, 0, 13], [6, 1, 44], [6, 2, 88], [6, 3, 98], [7, 0, 31], [7, 1, 1], [7, 2, 82], [7, 3, 32], [8, 0, 85], [8, 1, 97], [8, 2, 123], [8, 3, 64], [9, 0, 47], [9, 1, 114], [9, 2, 31], [9, 3, 48]],
                dataLabels: {
                    enabled: true,
                    color: '#000000'
                }
            }],

            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        yAxis: {
                            labels: {
                                formatter: function () {
                                    return this.value.charAt(0);
                                }
                            }
                        }
                    }
                }]
            }

        });
    </script>


    <script>
        Highcharts.chart('Cattle_Milk', {

            chart: {
                type: 'heatmap',
                // marginTop: 40,
                // marginBottom: 80,
                // plotBorderWidth: 1
            },


            title: {
                text: ''
            },

            xAxis: {
                categories: ['Mar 21', 'Apr 21', 'May 21', 'Jun 21', 'Jul 21', 'Aug 21', 'Sep 21', 'Oct 21', 'Nv 21', 'Dec 21']
            },
            exporting: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            yAxis: {
                categories: ['Kargi', 'Korr', 'Merille', 'Ol turot'],
                title: null,
                reversed: true
            },

            accessibility: {
                point: {
                    descriptionFormatter: function (point) {
                        var ix = point.index + 1,
                            xName = getPointCategoryName(point, 'x'),
                            yName = getPointCategoryName(point, 'y'),
                            val = point.value;
                        return ix + '. ' + xName + ' sales ' + yName + ', ' + val + '.';
                    }
                }
            },

            // colorAxis: {
            //     min: 0,
            //     minColor: '#FFFFFF',
            //     maxColor: Highcharts.getOptions().colors[0]
            // },
            colorAxis: {
                stops: [
                    [0, '#C8E76F'], //  for values <= 10
                    [0.5, '#F7BA1E'], // green for values between 10 and 20
                    [1, '#5978A3'] // red for values > 20
                ]
            },

            tooltip: {
                formatter: function () {
                    return '<b>' + getPointCategoryName(this.point, 'x') + '</b> sold <br><b>' +
                        this.point.value + '</b> items on <br><b>' + getPointCategoryName(this.point, 'y') + '</b>';
                }
            },

            series: [{
                name: 'Cattle Milk',
                borderWidth: 0,
                data: [[0, 0, 10], [0, 1, 19], [0, 2, 8], [0, 3, 24], [1, 0, 92], [1, 1, 58], [1, 2, 78], [1, 3, 117], [2, 0, 35], [2, 1, 15], [2, 2, 123], [2, 3, 64], [3, 0, 72], [3, 1, 132], [3, 2, 114], [3, 3, 19], [4, 0, 38], [4, 1, 5], [4, 2, 8], [4, 3, 117], [5, 0, 88], [5, 1, 32], [5, 2, 12], [5, 3, 6], [6, 0, 13], [6, 1, 44], [6, 2, 88], [6, 3, 98], [7, 0, 31], [7, 1, 1], [7, 2, 82], [7, 3, 32], [8, 0, 85], [8, 1, 97], [8, 2, 123], [8, 3, 64], [9, 0, 47], [9, 1, 114], [9, 2, 31], [9, 3, 48]],
                dataLabels: {
                    enabled: true,
                    color: '#000000'
                }
            }],

            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        yAxis: {
                            labels: {
                                formatter: function () {
                                    return this.value.charAt(0);
                                }
                            }
                        }
                    }
                }]
            }

        });
    </script>

    <script>
        Highcharts.chart('Maize_Flour', {

            chart: {
                type: 'heatmap',
                // marginTop: 40,
                // marginBottom: 80,
                // plotBorderWidth: 1
            },


            title: {
                text: ''
            },

            xAxis: {
                categories: ['Mar 21', 'Apr 21', 'May 21', 'Jun 21', 'Jul 21', 'Aug 21', 'Sep 21', 'Oct 21', 'Nv 21', 'Dec 21']
            },
            exporting: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            yAxis: {
                categories: ['Kargi', 'Korr', 'Merille', 'Ol turot'],
                title: null,
                reversed: true
            },

            accessibility: {
                point: {
                    descriptionFormatter: function (point) {
                        var ix = point.index + 1,
                            xName = getPointCategoryName(point, 'x'),
                            yName = getPointCategoryName(point, 'y'),
                            val = point.value;
                        return ix + '. ' + xName + ' sales ' + yName + ', ' + val + '.';
                    }
                }
            },

            // colorAxis: {
            //     min: 0,
            //     minColor: '#FFFFFF',
            //     maxColor: Highcharts.getOptions().colors[0]
            // },
            colorAxis: {
                stops: [
                    [0, '#C8E76F'], //  for values <= 10
                    [0.5, '#F7BA1E'], // green for values between 10 and 20
                    [1, '#5978A3'] // red for values > 20
                ]
            },

            tooltip: {
                formatter: function () {
                    return '<b>' + getPointCategoryName(this.point, 'x') + '</b> sold <br><b>' +
                        this.point.value + '</b> items on <br><b>' + getPointCategoryName(this.point, 'y') + '</b>';
                }
            },

            series: [{
                name: 'Maize Flour',
                borderWidth: 0,
                data: [[0, 0, 10], [0, 1, 19], [0, 2, 8], [0, 3, 24], [1, 0, 92], [1, 1, 58], [1, 2, 78], [1, 3, 117], [2, 0, 35], [2, 1, 15], [2, 2, 123], [2, 3, 64], [3, 0, 72], [3, 1, 132], [3, 2, 114], [3, 3, 19], [4, 0, 38], [4, 1, 5], [4, 2, 8], [4, 3, 117], [5, 0, 88], [5, 1, 32], [5, 2, 12], [5, 3, 6], [6, 0, 13], [6, 1, 44], [6, 2, 88], [6, 3, 98], [7, 0, 31], [7, 1, 1], [7, 2, 82], [7, 3, 32], [8, 0, 85], [8, 1, 97], [8, 2, 123], [8, 3, 64], [9, 0, 47], [9, 1, 114], [9, 2, 31], [9, 3, 48]],
                dataLabels: {
                    enabled: true,
                    color: '#000000'
                }
            }],

            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        yAxis: {
                            labels: {
                                formatter: function () {
                                    return this.value.charAt(0);
                                }
                            }
                        }
                    }
                }]
            }

        });
    </script>

    <script>
        Highcharts.chart('Index_Commodities_Market', {
            chart: {
                type: 'spline',
            },
            title: {
                text: ''
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'April', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
                min: 0,
                title: {
                    text: ''
                }
            },
            tooltip: {
                pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
                shared: true
            },
            plotOptions: {
                series: {
                    marker: {
                        enabled: true,
                        radius: 2.5,
                        symbol: 'circle'
                    },
                    labels: {
                        enabled: false,
                        //radius: 2.5
                    }
                }
            },
            legend: {
                reversed: true,
            },
            exporting: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Camel Milk',
                color: '#165DFF',
                data: [4, 4, 2, 4, 4, 3, 4, 5, 6, 4, 5, 7]
            }, {
                name: 'Cattle Milk',
                color: '#14C9C9',
                data: [1, 2, 2, 1, 2, 3, 2, 4, 2, 3, 4, 5]
            }]
        });
    </script>


    <script>
        Highcharts.chart('Index_Commodities_Market_1', {
            chart: {
                type: 'spline',
            },
            title: {
                text: ''
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
                min: 0,
                title: {
                    text: ''
                }
            },
            tooltip: {
                pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
                shared: true
            },
            plotOptions: {
                series: {
                    marker: {
                        enabled: true,
                        radius: 2.5,
                        symbol: 'circle'
                    },
                    labels: {
                        enabled: false,
                        //radius: 2.5
                    }
                }
            },
            legend: {
                reversed: true,
            },
            exporting: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Grain',
                color: '#165DFF',
                data: [4, 4, 2, 4, 4, 3, 4, 5, 6, 4, 5, 7]
            }, {
                name: 'Sorghum',
                color: '#FFB6BA',
                data: [1, 2, 2, 1, 2, 3, 2, 4, 2, 3, 4, 5]
            }, {
                name: 'Wheat',
                color: '#14C9C9',
                data: [5, 4, 3, 2, 3, 3, 4, 5, 4, 3, 4, 5]
            }, {
                name: 'Sugar',
                color: '#F7BA1E',
                data: [4, 4, 2, 4, 4, 5, 4, 6, 5, 7, 5, 3]
            }, {
                name: 'Unpacked regular rice',
                color: '#C91414',
                data: [4, 4, 2, 4, 4, 5, 4, 6, 5, 7, 5, 3]
            },]
        });
    </script>

    <script>
        Highcharts.chart('Index_Commodities_Market_2', {
            chart: {
                type: 'spline',
            },
            title: {
                text: ''
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
                min: 0,
                title: {
                    text: ''
                }
            },
            tooltip: {
                pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
                shared: true
            },
            plotOptions: {
                series: {
                    marker: {
                        enabled: true,
                        radius: 2.5,
                        symbol: 'circle'
                    },
                    labels: {
                        enabled: false,
                        //radius: 2.5
                    }
                }
            },
            legend: {
                reversed: true,
            },
            exporting: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Goat Meat',
                color: '#165DFF',
                data: [4, 4, 2, 4, 4, 3, 4, 5, 6, 4, 5, 7]
            }, {
                name: 'One head of cabbage',
                color: '#FFB6BA',
                data: [1, 2, 2, 1, 2, 3, 2, 4, 2, 3, 4, 5]
            }, {
                name: 'One kilogram of common beans',
                color: '#14C9C9',
                data: [5, 4, 3, 2, 3, 3, 4, 5, 4, 3, 4, 5]
            }]
        });
    </script>


    <script>
        Highcharts.chart('Dry_Food_Market', {
            chart: {
                type: 'spline',
            },
            title: {
                text: ''
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
                min: 0,
                title: {
                    text: ''
                }
            },
            tooltip: {
                pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
                shared: true
            },
            plotOptions: {
                series: {
                    marker: {
                        enabled: true,
                        radius: 2.5,
                        symbol: 'circle'
                    },
                    labels: {
                        enabled: false,
                        //radius: 2.5
                    }
                }
            },
            legend: {
                reversed: true,
            },
            exporting: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'One bale of dry fodder',
                color: '#165DFF',
                data: [4, 4, 2, 4, 4, 3, 4, 5, 6, 4, 5, 7]
            }]
        });
    </script>

    <script>
        Highcharts.chart('Livestock_Volumes_Market', {
            chart: {
                type: 'column'
            },
            title: {
                align: 'left',
                text: ''
            },
            subtitle: {
                align: 'left',
                text: ''
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: ''
                }

            },
            legend: {
                enabled: true
            },
            exporting: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b><br/>'
            },

            series: [
                {
                    name: 'Livestock Volumes',
                    data: [
                        {
                            name: 'Market 1',
                            color: '#165DFF',
                            y: 50.06,
                        },
                        {
                            name: 'Market 2',
                            color: '#165DFF',
                            y: 50.84,
                        },
                        {
                            name: 'Market 3',
                            y: 90.18,
                            color: '#165DFF',
                        },
                        {
                            name: 'Market 4',
                            color: '#165DFF',
                            y: 30.06,
                        },
                        {
                            name: 'Market 5',
                            y: 34.18,
                            color: '#165DFF',
                        },
                        {
                            name: 'Market 6',
                            color: '#165DFF',
                            y: 50.06,
                        },
                        {
                            name: 'Market 7',
                            color: '#165DFF',
                            y: 60.06,
                        },]
                }
            ],
        });
    </script>

</body>

</html>