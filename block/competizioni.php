<?php
if (isset($_GET['id'])) {
    $idcomp = $_GET['id'];
} else {
    header("Location: index.php");
    exit();
}
?>
<form class="navcomp" action="" method="post">
    <div class="container text-center">
        <div class="row justify-content-center d-none d-lg-flex">
            <!-- Bottone home -->
            <div class="col mb-3">
                <button class="btn btn-success w-100" type="submit" name="blockcomp" value="home">
                    <i class="bi bi-house"></i> <?php echo HOME ?>
                </button>
            </div>
            <!-- Bottone Calendario -->
            <div class="col mb-3">
                <button class="btn btn-success w-100" type="submit" name="blockcomp" value="calendario">
                    <i class="bi bi-calendar"></i> <?php echo CALENDARIO ?>
                </button>
            </div>
            <!-- Bottone Classifica -->
            <div class="col mb-3">
                <button class="btn btn-success w-100" type="submit" name="blockcomp" value="classifica">
                    <i class="bi bi-trophy"></i> <?php echo CLASSIFICA ?>
                </button>
            </div>
            <!-- Bottone Tabellone -->
            <div class="col mb-3">
                <button class="btn btn-success w-100" type="submit" name="blockcomp" value="tabellone">
                    <i class="bi bi-table"></i> <?php echo TABELLONE ?>
                </button>
            </div>
            <!-- Bottone Statistiche -->
            <div class="col mb-3">
                <button class="btn btn-success w-100" type="submit" name="blockcomp" value="statistiche">
                    <i class="bi bi-bar-chart"></i> <?php echo STATISTICHE ?>
                </button>
            </div>
        </div>
        <div class="row justify-content-center d-flex d-lg-none">
            <!-- Bottone home -->
            <div class="col mb-3">
                <button class="btn btn-success w-100" type="submit" name="blockcomp" value="home">
                    <i class="bi bi-house"></i>
                </button>
            </div>
            <!-- Bottone Calendario -->
            <div class="col mb-3">
                <button class="btn btn-success w-100" type="submit" name="blockcomp" value="calendario">
                    <i class="bi bi-calendar"></i>
                </button>
            </div>
            <!-- Bottone Classifica -->
            <div class="col mb-3">
                <button class="btn btn-success w-100" type="submit" name="blockcomp" value="classifica">
                    <i class="bi bi-trophy"></i>
                </button>
            </div>
            <!-- Bottone Tabellone -->
            <div class="col mb-3">
                <button class="btn btn-success w-100" type="submit" name="blockcomp" value="tabellone">
                    <i class="bi bi-table"></i>
                </button>
            </div>
            <!-- Bottone Statistiche -->
            <div class="col mb-3">
                <button class="btn btn-success w-100" type="submit" name="blockcomp" value="statistiche">
                    <i class="bi bi-bar-chart"></i>
                </button>
            </div>
        </div>
    </div>
</form>