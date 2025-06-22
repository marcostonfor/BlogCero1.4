<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../router.php';
require_once __DIR__ . '/login/userRepository.php';

$user = null;

if (isset($_SESSION['user_id'])) {
    $userRepo = new UserRepository();
    $user = $userRepo->findById($_SESSION['user_id']);
}
?>
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/system_login/assets/css/estilosLogins.css">
<section id="system_login">
    <?php if (!empty($user)): ?>
        <?php echo "<h6>Bienvenido usuario " . htmlspecialchars($user->getEmail()) . "</h6>"; ?>
        <div class="dropdown">
            <button onclick="myFunction()" class="dropbtn">Dropdown</button>
            <div id="myDropdown" class="dropdown-content">
                <a href="<?php echo BASE_URL; ?>/admin/dashboard.php"><strong>Dashboard</strong></a>
                <a href="#">Bloc de notas</a>
                <a href="#contact">Contact</a>
            </div>
        </div>
        <br>Te has logueado correctamente
        <a href="<?php echo BASE_URL; ?>/system_login/logout/logout.php">Logout</a>
    <?php else: ?>
        <h5>Por favor, registrese o acceda</h5>
        <a href="<?php echo BASE_URL; ?>/system_login/login/login.php">Login</a>
        <small>OR</small>
        <a href="<?php echo BASE_URL; ?>/system_login/signup/signup.php">Signup</a>
    <?php endif; ?>
</section>
<script>
    /* When the user clicks on the button, 
    toggle between hiding and showing the dropdown content */
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function (event) {
        if (!event.target.matches('.dropbtn')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
</script>