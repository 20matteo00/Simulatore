<nav class="navbar navbar-expand-md navbar-dark bg-dark" aria-label="Fourth navbar example">
    <div class="container">
        <a class="navbar-brand fs-2 fw-bold me-5" href="?page=home"><?php echo $NOMESITO ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar"
            aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="?page=comp"><?php echo $COMPETIZIONI ?></a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto me-2 mb-2 mb-md-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="?page=regis"><?php echo $REGISTRATI ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="?page=login"><?php echo $ACCEDI ?></a>
                </li>
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