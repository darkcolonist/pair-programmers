<!doctype html>
<html lang="en">
<head>
  <?php echo \App\Helpers\Vite::assets('resources/js/main.jsx'); ?>
  <meta charset="UTF-8" />
  <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo env("APP_NAME") ?></title>
  <script>
    <?php
      if(isset($expose) && is_array($expose)){
        foreach ($expose as $key => $value) {
          $value = json_encode($value);
          echo "const {$key} = {$value};";
        }
      }
    ?>
  </script>
</head>

<body>
  <div id="root"></div>
</body>

</html>
