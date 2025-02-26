<?php
// responder_pergunts.php
session_start();
include_once "../conexao.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Responder Perguntas de Segurança</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            padding: 20px;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
            background-color: #fff;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
        }
        h2 {
            margin-bottom: 30px;
            text-align: center;
            color: #007bff;
        }
        form {
            margin-top: 20px;
        }
        label {
            font-weight: bold;
        }
        input[type=text] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ced4da;
            border-radius: 5px;
        }
        button[type=submit] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        button[type=submit]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Responder Perguntas de Segurança</h2>
        <form action="verificar_respostas.php" method="post">
            <div class="form-group">
                <label for="answer1"><?php echo isset($_SESSION['question1']) ? $_SESSION['question1'] : ''; ?></label><br>
                <input type="text" id="answer1" name="answer1" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="answer2"><?php echo isset($_SESSION['question2']) ? $_SESSION['question2'] : ''; ?></label><br>
                <input type="text" id="answer2" name="answer2" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Verificar Respostas</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


