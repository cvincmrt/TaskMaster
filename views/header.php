<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <span class="navbar-brand">TaskMaster</span>
        <div class="d-flex align-items-center">
            <?php if(isset($_SESSION['username'])): ?>
                <span class="text-white me-3">
                    <i class="bi bi-person-circle"></i> <?= htmlspecialchars($_SESSION['username']); ?> 
                    <small class="text-while">(<?= $_SESSION['role']; ?>)</small>
                </span>
                <a href="index.php?page=logout" class="btn btn-outline-danger btn-sm">Logout</a>
            <?php endif; ?>
        </div>
    </div>
</nav>