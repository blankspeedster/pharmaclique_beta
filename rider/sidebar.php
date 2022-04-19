<?php
include('dbh.php');

if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
}

$role = $_SESSION['role'];
//4 is admin
?>
<style>
    nav ul {
        position: sticky !important;
        top: 0;
        z-index: 99;
        white-space: normal;
    }

    nav ul li a {
        white-space: normal !important;
    }
</style>
<nav>
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
            <div class="sidebar-brand-icon">
                <i class="fas fa-capsules"></i>
            </div>
            <div class="sidebar-brand-text mx-3">PharmaClique</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
            <a class="nav-link" href="index.php">
                <i class="fas fa-house-user"></i>
                <span>Home</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider" style="display: none;">

        <!-- Heading -->
        <div class="sidebar-heading">
            Menus
        </div>

        <!-- Nav Item - Pharmacy -->
        <li class="nav-item">
            <a class="nav-link" href="rides.php">
                <i class="fas fa-biking"></i>
                <span>Rides</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="transactions.php">
                <i class="fas fa-table"></i>
                <span>Transactions</span></a>
        </li>
        
        <!-- Nav Item - Pharmacy -->
        <!-- <li class="nav-item">
            <a class="nav-link" href="rider_sample.php">
                <i class="fas fa-biking"></i>
                <span>Rider Sample</span></a>
        </li> -->


        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
    <?php
    //Navy Blue
    //#05445E
    //
    //Blue Grotto
    //#189AB4
    //
    //Blue Green
    //#75E6DA
    //
    //Baby Blue
    //#D4F1F4
    ?>
</nav>