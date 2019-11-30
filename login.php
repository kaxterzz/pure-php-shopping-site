
<?php 
$meta_title='Customer Login';
$c_page = 'login';
include('inc_head.php');

session_start();
$session_id=session_id();
?>
</head>

<body>
<?php include('inc_header.php');?>
<div class="container-fluid col-md-offset-2">
	<!--<div class="row">-->
	<div class="login-form container col-md-5 ">
    	<div class="panel panel-primary">
        	<div class="panel-heading">
            	<div class="panel-title"><h4>Login to your Account</h4></div><!-- panel-title -->
            </div><!-- panel-header-->
        	<div class="panel-body">
            <div id="msglogin"></div>
             	<div class="form-horizontal" role="form" id="frmlogin">
                    	<div class="form-group" >
                        	<label for="txtlemail" class="col-sm-3 control-label">Email</label>
                        	<div class="col-sm-7">   
                            	<div class="input-group"> 
                            		<input type="text" id="txtlemail" name="txtlemail" placeholder="" class="form-control" aria-describedby="usr"/>
                            		<span class="input-group-addon glyphicon glyphicon-user" id="usr"></span>
                                </div><!-- input-group -->
                       		 </div>   
                        </div><!-- end username grp -->
                        <div class="form-group">
                         	<label for="txtlupass" class="col-sm-3 control-label">Password</label>
                        	<div class="col-sm-7">
                            	<div class="input-group">
                            		<input type="password" id="txtlupass" name="txtlupass" placeholder="" class="form-control"aria-describedby="pass"/>
                            		<span class="input-group-addon glyphicon glyphicon-lock" id="pass"></span>
                                </div><!-- input-group -->    
                        	</div>    
                        </div><!-- end password grp -->
                        <div class="form-group last">
                        	<div class="col-sm-offset-3">
                            	<input type="button" class="btn btn-primary" id="btnlogin" value="Login"/>
                            	<input type="reset" class="btn btn-warning" id="btncancel" value="Cancel"/>
                            </div>    
                        </div><!-- end button grp -->
                    </div><!-- end form horizontal -->   
            </div><!-- panel-body --> 
         </div><!-- main panel -->    
   </div><!-- login-form -->
  <!-- </div><!-- end row--> 
   <!-- <div class="row">-->
    <div class="new-ac-form container  col-md-5">
    	<div class="panel panel-primary">
        	<div class="panel-heading">
            	<div class="panel-title"><h4>New User ! Signup</h4></div><!-- panel-title -->
            </div><!-- panel-header-->
        	<div class="panel-body">
            <div id="msg"></div>
             	<div class="form-horizontal" role="form" id="frmsignup">
                    	<div class="form-group" >
                        	<label for="txtemail" class="col-sm-3 control-label">Email</label>
                        	<div class="col-sm-7">   
                            	<div class="input-group"> 
                            		<input type="text" id="txtemail" name="txtemail" placeholder="" class="form-control" aria-describedby="email"/>
                            		<span class="input-group-addon glyphicon glyphicon-user" id="email"></span>
                                </div><!-- input-group -->
                       		 </div>   
                        </div><!-- end username grp -->
                        <div class="form-group">
                         	<label for="txtupass" class="col-sm-3 control-label">Password</label>
                        	<div class="col-sm-7">
                            	<div class="input-group">
                            		<input type="password" id="txtupass" name="txtupass" placeholder="" class="form-control"aria-describedby="pass"/>
                            		<span class="input-group-addon glyphicon glyphicon-lock" id="pass"></span>
                                </div><!-- input-group -->    
                        	</div>    
                        </div><!-- end password grp -->
                        <div class="form-group">
                         	<label for="txtreupass" class="col-sm-3 control-label">Retype password</label>
                        	<div class="col-sm-7">
                            	<div class="input-group">
                            		<input type="password" id="txtreupass" name="txtreupass" placeholder="" class="form-control"aria-describedby="repass"/>
                            		<span class="input-group-addon glyphicon glyphicon-lock" id="repass"></span>
                                </div><!-- input-group -->    
                        	</div>    
                        </div><!-- end password grp -->

                        <div class="form-group last">
                        	<div class="col-sm-offset-3">
                            	<input type="button" class="btn btn-primary" id="btnsignup" value="SignUp"/>
                            	<input type="reset" class="btn btn-warning" id="btncancel" value="Cancel"/>
                            </div>    
                        </div><!-- end button grp -->
                    </div><!-- end form horizontal -->   
            </div><!-- panel-body --> 
         </div><!-- main panel -->     
    </div><!-- new-ac-form -->
  <!-- </div><!-- end row --> 
