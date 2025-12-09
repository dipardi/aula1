<?php
session_start();

// Se já estiver logado como admin, redireciona
if (isset($_SESSION["admin"]) && $_SESSION["admin"] === true) {
    header("Location: admin/dashboard.php");
    exit;
}

// Processa login admin
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = $_POST["usuario"] ?? "";
    $senha = $_POST["senha"] ?? "";
    
    // CREDENCIAIS FIXAS (você pode mudar depois para banco)
    if ($usuario === "admin" && $senha === "admin123") {
        $_SESSION["admin"] = true;
        $_SESSION["admin_nome"] = "Administrador IFsul";
        header("Location: admin/dashboard.php");
        exit;
    } else {
        $erro = true;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - IFsul Vagas</title>
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
            box-shadow: 0 20px 60px rgba(46, 204, 113, 0.4);
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
            animation: rotate 4s ease-in-out infinite;
        }
        
        @keyframes rotate {
            0%, 100% { transform: rotate(0deg); }
            50% { transform: rotate(10deg); }
        }
        
        .admin-badge {
            display: inline-block;
            padding: 10px 24px;
            background: var(--ifsul-verde);
            color: white;
            border-radius: 25px;
            font-size: 0.9rem;
            font-weight: 700;
            margin-bottom: 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: var(--sombra);
        }
        
        .auth-header h1 {
            font-size: 2rem;
            color: var(--ifsul-verde-escuro);
            margin-bottom: 8px;
            font-weight: 700;
        }
        
        .auth-header p {
            color: var(--cinza);
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
            font-size: 0.9rem;
        }
        
        .auth-footer a {
            color: var(--ifsul-verde-escuro);
            text-decoration: none;
            font-weight: 600;
        }
        
        .auth-footer a:hover {
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
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
            transition: var(--transicao);
            display: inline-block;
        }
        
        .back-home a:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-2px);
        }
        
        .credentials-hint {
            background: rgba(46, 204, 113, 0.1);
            border-left: 4px solid var(--ifsul-verde);
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 0.9rem;
        }
        
        .credentials-hint strong {
            display: block;
            margin-bottom: 8px;
            color: var(--ifsul-verde-escuro);
            font-size: 0.95rem;
        }
        
        .credentials-hint code {
            background: rgba(46, 204, 113, 0.15);
            padding: 2px 8px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            color: var(--ifsul-verde-escuro);
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="auth-header">
                <div class="auth-logo">⚙️</div>
                <div class="admin-badge">🔐 Área Administrativa</div>
                <h1>Painel do Administrador</h1>
                <p>IFsul Vagas - Acesso Restrito</p>
            </div>

            <?php if (isset($erro) && $erro): ?>
                <div class="alert alert-error">❌ Credenciais inválidas. Tente novamente.</div>
            <?php endif; ?>

            <!-- DICA DE CREDENCIAIS (remover em produção) -->
            <div class="credentials-hint">
                <strong>💡 Credenciais de Teste:</strong>
                Usuário: <code>admin</code><br>
                Senha: <code>admin123</code>
            </div>

            <form method="post">
                <div class="form-group">
                    <label for="usuario">👤 Usuário Administrativo</label>
                    <input type="text" id="usuario" name="usuario" required placeholder="Digite seu usuário" autofocus>
                </div>

                <div class="form-group">
                    <label for="senha">🔒 Senha de Acesso</label>
                    <input type="password" id="senha" name="senha" required placeholder="Digite sua senha">
                </div>

                <button type="submit" class="btn btn-admin btn-full">
                    🔓 Acessar Painel Administrativo
                </button>
            </form>

            <div class="auth-footer">
                <p>Não é administrador? <a href="login.php">Área de usuários →</a></p>
            </div>
        </div>
        
        <div class="back-home">
            <a href="index.php">← Voltar para página inicial</a>
        </div>
    </div>
</body>
</html>