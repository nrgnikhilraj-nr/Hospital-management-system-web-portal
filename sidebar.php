<aside class="sidebar" id="sidebar">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link <?php echo $current_page == 'dashboard.php' ? 'active' : ''; ?>" href="<?php echo base_url(); ?>dashboard.php">
                <i class="fa-solid fa-gauge"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo strpos($_SERVER['PHP_SELF'], 'patients') !== false ? 'active' : ''; ?>" href="<?php echo base_url(); ?>patients/list.php">
                <i class="fa-solid fa-bed-pulse"></i> Patients
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo strpos($_SERVER['PHP_SELF'], 'doctors') !== false ? 'active' : ''; ?>" href="<?php echo base_url(); ?>doctors/list.php">
                <i class="fa-solid fa-user-doctor"></i> Doctors
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo strpos($_SERVER['PHP_SELF'], 'appointments') !== false ? 'active' : ''; ?>" href="<?php echo base_url(); ?>appointments/list.php">
                <i class="fa-solid fa-calendar-check"></i> Appointments
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo strpos($_SERVER['PHP_SELF'], 'billing') !== false ? 'active' : ''; ?>" href="<?php echo base_url(); ?>billing/list.php">
                <i class="fa-solid fa-file-invoice-dollar"></i> Billing
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo strpos($_SERVER['PHP_SELF'], 'inventory') !== false ? 'active' : ''; ?>" href="<?php echo base_url(); ?>inventory/list.php">
                <i class="fa-solid fa-boxes-stacked"></i> Inventory
            </a>
        </li>
    </ul>
</aside>
