
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Jss Documents Library</title>

    <!-- Bootstrap Core CSS -->
    <link href="http://localhost:8080/blog/public/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="http://localhost:8080/blog/public/css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="http://localhost:8080/blog/public/css/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="http://localhost:8080/blog/public/fonts/font-awesome.min.css" rel="stylesheet" type="text/css">

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">JSS Medical Research - Document Library</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>Admin User<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="active">
                        <a href="./"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i>Users<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo" class="collapse">
                            <li>
                                <a href="createaccount">Create new User</a>
                            </li>
							<li>
                                <a href="adimport">AD Import</a>
                            </li>
                            <li>
                                <a href="accounts">User List</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="blank-page.html"><i class="fa fa-fw fa-file"></i>Upload Files</a>
                    </li>
                    <li>
                        <a href="index-rtl.html"><i class="fa fa-fw fa-dashboard"></i>ACL</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>
    <!-- /#wrapper -->
	
	<div id="page-wrapper">
	
		<div class="container-fluid">
			<div class="row">
				<?php echo $__env->yieldContent('content'); ?>
			</div>
		</div>
	
	</div>
	
	</div>

    <!-- jQuery -->
    <script src="http://localhost:8080/blog/public/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="http://localhost:8080/blog/public/js/bootstrap.min.js"></script>
	<script src="http://localhost:8080/blog/public/js/bootstrap-filestyle.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="http://localhost:8080/blog/public/js/plugins/raphael.min.js"></script>
    <script src="http://localhost:8080/blog/public/js/plugins/morris.min.js"></script>
    <script src="http://localhost:8080/blog/public/js/plugins/morris-data.js"></script>

</body>

</html>
