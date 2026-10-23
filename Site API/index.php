<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Encontre endereços de todo o Brasil com uma consulta de CEP.">
  <title>Localiza — Consulta de CEP</title>
  <link rel="stylesheet" href="assets/style.css">
  <script src="assets/app.js" defer></script>
</head>
<body>
  <header class="topbar"><a class="brand" href="./"><span class="brand-icon" aria-hidden="true">◎</span> localiza<span class="brand-dot">.</span></a><span class="header-tag">ENDEREÇOS DO BRASIL</span></header>
  <main>
    <section class="intro">
      <span class="eyebrow"><span></span> UM CEP, UM NOVO DESTINO</span>
      <h1>Todo endereço<br>começa <em>aqui.</em></h1>
      <p>Da sua rua ao outro lado do Brasil.<br>Encontre o endereço que você procura em segundos.</p>
      <div class="coverage"><span aria-hidden="true">↗</span><div><strong>De norte a sul.</strong><br><span>Uma consulta para todo o Brasil.</span></div></div>
      <div class="decoration" aria-hidden="true"><span class="route"></span><span class="pin">●</span><span class="map-label">SEU PRÓXIMO DESTINO</span></div>
    </section>
    <section class="search-card" aria-labelledby="search-title">
      <div class="card-heading"><span class="step">01 / CONSULTA</span><span class="live"><span></span> ViaCEP</span></div>
      <h2 id="search-title">Qual endereço você procura?</h2>
      <p class="muted">Digite o CEP e deixe o resto com a gente.</p>
      <form id="cep-form" action="api/cep.php" method="get">
        <label for="cep">CEP</label>
        <div class="search-row"><input id="cep" name="cep" type="text" inputmode="numeric" autocomplete="postal-code" placeholder="00000-000" maxlength="9" pattern="[0-9]{5}-?[0-9]{3}" required aria-describedby="cep-hint"><button id="submit" type="submit">Consultar <span aria-hidden="true">↗</span></button></div>
        <p id="cep-hint" class="hint">Informe os 8 números do CEP, com ou sem hífen.</p>
      </form>
      <div class="examples">Experimente <button type="button" data-cep="01001000">São Paulo ↗</button><button type="button" data-cep="20040002">Rio de Janeiro ↗</button></div>
      <div id="feedback" role="status" aria-live="polite"></div>
      <div id="empty-state" class="empty-state"><span class="empty-icon" aria-hidden="true">⌖</span><h3>Seu destino aparece aqui</h3><p>Faça uma consulta para descobrir o endereço completo.</p></div>
      <section id="result" hidden aria-labelledby="result-title">
        <div class="result-header"><span class="step">02 / ENDEREÇO ENCONTRADO</span><span class="success-mark" aria-hidden="true">✓</span></div>
        <h3 id="result-title"></h3><span id="result-location"></span>
        <dl class="result-grid"><div><dt>CEP</dt><dd data-field="cep"></dd></div><div><dt>Estado</dt><dd data-field="uf"></dd></div><div class="wide"><dt>Logradouro</dt><dd data-field="logradouro"></dd></div><div><dt>Bairro</dt><dd data-field="bairro"></dd></div><div><dt>Cidade</dt><dd data-field="localidade"></dd></div><div class="wide"><dt>Complemento</dt><dd data-field="complemento"></dd></div></dl>
        <p class="result-source">Dados fornecidos pelo ViaCEP · consulta em tempo real</p>
      </section>
      <noscript><p>Ative o JavaScript para visualizar o endereço nesta página. O formulário também permite consultar o JSON retornado pelo PHP.</p></noscript>
    </section>
  </main>
  <footer><span>Localiza © 2026</span><span>Feito para encurtar distâncias.</span><a href="https://viacep.com.br/" target="_blank" rel="noopener noreferrer">Dados por ViaCEP ↗</a></footer>
</body>
</html>
