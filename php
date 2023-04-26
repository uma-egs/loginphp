php___________________________________________________________________________________________________



<?php
session_start();
if(isset($_SESSION["user"])){
    header("Location: submit.php");
}
?>
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
    // $hashpassword = password_hash($password, PASSWORD_DEFAULT);

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
    require_once("config.php");
    $sql = "select * from students where Email='$email'";
   $result= mysqli_query($conn,$sql);
   $rowcount = mysqli_num_rows($result);
   if($rowcount>0){
    array_push($myarray,"provided email is already exists");
   }
    if(count($myarray)>0){
        foreach($myarray as $error){
            echo "<div class='alert alert-danger'>$error</div>"; 
        }
    }
    else{
require_once("config.php");

$sql = "insert into students(Name,Email,Password) values(?,?,?)";
$stmt=mysqli_stmt_init($conn);
$preparedStmt = mysqli_stmt_prepare($stmt,$sql);
if($preparedStmt){
    mysqli_stmt_bind_param($stmt,"sss",$name,$email,$password);
    mysqli_stmt_execute($stmt);
    echo "<div class='alert alert-success'>register successfully</div>";
}else{
    die("something went wrong");
}


    }
}

        ?>
            <form action="register.php" method="post">
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
            <div><p>already registered<a href="login.php">click here</a>to login</p></div>
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



login.hp___________________________________________________


<?php
session_start();
if(isset($_SESSION["user"])){
    header("Location: submit.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>
<body>
    <div class="container">
<?php
if(isset($_POST["submit"])){
    $email = $_POST["email"];
    $password = $_POST["password"];
   require_once("config.php");
   $sql = "select * from students where Email='$email'";
   $result = mysqli_query($conn,$sql);
   $user=mysqli_fetch_array($result,MYSQLI_ASSOC);
   if($user){
    print_r($user);
    // if($password==$user["password"]){
        session_start();
        $_SESSION["user"]="yes";
    // //  header("Location: submit.php");
    //  die();
    // }else{

    //     echo "<div class='alert alert-success'>Password does not match</div>";
    // }
   }else{
    echo "<div class='alert alert-success'>emil doent exists</div>";
   }
}

?>
<form action="login.php" method="post">
               
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="enter your email">
                </div>
                
                <div class="form-group">
                    <input type="password" name="rpassword" class="form-control" placeholder="repeat password">
                </div>
                <div class="form-btn">
                    <input type="submit" name="submit" class="btn btn-primary" value=" login">
                </div>
            </form>
            <div><p>not registered yet <a href="register.php">click here</a>to register</p></div>
            </div>
    
</body>
</html>



submit.php_______________________________________________________



<?php
session_start();
if(!isset($_SESSION["user"])){
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>submit</title>
</head>
<body>
    <div class="container">
        <h1>Submitted scucccessfully</h1>
        <a href="logout.php" class="btn btn-warning">log out</a>
    </div>
    
</body>
</html>


logout.php_____________________________________________________________


<?php
session_start();
session_destroy();
header("location: login.php");



?>
