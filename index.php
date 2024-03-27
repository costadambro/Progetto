<?php 
require 'connessione.php';
?>
<!DOCTYPE html>
<head>
    <link rel="stylesheet" href="css/styles.css">
    <title>Accesso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <form method="POST">
        <section class="vh-100 gradient-custom">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                        <div class="card bg-dark text-white" style="border-radius: 1rem;">
                            <div class="card-body p-5 text-center">
                                <div class="mb-md-5 mt-md-4 pb-5">
                                    <h2 class="fw-bold mb-2 text-uppercase rnbw">Login</h2>
                                    <div class="form-outline form-white mb-4">
                                        <input type="email" id="email" name="email" class="form-control form-control-lg" style="text-align:center" placeholder="Email"/>
                                    </div>
                                    <div class="form-outline form-white mb-4">
                                        <input type="password" id="password" name="pass"  class="form-control form-control-lg" style="text-align:center" placeholder="Password"/>
                                    </div>
                                    <button class="fw-bold mb-2 text-uppercase qqq btn btn-outline-light btn-lg px-5" type="submit" name="accesso">
                                        Log in
                                    </button>
                                    <button class="fw-bold mb-2 text-uppercase qqq btn btn-outline-light btn-lg px-5" type="submit" name="registrazione">
                                        Sign in
                                    </button>
                                </div>
                                <?php
                                    if (isset($_POST['accesso'])) {
                                        accesso();
                                    }
                                    if (isset($_POST['registrazione'])) {
                                        header('Location: registrazione.php');
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form> 
</body>
<?php
    function accesso()
    {
        session_start();
        global $conn;
        $email = $_SESSION['email'] = $_POST['email'];
        $pass = $_POST['pass'];
        $pass=hash("sha256",$pass);
        $sql = "SELECT email, nome FROM accesso WHERE email='$email' and pass='$pass'";
        $result = $conn->query($sql);
        while ($obj = $result->fetch_object()) {
            $_SESSION['nome'] = (string) $obj->nome;
        }
        if ($result->num_rows > 0) {
            header('Location: playlist.php');
        } else {
            echo "<p style='error'> *l'email o la password non sono corretti </p>";
        }
    }
?>