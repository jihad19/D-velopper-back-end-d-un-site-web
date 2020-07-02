<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>The Perfect Cup - Contact</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/business-casual.css" rel="stylesheet">

    <!-- Fonts -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->


</head>

<body>
<div>
<?php

$errors = [];
$message = "";
if(isset($_POST['signupSubmit'])){
    require ('includes/db.inc.php');
    $user = mysqli_escape_string($conn,$_POST['username']);
    $email = mysqli_escape_string($conn,$_POST['email']);
    $password = mysqli_escape_string($conn,$_POST['password']);
    $copassword = mysqli_escape_string($conn,($_POST['copassword']));
    if (empty($user) || empty($email) || empty($password) || empty($copassword)) {
        $errors= "veuillez remplir le champ vide";
    }else {
            //Check if input characters are valid
            if (!preg_match("/^[a-zA-Z0-9]*$/", $user)){
                $errors= "input characters are invalid";
            }else {
                    //Check if email is valid
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                        $errors= "email is invalid";
                    }else{
                        if ($password !== $copassword) {
                            $errors= "password check";                        
                        }else {
                            $sql = "SELECT * FROM users WHERE uidUsers='$user'";
                            $result = mysqli_query($conn, $sql);
                            $resultCheck = mysqli_num_rows($result);
                            if ($resultCheck > 0) {
                                $errors= "User taken";
                            }else {
                                //Hashing the password
                                $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
                                //Insert the user into the database
                                $sql = "INSERT INTO users (uidUsers, emailUsers, pwdUsers) VALUES ('$user', '$email', '$hashedPwd');";
                                if(mysqli_query($conn, $sql)){
                                    $message = "<div class= 'alert alert-success'>
                                            compte crée avec succeés
                                            </div>";
                                }else {
                                    $message = "<div class= 'alert alert-danger'>
                                                Une erreur '.mysqli_error($conn).'
                                                </div>";
                                }
                               
                            }
                        }
                    }
            }
        }
    }
    
?>
</div>
    <div class="brand">The Perfect Cup</div>
    <div class="address-bar">3481 Melrose Place | Beverly Hills, CA 90210 | 123.456.7890</div>

    <!-- Navigation -->
    <nav class="navbar navbar-default" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- navbar-brand is hidden on larger screens, but visible when the menu is collapsed -->
                <a class="navbar-brand" href="index.html">The Perfect Cup</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        <a href="about.php">About</a>
                    </li>
                    <li>
                        <a href="blog.php">Blog</a>
                    </li>
                    <li>
                        <a href="contact.php">Contact</a>
                    </li>
                    <li>
                        <a href="signup.php">SIGN UP</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <div class="container">
        <div class="row">
            <div class="box">
                <div class="col-lg-12">
                    <hr>
                    <h2 class="intro-text text-center">REGISTRATION 
                        <strong>FORM</strong>
                    </h2>
                    <hr>
                    <div id="add_err2"></div>
                    <?php
                    if(!empty($errors)){
                        echo "<div class= 'alert alert-danger'>
                        $errors
                        </div>";
                    }else {
                       echo $message;
                    }
                    ?>
                    <form role="form" action="#" method="post">
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label>User Name</label>
                                <input type="text" id="fname" name="username" maxlength="20" class="form-control" placeholder="Username">
                                    
                            </div>
                            <div class="form-group col-lg-4">
                                <label>Email Address</label>
                                <input type="email" id="email" name="email" maxlength="50" class="form-control" placeholder="E-mail...">
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group col-lg-4">
                                <label>Password</label>
                                <input type="password" id="email" name="password"  maxlength="10" class="form-control" placeholder="password">
                            </div>
                            <div class="form-group col-lg-4">
                                <label>Confirm password</label>
                                <input type="password" id="email" name="copassword"  maxlength="10" class="form-control" placeholder="Confirm password">
                            </div>
                            <div class="form-group col-lg-12">
                                <button type="submit" id="contact" name="signupSubmit" class="btn btn-default">Signup</button>
                            </div>
                            <div class="form-group col-lg-12">
                                <a href = "login.php" id="contact" class="btn btn-default">Already have an account? <strong>LOGIN</strong></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container -->

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p>Copyright &copy; The Perfect Cup 2019</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>