</div><!-- main container -->
 <?php include('admin/inc-footer.php'); ?>
</body>
</html>
<script type="text/javascript">
	$("#btnlogin").click(function(){
		var email=$("#txtlemail").val();
		var upass=$("#txtlupass").val();	
		
		if(email=="" || upass==""){
			$("#msglogin").css("display","block");
			$("#msglogin").html("<p class='alert alert-danger'>Please Fill the required fields</p>");
		}
		else{
			//alert("sucess");
			$.post("lib/site_functions.php?type=loginacc",{email:email,upass:upass},function(data,status){
				console.log(data);
				console.log(status);
				
				if(status=="success"){	
						var arr = data.split("|");
						if(arr[0]==2){
							$("#msglogin").css("display","block");
							$("#msglogin").html("<p class='alert alert-danger'>"+arr[1]+"</p>");
							$("#txtlemail").val("");
							$("#txtlupass").val("");
							$("#txtlemail").focus();
						}
						else if(arr[0]==3){
							$("#msglogin").css("display","block");
							$("#msglogin").html("<p class='alert alert-danger'>"+arr[1]+"</p>");
							setTimeout(function(){ window.location.href= "index.php"; },2500);
							
						}
						else if(arr[0]==1){
							$("#txtlemail").val("");
							$("#txtlupass").val("");
							$("#msglogin").css("display","block");
							$("#msglogin").html("<p class='alert alert-success'>"+arr[1]+"</p>");
							setTimeout(function(){ window.location.href= "lib/route.php"; },1500);
							
						}
				}
			});	
		}
	});

	$("#btnsignup").click(function(){
		var email=$("#txtemail").val();	
		var upass=$("#txtupass").val();
		var reupass=$("#txtreupass").val();
		//var email_pat="/^[a-zA-Z0-9\.\_]+\@[a-zA-Z0-9\.\_]+\.[a-zA-Z]{2,4}$/";
		if(email=="" || upass=="" || reupass==""){
			$("#msg").css("display","block");
			$("#msg").html("<p class='alert alert-danger'>Please Fill the required fields</p>");
		}
		else if(upass.length<8 && reupass.length<8){
			$("#txtupass").val("");
			$("#txtreupass").val("");
			$("#txtupass").focus();
			$("#msg").css("display","block");
			$("#msg").html("<p class='alert alert-danger'>Please Enter a password of atleast 8 characters</p>");
		}
		
		else{
			//alert("sucess");
			$.post("lib/site_functions.php?type=newacc",{email:email,upass:upass,reupass:reupass},function(data,status){
				console.log(data);
				console.log(status);
				
				if(status=="success"){	
						var arr = data.split("|");
						if(arr[0]==2){
							$("#msg").css("display","block");
							$("#msg").html("<p class='alert alert-danger'>"+arr[1]+"</p>");
							$("#txtemail").val("");
							$("#txtemail").focus();
						}
						else if(arr[0]==3){
							$("#msg").css("display","block");
							$("#msg").html("<p class='alert alert-danger'>"+arr[1]+"</p>");
							$("#txtreupass").val("");
							$("#txtreupass").focus();
						}
						else if(arr[0]==1){
							$("#txtemail").val("");
							$("#txtupass").val("");
							$("#txtreupass").val("");
							$("#msg").css("display","block");
							$("#msg").html("<p class='alert alert-success'>"+arr[1]+"</p>");
							setTimeout(function(){window.location.href= "lib/route.php"; },1500);
							
						}
				}
			});	
		}
	});
</script>