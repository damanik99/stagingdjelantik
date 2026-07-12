<!-- App-Header -->
<div class="app-header header">
    <div class="container-fluid">
        <div class="d-flex">
            <a class="header-brand ml-auto d-md-none" href="#">
                <img src="<?= base_url() ?>/teamplate/assets/images/logoheader/logo_djelantikWeb.png"
                    class="header-brand-img mobile-icon" alt="logo">
                <img src="<?= base_url() ?>/teamplate/assets/images/brand/logo.png"
                    class="header-brand-img desktop-logo mobile-logo" alt="logo">
            </a>
            <a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-toggle="sidebar" href="#">
                <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                    <path d="M0 0h24v24H0V0z" fill="none" />
                    <path d="M21 11.01L3 11v2h18zM3 16h12v2H3zM21 6H3v2.01L21 8z" />
                </svg>
            </a><!-- sidebar-toggle-->
            <div class="d-flex ml-auto header-right-icons">
                <button class="navbar-toggler navresponsive-toggler d-md-none" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent-4" aria-controls="navbarSupportedContent-4"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"
                        class="navbar-toggler-icon">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path
                            d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" />
                    </svg>
                </button>
                <div class="dropdown profile-1">
                    <a href="#" data-toggle="dropdown" class="nav-link pl-2 pr-2  leading-none d-flex">
                        <span>
                            <img src="<?= base_url() ?>/teamplate/assets/images/users/profile.png"
                                alt="profile-user" class="avatar  mr-xl-3 profile-user brround cover-image">
                        </span>
                        <div class="text-center mt-1 d-none d-xl-block">
                            <h6 class="text-dark mb-0 fs-13 font-weight-semibold"><?=session()->get('username')?></h6>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                        <a class="dropdown-item"
                            href="<?=base_url()?>/users/editprofile/<?=session()->get('users_id')?>">
                            <i class="dropdown-icon mdi mdi-account-outline"></i> Update Password
                        </a>
                        <a class="dropdown-item" href="<?= base_url() ?>/auth/logout">
                            <i class="dropdown-icon mdi  mdi-logout-variant"></i> Sign out
                        </a>
                    </div>
                </div><!-- SIDE-MENU -->
            </div>
        </div>
    </div>
</div>
<!-- responsive-navbar -->
<div class="mb-1 navbar navbar-expand-lg  responsive-navbar navbar-dark d-md-none bg-white">
    <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
        <div class="d-flex order-lg-2 ml-auto">
            <div class="dropdown d-sm-flex">
                <a href="#" class="nav-link icon" data-toggle="dropdown">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path
                            d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
                    </svg>
                </a>
                <div class="dropdown-menu header-search dropdown-menu-left">
                    <div class="input-group w-100 p-2">
                        <form class="form-inline">
                            <div class="search-element">
                                <select class="form-control" name="programid" id="programid">
                                    <option value="">-- SELECT PROGRAM --</option>
                                    <?php

                                                $db         = \Config\Database::connect();
                                                $id         = session()->get('users_id');
                                                $admin      = session()->get('first_name');

                                                if($admin=='Super Admin')
                                                {
                                                        $programall  = $db->query("SELECT a.program_id, c.name FROM usersgroupprogram a 
                                                                                    JOIN users b ON a.users_id = b.users_id
                                                                                    JOIN program c ON a.program_id = c.program_id
                                                                                    JOIN `group` d ON a.group_id = d.group_id
                                                                                    GROUP BY program_id
                                                                                    ORDER BY c.name ASC");
                                                        foreach ($programall->getResult() as $all) 
                                                        {
                                                                echo "<option value='$all->program_id' class='selecttwo'>$all->name</option>";
                                                        }
                                                }
                                                else
                                                {  
                                                        $programid  = $db->query("SELECT c.program_id, c.name FROM usersgroupprogram a
                                                                        JOIN users b ON a.users_id = b.users_id
                                                                        JOIN program c ON a.program_id = c.program_id
                                                                        JOIN `group` d ON a.group_id = d.group_id
                                                                        WHERE a.users_id = '".$id."' GROUP BY c.program_id
                                                                        ORDER BY c.name ASC");
                                                        foreach ($programid->getResult() as $h) 
                                                        {
                                                                echo "<option value='$h->program_id'>$h->name</option>";
                                                        }
                                                }
                                        ?>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!-- SEARCH -->
            <div class="dropdown d-md-flex">
                <a class="nav-link icon full-screen-link nav-link-bg">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"
                        class="fullscreen-button">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <circle cx="12" cy="12" opacity=".3" r="3" />
                        <path
                            d="M7 12c0 2.76 2.24 5 5 5s5-2.24 5-5-2.24-5-5-5-5 2.24-5 5zm8 0c0 1.65-1.35 3-3 3s-3-1.35-3-3 1.35-3 3-3 3 1.35 3 3zM3 19c0 1.1.9 2 2 2h4v-2H5v-4H3v4zM3 5v4h2V5h4V3H5c-1.1 0-2 .9-2 2zm18 0c0-1.1-.9-2-2-2h-4v2h4v4h2V5zm-2 14h-4v2h4c1.1 0 2-.9 2-2v-4h-2v4z" />
                    </svg>
                </a>
            </div><!-- FULL-SCREEN -->
        </div>
    </div>
</div><!-- End responsive-navbar -->
<!-- App-Header -->