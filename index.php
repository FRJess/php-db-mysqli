<?php

require_once 'env.php';
require_once 'functions.php';

$base_url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];

$conn = conn();

$limit = 5;
//se è presente il GET lo valorizzo, altrimenti è 0
//l'offset serve a definire le pagine
$offset = $_GET['offset'] ?? 0;

$sql_global = "SELECT `students`.`name`,`students`.`surname`,`students`.`registration_number`,`students`.`id`, ROUND(AVG(`exam_student`.`vote`),1) AS `media_voti`
FROM `students`
JOIN `exam_student`ON `students`.`id` = `exam_student`.`student_id`
WHERE `exam_student`.`vote` >= 18
GROUP BY `students`.`id`
ORDER BY `students`.`surname`, `students`.`name`";
$result_global = makeQuery($sql_global, $conn);

$totale_studenti = $result_global->num_rows;

$sql = "SELECT `students`.`name`,`students`.`surname`,`students`.`registration_number`,`students`.`id`, ROUND(AVG(`exam_student`.`vote`),1) AS `media_voti`
FROM `students`
LEFT JOIN `exam_student`ON `students`.`id` = `exam_student`.`student_id`
WHERE `exam_student`.`vote` >= 18
GROUP BY `students`.`id`
ORDER BY `students`.`surname`, `students`.`name`
LIMIT $limit OFFSET $offset";


$result = makeQuery($sql, $conn);

closeConn($conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- BOOTSTRAP -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
  integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
  crossorigin="anonymous"></script>
  <title>DB University</title>
</head>

<body>

  <div class="container my-5">
    <h1 class="mb-3">Lista studenti</h1>

    <table class="table table-striped">

      <thead>
        <tr>
          <th scope="col">#id</th>
          <th scope="col">Nome</th>
          <th scope="col">Cognome</th>
          <th scope="col">Matricola</th>
          <th scope="col">Media voti</th>
          <th scope="col">AZIONI</th>
        </tr>
      </thead>

      <tbody>

        <?php while($row = $result->fetch_object()): ?>
          <tr>
            <td><?php echo $row->id ?></td>
            <td><?php echo $row->name ?></td>
            <td><?php echo $row->surname ?></td>
            <td><?php echo $row->registration_number ?></td>
            <td><?php echo $row->media_voti ?></td>
            <td><a href="form.php?id=<?php echo $row->id ?>">EDIT</a></td>
          </tr>
        <?php endwhile; ?>

      </tbody>
    </table>

  </div>

  <div class="container mb-5">

    <?php if($offset > 0): ?>
      <!-- bottone per tornare all'inizio -->
      <a href="<?php baseUrl()?>?offset=0" class="btn btn-success">|<</a>
      <!-- bottone per tornare indietro di una pagina -->
      <a href="<?php baseUrl()?>?offset=<?php echo $offset - $limit ?>" class="btn btn-success"><< indietro</a>
    <?php endif; ?>

    <?php if($offset + $limit < $totale_studenti): ?>
      <!-- da perfezionare --> 
      <a href="<?php baseUrl() ?>?offset=<?php echo $offset + $limit ?>" class="btn btn-success">avanti >></a>
      <a href="<?php baseUrl() ?>?offset=<?php echo $totale_studenti - $limit ?>" class="btn btn-success">>|</a>
    <?php endif; ?>

    <!-- bottone per andare avanti di una pagina -->
    <a href="<?php baseUrl()?>?offset=<?php echo $offset + $limit ?>" class="btn btn-success">avanti >></a>
    
  </div>
  
</body>
</html>