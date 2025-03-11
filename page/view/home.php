<?php
// Esegui la query per ottenere campionati e squadre
$query = "
    SELECT 
        c.id AS campionato_id, 
        c.nome AS campionato_nome,
        c.logo AS campionato_logo,
        s.id AS squadra_id,
        s.nome AS squadra_nome,
        s.logo AS squadra_logo
    FROM 
        campionati c
    JOIN 
        competizioni cp ON JSON_UNQUOTE(JSON_EXTRACT(cp.params, '$.tipo')) = 'Campionato' 
                      AND JSON_UNQUOTE(JSON_EXTRACT(cp.params, '$.stato')) = 'Italia'
    JOIN 
        squadre s ON s.campionato_id = c.id;
";

// Supponiamo che $db sia l'oggetto della connessione al database
$result = $db->getQueryResult($query);

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