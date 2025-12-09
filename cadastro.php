<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - IFsul Vagas</title>
    <link rel="stylesheet" href="assets/style_ifsul.css">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 40px 20px;
        }
        
        .auth-wrapper {
            width: 100%;
            max-width: 550px;
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
            animation: bounce 2s ease-in-out infinite;
        }
        
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
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
        
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid var(--cinza-medio);
            border-radius: 12px;
            font-size: 1rem;
            transition: var(--transicao);
            background: var(--cinza-claro);
        }
        
        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--ifsul-verde);
            background: white;
            box-shadow: 0 0 0 4px rgba(46, 204, 113, 0.1);
        }
        
        .form-group small {
            display: block;
            margin-top: 6px;
            color: var(--cinza);
            font-size: 0.85rem;
        }
        
        .form-group .icon {
            font-size: 1.2rem;
            margin-right: 4px;
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
            color: var(--ifsul-verde-escuro);
            text-decoration: none;
            font-weight: 700;
            transition: var(--transicao);
        }
        
        .auth-footer a:hover {
            color: var(--ifsul-verde);
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
        
        .required-note {
            background: rgba(46, 204, 113, 0.1);
            border-left: 4px solid var(--ifsul-verde);
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-size: 0.9rem;
            color: var(--cinza-escuro);
        }
    </style>
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="auth-header">
                <div class="auth-logo">🎯</div>
                <h1>Criar Nova Conta</h1>
                <p class="institution">IFsul Vagas</p>
                <p>Junte-se à comunidade de talentos</p>
            </div>

            <div class="required-note">
                ℹ️ <strong>Campos obrigatórios</strong> estão marcados com asterisco (*)
            </div>

            <form method="post" action="usuario/inserirOK.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nome">
                        <span class="icon">👤</span> Nome completo *
                    </label>
                    <input type="text" id="nome" name="nome" required placeholder="Digite seu nome completo">
                </div>

                <div class="form-group">
                    <label for="email">
                        <span class="icon">📧</span> E-mail *
                    </label>
                    <input type="email" id="email" name="email" required placeholder="seu.email@exemplo.com">
                    <small>Use um e-mail válido para recuperação de conta</small>
                </div>

                <div class="form-group">
                    <label for="senha">
                        <span class="icon">🔒</span> Senha *
                    </label>
                    <input type="password" id="senha" name="senha" required placeholder="Mínimo 6 caracteres" minlength="6">
                    <small>Crie uma senha forte com pelo menos 6 caracteres</small>
                </div>

                <div class="form-group">
                    <label for="imagem">
                        <span class="icon">📷</span> Foto de perfil (opcional)
                    </label>
                    <input type="file" id="imagem" name="imagem" accept="image/*">
                    <small>Formatos: JPG, PNG, GIF (máx. 2MB)</small>
                </div>

                <div class="form-group">
                    <label for="linkedin">
                        <span class="icon">💼</span> LinkedIn (opcional)
                    </label>
                    <input type="url" id="linkedin" name="linkedin" placeholder="https://www.linkedin.com/in/seu-perfil">
                    <small>Cole o link completo do seu perfil profissional</small>
                </div>

                <button type="submit" class="btn btn-success btn-full">
                    ✅ Criar minha conta agora
                </button>
            </form>

            <div class="auth-footer">
                <p>Já possui uma conta no IFsul Vagas?</p>
                <a href="login.php">🔐 Fazer login</a>
            </div>
        </div>
        
        <div class="back-home">
            <a href="index.php">← Voltar para página inicial</a>
        </div>
    </div>
</body>
</html>