<?php 
session_start();
include('lib/config.php'); // attach config.php
include('lib/function.php');
$meta_title='Login.Binny Traders';
include('inc-head.php');

?>
</head>

<body class="page-login">
    <div class="container col-md-6 col-sm-6" id="form">
    <div class="row">
        <div class="col-md-12 col-sm-12">
        	<div class="panel panel-default">
            	<div class="panel-heading"><img src="<?php echo($base_url) ?>images/bannar_login_transperant.png" alt="Binny Traders Bannar" width="90%" class="img-responsive"/></div><!-- end panel-header -->
                <div class="panel-body">
                	<div id="msglogin"></div><!-- err msg -->
                	<div class="form-horizontal" role="form" id="frmlogin">
                    	<div class="form-group has-feedback has-feedback-left" >
                        	<label for="txtuname" class="col-sm-3 control-label">Username</label>
                        <div class="col-sm-7">    
                            <input type="text" id="txtuname" name="txtuname" placeholder="" class="form-control"/>
                            <i class="form-control-feedback glyphicon glyphicon-user"></i>
                        </div>   
                        </div><!-- end username grp -->
                        <div class="form-group has-feedback has-feedback-left">
                         	<label for="txtupass" class="col-sm-3 control-label">Password</label>
                        <div class="col-sm-7">
                        	 <i class="form-control-feedback glyphicon glyphicon-lock"></i>
                            <input type="password" id="txtupass" name="txtupass" placeholder="" class="form-control"/>
                        </div>    
                        </div><!-- end password grp -->
                        <div class="form-group last">
                        	<div class="col-sm-offset-3">
                            	<button type="button" class="btn btn-primary btn-sm" id="btnlogin"><b>Login</b>&nbsp;<img src="<?php echo($base_url) ?>images/yellow_small_key.png"/></button>
                            	<button type="reset" class="btn btn-warning btn-sm" id="btncancel"><b>Cancel</b>&nbsp;<img src="<?php echo($base_url) ?>images/red_small_cancel.png"/></button>
                        </div><!-- end button grp -->
                    </div><!-- end form horizontal -->
                </div><!-- end panel body -->
                <div class="panel-footer">
                
                <div style="color:#068"><center><small>Copyright &copy; 2019 Cloth Shop All rights reserved</small></center></div>
                </div><!-- end panel footer -->
            </div><!-- end panel -->
        </div><!--login form -->
    </div><!-- end row -->
    </div><!-- end container form -->
</body>
</html>
<script type="text/javascript">
	$("#btnlogin").click(function(){
		var uname=$("#txtuname").val();
		var upass=$("#txtupass").val();	
		
		if(uname=="" || upass==""){
			$("#msglogin").css("display","block");
			$("#msglogin").html("<p class='alert alert-danger'>Please Fill the required fields</p>");
		}
		else{
			//alert("sucess");
			$.post("../lib/function.php?type=loginemp",{uname:uname,upass:upass},function(data,status){
				console.log(data);
				console.log(status);
				
				if(status=="success"){	
						var arr = data.split("|");
						// arr = arr.filter(function(str) {
						// 	return /\S/.test(str);
						// });
						var scode = arr[0].replace(/\n/ig, '');
						console.log(arr);
						console.log(scode);
						if(scode==2){
							$("#msglogin").css("display","block");
							$("#msglogin").html("<p class='alert alert-danger'>"+'Invalid Username or Password !'+"</p>");
							$("#txtuname").val("");
							$("#txtupass").val("");
							$("#txtuname").focus();
						}
						else if(scode==3){
							$("#msglogin").css("display","block");
							$("#msglogin").html("<p class='alert alert-danger'>"+'Your account has been disabled !'+"</p>");
							$("#txtuname").val("");
							$("#txtupass").val("");
							
						}
						else if(scode==1){
							console.log('inside log')
							/*$("#txtuname").val("");
							$("#txtupass").val("");
							$("#msglogin").css("display","block");
							$("#msglogin").html("<p class='alert alert-success'>"+arr[1]+"</p>");
							setTimeout(function(){ window.location.href="lib/route.php"; },1500);*/
							window.location.href="../lib/route.php";
							
						}
				}
			});	
		}
	});

</script>