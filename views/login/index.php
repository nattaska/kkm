<!-- <h1>Login</h1>

<form action="login/login" method="post">
    <label>Login</label><input type="text" name="usercode"/><br/>
    <label>Password</label><input type="password" name="password"/><br/>
    <label></label><input type="submit" />
</form> -->

<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Krua Kroo Meuk ERP</title>
    <meta name="description" content="Krua Kroo Meuk ERP">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="<?php echo URL.'views/login/default.css' ?>">
</head>


<div class="body"></div>
	<div class="grad"></div>
		<div class="header">
			<div>Krua Kroo Meuk<br><span>Restuarant</span></div>
		</div>
		<br>
		<div class="login">
            <form action="login/login" method="post">
				<input type="text" placeholder="username" name="usercode"><br>
				<input type="password" placeholder="password" name="password"><br>
                <input type="submit" value="Login">
            </form>
		</div>
	</div>
</div>