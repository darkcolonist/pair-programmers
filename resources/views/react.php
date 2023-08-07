<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="/vite.svg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo env("APP_NAME") ?></title>
  </head>
  <body>
    <div id="root"></div>
    <?php // echo htmlentities(\App\Helpers\Vite::html('resources/js/main.jsx')); ?>
    <?php echo \App\Helpers\Vite::assets('resources/js/main.jsx'); ?>
  </body>
</html>
