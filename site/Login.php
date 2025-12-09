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
    <title>Login - IFsul Vagas</title>
    <link rel="stylesheet" href="assets/style_ifsul.css">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }
        
        .auth-wrapper {
            width: 100%;
            max-width: 480px;
        }
        
        .auth-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(46, 204, 113, 0.3);
            padding: 48px;
            border-top: 6px solid var(--ifsul-verde);
        }
        
        .auth-header {
            text-align: center;
            margin-bottom: 36px;
        }
        
        .auth-logo {
            font-size: 4rem;
            margin-bottom: 16px;
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        .auth-header h1 {
            font-size: 2rem;
            color: var(--ifsul-verde-escuro);
            margin-bottom: 8px;
            font-weight: 700;
        }
        
        .auth-header .institution {
            color: var(--ifsul-verde);
            font-weight: 600;
            font-size: 1.1rem;
        }
        
        .auth-header p {
            color: var(--cinza);
            margin-top: 8px;
        }
        
        .form-group {
            margin-bottom: 24px;
        }
        
        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--ifsul-verde-escuro);
            font-size: 0.95rem;
        }
        
        .form-group input {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid var(--cinza-medio);
            border-radius: 12px;
            font-size: 1rem;
            transition: var(--transicao);
            background: var(--cinza-claro);
        }
        
        .form-group input:focus {
            outline: none;
            border-color: var(--ifsul-verde);
            background: white;
            box-shadow: 0 0 0 4px rgba(46, 204, 113, 0.1);
        }
        
        .auth-footer {
            text-align: center;
            margin-top: 28px;
            padding-top: 28px;
            border-top: 2px solid var(--cinza-medio);
        }
        
        .auth-footer p {
            color: var(--cinza);
            margin-bottom: 12px;
        }
        
        .auth-footer a {
            color: var(--ifsul-verde);
            text-decoration: none;
            font-weight: 700;
            transition: var(--transicao);
        }
        
        .auth-footer a:hover {
            color: var(--ifsul-verde-escuro);
            text-decoration: underline;
        }
        
        .back-home {
            text-align: center;
            margin-top: 24px;
        }
        
        .back-home a {
            color: white;
            text-decoration: none;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 25px;
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            transition: var(--transicao);
            display: inline-block;
        }
        
        .back-home a:hover {
            background: rgba(255,255,255,0.25);
            transform: translateY(-2px);
        }
        
        .divider {
            display: flex;
            align-items: center;
            margin: 24px 0;
            color: var(--cinza);
            font-size: 0.9rem;
        }
        
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--cinza-medio);
        }
        
        .divider span {
            padding: 0 16px;
        }
    </style>
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="auth-header">
                <div class="auth-logo">🎓</div>
                <h1>Bem-vindo de volta!</h1>
                <p class="institution">IFsul Vagas</p>
                <p>Entre para acessar as oportunidades</p>
            </div>

            <?php
            // Mensagens de erro
            if (isset($_GET["erro"])) {
                if ($_GET["erro"] == 0) {
                    echo '<div class="alert alert-error">❌ E-mail não cadastrado no sistema.</div>';
                } elseif ($_GET["erro"] == 1) {
                    echo '<div class="alert alert-error">❌ Senha incorreta. Tente novamente.</div>';
                } elseif ($_GET["erro"] == 2) {
                    echo '<div class="alert alert-warning">⚠️ Você precisa estar logado para acessar essa página.</div>';
                }
            }
            
            // Mensagem de sucesso no cadastro
            if (isset($_GET["msg"]) && $_GET["msg"] === "cadastrado") {
                echo '<div class="alert alert-success">✅ Cadastro realizado com sucesso! Faça login para continuar.</div>';
            }
            ?>

            <form action="site/loginOK.php" method="post">
                <div class="form-group">
                    <label for="email">📧 E-mail</label>
                    <input type="email" id="email" name="email" required placeholder="seu.email@exemplo.com" autofocus>
                </div>

                <div class="form-group">
                    <label for="senha">🔒 Senha</label>
                    <input type="password" id="senha" name="senha" required placeholder="Digite sua senha">
                </div>

                <button type="submit" class="btn btn-primary btn-full">
                    🔓 Entrar no sistema
                </button>
            </form>

            <div class="divider">
                <span>ou</span>
            </div>

            <div class="auth-footer">
                <p>Ainda não tem cadastro?</p>
                <a href="cadastro.php">✨ Criar conta gratuitamente</a>
            </div>
        </div>
        
        <div class="back-home">
            <a href="index.php">← Voltar para página inicial</a>
        </div>
    </div>
</body>
</html>