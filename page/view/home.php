<?php
global $db;
if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$result = generaHome();
if ($result) {
    // Array per memorizzare i dati raggruppati per campionato
    $campionati = [];

    while ($row = $result->fetch_assoc()) {
        // Se il campionato non è già stato aggiunto all'array
        if (!isset($campionati[$row['campionato_id']])) {
            $campionati[$row['campionato_id']] = [
                'nome' => $row['campionato_nome'],
                'logo' => $row['campionato_logo'],
                'squadre' => []
            ];
        }

        // Aggiungi la squadra all'array del campionato
        $campionati[$row['campionato_id']]['squadre'][] = [
            'nome' => $row['squadra_nome'],
            'logo' => $row['squadra_logo']
        ];
    }
    ?>
    <div class="container mt-4 home">
        <div class="row g-4">
            <?php foreach ($campionati as $campionato): ?>
                <div class="col">
                    <div class="card h-100">
                        <!-- Card Header con Logo a sinistra e Titolo al centro -->
                        <div class="card-header">
                            <div class="row">
                                <div class="col-auto">
                                    <img src="<?= $campionato['logo']; ?>" class="col-1 card-img-top" alt="Logo del campionato">
                                </div>
                                <div class="col-auto d-flex align-items-center justify-content-center">
                                    <span class="h2 m-0 fw-bold"><?= $campionato['nome']; ?></span>
                                </div>
                            </div>
                        </div>
                        <!-- Corpo della Card -->
                        <div class="card-body">
                            <!-- Lista delle Squadre -->
                            <ul class="list-unstyled">
                                <?php foreach ($campionato['squadre'] as $squadra): ?>
                                    <li class="d-flex align-items-center my-1">
                                        <img src="<?= $squadra['logo']; ?>" alt="Logo della squadra" class="card-img-top me-2">
                                        <span class="h5 m-0 fw-bold"><?= $squadra['nome']; ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div> <!-- Fine della griglia -->
    </div> <!-- Fine del container -->
    <?php
}
?>