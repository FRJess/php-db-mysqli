<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'env.php';
require_once 'functions.php';

$conn = conn();

$sql = "SELECT * FROM `degrees`";

$result = makeQuery($sql, $conn);

//controlliamo se esiste la variabile ID nel GET
if(isset($_GET['id'])){
  //se esiste la creiamo
  $id = $_GET['id'];
  $sql = "SELECT * FROM `students` WHERE `id` = ?";
  $selectStmt = $conn->prepare($sql);
  $selectStmt->bind_param('i', $id);
  $selectStmt->execute();
  $res = $selectStmt->get_result();
  $user = $res->fetch_object();
}

if (isset($_POST['delete']) && isset($id)) {
  $sql = "DELETE FROM `students` WHERE id = ?";
  $deletStmt = $conn->prepare($sql);
  $deletStmt->bind_param('i', $id);
  $deletStmt->execute();
  header('Location: index.php');
}

if (isset($_POST['submit'])){
  $degree_id = strip_tags($_POST['degree_id']);
  $name = strip_tags($_POST['name']);
  $surname = strip_tags($_POST['surname']);
  $fiscal_code = strip_tags($_POST['fiscal_code']);
  $registration_number = strip_tags($_POST['registration_number']);
  $email = strip_tags($_POST['email']);
  $date_of_birth = '2002-06-26';
  $enrolment_date = '2022-01-01';

  $errors = [];
  if (strlen($name) < 3){
    $errors['name'] = 'Il valore deve avere almeno 3 caratteri';
  }
  if (strlen($fiscal_code) != 16){
    $errors['fiscal_code'] = 'Il valore deve avere 16 caratteri';
  }

  //se esiste $id, vuol dire che esiste anche la variabile $_GET['id']
  if (!count($errors)){
    if(isset($id)){
      //se esiste facciamo update
      $sql = "UPDATE `students` SET degree_id = ?, name = ?, surname = ?, fiscal_code = ?, registration_number = ?, email = ?, date_of_birth = ?, enrolment_date = ? WHERE id =?";
      $insertStmt = $conn->prepare($sql);
      $insertStmt->bind_param('isssssssi', $degree_id, $name, $surname, $fiscal_code, $registration_number, $email, $date_of_birth, $enrolment_date, $id);
      $insertStmt->execute();
      
    } else {
      //altrimenti facciamo insert
      $sql = "INSERT INTO students(degree_id, name, surname, fiscal_code, registration_number, email, date_of_birth, enrolment_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
      $insertStmt = $conn->prepare($sql);
      $insertStmt->bind_param('isssssss', $degree_id, $name, $surname, $fiscal_code, $registration_number, $email, $date_of_birth, $enrolment_date);
      $insertStmt->execute();
  
    }
    
    header('location: index.php');
  }

} 

closeConn($conn);

?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bootstrap demo</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
    <div class="container my-5">
        <h1>Form <?php echo isset($_GET['id']) ? 'modifica' : 'creazione'; ?></h1>

        <form method="post">

            <div class="mb-3">
                <label class="form-label">Facoltà</label>
                <select class="form-select" name="degree_id">
                    <option selected></option>
                    <?php while ($row = $result->fetch_object()) : ?>
                        <option value="<?php echo $row->id ?>" <?php if (isset($user) && $user->degree_id ==  $row->id) echo "selected" ?>><?php echo $row->name ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Nome</label>
                <input type="text" name="name" class="form-control <?php if (isset($errors['name'])) echo 'border-danger'; ?>" value="<?php echo $_POST['name'] ?? ($user->name ?? '') ?>">
                <span class="form-text text-danger"><?php echo $errors['name'] ?? ''; ?></span>
            </div>

            <div class="mb-3">
                <label class="form-label">Cognome</label>
                <input type="text" name="surname" class="form-control" value="<?php echo $user->surname ?? '' ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Codice fiscale</label>
                <input type="text" name="fiscal_code" class="form-control <?php if (isset($errors['fiscal_code'])) echo 'border-danger'; ?>" value="<?php echo  $_POST['fiscal_code'] ?? ($user->fiscal_code ?? '') ?>">
                <span class="form-text text-danger"><?php echo $errors['fiscal_code'] ?? '' ?></span>
            </div>

            <div class="mb-3">
                <label class="form-label">Matricola</label>
                <input type="text" name="registration_number" class="form-control" value="<?php echo $user->registration_number ?? '' ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="text" name="email" class="form-control" value="<?php echo $user->email ?? '' ?>">
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            <?php if (isset($_GET['id'])) { ?>
                <button type="submit" name="delete" class="btn btn-danger">Elimina</button>
            <?php } ?>
        </form>
    </div>
        
    </body>
</html>