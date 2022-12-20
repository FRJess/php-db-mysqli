<?php

require_once 'env.php';
require_once 'functions.php';

$conn = conn();

$sql = "SELECT * FROM `degrees`";

$result = makeQuery($sql, $conn);

if (isset($_POST['submit'])){
  $degree_id = strip_tags($_POST['degree_id']);
  $name = strip_tags($_POST['name']);
  $surname = strip_tags($_POST['surname']);
  $fiscal_code = strip_tags($_POST['fiscal_code']);
  $registration_number = strip_tags($_POST['registration_number']);
  $email = strip_tags($_POST['email']);
  $date_of_birth = '2002-06-26';
  $enrolment_date = '2022-01-01';
  
  $sql = "INSERT INTO students(degree_id, name, surname, fiscal_code, registration_number, email, date_of_birth, enrolment_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
  $insertStmt = $conn->prepare($sql);
  $insertStmt->bind_param('isssssss', $degree_id, $name, $surname, $fiscal_code, $registration_number, $email, $date_of_birth, $enrolment_date);
  $insertStmt->execute();
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
            <h1>Form</h1>
            <form method="post">
​
                <div class="mb-3">
                    <label class="form-label">Facoltà</label>
                    <select class="form-select" name="degree_id">
                      <option selected></option>
                      <?php while($row = $result->fetch_object()): ?>
                        <option value="<?php echo $row->id ?>"><?php echo $row->name ?></option>
                      <?php endwhile; ?>
                    </select>
                    
                </div>
​
                <div class="mb-3">
                    <label class="form-label">Nome</label>
                    <input type="text" name="name" class="form-control">
                </div>
​
                <div class="mb-3">
                    <label class="form-label">Cognome</label>
                    <input type="text" name="surname" class="form-control" >
                </div>
​
                <div class="mb-3">
                    <label class="form-label">Codice fiscale</label>
                    <input type="text" name="fiscal_code" class="form-control">
                </div>
​
                <div class="mb-3">
                    <label class="form-label">Matricola</label>
                    <input type="text" name="registration_number" class="form-control">
                </div>
​
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="text" name="email" class="form-control">
                </div>
​
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </body>
</html>