<?php 
require 'connessione.php';
?>
<!DOCTYPE html>
<head>
    <title>Registrazione</title>
    <link rel="stylesheet" href="css/styles.css">
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
                                    <h2 class="fw-bold mb-2 text-uppercase rnbw">Registrazione</h2>
                                    <div class="form-outline form-white mb-4">
                                        <input type="nome" id="nome" name="nome" class="form-control form-control-lg"  style="text-align:center" placeholder="Nome"/>
                                    </div>
                                    <div class="form-outline form-white mb-4">
                                        <input type="cognome" id="cognome" name="cognome" class="form-control form-control-lg"  style="text-align:center" placeholder="Cognome"/>
                                    </div>
                                    <div class="form-outline form-white mb-4">
                                        <input type="email" id="email" name="email" class="form-control form-control-lg"  style="text-align:center" placeholder="Email"/>
                                    </div>
                                    <div class="form-outline form-white mb-4">
                                        <input type="password" id="password" name="pass" class="form-control form-control-lg"  style="text-align:center" placeholder="Password" />
                                    </div>
                                    <button class="fw-bold mb-2 text-uppercase qqq btn btn-outline-light btn-lg px-5 custom-hover" type="submit" value="Registrati" name="registrati">
                                        Sign in
                                    </button>
                                    <button class="fw-bold mb-2 text-uppercase qqq btn btn-outline-light btn-lg px-5" type="submit" value="Log in" name="accedi">
                                        Log in
                                    </button>
                                </div>
                                <?php
                                    if (isset($_POST['registrati'])) {
                                        registrati();
                                    }
                                    if (isset($_POST['accedi'])) {
                                        header('Location: index.php');
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
function registrati(){
    global $conn;
    $cognome = $_POST['cognome'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $pass=hash("sha256",$pass);
    $bool=true;
    if ($cognome != "" && $nome != "" && $email != "" && $pass != "") {
        //$sql = "INSERT INTO accesso (email, nome, cognome, pass) VALUES ('$email', '$nome', '$cognome', sha2('$pass',256))";
        $sql = "SELECT * FROM accesso";
        $result = $conn->query($sql);
        while ($obj = $result->fetch_object()) {
            if($obj->email==$email){
                $bool = false;
            }
        }
        if($bool){
            $sql = "INSERT INTO accesso (email, nome, cognome, pass) 
            VALUES ('$email', '$nome', '$cognome', '$pass')";
            if ($conn->query($sql) == TRUE) {
                header('Location: index.php');
            }
        }else{
            echo "<p>Email gia in uso, sceglierne un altra o accedere</p>";
        }
    } else {
        echo "<p>Inserisci tutti i dati</p>";
    }
}
?>