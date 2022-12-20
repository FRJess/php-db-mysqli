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
            <form action="" method="post">
​
                <div class="mb-3">
                    <label class="form-label">Facoltà</label>
                    <select class="form-select" name="degree_id">
                        <option value="">Seleziona un'opzione</option>
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