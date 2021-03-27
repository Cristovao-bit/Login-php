<?php
    require_once 'db_connect.php';
    
    session_start();
    
    if(isset($_POST['login'])):
        $erros = array();
        $login = mysqli_escape_string($connect, $_POST['user']);
        $pass = mysqli_escape_string($connect, $_POST['pass']);
        
        if(empty($login) || empty($pass)):
            $erros[] = "<li> O campo usuário/senha precisa ser preenchido!";
        else:
            $sql = "SELECT login FROM usuarios WHERE login = '$login'";
            $resultado = mysqli_query($connect, $sql);
            
            if(mysqli_num_rows($resultado) > 0):
                $pass = md5($pass);
                $sql = "SELECT * FROM usuarios WHERE login = '$login' AND pass = '$pass'";
                $resultado = mysqli_query($connect, $sql);
                                  
                if(mysqli_num_rows($resultado) == 1):
                    $dados = mysqli_fetch_array($resultado);
                    mysqli_close($connect);
                    $_SESSION['logado'] = true;
                    $_SESSION['id_usuario'] = $dados['id'];
                    header('Location: home.php');
                else:
                    $erros[] = "<li> Usuário e senha não conferem! </li>";
                endif;
            else:
                $erros[] = "<li> Usuário inexistente! </li>";
            endif;
        endif;
    endif;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Tela de Login</title>
        <link rel="stylesheet" href="_css/style.css"/>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    </head>
    <body>
        <section class="login">
            <img src="_img/usuario.jpg" class="usuario" width="100" height="100" alt="" />
            <h3>Login</h3>
            <?php 
                if(!empty($erros)):
                    foreach ($erros as $erro):
                        echo $erro;
                    endforeach;
                endif;
            ?>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <p>Usuário</p>
                <input type="text" name="user" placeholder="Insira seu nome de usuário" />
                <p>Senha</p>
                <input type="password" name="pass" placeholder="Insira sua senha de usuário" />
                <input type="submit" name="login" value="login"/>
                <div class="btn-login">
                    <a href="">Esqueceu sua senha?</a>
                    <a href="">Ainda não possui uma conta?</a>
                </div>
            </form>
        </section>
    </body>
</html>
