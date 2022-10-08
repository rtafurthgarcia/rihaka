<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $pageTitle?>
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="/css/asciinema-player.css" />
    <link rel="stylesheet" type="text/css" href="/css/style.css" />
    <script src="/js/app.js"></script>
</head>

<body class="d-flex flex-column min-vh-100">
    <?=$this->fetch('./Base/Header.php', [
        "hideLogin" => (isset($hideLogin)) ? true : false,
        "hideSignup" => (isset($hideSignup)) ? true : false,
    ])?>
    <main>
        <?= $content?>
    </main>
    <?=$this->fetch('./Base/Footer.php', [])?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>

</html>