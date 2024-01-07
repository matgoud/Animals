<!DOCTYPE html>
    <html lang="en">
    <head>
        <title> <?php echo $this->title ?> </title>
        <link rel="stylesheet" href="src/skin/view.css" type="text/css">
        <script src="src/view/View.js"></script>
    </head>
    <body>
        <h1> <?php echo $this->title ?> </h1>
        <?php echo $this->getMenu();
              echo "<div class='feedback'>".$this->feedback."</div>"; ?>
        <?php echo $this->content; ?>
        <script>
            "use strict"
            init();
        </script>
    </body>
    </html>