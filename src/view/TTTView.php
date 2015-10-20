<html>
<head>

    <title>Tic Tac Toe</title>

    <link rel="stylesheet" type="text/css" href="assets/css/style.css" />

</head>

<body>

    <div id="content">

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

            <h2>Let's Play Tic Tac Toe!</h2>

            <?php $session->get('game')->playGame($request);   ?>

        </form>

    </div>

</body>

</html>