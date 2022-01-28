<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--        <link rel="stylesheet" href="../statics/bootstrap-5.1.3-dist/css/bootstrap.css">-->
    <link rel="stylesheet" href="../../statics/css/ssm.css">
    <script type="text/javascript" src="../../statics/js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="../../statics/js/ssm-screen-resolution.js"></script>
</head>
<body>
<div class="row header-pane">
    <div class="logged-in-header">
        <div id="mobile-header">
            <?php include_once ("../../includes/mobile-header.php")?>
        </div>
        <div id="desktop-header">
            <?php include_once ("../../includes/desktop-header.php")?>
        </div>
    </div>
</div>
<div class="col-12">
    <div class="col-3 side-bar">side bar</div>
    <div class="col-9">
        <div class="main-content">Content</div>
        <div class="col-12 footer">footer</div>
    </div>

</div>

</body>
</html>