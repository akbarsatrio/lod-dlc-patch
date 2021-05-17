<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lodger Installer</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
</head>
<body>
  <div class="mt-5 container">
    <div class="col-lg-4 col-md-6 mx-auto">
      <h1 class="mb-3"><strong>Lodger<br>Installer Patch v1.0</strong></h1>
      <form action="proccess.php" method="POST">
        <div class="form-group mb-3">
          <label>Database Hostname:</label>
          <input type="text" name="hostname" class="form-control">
        </div>
        <div class="form-group mb-3">
          <label>Nama Database:</label>
          <input type="text" name="db-name" class="form-control">
        </div>
        <div class="form-group mb-3">
          <label>Username Database:</label>
          <input type="text" name="db-username" class="form-control">
        </div>
        <div class="form-group mb-3">
          <label>Password Database:</label>
          <input type="text" name="db-password" class="form-control">
        </div>
        <div class="form-group mb-3">
          <label>Lodger Web PATH:</label>
          <input type="text" name="web-path" class="form-control mb-1">
          <small>Contoh untuk cPanel: <strong>/home/<span class="text-danger text-decoration-underline">username</span>/public_html</strong><br>Linux Webserver: <strong>/var/www/html/<span class="text-danger text-decoration-underline">nama_proyek</span></strong></small>
        </div>
        <button type="submit" name="submit" class="btn btn-primary w-100">Lanjut</button>
      </form>
    </div>  
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>
</html>
