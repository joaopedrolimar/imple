

<div class="container">
    <h2>Login</h2>
    <form action="processar_login.php" method="POST">
        <div class="form-group">
            <label for="username">Nome de usuário:</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Senha:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>

