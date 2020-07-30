<div class="container-sm">
    
<div class="row"><h1>Consultar Pontos Próximos</h1></div>
<div class="row">
  <form method="POST" action="/buscas/pontos">
    <div class="form-group">
      <label for="inputCep">CEP</label>
      <input type="text" class="form-control" name="cep" id="inputCep" aria-describedby="cepHelp" placeholder="Digite o CEP">
      <small id="cepHelp" class="form-text text-muted">Formato: 00000-000 ou 00000000</small>
    </div>
    <button type="submit" class="btn btn-primary">Enviar</button>
  </form>
</div>
