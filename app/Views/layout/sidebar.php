<style>
/* Memberikan margin dan padding yang tepat pada elemen select */
.custom-selectxs {
    width: 100% !important;
    /* Memastikan lebar dropdown penuh dengan lebar kontainer */
    /* max-width: 100%; */
    /* Menjamin dropdown tidak melebihi lebar kontainer */
    padding: 10px 15px;
    /* Memberikan jarak antara teks dan border */
    margin: 10px 0;
    /* Menambahkan margin atas dan bawah untuk jarak antar elemen */
    background-color: #ffffff;
    /* Warna latar belakang dropdown */
    color: #fff;
    /* Warna teks putih */
    border: 1px solid #555;
    /* Warna border dropdown */
    border-radius: 7px;
    /* Membuat sudut dropdown lebih melengkung */
    font-size: 14px;
    /* Ukuran font yang lebih sesuai */
    transition: all 0.3s ease-in-out;
    /* Efek transisi untuk tampilan */
}

/* Menambahkan efek saat dropdown mendapatkan fokus */
.custom-selectxs:focus {
    border-color: #007bff;
    /* Warna border saat fokus */
    outline: none;
    /* Menghilangkan outline */
    box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
    /* Menambahkan efek bayangan saat fokus */
}

/* Menata pilihan dropdown */
.custom-selectxs option {
    line-height: 1.5;
    color: #0c0c0c;
}

/* Menambahkan hover pada pilihan dropdown */
.custom-selectxs option:hover {
    background-color: #007bff;
    /* Warna saat hover */
    color: #fff;
}

/* Menambahkan margin pada form control untuk memberikan jarak dari elemen lain */
.formMargin {
    margin-left: 10px;
    margin-right: 10px;
}
</style>

<!--APP-SIDEBAR-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="side-header">
        <?php $program_id = session()->get('program'); ?>
        <a class="header-brand1" href="<?= base_url() ?>/Dashboard">
            <img src="<?php base_url() ?>/teamplate/assets/images/logoheader/logo_djelantikWeb.png" class="header-brand-img light-logo1"
            id="logochange" alt="logo">
        </a>
    </div>

    <ul class="side-menu">
        <form class="form-inline">
            <select class="form-control custom-selectxs formMargin" name="programid" id="programid" onchange="setValue()">
                <option value="" selected='selected' id='nameprogram'>
                    <?php
                        $nameProgram = session()->get('nameprogram') ?: '-- Select Program --';
        echo $nameProgram;
        ?>
                </option>
                <?php
        // Koneksi ke database
        $db = \Config\Database::connect();
        $userId = session()->get('users_id');
        $admin = session()->get('first_name');
        $selectedProgramId = session()->get('program'); // Mendapatkan ID program yang dipilih

        if ($admin == 'Super Admin') {
            $query = "SELECT c.program_id, c.name, e.picture
                        FROM users a
                        JOIN usersgroupprogram b ON a.users_id = b.users_id
                        JOIN program c ON b.program_id = c.program_id
                        JOIN `group` d ON b.group_id = d.group_id
                        JOIN `client` e ON e.client_id = c.client_id
                        GROUP BY b.program_id 
                        ORDER BY c.name ASC";
        } else {
            $query = "SELECT c.program_id, c.name, e.picture
                        FROM users a
                        JOIN usersgroupprogram b ON a.users_id = b.users_id
                        JOIN program c ON b.program_id = c.program_id
                        JOIN `group` d ON b.group_id = d.group_id
                        JOIN `client` e ON e.client_id = c.client_id
                        WHERE a.users_id = '$userId'
                        GROUP BY b.program_id 
                        ORDER BY c.name ASC";
        }

        // Menjalankan query dan menampilkan opsi program
        $programs = $db->query($query)->getResult();

        foreach ($programs as $program) {
            // Melewatkan program yang sudah dipilih agar tidak muncul dua kali
            if ($program->program_id == $selectedProgramId) {
                continue;
            }
            echo "<option value='{$program->program_id}'>{$program->name}</option>";
        }
        ?>
            </select>
        </form>
        <?php
        $db = \Config\Database::connect();
        $parentmenu = $db->query("SELECT * FROM menu WHERE parent_id IS NULL OR parent_id = ' ' ORDER BY sequence ASC ");

        $menuview ='<li class="slide">
                        <a class="side-menu__item" href='.base_url('Dashboard').'>
                            &nbsp;&nbsp;
                           <span class="side-menu__label">DASHBOARD</span>
                        </a>
                    </li>';

        foreach ($parentmenu->getResult() as $menu) {
            if ($admin == 'Super Admin') {
                $cek_parent = $db->query("
                    SELECT a.menu_id, a.parent_id, b.name AS parentNAME, a.name AS menu_name, c.name AS url, d.name AS actionName, 
                            a.sequence, a.image_url, a.page_id, d.action_id
                    FROM menu a
                    LEFT JOIN menu b ON a.parent_id = b.menu_id
                    LEFT JOIN page c ON a.page_id = c.page_id
                    LEFT JOIN action d ON a.action_id = d.action_id
                    WHERE a.parent_id = '$menu->menu_id'
                    ORDER BY a.sequence DESC
                ");
            } else {
                $cek_parent = $db->query("
                    SELECT DISTINCT a.users_id, a.group_id, a.program_id, a.data_level, c.code, c.name, d.name AS group_name, 
                    f.page_id, g.name AS menu_name, f.name AS url, g.parent_id, g.image_url
                    FROM usersgroupprogram a
                    JOIN users b ON a.users_id = b.users_id
                    JOIN program c ON a.program_id = c.program_id
                    JOIN `group` d ON a.group_id = d.group_id
                    JOIN privilege e ON d.group_id = e.group_id
                    JOIN page f ON e.page_id = f.page_id
                    JOIN menu g ON f.page_id = g.page_id
                    WHERE a.users_id = '$userId' AND a.program_id = '$program_id' AND g.parent_id = '$menu->menu_id'
                ");
            }

            if (($cek_parent->getRow()) > null) {
                $menuview .= '
                    <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#">
                        '.$menu->image_url.'&nbsp;&nbsp;
                        <span class="side-menu__label">'.$menu->name.'</span><i class="angle fa fa-angle-right"></i>
                    </a>';
                $menuview .= '<ul class="slide-menu">';

                foreach ($cek_parent->getResult() as $sub) {
                    $menuview .= '<li><a href="'.base_url($sub->url).'" class="slide-item">'.$sub->menu_name.'</a></li>';
                }
                $menuview .= '</ul></li>';
            }
        }
        echo $menuview;
        ?>
    </ul>
</aside>

<div class="app-header header">
</div>
<!--/APP-SIDEBAR-->