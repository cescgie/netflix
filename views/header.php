<!doctype html>
<html>
<head>
   <meta charset="utf-8">
   <title><?= $data['title'] . ' - ' . SITETITLE ?></title>
   <link rel="stylesheet" href="<?= URL::STYLES('bootstrap.min') ?>">
   <link rel="stylesheet" href="<?= URL::STYLES('style') ?>">
   <?php $now = date("U"); ?>
   <script type=\"text/javascript\">
      window.onload =
        function() {
          // Current server time
          var d1 = new Date($now);
          // Next hour
          var d2 = new Date($now);
          d2.setUTCHours(d1.getUTCHours() + 1, 0, 0, 0);
          // Update in d milliseconds
          var d = d2 - d1;
          d = d.getTime();
          // Force reload in d milliseconds
          window.setTimeout(function(){location.reload(true);}, d);
        };
    </script>
</head>
<body>

   <div class="container">