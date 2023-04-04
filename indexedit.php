<?php
    ob_start();
    session_start();

    //cek session
    if(isset($_SESSION['admin'])){
        header("Location: ./admin.php");
        die();
    }

    require_once 'include/config.php';
    require_once 'include/functions.php';
    $config = conn($host, $username, $password, $database);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php
        $query = mysqli_query($config, "SELECT logo from tbl_instansi");
        list($logo) = mysqli_fetch_array($query);
        echo '<link rel="shortcut icon" href="upload/'.$logo.'">';
    ?>
</head>
<body>
	<div>
		<?php
                        $query = mysqli_query($config, "SELECT * FROM tbl_instansi");
                        while($data = mysqli_fetch_array($query)){
                    ?>
                    <!-- Logo and title START -->
                    <div class="login-content">
                        <div class="card-content">
                            <h2 class="title" id="title">Pelayanan Informasi Elektronik dan Urusan Ketatausahaan</h2>
                            <img src="asset/img/avatar.svg">
                            <h4 class="center" id="smk">
                            <?php echo ''.$data['nama'].'';?>
                            </h4>
                            <div class="batas"></div>
                        </div>
                    </div>
                    <!-- Logo and title END -->
                    <?php
                        }
                    ?>
                    <?php
                        if(isset($_REQUEST['submit'])){

                            //validasi form kosong
                            if($_REQUEST['username'] == "" || $_REQUEST['password'] == ""){
                                echo '<div class="upss red-text"><i class="material-icons">error_outline</i> <strong>ERROR!</strong> Username dan Password wajib diisi.
                                <a class="btn-large waves-effect waves-light blue-grey col s11" href="" style="margin: 20px 0 0 5px;"><i class="material-icons md-24">arrow_back</i> Kembali ke login form</a></div>';
                            } else {

                                $username = trim(htmlspecialchars(mysqli_real_escape_string($config, $_REQUEST['username'])));
                                $password = trim(htmlspecialchars(mysqli_real_escape_string($config, $_REQUEST['password'])));

                                $query = mysqli_query($config, "SELECT id_user, username, nama, nip, admin FROM tbl_user WHERE username=BINARY'$username' AND password=MD5('$password')");

                                if(mysqli_num_rows($query) > 0){
                                    list($id_user, $username, $nama, $nip, $admin) = mysqli_fetch_array($query);

                                    //buat session
                                    $_SESSION['id_user'] = $id_user;
                                    $_SESSION['username'] = $username;
                                    $_SESSION['nama'] = $nama;
                                    $_SESSION['nip'] = $nip;
                                    $_SESSION['admin'] = $admin;

                                    header("Location: ./admin.php");
                                    die();
                                } else {

                                    //session error
                                    $_SESSION['errLog'] = '<center>Username & Password tidak ditemukan!</center>';
                                    header("Location: ./");
                                    die();
                                }
                            }
                        } else {
                    ?>             	
    </div>
	<img class="wave" src="asset/img/wave.png">
	<div class="container">
		<div class="img">
			<img src="asset/img/bg.svg">
		</div>
		<div class="login-content">
			<form action="index.html">
				<img src="asset/img/avatar.svg">
				<h2 class="title">SELAMAT DATANG</h2>
           		<div class="input-div one">
           		   <div class="i">
           		   		<i class="fas fa-user"></i>
           		   </div>
           		   <div class="div">
           		   		<h5>Username</h5>
           		   		<input type="text" class="input">
           		   </div>
           		</div>
           		<div class="input-div pass">
           		   <div class="i"> 
           		    	<i class="fas fa-lock"></i>
           		   </div>
           		   <div class="div">
           		    	<h5>Password</h5>
           		    	<input type="password" class="input">
            	   </div>
            	</div>
            	<input type="submit" class="btn" value="Login">
            </form>
        </div>
    </div>
    <script type="text/javascript" src="js/main.js"></script>
    <script type="text/javascript" src="asset/js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="asset/js/materialize.min.js"></script>
    <script type="text/javascript" src="asset/js/bootstrap.min.js"></script>
    <script data-pace-options='{ "ajax": false }' src='./asset/js/pace.min.js'></script>
    
    <script type="text/javascript">
        $("#alert-message").alert().delay(3000).slideUp('slow');

    <noscript>
        <meta http-equiv="refresh" content="0;URL='/enable-javascript.html'" />
    </noscript>
</body>
</html>