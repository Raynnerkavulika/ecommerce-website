<?php 
include('config.php');

session_start();

if(isset($POST['submit'])){
    $name = $_POST['name'];
    $name = filter_var($name,FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
    $password = filter_var($password,FILTER_SANITIZE_STRING);

    $select_admin = $conn->prepare("SELECT * FROM admin WHERE name=? AND password=?");
    $select_admin->execute([$name,$password]);
    $fetch_admin_id = $select_admin->fetch(PDO::FETCH_ASSOC);

    if($select_admin->rowCount()>0){

        $_SESSION['admin_id'] = $fetch_admin_id['id'];
        header('location:dashboard.php');
    }else{
        $message = "Incorrect username or password";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php  
    if(isset($message)){
         foreach($message as $message){
            echo'
            <div class="message">
                <span>'.$message.'</span>
            </div>
            ';
         }
    }
    ?>
<section class="form-container">
    <form action="" method="post">
        <input type="text" placeholder="Enter your name" required class="box">
        <input type="password" placeholder="Enter your password" required class="box">
        <input type="submit" value="login now" required class="btn">
    </form>
</section>
</body>
</html>