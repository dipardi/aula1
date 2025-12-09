<?php
session_start();

// Se já estiver logado como admin, redireciona
if (isset($_SESSION["admin"]) && $_SESSION["admin"] === true) {
    header("Location: admin/dashboard.php");
    exit;
}

// Processa login admin (simples, sem banco - você pode adaptar depois)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = $_POST["usuario"] ?? "";
    $senha = $_POST["senha"] ?? "";
    
    // CREDENCIAIS FIXAS (você pode mudar depois para banco)
    if ($usuario === "admin" && $senha === "admin123") {
        $_SESSION["admin"] = true;
        $_SESSION["admin_nome"] = "Administrador";
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
    <title>Admin Login - VagasJob</title>
    <link rel="stylesheet" href="assets/style_new.css">
    <style>
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            background: linear-gradient(135deg, #7c3aed 0%, #5b21b6 100%);
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
        
        .auth-header .admin-badge {
            display: inline-block;
            padding: 6px 16px;
            background: linear-gradient(135deg, #7c3aed, #5b21b6);
            color: white;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 12px;
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
            border-color: var(--admin);
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
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
        
        .credentials-hint {
            background: var(--gray-50);
            border-left: 4px solid var(--admin);
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.85rem;
            color: var(--gray-700);
        }
        
        .credentials-hint strong {
            display: block;
            margin-bottom: 4px;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div>
            <div class="auth-card">
                <div class="auth-header">
                    <div class="admin-badge">👑 ÁREA ADMINISTRATIVA</div>
                    <h1>🔐 Login Admin</h1>
                    <p>Acesso restrito aos administradores</p>
                </div>

                <?php if (isset($erro) && $erro): ?>
                    <div class="alert alert-error">❌ Usuário ou senha incorretos.</div>
                <?php endif; ?>

                <!-- DICA DE CREDENCIAIS (remover em produção) -->
                <div class="credentials-hint">
                    <strong>💡 Credenciais de teste:</strong>
                    Usuário: <code>admin</code><br>
                    Senha: <code>admin123</code>
                </div>

                <form method="post">
                    <div class="form-group">
                        <label for="usuario">Usuário</label>
                        <input type="text" id="usuario" name="usuario" required placeholder="Digite seu usuário" autofocus>
                    </div>

                    <div class="form-group">
                        <label for="senha">Senha</label>
                        <input type="password" id="senha" name="senha" required placeholder="Digite sua senha">
                    </div>

                    <button type="submit" class="btn btn-admin btn-full">
                        🔓 Acessar Painel Admin
                    </button>
                </form>

                <div class="auth-footer">
                    <p style="color: var(--gray-600); font-size: 0.9rem;">
                        Não é administrador? <a href="login.php">Área de usuários →</a>
                    </p>
                </div>
            </div>
            
            <div class="back-home">
                <a href="index.php">← Voltar para a página inicial</a>
            </div>
        </div>
    </div>
</body>
</html>