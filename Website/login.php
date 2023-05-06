<?php
session_start(); // Inicie a sessão

if (isset($_POST['logar'])) {
    include_once('config.php');
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM usuarios WHERE email='$email'";
    $result = mysqli_query($conexao, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $hashedPassword = $row['password'];
        
        // Verifique se a senha corresponde à senha criptografada no banco de dados
        if (password_verify($password, $hashedPassword)) {
            // As credenciais estão corretas, redirecione para outro site
            $_SESSION['email'] = $email; // Armazene o email na sessão para uso posterior, se necessário
            header('Location: https://www.youtube.com'); // Substitua o URL pelo site desejado
            exit();
        } else {
            // As credenciais estão incorretas, exiba uma mensagem de erro
            echo "Credenciais inválidas. Por favor, tente novamente.";
        }
    } else {
        // Usuário não encontrado, exiba uma mensagem de erro
        echo "Usuário não encontrado. Por favor, verifique suas credenciais.";
    }
}
?>
