<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Busca de Receitas</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <main class="app-container">
        <header class="header">
            <span class="badge">Chef Virtual</span>
            <h1>Receitas Culinárias</h1>
            <p>Descubra os melhores pratos e ingredientes para a sua refeição.</p>
        </header>

        <section class="search-section">
            <form action="index.php" method="GET" class="search-form">
                <div class="input-group">
                    <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <input 
                        type="text" 
                        name="busca" 
                        placeholder="Digite um ingrediente ou prato..." 
                        value="<?= htmlspecialchars($_GET['busca'] ?? '') ?>"
                        autocomplete="off"
                    >
                    <?php if (!empty($_GET['busca'])): ?>
                        <a href="index.php" class="clear-btn" title="Limpar busca">&times;</a>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn-primary">Pesquisar</button>
            </form>
        </section>

        <section class="results-section">
            <div class="results-header">
                <h2>Resultados</h2>
                <?php if (!empty($receitas)): ?>
                    <span class="counter"><?= count($receitas) ?> receita(s) encontrada(s)</span>
                <?php endif; ?>
            </div>

            <?php if (!empty($receitas)): ?>
                <div class="recipe-grid">
                    <?php foreach ($receitas as $receita): ?>
                        <article class="recipe-card">
                            <div class="card-body">
                                <span class="category-tag"><?= htmlspecialchars($receita['categoria']) ?></span>
                                <h3 class="recipe-title"><?= htmlspecialchars($receita['titulo']) ?></h3>
                            </div>
                            <div class="card-footer">
                                <span class="view-more">Ver detalhes &rarr;</span>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-icon">🍳</div>
                    <h3>Nenhuma receita encontrada</h3>
                    <p>Tente buscar por termos mais genéricos ou cheque a ortografia.</p>
                </div>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>