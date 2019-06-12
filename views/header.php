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

    <link rel="apple-touch-icon" href="https://i.imgur.com/QRAUqs9.png">
    <link rel="shortcut icon" href="https://i.imgur.com/QRAUqs9.png">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="<?php echo URL ?>assets/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="<?php echo URL ?>assets/css/style.css">
    <link rel="stylesheet" href="<?php echo URL ?>public/css/style.css">

    <?php 
        if (isset($this->css)) {
            foreach ($this->css as $css) {
                echo '<link rel="stylesheet" href="'.$css.'">
    ';
            }
        }
    ?>
</head>

<body>
<!-- Left Panel -->
    <input id="auth" name="auth" type="hidden" value="<?php echo $auth; ?>" >
    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">
            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <!-- <li class="active"><a href="index.php"><i class="menu-icon fa fa-laptop"></i>Dashboard </a></li> -->
                    <?php
                    // print_r($userMenu["menus"]);
                    $startLV3 = false;

                    foreach ($userMenu["menus"] as $menu) {
                        // echo $menu["url"].'</br>';
                        if ($menu["level"] == 1) {

                            if ($startLV3) {
                                echo '</ul></li>
                                ';
                                $startLV3 = false;
                            }

                            echo '<li class="menu-title">'.$menu["name"].'</li>'
                            ;
                        } else if (($menu["level"] == 2) && isset($menu["url"])) {
                            echo '<li><a href="'.URL.$menu["url"].'"> <i class="menu-icon fa '.$menu["icon"].'"></i>'.$menu["name"].' </a></li>
                            ';
                        } else if (($menu["level"] == 2) && !isset($menu["url"]) ) {
                            
                                echo '<li class="menu-item-has-children dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa '.$menu["icon"].'"></i>'.$menu["name"].'</a>
                                        <ul class="sub-menu children dropdown-menu">
                                        ';
                                        
                                $startLV3 = true;
                                
                        } else {
                            if ( isset($menu["icon"]))
                            echo '<li><i class="menu-icon fa '.$menu["icon"].'"></i><a href="'.URL.$menu["url"].'">'.$menu["name"].'</a></li>
                            ';
                        }
                    }
                    if ($startLV3) {
                        echo '</ul></li>
                        ';
                        $startLV3 = false;
                    }
                    ?>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside>
    <!-- /#left-panel -->
    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">
        <!-- Header-->
        <header id="header" class="header">
            <div class="top-left">
                <div class="navbar-header">
                    <a class="navbar-brand" href="./"><img src="images/logo.png" alt="Logo"></a>
                    <a class="navbar-brand hidden" href="./"><img src="images/logo2.png" alt="Logo"></a>
                    <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
                </div>
            </div>
            <div class="top-right">
                <div class="header-menu">
                    <div class="header-left">
                        <!-- <div class="nav-link"> -->
                        <div class="user-area dropdown float-right">

                            <?php echo $userMenu['code'].'['.$userMenu['nickname']."]&nbsp;|&nbsp;&nbsp;".$userMenu['role_name']; ?> &nbsp;&nbsp; 
                            
                            <a href="<?php echo URL ?>login/logout"><button type="button" class="btn btn-danger btn-sm"><i class="ti-power-off"></i>&nbsp;Log Out </button></a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- /#header -->
    <!-- </div> -->
    <!-- /#right-panel -->