<?php 
require 'connessione.php';
?>
<!DOCTYPE html>
<head>
<title>Playlist</title>
</head>
<style>
table, th, td {
  border:1px solid black;
}
</style>
<body>
  <form method="post">
    <?php
    session_start();
    echo '<h1>Gestione playlist musicale di '.$_SESSION["nome"].'</h1>';
    ?>
    <h4>inserisci i dati di una canzone</h4>
    <p>
    Titolo: <input name="titolo" id="titolo" type="text"/> <a id="asterisco1"></a> <p>
    Artista: <input name="artista" id="artista" type="text"/> <a id="asterisco2"></a> <p>
    Genere: <select name="genere" id="genere">
      <option hidden value=''></option>
      <option id="pop">pop</option>
      <option id="hip pop">hip pop</option>
      <option id="rap">rap</option>
      <option id="altro">altro</option>
      </select><a id="asterisco3"></a> <p>
    Durata: <input name="durata" id="durata" type="number"/> (sec) <a id="asterisco4"></a>
    <p>
    <a id="sparisci"><button type="submit" name="aggiungi">Aggiungi</button></a>
    <a id="sparisci2"><button type="submit" name="cancella">Cancella</button></a>
    <a id="sparisci3"><button type="submit" name="modifica">Modifica</button></a>
    <a id="sparisci4"><button type="reset">Annulla</button></a>
    <a id="out"></a>

    <?php
      if (isset($_POST['aggiungi'])){
        aggiungi();
      }
      if (isset($_POST['cancella'])){
        cancella();
      }
      if (isset($_POST['modifica'])){
        modifica();
      }
      if (isset($_POST['conferma'])){
        conferma();
      }
      stamp();
    ?>
  </form>

<?php
  function aggiungi() {
    global $conn;
    if($_POST['titolo']!="" && $_POST['artista'] != "" && $_POST['genere'] != "" && $_POST['durata']!=0){
      $titolo = strtolower($_POST['titolo']);
      $artista = strtolower($_POST['artista']);
      $titolo = ucwords($titolo);
      $artista = ucwords($artista);
      $genere = $_POST['genere'];
      $durata = $_POST['durata'];
      $email =$_SESSION['email'];
      $bool=true;
      $sql = "SELECT * FROM canzone where email='$email'";
      $result = $conn->query($sql);
      while ($obj = $result->fetch_object()) {
        if($obj->titolo==$titolo && $obj->artista==$artista){
          $bool = false;
        }
      }
      if($bool){
        $sql = "INSERT INTO canzone (titolo, artista, genere, durata, email) 
        VALUES ( '$titolo', '$artista', '$genere', '$durata' , '$email')";
        if ($conn->query($sql)) {
          echo '<p>canzone aggiunta</p>';
        }
      }else{
        echo '<p>la canzone inserita esiste gia nella lista</p>';
      }
    }else{
      echo '"<p>Inserisci tutti i dati</p>"';
    }
  }
  function cancella() {
    global $conn;
    $titolo = $_POST['titolo'];
    $artista = $_POST['artista'];

    $sql = "DELETE FROM canzone WHERE titolo='$titolo' and artista='$artista'";
    $result = $conn->query($sql);
  }
  function stamp(){
    global $conn;
    $email =$_SESSION['email'];
    $sql = "SELECT * FROM canzone WHERE email='$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      
      echo '<table>
            <thead>
            <tr><th>Titolo</th><th>Artista</th><th>Genere</th><th>Durata</th></tr>
            <thead><tbody>';
      while ($obj = $result->fetch_object()) {
        
        echo "
        <tr>
          <td><a href='https://www.google.com/search?q=$obj->titolo+$obj->artista' target='_blank'> $obj->titolo</a></td>
          <td><a href='https://it.wikipedia.org/wiki/$obj->artista' target='_blank'> $obj->artista </a></td>
          <td>$obj->genere </td>
          <td>$obj->durata</td>
        </tr>";
      }
      echo '</tbody></table>';
    }
}
  function modifica() {
    if($_POST['titolo']!="" && $_POST['artista'] != ""){
      global $conn;
      $titolo = $_POST['titolo'];
      $artista = $_POST['artista'];
      $sql = "SELECT * FROM canzone WHERE titolo='$titolo' and artista='$artista'";
      $result = $conn->query($sql);
      while ($obj = $result->fetch_object()) {
        $genere= (string) $obj->genere;
        $durata= (int) $obj->durata;
      }
      if ($result->num_rows > 0) {
        echo "
        <script>
        document.getElementById('$genere').selected = true;
        document.getElementById('titolo').readOnly = true;
        document.getElementById('artista').readOnly = true;
        titolo.value=$titolo
        artista.value=$artista
        durata.value=$durata
        let sparisci = document.getElementById('sparisci')
        let sparisci2 = document.getElementById('sparisci2')
        let sparisci3 = document.getElementById('sparisci3')
        let sparisci4 = document.getElementById('sparisci4')
        let out = document.getElementById('out')
        sparisci.innerHTML=' '
        sparisci2.innerHTML=' '
        sparisci3.innerHTML=' '
        sparisci4.innerHTML=' '
        out.innerHTML=\"<button type='submit' name='conferma'>conferma</button><a> </a><button type='submit' name='annulla'>annulla</button>\"
        </script>";
      } else {
        echo "la canzone non esiste";
      }
    }else{
      echo "<p>Riempire i campi Titolo e Artita</p>";
    }
  }
  function conferma() {
    global $conn;
    if($_POST['titolo']!="" && $_POST['artista'] != "" && $_POST['genere'] != "" && $_POST['durata']!=0){
      $titolo = $_POST['titolo'];
      $artista = $_POST['artista'];
      $genere = $_POST['genere'];
      $durata = $_POST['durata'];
      $email =$_SESSION['email'];
      $sql = "UPDATE canzone SET genere='$genere', durata='$durata' WHERE artista='$artista' && titolo='$titolo' && email='$email'";
      if ($conn->query($sql)) {
        echo '<p>canzone modificata</p>';
      } else {
        echo "<p>aaaa modificata</p>";
      }
    }
  }
?>
</body>