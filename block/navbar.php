<nav class="navbar navbar-expand-md navbar-dark bg-dark" aria-label="Fourth navbar example">
    <div class="container">
        <a class="navbar-brand fs-2 fw-bold me-5" href="?group=home&page=home"><?php echo NOMESITO ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar"
            aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                <?php if (isset($_SESSION['username'])) { ?>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="?group=comp&page=competizioni"><?php echo COMPETIZIONI ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="?group=comp&page=campionati"><?php echo CAMPIONATI ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="?group=comp&page=squadre"><?php echo SQUADRE ?></a>
                    </li>
                <?php } ?>
            </ul>
            <ul class="navbar-nav ms-auto me-2 mb-2 mb-md-0">
                <?php if (isset($_SESSION['username'])) { ?>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="?group=login&page=profile"><?php echo BENVENUTO . " " . $_SESSION['username']; ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="?group=login&page=logout"><?php echo ESCI ?></a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="?group=login&page=registrazione"><?php echo REGISTRATI ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="?group=login&page=login"><?php echo ACCEDI ?></a>
                    </li>
                <?php } ?>
            </ul>
            <form method="POST" action="">
                <select name="lingua" onchange="this.form.submit()">
                    <option value="ita" <?php echo ($lang == 'ita') ? 'selected' : ''; ?>>IT</option>
                    <option value="eng" <?php echo ($lang == 'eng') ? 'selected' : ''; ?>>EN</option>
                </select>
            </form>
        </div>
    </div>
</nav>