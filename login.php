<?php
session_start();

// Se já estiver logado, redireciona
if (isset($_SESSION["login"]) && $_SESSION["login"] === true) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - VagasJob</title>
    <link rel="stylesheet" href="assets/style_new.css">
    <style>
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .auth-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 450px;
            width: 100%;
            padding: 40px;
        }
        
        .auth-header {
            text-align: center;
            margin-bottom: 32px;
        }
        
        .auth-header h1 {
            font-size: 2rem;
            color: var(--gray-900);
            margin-bottom: 8px;
        }
        
        .auth-header p {
            color: var(--gray-600);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--gray-700);
        }
        
        .form-group input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid var(--gray-300);
            border-radius: 8px;
            font-size: 1rem;
            transition: var(--transition);
        }
        
        .form-group input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .btn-full {
            width: 100%;
            padding: 14px;
            font-size: 1.05rem;
            margin-top: 8px;
        }
        
        .auth-footer {
            text-align: center;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid var(--gray-200);
        }
        
        .auth-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }
        
        .auth-footer a:hover {
            text-decoration: underline;
        }
        
        .back-home {
            text-align: center;
            margin-top: 20px;
        }
        
        .back-home a {
            color: white;
            text-decoration: none;
            font-weight: 500;
        }
        
        .back-home a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div>
            <div class="auth-card">
                <div class="auth-header">
                    <h1>🔐 Entrar</h1>
                    <p>Acesse sua conta para se candidatar</p>
                </div>

                <?php
                // Mensagens de erro
                if (isset($_GET["erro"])) {
                    if ($_GET["erro"] == 0) {
                        echo '<div class="alert alert-error">❌ E-mail não cadastrado.</div>';
                    } elseif ($_GET["erro"] == 1) {
                        echo '<div class="alert alert-error">❌ Senha incorreta.</div>';
                    } elseif ($_GET["erro"] == 2) {
                        echo '<div class="alert alert-warning">⚠️ Você precisa estar logado para acessar essa página.</div>';
                    }
                }
                
                // Mensagem de sucesso no cadastro
                if (isset($_GET["msg"]) && $_GET["msg"] === "cadastrado") {
                    echo '<div class="alert alert-success">✅ Cadastro realizado! Faça login para continuar.</div>';
                }
                ?>

                <form action="site/loginOK.php" method="post">
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" id="email" name="email" required placeholder="seu@email.com" autofocus>
                    </div>

                    <div class="form-group">
                        <label for="senha">Senha</label>
                        <input type="password" id="senha" name="senha" required placeholder="Digite sua senha">
                    </div>

                    <button type="submit" class="btn btn-primary btn-full">
                        Entrar
                    </button>
                </form>

                <div class="auth-footer">
                    <p>Não tem uma conta? <a href="cadastro.php">Cadastre-se gratuitamente</a></p>
                </div>
            </div>
            
            <div class="back-home">
                <a href="index.php">← Voltar para a página inicial</a>
            </div>
        </div>
    </div>
</body>
</html>