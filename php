php___________________________________________________________________________________________________



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./style.css">
    <title>registration form</title>
</head>

<body>
    <div class="container">

        <?php
if(isset($_POST["submit"])){
    $name = $_POST["fullname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $rpassword = $_POST["rpassword"];
    $hashpassword = password_hash($password, PASSWORD_DEFAULT);

    $myarray =array();
    if(empty($name) or empty($email) or empty($password) ){
        array_push($myarray,"please fill all the field");
    }
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        array_push($myarray,"please enter valid email");
    }
    if(strlen($password)<8){
        array_push($myarray,"password length is too short");
    }
    if($password!=$rpassword){
        array_push($myarray,"repeat password does not match with original password");
    }
    if(count($myarray)>0){
        foreach($myarray as $error){
            echo "<div class='alert alert-danger'>$error</div>"; 
        }
    }
    else{
require_once("config.php");

$sql = "insert into students(Name,Email,Password) values('$name','$email','$hashpassword')";
$result = mysqli_query($conn,$sql);
echo $result;

    }
}

        ?>
            <form action="registration.php" method="post">
                <div class="form-group">
                    <input type="text" class="form-control" name="fullname" placeholder="enter your full name">
                </div>
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="enter your email">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="create password">
                </div>
                <div class="form-group">
                    <input type="password" name="rpassword" class="form-control" placeholder="repeat password">
                </div>
                <div class="form-btn">
                    <input type="submit" name="submit" class="btn btn-primary" value=" register">
                </div>
            </form>
    </div>
</body>

</html>



config.php________________________________________

<?php
$conn = mysqli_connect("localhost","root","","mydbb");
if(!$conn){
echo "connected";
}

?>
