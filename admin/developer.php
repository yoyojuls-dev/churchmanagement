
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="St.Lukes Boys School management System">
    <meta name="author" content="Kithinji Godfrey">
	<link href="admin/bootstrap/css/index_background.css" rel="stylesheet" media="screen"/>
<link rel="shortcut icon" href="images/pmanlogos.png" />

</style>
</head>
<?php include('header_dashboard.php'); ?>
    <body id="home">
		<?php include('navbar_about.php'); ?>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span12" id="content">
                     <div class="row-fluid">
                        <!-- block -->
                        <div class="block">
								<div class="navbar navbar-inner block-header">
									<div id="" class="muted pull-right"><a id="return" data-placement="left" title="Click to Return" href="index.php"><i class="icon-arrow-left"></i> Back</a></div>
									<script type="text/javascript">
																$(document).ready(function(){
																	$('#return').tooltip('show');
																	$('#return').tooltip('hide');
																});
																</script> 
								</div>
                            <div class="block-content collapse in" >
							<h3></i><i class="icon-group"></i>&nbsp;System Developers:</h3>
							<hr>
							
                                <p>
														
                                <div class="span3" >
								        <img id="developers" src="developers/visbal.jpg" class="img-circle">
								        <hr>
										<p>Main Dev</p>
										<p>Name: Julius Ceasar Visbal</p>
										<p>Address: Caloocan City</p>
										<p>Email:<a href="http://www.gmail.com"> visbaljulius@gmail.com</a></p>
										<p>Position: Web Programmer </p>								        
								</div>
								<div class="span3" >
								        <img id="developers" src="developers/mensenas.jpg" class="img-circle">
								        <hr>
										<p>Name: Rhykel Ivan Mensenas</p>
										<p>Address: Caloocan City</p>
										<p>Email:<a href="http://www.gmail.com"> rhykl.vn@gmail.com</a></p>
										<p>Position: Web Designer </p>								        
								</div>
								<div class="span3" >
								        <img id="developers" src="developers/cuevas.jpg" class="img-circle">
								        <hr>
										<p>Name: Maverick Ivan Cuevas</p>
										<p>Address: Antipolo Rizal</p>
										<p>Email:<a href="http://www.gmail.com"> mavs@gmail.com</a></p>
										<p>Position: Content Maker </p>								        
								</div>
								<div class="span3" >
								        <img id="developers" src="developers/ramos.jpg" class="img-circle">
								        <hr>
										<p>Name: Mark Enrico Ramos</p>
										<p>Address: Montalban Rizal</p>
										<p>Email:<a href="http://www.gmail.com"> markramos@gmail.com</a></p>
										<p>Position: Web Designer </p>								        
								</div>
								</p>
                                
                               
                            </div>
                        </div>
                        <!-- /block -->
                    </div>
                </div>
            </div>
		<?php include('footer.php'); ?>
        </div>
		<?php include('script.php'); ?>
    </body>
</html>