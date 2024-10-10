<!-- Sidebar content -->
<div id="mySidenav" class="sidenav">
    <a class="mt-mb-26px" href="#">
        <span class="logo-img"><img src="<?php echo base_url(); ?>include/assets/images/logo.png"></span>
        <span class="collapse-text-none mb-0">KAZNET</span>
    </a>
    <hr>
    <nav id="sidebar">
        <ul class="list-unstyled components">
            <li class="<?php echo(($this->uri->segment(1)) == 'dashboard' ? 'active' : '');?>">
                <a href="#dashboardSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <!-- <a href="<?php echo base_url(); ?>dashboard/view_dashboard" class="sub-menu <?php echo(($this->uri->segment(2)) == 'view_dashboard' ? 'active' : '');?>"> -->
                <!-- <a href="<?php echo base_url(); ?>login/profile" class="sub-menu <?php echo(($this->uri->segment(2)) == 'view_dashboard' ? 'active' : '');?>"> -->
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
                <ul class="collapse list-unstyled <?php echo(($this->uri->segment(1)) == 'dashboard' ? 'show' : '');?>" id="dashboardSubmenu">
                    <li>
                        <a href="<?php echo base_url(); ?>dashboard/view_dashboard" class="sub-menu <?php echo(($this->uri->segment(2)) == 'view_dashboard' ? 'active' : '');?>">Summary</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>dashboard/view_dashboard_feedback" class="sub-menu <?php echo(($this->uri->segment(2)) == 'view_dashboard_feedback' ? 'active' : '');?>">Dissemination report</a>
                    </li>
                </ul>
            </li>
            
            <li class="<?php echo(($this->uri->segment(1)) == 'survey' ? 'active' : '');?>">
                <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <span class="logo-img-mt-4">
                        <svg width="26" height="22" viewBox="0 0 26 22" fill="none"
                            xmlns="http://www.w3.org/2000/svg" class="bg <?php echo(($this->uri->segment(1)) == 'survey' ? 'active' : '');?>">
                            <path
                                d="M16.2501 5.04167C15.6521 5.04167 15.1667 4.55634 15.1667 3.95834V2.33334H10.8334V3.95834C10.8334 4.55634 10.3481 5.04167 9.75008 5.04167C9.15208 5.04167 8.66675 4.55634 8.66675 3.95834V2.33334C8.66675 1.13842 9.6385 0.166672 10.8334 0.166672H15.1667C16.3617 0.166672 17.3334 1.13842 17.3334 2.33334V3.95834C17.3334 4.55634 16.8481 5.04167 16.2501 5.04167Z" />
                            <path
                                d="M13.7692 14.6617C13.5742 14.7375 13.2925 14.7917 13 14.7917C12.7075 14.7917 12.4258 14.7375 12.1658 14.64L0 10.5883V18.8542C0 20.5008 1.3325 21.8333 2.97917 21.8333H23.0208C24.6675 21.8333 26 20.5008 26 18.8542V10.5883L13.7692 14.6617Z" />
                            <path
                                d="M26 6.39584V8.87667L13.26 13.1233C13.1733 13.1558 13.0867 13.1667 13 13.1667C12.9133 13.1667 12.8267 13.1558 12.74 13.1233L0 8.87667V6.39584C0 4.74917 1.3325 3.41667 2.97917 3.41667H23.0208C24.6675 3.41667 26 4.74917 26 6.39584Z" />
                        </svg>
                    </span>
                    <span class="collapse-text-none-nav mb-0">Task Management</span>
                </a>
                <ul class="collapse list-unstyled <?php echo(($this->uri->segment(1)) == 'survey' ? 'show' : '');?>" id="homeSubmenu">
                    <li>
                        <a href="<?php echo base_url(); ?>survey/manage_task" class="sub-menu <?php echo(($this->uri->segment(2)) == 'manage_task' ? 'active' : '');?>">Manage Tasks</a>
                    </li>
                    <!-- <li>
                        <a href="../dashboard/tasks/assign-tasks.html" class="sub-menu <?php echo(($this->uri->segment(2)) == 'remaider' ? 'active' : '');?>">Reminder</a>
                    </li> -->
                    <li>
                        <a href="<?php echo base_url(); ?>survey/assign_task" class="sub-menu <?php echo(($this->uri->segment(2)) == 'assign_task' ? 'active' : '');?>">Assign Task</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>survey/task_contributer" class="sub-menu <?php echo(($this->uri->segment(2)) == 'task_contributor' ? 'active' : '');?>">Task Contributor</a>
                    </li>
                    <!-- <li>
                        <a href="<?php echo base_url(); ?>reports/task_data_export" class="sub-menu <?php echo(($this->uri->segment(2)) == 'task_data_export' ? 'active' : '');?>">Task Data Export</a>
                    </li> -->
                    
                    <!-- <li>
                        <a href="<?php echo base_url(); ?>survey/task_contributer" class="sub-menu <?php echo(($this->uri->segment(2)) == 'task_contributer' ? 'active' : '');?>">Task Contributers</a>
                    </li> -->
                </ul>
            </li>
            
            <li class="<?php echo(($this->uri->segment(1)) == 'users' ? 'active' : '');?>">
                <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle">
                    <span class="logo-img-mt-4">
                        <svg width="26" height="23" viewBox="0 0 26 23" fill="none"
                            xmlns="http://www.w3.org/2000/svg" class="bg <?php echo(($this->uri->segment(1)) == 'users' ? 'active' : '');?>">
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
                    <span class="collapse-text-none-nav mb-0">Users</span>
                </a>
                <ul class="collapse list-unstyled <?php echo(($this->uri->segment(1)) == 'users' ? 'show' : '');?>" id="pageSubmenu">
                    <li>
                        <a href="<?php echo base_url(); ?>users/create" class="sub-menu <?php echo(($this->uri->segment(2)) == 'create' ? 'active' : '');?>">Create User</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>users/manage" class="sub-menu <?php echo(($this->uri->segment(2)) == 'manage' ? 'active' : '');?>">Manage User</a>
                    </li>
                    <!-- <li>
                        <a href="<?php echo base_url(); ?>users/manage_respondent" class="sub-menu <?php echo(($this->uri->segment(2)) == 'manage_respondent' ? 'active' : '');?>">Manage Respondent</a>
                    </li> -->
                    <li>
                        <a href="<?php echo base_url(); ?>users/manage_contributer_location" class="sub-menu <?php echo(($this->uri->segment(2)) == 'manage_contributer_location' ? 'active' : '');?>">Manage Contributor Locations</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>users/manage_cluster_location" class="sub-menu <?php echo(($this->uri->segment(2)) == 'manage_cluster_location' ? 'active' : '');?>">Manage Cluster Admin Locations</a>
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
                    <span class="collapse-text-none-nav mb-0">Data Management</span>
                </a>
                <ul class="collapse list-unstyled <?php echo(($this->uri->segment(1)) == 'reports' ? 'show' : '');?>" id="pageSubmenu1">
                    <li>
                        <a href="<?php echo base_url(); ?>reports/view_survey_data/3" class="sub-menu <?php echo(($this->uri->segment(3)) == '3' ? 'active' : '');?>">Milk Production</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>reports/view_survey_data/4" class="sub-menu <?php echo(($this->uri->segment(3)) == '4' ? 'active' : '');?>">Body condition and weight</a>
                    </li>                    
                    <li>
                        <a href="<?php echo base_url(); ?>reports/view_survey_data/6" class="sub-menu <?php echo(($this->uri->segment(3)) == '6' ? 'active' : '');?>">MUAC</a>
                    </li>                    
                    <li>
                        <a href="<?php echo base_url(); ?>reports/view_survey_data/8" class="sub-menu <?php echo(($this->uri->segment(3)) == '8' ? 'active' : '');?>">RCSI</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>reports/view_survey_data/10" class="sub-menu <?php echo(($this->uri->segment(3)) == '10' ? 'active' : '');?>">Livestock births and deaths trade</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>reports/view_survey_data/12" class="sub-menu <?php echo(($this->uri->segment(3)) == '12' ? 'active' : '');?>">Livestock Feeds and Water</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>reports/view_survey_data/13" class="sub-menu <?php echo(($this->uri->segment(3)) == '13' ? 'active' : '');?>">Crops Water Incomes Expenditures</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>reports/view_survey_data/14" class="sub-menu <?php echo(($this->uri->segment(3)) == '14' ? 'active' : '');?>">Conflict Exposure</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>reports/view_survey_data/5" class="sub-menu <?php echo(($this->uri->segment(3)) == '5' ? 'active' : '');?>">Livestock Prices & Quality</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>reports/view_survey_data/7" class="sub-menu <?php echo(($this->uri->segment(3)) == '7' ? 'active' : '');?>">Prices of Index commodities</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>reports/view_survey_data/11" class="sub-menu <?php echo(($this->uri->segment(3)) == '11' ? 'active' : '');?>">Livestock Volumes</a>
                    </li>                    
                    <li>
                        <a href="<?php echo base_url(); ?>reports/view_survey_data/9" class="sub-menu <?php echo(($this->uri->segment(3)) == '9' ? 'active' : '');?>">Transect forage conditions</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>reports/household_profile" class="sub-menu <?php echo(($this->uri->segment(2)) == 'household_profile' ? 'active' : '');?>">Household profile</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>reports/contributor_profile" class="sub-menu <?php echo(($this->uri->segment(2)) == 'contributor_profile' ? 'active' : '');?>">Contributor profile</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>reports/transect_pastures" class="sub-menu <?php echo(($this->uri->segment(2)) == 'transect_pastures' ? 'active' : '');?>">Transect Pastures</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>reports/payment_report" class="sub-menu <?php echo(($this->uri->segment(2)) == 'payment_report' ? 'active' : '');?>">Payment Report</a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="<?php echo base_url(); ?>notification/send_alert">
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
                    <span class="collapse-text-none-nav mb-0">Notification</span>
                </a>
            </li>
            <li class="<?php echo(($this->uri->segment(1)) == 'FormController' ? 'active' : '');?>">
                <a href="#templateSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
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
                    <span class="collapse-text-none-nav mb-0">Custom Templates</span>
                </a>
                <ul class="collapse list-unstyled <?php echo(($this->uri->segment(1)) == 'FormController' ? 'show' : '');?>" id="templateSubmenu">
                    <li>
                        <a href="<?php echo base_url(); ?>FormController/create_form" class="sub-menu <?php echo(($this->uri->segment(2)) == 'create_form' ? 'active' : '');?>">Create Template</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>FormController/list_forms" class="sub-menu <?php echo(($this->uri->segment(2)) == 'list_forms' ? 'active' : '');?>">Manage Templates</a>
                    </li>
                </ul>
            </li>
        </ul>


    </nav>
</div>
<!-- /Sidebar content end-->