<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <style type="text/css">
        #loading {
             position: absolute;
             top: 40%;
             left: 45%;
             z-index: 2;
        }
        #loading SPAN {
             background: url('/images/icons/loading.gif') no-repeat left center;
             padding: 5px 30px;
             display: block;
        }
</style>

  </head>
  <body>
    <?php echo $sf_content ?>
  </body>
</html>
