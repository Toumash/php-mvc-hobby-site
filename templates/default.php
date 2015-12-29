<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <title><?php echo $this->get('title'); ?></title>

    <link href="style.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Ubuntu+Mono"/>
    <!--[if lt IE 9]>
    <script src="script/html5shiv.min.js"></script>
    <![endif]-->

    <script src="script/jquery-1.11.3.min.js"></script>
    <script src="script/jquery-ui.min.js"></script>
    <script src="script/main.js"></script>
</head>
<body>

<div class="container">
    <header>
        <h1>C# World!</h1>
    </header>
    <nav>
        <label for="show-menu" class="show-menu">Pokaż Menu</label>
        <input type="checkbox" id="show-menu" role="button"/>
        <?php View::load('menu')->index(); ?>
    </nav>
    <main id="main">
        <?php echo $this->get('content'); ?>
        <span id="copyright"><a href="mailto:tomasz.dluski@juniornet.onmicrosoft.com">&copy; Tomasz Dłuski</a></span>
    </main>

    <footer>

    </footer>
</div>

</body>
</html>
