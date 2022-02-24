<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--        <link rel="stylesheet" href="../statics/bootstrap-5.1.3-dist/css/bootstrap.css">-->
    <link rel="stylesheet" href="../statics/css/ssm.css">
</head>
<body>
<div class="row header-pane">
    <?php include_once ("../includes/pre-auth-header.php")?>
</div>
<div class="col-12">
    <div class="col-12">
        <div class="col-3"></div>
        <div class="col-6 form-pane">
            <form name="login-form" method="post" action="../backend/authentication/update-user-password.php" class="auth-form">
                <h4>LOGIN</h4>
                <input type="password" name="username" placeholder="Enter New Password" class="form-input form-element">
                <input type="password" name="user-password" placeholder="Confirm Password" class="form-input form-element">
                <input type="submit" name="submit" value="LOGIN" class="form-input auth-btn"><span id="forget-password-link"><a href="password-change-request.php">Forget Password</a></span>
            </form>
        </div>
        <div class="col-3"></div>
    </div>
    <!--            <div class="col-12 footer">footer</div>-->
</div>

</body>
</html>