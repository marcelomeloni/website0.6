<?php
session_start();
if (isset($_POST['submit'])) {
    include_once('config.php');
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $termsCheckbox = isset($_POST['terms_checkbox']);

    if (!$termsCheckbox) {
        $message[] = 'You need to agree to the terms and conditions to register.';
    } else {
        $select = mysqli_query($conexao, "SELECT * FROM `usuarios` WHERE email = '$email'") or die('query failed');

        if (mysqli_num_rows($select) > 0) {
            $message[] = 'User already exists!';
        } else {
            mysqli_query($conexao, "INSERT INTO `usuarios`(username, email, password) VALUES('$username', '$email', '$password')") or die('query failed');
            $message[] = 'Registered successfully!';
        }
    }
}

if (isset($_POST['logar'])) {
    include_once('config.php');
    
    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $password = mysqli_real_escape_string($conexao, $_POST['password']);

    $select = mysqli_query($conexao, "SELECT * FROM `usuarios` WHERE email = '$email'") or die('query failed');

    if (mysqli_num_rows($select) > 0) {
        $row = mysqli_fetch_assoc($select);
        if ($password === $row['password']) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['email'] = $row['email']; // Adiciona o email do usuário na variável de sessão
            header('location: home.php');
            exit;
        } else {
            $message[] = 'Incorrect password!';
        }
    } else {
        $message[] = 'Incorrect email!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>
<body>
<?php
if(isset($message)){
   foreach($message as $message){
      echo '<div class="message" onclick="this.remove();">'.$message.'</div>';
   }
}
?>
    <header>
        <h2 class="logo">Zozo</h2>
        <nav class="navigation">
            <a href="#">Home</a>
            <a href="about.html">About</a>
            <a href="#">Services</a>
            <a href="#">Contact</a>
            <button class="Btnlogin-popup">Login</button>
        </nav>
    </header>
    <div class="wrapper">
        <span class="icon-close">
            <i class="fa-solid fa-xmark"></i>
        </span>
        <div class="form-box login">
            <h2>Login</h2>
            <form action="index.php" method="post" autocomplete="off">
                <div class="input-box">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" required name="email" role="presentation">
                    <label>Email</label>
                </div>
                <div class="input-box">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" required name="password" >
                    <label>Password</label>
                </div>
                <div class="remember-forgot">
                    <label><input type="checkbox">Remember me</label>
                    <a href="#">Forgot Password?</a>
                </div>
                <button type="submit" class="btn" name="logar">Login</button>
                <div class="login-register">
                    <p>Don't have an account? <a href="#" class="register-link">Register</a></p>
                </div>
            </form>
        </div> 
        <div class="form-box register">
            <h2>Registration</h2>
            <form action="index.php" method="POST" autocomplete="off">
                <div class="input-box">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" required name="username" role="presentation">
                    <label>Username</label>
                </div>
                <div class="input-box">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" required name="email" role="presentation">
                    <label>Email</label>
                </div>
                <div class="input-box">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" required name="password" >
                    <label>Password</label>
                </div>
                <div class="remember-forgot">
                    <label><input type="checkbox" name="terms_checkbox" value="1">I agree to the terms & conditions</label>
                </div>
                <button type="submit" class="btn" name="submit">Register</button>
                <div class="login-register">
                    <p>Already have an account? <a href="#" class="login-link">Login</a></p>
                </div>
            </form>
        </div> 
    </div>
    <script src="script.js"></script>
</body>
</html>