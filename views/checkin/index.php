
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Krua Kroo Meuk Check-In</title>
    <meta name="description" content="Krua Kroo Meuk Check-In">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="images/favicon.png">
    <link rel="shortcut icon" href="images/favicon.png"> 

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="views/checkin/style.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

</head>

<body>
<div class="content">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-8 offset-md-2 mr-auto ml-auto">                
                <header id="header" class="header">  
                    <div class="row">                    
                        <div class="col-lg-10 bg-info text-white">
                                <ul class="nav">
                                    <strong class="nav-link">Krua Kroo Meuk</strong>
                                </ul>
                        </div>                        
                        <div class="col-lg-2 bg-warning">
                                <ul class="nav justify-content-end">
                                    <li class="nav-item"><a class="nav-link nav-link-custom" href="login">Log-In</a></li>
                                </ul>
                        </div>
                    </div>
                </header>

                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">Working Time</strong>
                    </div>

                    <div class="card-body">
                    
                    <form id="clocked" action="<?php echo URL; ?>checkin/xhrClocked" method="post" class="form-horizontal">
                        <div class="row form-group">
                            <div class="col-lg-6 offset-md-3 mr-auto ml-auto">
                                <div class="input-group">                                            
                                    <div class="col">
                                    <input type="text" id="phone" name="phone" placeholder="Phone Number" class="form-control"  ></div>
                                    <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                                </div>
                            </div>
                            <input type="hidden" id="code" name="code" class="form-control"  ></div>
                            <input type="hidden" id="clocktype" name="clocktype" class="form-control"  ></div>
                        </div>
                    </form>
                        <div id="msgMain" ></div>
                        <div id="loader"></div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Check-In</th>
                                    <th scope="col">Check-Out</th>
                                </tr>
                            </thead>
                            <tbody id="listTimeChecked">
                            </tbody>
                        </table>
                    </div>
                </div>  <!-- Card -->
            </div>
        </div>
    </div>
</div>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
    <script src="assets/js/main.js"></script>
    
    <?php 
        if (isset($this->js)) {
            foreach ($this->js as $js) {
                // echo '<script type="text/javascript" src="'.URL.'views/'.$js.'"></script> 
                echo '<script type="text/javascript" src="'.$js.'"></script> 
    ';
            }
        }
    ?>
    
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
</body>
</html>