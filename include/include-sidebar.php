<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php?halaman=beranda">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item <?php if ($_GET['halaman']=="beranda") {?> active <?php } ?>">
        <a class="nav-link" href="index.php?halaman=beranda">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <hr class="sidebar-divider">

    <?php
        $ambil=mysqli_query($koneksi,"SELECT * from pengguna WHERE id_pengguna = $_SESSION[id_pengguna]");
        $pengguna=$ambil->fetch_assoc();
        if ($pengguna['role'] == 'Admin'){
    ?>

    <div class="sidebar-heading">
        Data Master
    </div>

    <li class="nav-item <?php if (($_GET['halaman']=="jamkerja") || ($_GET['halaman']=="jamkerja-tambah") || ($_GET['halaman']=="jamkerja-ubah")) {?> active <?php } ?>">
        <a class="nav-link" href="index.php?halaman=jamkerja">
            <i class="fas fa-fw fa-clock"></i>
            <span>Jam Kerja</span></a>
    </li>

    <li class="nav-item <?php if (($_GET['halaman']=="jabatan") || ($_GET['halaman']=="jabatan-tambah") || ($_GET['halaman']=="jabatan-ubah")) {?> active <?php } ?>">
        <a class="nav-link" href="index.php?halaman=jabatan">
            <i class="fas fa-fw fa-address-card"></i>
            <span>Jabatan</span></a>
    </li>
    
    <hr class="sidebar-divider">
    <?php
        }
    ?>


    <div class="sidebar-heading">
        Data
    </div>

    <?php
        $ambil=mysqli_query($koneksi,"SELECT * from pengguna WHERE id_pengguna = $_SESSION[id_pengguna]");
        $pengguna=$ambil->fetch_assoc();
        if ($pengguna['role'] == 'Admin'){
    ?>

    <li class="nav-item <?php if (($_GET['halaman']=="pengguna") || ($_GET['halaman']=="pengguna-tambah") || ($_GET['halaman']=="pengguna-ubah")) {?> active <?php } ?>">
        <a class="nav-link" href="index.php?halaman=pengguna">
            <i class="fas fa-fw fa-user"></i>
            <span>Pengguna</span></a>
    </li>

    <li class="nav-item <?php if (($_GET['halaman']=="pegawai") || ($_GET['halaman']=="pegawai-tambah") || ($_GET['halaman']=="pegawai-ubah")) {?> active <?php } ?>">
        <a class="nav-link" href="index.php?halaman=pegawai">
            <i class="fas fa-fw fa-user-friends"></i>
            <span>Pegawai</span></a>
    </li>

    <?php
        }
    ?>

    <li class="nav-item <?php if (($_GET['halaman']=="absensi") || ($_GET['halaman']=="absensi-pegawai") || ($_GET['halaman']=="absensi-ubah")) {?> active <?php } ?>">
        <a class="nav-link" href="index.php?halaman=absensi">
            <i class="fas fa-fw fa-tasks"></i>
            <span>Absensi</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="index.php?halaman=cuti">
            <i class="fas fa-fw fa-clipboard"></i>
            <span>Cuti</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="index.php?halaman=izin-sakit">
            <i class="fas fa-fw fa-clipboard"></i>
            <span>Izin Sakit</span></a>
    </li>

    <!-- <li class="nav-item active">
        <a class="nav-link" href="index.php?halaman=pengguna">
            <i class="fas fa-fw fa-address-card"></i>
            <span>Pengajuan Cuti</span></a>
    </li> -->

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>