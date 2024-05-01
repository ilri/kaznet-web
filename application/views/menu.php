<div id="main-content">
    <span class="btn btn-light expand-collapse-btn" id="sidebarCollapse"><span><img
                src="<?php echo base_url(); ?>include/assets/images/collapse-arrow.svg"></span></span>
    <nav class="navbar navbar-expand-md bg-dark navbar-dark" height="110px">
        <a class="navbar-brand" href="javascript:void(0);">
            <?php 
            $url_segment = $this->uri->segment(1);
            $page_name = "";
            switch ($url_segment) {
                case 'login':
                    $page_name = "Profile";
                    break;
                case 'users':
                    $page_name = "Contributors";
                    break;
                case 'survey':
                    $page_name = "Task Management";
                    break;
                case 'reports':
                    $page_name = "Data Management";
                    break;
                
                default:
                    # code...
                    break;
            }
            ?>
            <span class="nav-text"><?php echo($page_name);?></span>
            <p class="mb-0 text-small"><?php echo(date('l')); ?>, <span class="text-date"><?php echo (date('d M Y')); ?></span></p>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav ml-auto">
                <!-- <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span class="search-img"><span><img src="<?php echo base_url(); ?>include/assets/images/search.png"></span>
                        <input type="text" class="form-control search-input" name="" placeholder="Search"/></span>
                    </a>
                </li> -->
                <li class="nav-item pr-4 pl-4">
                    <a class="nav-link" href="#">
                        <img src="<?php echo base_url(); ?>include/assets/images/notification1.png">
                    </a>
                </li>
                
                <li class="nav-item">
                    <div class="dropdown mt-3">
                        <span class="dropdown-toggle drop-arrow-one"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php if(isset($profile_details['image'])){ ?>
                            <img class="pr-3" src="<?php echo base_url(); ?>uploads/user/<?php echo($profile_details['image']); ?>" height="30px" />
                            <?php }else{ ?>
                                <img class="pr-3" src="<?php echo base_url(); ?>include/assets/images/default.png" height="30px"/>
                                <?php } ?>
                              <?php echo($profile_details['first_name']." ". $profile_details['last_name']); ?> 
                        </span>
                        <div class="dropdown-menu tbl-drop-filter border-0 p-0" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#" style="background: #6F1B28;">
                                <div class="d-flex align-items-center">
                                    <div class="pr-3 mt-3 mb-3">
                                        <!-- <img src="<?php echo base_url(); ?>include/assets/images/<?php echo($profile_details['image']); ?>" /> -->
                                        <?php if(isset($profile_details['image'])){ ?>
                                            <img class="pr-3" src="<?php echo base_url(); ?>uploads/user/<?php echo($profile_details['image']); ?>" height="30px"/>
                                            <?php }else{ ?>
                                            <img class="pr-3" src="<?php echo base_url(); ?>include/assets/images/default.png" height="30px"/>
                                        <?php } ?>
                                    </div>
                                    <div class="profile-title">
                                        <h6 class="mb-0"><?php echo($profile_details['first_name']." ". $profile_details['last_name']); ?></h6>
                                        <p class="mb-0"><?php echo($profile_details['email_id']); ?></p>
                                    </div>
                                </div>
                            </a>
                            <a class="dropdown-item my-2" href="<?php echo base_url(); ?>login/profile"><img class="pr-2" src="<?php echo base_url(); ?>include/assets/images/profile.svg" /> My Profile</a>
                            <a class="dropdown-item my-2" href="#"><img class="pr-2" src="<?php echo base_url(); ?>include/assets/images/settings.svg" /> Settings</a>
                            <a class="dropdown-item my-2" href="<?php echo base_url(); ?>auth/logout"><img class="pr-2" src="<?php echo base_url(); ?>include/assets/images/logout.svg" /> Logout</a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>