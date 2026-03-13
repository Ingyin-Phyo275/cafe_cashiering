<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Admin Login</title>
    <style>
        body {
            background-image: url("cover.png");
            background-size: cover;
            background-repeat: no-repeat;
            backdrop-filter: contrast(1);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            text-align: center;
        }
        #page-title {
            text-shadow: 6px 4px 7px black;
            font-size: 3.5em;
            color: #fff4f4 !important;
            background: rgba(128, 128, 128, 0.1);
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px; /* Space between title and form */
        }
        .login-box {
            width: 100%;
            max-width: 360px;
            margin: 0 auto;
        }
        .card {
            border-radius: 10px;
        }
        .form-label {
            text-align: left;
        }
        .btnlogin{
            background-color: #563F36;
            color: white;
        }
        .btnlogin:hover{
            background-color: grey;
            color: white;
        }
    </style>
     <link rel="shortcut icon" href="images/logo.png" />
</head>
<body>
    <div class="container">
        <h1 id="page-title"><b>Cafe Cashiering System</b></h1>
        <div class="login-box">
            <div class="card card-navy my-2">
                <div class="card-body">
                    <p class="login-box-msg text-center">Please enter your credentials</p>
                    <form id="login-frm" action="#" method="post">
                        <div class="mb-3 text-start">
                            <label for="username" class="form-label">Username</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-person"></i>
                                </span>
                                <input type="text" id="username" class="form-control" name="username" autofocus placeholder="Username">
                            </div>
                        </div>
                        <div class="mb-3 text-start">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-lock"></i>
                                </span>
                                <input type="password" id="password" class="form-control" name="password" placeholder="Password">
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btnlogin" name="submit">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
        if(isset($_POST['submit'])){
            $username = $_POST['username'];
            $password = $_POST['password'];

            if($username == "admin" && $password =="1234"){
                ?>
                    <script>
                        Swal.fire({
                title: "Login Successful!",
                text: "Welcome back",
                icon: "success",
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to another page
                    window.location.href = "index.php"; // Replace with your target URL
                }
            });
    
                    </script>
                <?php
                
            }else{
                ?>
                <script>
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Username or Password is incorrect!! Please Try again.",
                        
                        });
                </script>
                <?php
            }
        }

    ?>
</body>
</html>
