<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Painel de Administração Escolar</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Administração Escolar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="#">Página Inicial</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Alunos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Professores</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            Configurações
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="#">Perfil</a>
            <a class="dropdown-item" href="#">Usuários</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Sair</a>
          </div>
        </li>
      </ul>
    </div>
  </nav>

  <div class="container mt-5">
    <h1>Ficha de Notas</h1>
    <div class="row mt-4">
      <div class="col-lg-6">
        <h3>João</h3>
        <div class="table-responsive">
          <table class="table">
            <!-- Cabeçalho da tabela -->
            <thead>
              <tr>
                <th scope="col">Disciplina</th>
                <th scope="col">Nota</th>
              </tr>
            </thead>
            <tbody>
              <!-- Linhas da tabela -->
              <tr>
                <td>
                  <strong>Educação Moral e Cívica</strong>
                  <span class="d-sm-none">Nota:</span>
                </td>
                <td>9.5</td>
              </tr>
              <tr>
                <td>
                  <strong>Física</strong>
                  <span class="d-sm-none">Nota:</span>
                </td>
                <td>8.0</td>
              </tr>
              <tr>
                <td>
                  <strong>Química</strong>
                  <span class="d-sm-none">Nota:</span>
                </td>
                <td>7.5</td>
              </tr>
            </tbody>
          </table>
        </div>
        
      </div>
      <div class="col-lg-6">
        <h3>Maria</h3>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Disciplina</th>
              <th scope="col">P1</th>
              <th scope="col">P2</th>
              <th scope="col">MAC</th>
              <th scope="col">MÉDIA</th>
          
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Educação Moral e Cívica</td>
              <td>8.0</td>
              <td>8.0</td>
              <td>8.0</td>
              <td>8.0</td>
            </tr>
            <tr>
              <td>Física</td>
              <td>9.0</td>
            </tr>
            <tr>
              <td>Química</td>
              <td>7.0</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
