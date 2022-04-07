<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Könyvtár Program</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="icon" href="Sources/img/favicon.png">
    <link rel="stylesheet" href="Sources/css/responsive.css" />
    <link rel="stylesheet" href="Sources/css/admin.css" />
</head>

<body>
    <main class="col-6 form_panel">
        <header>
            <h1>Könyvtár Program</h1>
        </header>

        <?= $object->msg->getSessionMessage() ?>

        <form id="form-inside" method="post" enctype="multipart/form-data">


            <label class="col-3" for="loginname">Felhasználónév:</label>
            <input class="col-6" type="text" name="loginname" />

            <label class="col-3" for="password">Jelszó:</label>
            <input class="col-6" type="password" name="password" />

            <div class="col-12" id="form-buttons">
                <input type="submit" value="Belép" />
                <button type="button" onClick="location.href='?library/index'">Bezár</button>
            </div>
        </form>
    </main>

</body>

</html>