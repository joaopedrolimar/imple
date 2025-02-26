
<?php
//trocar_senha.php
session_start();
require_once('./conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        $response = array(
            'status' => 'error',
            'message' => 'Usuário não autenticado.'
        );
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }

    $usuario_id = $_SESSION['user_id'];
    $senhaAtual = $_POST['senhaAtual'];
    $novaSenha = $_POST['novaSenha'];
    $confirmarSenha = $_POST['confirmarSenha'];

    // Verificar se a nova senha e a confirmação coincidem
    if ($novaSenha !== $confirmarSenha) {
        $response = array(
            'status' => 'error',
            'message' => 'As senhas não coincidem. Por favor, tente novamente.'
        );
    } else {
        // Verificar a senha atual do usuário
        $query = "SELECT senha FROM policiais WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $usuario_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $senhaHash = $row['senha'];

            // Comparar a senha atual fornecida com a senha hash do banco de dados
            if (password_verify($senhaAtual, $senhaHash)) {
                // Hash da nova senha antes de salvar no banco de dados
                $novaSenhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);

                // Atualizar a senha do usuário no banco de dados
                $updateQuery = "UPDATE policiais SET senha = :novaSenha WHERE id = :id";
                $updateStmt = $conn->prepare($updateQuery);
                $updateStmt->bindParam(':novaSenha', $novaSenhaHash);
                $updateStmt->bindParam(':id', $usuario_id);

                if ($updateStmt->execute()) {
                    $response = array(
                        'status' => 'success',
                        'message' => 'Senha alterada com sucesso.'
                    );
                } else {
                    $response = array(
                        'status' => 'error',
                        'message' => 'Ocorreu um erro ao alterar a senha. Por favor, tente novamente.'
                    );
                }
            } else {
                $response = array(
                    'status' => 'error',
                    'message' => 'A senha atual inserida está incorreta. Por favor, verifique e tente novamente.'
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Usuário não encontrado.'
            );
        }
    }

    // Retornar apenas o JSON esperado
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
