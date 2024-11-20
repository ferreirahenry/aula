<?php
// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Obter dados do formulário
    $cpf = isset($_POST['cpf']) ? $_POST['cpf'] : '';
    $lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
    $firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $nascimento = isset($_POST['nascimento']) ? $_POST['nascimento'] : '';
    $sexo = isset($_POST['sexo']) ? $_POST['sexo'] : '';

    // Conectar ao banco de dados (substitua os valores abaixo pelas suas configurações reais)
    $conn = new mysqli('localhost', null, null, 'persons');

    // Verificar se houve erro na conexão
    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    // Preparar e vincular a consulta
    $stmt = $conn->prepare("INSERT INTO Persons (CPF, LastName, FirstName, Address, Phone, Nascimento, Sexo) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $cpf, $lastName, $firstName, $address, $phone, $nascimento, $sexo);

    // Executar a consulta
    if ($stmt->execute()) {
        $msg = "Novo registro criado com sucesso!";
        $msgClass = "alert-success";
    } else {
        $msg = "Erro ao registrar: " . $stmt->error;
        $msgClass = "alert-danger";
    }

    // Fechar a declaração e a conexão
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Pessoa</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }
        body {
            background-color: #f4f4f9;
            font-family: Arial, sans-serif;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            margin: 0px;
            padding: 0px;
            min-height: 300px;
        }

        .header-container {
            background-color: #343a40;
            padding: 20px;
            margin: 0px;
            padding: 0px;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%
            height: 150px;
            text-align: center;
           
        }

        .form-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            max-width: 600px;
            width: 100%;
            margin-top: 20px;
        }
        .text {
            border: 3px solid black;
            padding: 1.5rem;
            margin : 10px
        }
        h1 {
            margin-bottom: 30px;
        }
        .form-group {
            justify-content: center;
            align-items: center;
        }
        
    </style>
</head>
<body>

    <!-- Header com o Formulário de Cadastro -->
    <div class="header-container">
        <h1 class="text">Locadora aula PHP</h1>
        <h1 class="text-white">Cadastro de Cliente :</h1>
        <p>Preencha as informações abaixo para cadastrar um novo cliente.</p>

        <!-- Formulário de Cadastro -->
        <div class="form-container">
            <?php if (isset($msg)): ?>
                <div class="alert <?php echo $msgClass; ?> alert-dismissible fade show" role="alert">
                    <?php echo $msg; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <form action="index.php" method="POST">
                <div class="form-group">
                    <label for="cpf">CPF</label>
                    <input type="text" class="form-control" id="cpf" name="cpf" required placeholder="Insira o CPF :">
                </div>
                <div class="form-group">
                    <label for="firstName">Nome</label>
                    <input type="text" class="form-control" id="firstName" name="firstName" required placeholder="Primeiro nome :">
                </div>
                <div class="form-group">
                    <label for="lastName">Sobrenome</label>
                    <input type="text" class="form-control" id="lastName" name="lastName" required placeholder="Sobrenome :">
                </div>
                <div class="form-group">
                    <label for="address">CEP</label>
                    <input type="text" class="form-control" id="address" name="address" required placeholder="Insira o CEP :">
                </div>
                <div class="form-group">
                    <label for="phone">Telefone</label>
                    <input type="text" class="form-control" id="phone" name="phone" required placeholder="Telefone de contato">
                </div>
                <div class="form-group">
                    <label for="nascimento">Data de Nascimento</label>
                    <input type="date" class="form-control" id="nascimento" name="nascimento" required>
                </div>
                <div class="form-group">
                    <label for="sexo">Sexo</label>
                    <select class="form-control" id="sexo" name="sexo" required>
                        <option value="M">Masculino</option>
                        <option value="F">Feminino</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Cadastrar</button>
            </form>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
