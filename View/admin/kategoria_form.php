<!DOCTYPE html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Library</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <link rel="icon" href="Sources/img/favicon.png">
  <link rel="stylesheet" href="Sources/css/responsive.css" />
  <link rel="stylesheet" href="Sources/css/admin.css" />
</head>

<body>

  <main class="col-6 form_panel">
    <header>
      <h1>Library</h1>
    </header>
    <form id="form-inside" action="/action_page" method="post" enctype="multipart/form-data">
      <label class="col-3" for="cim">Category:</label>
      <input class="col-6" type="text" name="cim" value="ide írd az új kategóriát" />
      <div class="col-12">
        <input type="submit" value="Save">
        <button type="button" onclick="location.href='?library/backend'">Close</button>
      </div>
    </form>
  </main>
</body>

</html>