<?php
include('dbh.php');

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
}

if ($_SESSION['role'] == 3) {
    header("Location: ../pharmacy/index.php");
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
                <!--            <i class="fas fa-fw fa-tachometer-alt"></i>-->
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
        <?php if ($role == "3") { ?>
            <li class="nav-item">
                <a class="nav-link" href="pharmacy.php">
                    <i class="fas fa-clinic-medical"></i>
                    <span>Pharmacy</span></a>
            </li>
        <?php } ?>

        <!-- Nav Item - Users -->
        <?php if ($role == "4") { ?>
            <li class="nav-item">
                <a class="nav-link" href="users.php">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Users</span></a>
            </li>
        <?php } ?>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">
        <li class="nav-item">
            <a class="nav-link" href="cart.php">
                <i class="fas fa-shopping-cart"></i>
                <span>Cart</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="orders.php">
                <i class="fas fa-book-reader"></i>
                <span>Orders</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="book_an_appointment.php">
                <i class="fas fa-calendar-check"></i>
                <span>Book an appointment</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="bookings.php">
                <i class="fas fa-calendar-check"></i>
                <span>Bookings</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="transactions.php">
                <i class="fas fa-table"></i>
                <span>Transactions</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="profile.php">
                <i class="fas fa-address-card"></i>
                <span>Profile</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="cashin.php">
            <i class="fa fa-money-bill"></i>
                <span>PharmaPay</span></a>
        </li>


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