<?php
    function PageName() {
    return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
    }
    
    $currentPage = PageName();
?>
<ul class="navbar-nav bg-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <img src="asset/img/logo1.png" alt="" height=35px>
        <div class="sidebar-brand-text mx-3">SISAB</div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item <?php echo ($currentPage=='index.php') ? 'active':NULL ?>">
        <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <?php
        if ($userLogin['role'] == 'Admin'){
    ?>

    <li class="nav-item <?php echo ($currentPage=='datamaster.php') || ($currentPage=='datamaster_jabatan_tambah.php') || ($currentPage=='datamaster_jabatan_ubah.php') ? 'active':NULL ?>"> 
        <a class="nav-link" href="datamaster.php">
            <i class="fas fa-fw fa-clock"></i>
            <span>Data Master</span></a>
    </li>

    <li class="nav-item <?php echo ($currentPage=='pengguna.php') || ($currentPage=='pengguna_tambah.php') || ($currentPage=='pengguna_ubah.php') || ($currentPage=='pengguna_ubah_katasandi.php') ? 'active':NULL ?>">
        <a class="nav-link" href="pengguna.php">
            <i class="fas fa-fw fa-user"></i>
            <span>Pengguna</span></a>
    </li>

    <li class="nav-item <?php echo ($currentPage=='pegawai.php') || ($currentPage=='pegawai_tambah.php') || ($currentPage=='pegawai_ubah.php') || ($currentPage=='pegawai_ubah_katasandi.php') ? 'active':NULL ?>">
        <a class="nav-link" href="pegawai.php">
            <i class="fas fa-fw fa-user-friends"></i>
            <span>Pegawai</span></a>
    </li>

    <li class="nav-item <?php echo ($currentPage=='absensi.php') || ($currentPage=='absensi_pegawai.php') || ($currentPage=='absensi_ubah.php') ? 'active':NULL ?>">
        <a class="nav-link" href="absensi.php">
            <i class="fas fa-fw fa-clock"></i>
            <span>Absensi</span></a>
    </li>
    <?php
        }elseif ($userLogin['role'] == 'Pegawai'){
    ?>
    <li class="nav-item <?php echo ($currentPage=='absensi_perpegawai.php') ? 'active':NULL ?>">
        <a class="nav-link" href="absensi_perpegawai.php">
            <i class="fas fa-fw fa-clock"></i>
            <span>Absensi</span></a>
    </li>
    <?php
        }
    ?>


    <li class="nav-item <?php echo ($currentPage=='cuti.php') || ($currentPage=='cuti_pengajuan.php') || ($currentPage=='cuti_editpengajuan.php') || ($currentPage=='cuti_konfirmasi.php') ? 'active':NULL ?>">
        <a class="nav-link" href="cuti.php">
            <i class="fas fa-fw fa-clipboard"></i>
            <span>Cuti</span></a>
    </li>

    <li class="nav-item <?php echo ($currentPage=='izinsakit.php') || ($currentPage=='izinsakit_pengajuan.php') || ($currentPage=='izinsakit_editpengajuan.php') || ($currentPage=='izinsakit_konfirmasi.php') ? 'active':NULL ?>">
        <a class="nav-link" href="izinsakit.php">
            <i class="fas fa-fw fa-clipboard"></i>
            <span>Izin Sakit</span></a>
    </li>

    <?php
        if ($userLogin['role'] == 'Admin'){
    ?>
    <li class="nav-item <?php echo ($currentPage=='laporan.php') ? 'active':NULL ?>">
        <a class="nav-link" href="laporan.php">
            <i class="fas fa-fw fa-print"></i>
            <span>Laporan</span></a>
    </li>
    <?php
        }
    ?>

    <!-- <li class="nav-item active">
        <a class="nav-link" href="pengguna">
            <i class="fas fa-fw fa-address-card"></i>
            <span>Pengajuan Cuti</span></a>
    </li> -->

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>