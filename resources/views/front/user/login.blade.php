@extends('front/templateFront')

@section('content')
              
        <section id="content">
        	<div id="breadcrumb-container" class="light">
                <div class="container">
                    <ul class="breadcrumb">
                        <li><a href="index.html"><i class="fa fa-home"></i> Home</a></li>
                        <li class="active">Log In</li>
                    </ul>
                </div>
            </div>
            <div class="container">
                <div class="row">
                	<div class="col-md-12">
                        <header class="content-title">
                            <div class="title-bg">
								<h2 class="title">Log In</h2>
							</div><!-- End .title-bg -->
                        </header>
                        <div class="xs-margin"></div>
                        <div class="row">
                        	<div class="col-md-12">


                                            <div class="row">
                                                
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <h2 class="checkout-title">Returning Customers</h2>
                                                      	@if(Session::has('error'))
                                                    		<div class="alert alert-danger">
                                                            	<div class="alert-box success">
                                                                	<p>{{ Session::get('error') }}</p>
                                                            	</div>
                                               		 		</div>
                                                		@endif
                                                
                                                		@if(Session::has('success'))
                                							<div class="alert alert-success">
                                                            	<div class="alert-box success">
                                    								<p>{{ Session::get('success') }}</p>
                                								</div>
                                                            </div>
                            							@endif
                                                 
                                                    <p>If you have an account with us, please log in.</p>
                                                    <div class="xs-margin"></div>
                                                    <form action="login" id="login-form" method="post" name="login-form" enctype="multipart/form-data">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                    <input type="hidden" name="redirect" value="dashboard" />
                                                    <div class="input-group"><span class="input-group-addon"><i class="fa fa-envelope"></i> <span class="input-text">Email &#42;</span></span>
                                                        <input type="text"  id="email" name="email" required class="form-control input-lg" placeholder="Your Email">
                                                    </div>
                                                    
                                                    <div class="input-group xs-margin"><span class="input-group-addon"><i class="fa fa-lock"></i>  <span class="input-text">Password &#42;</span></span>
                                                        <input type="password" name="password" id="password" required class="form-control input-lg" placeholder="Your Password">
                                                    </div>
                                                    <span class="help-block"><a href="#" data-toggle="modal" data-target="#modal-forgot-password">Forgot your password?</a></span>
                                                    
                                                    <div class="md-margin"></div>
                                                    <!--<a href="#" class="btn btn-custom pull-left">LOGIN &nbsp;<i class="fa fa-sign-in"></i></a> -->
                                                  <span class="btn btn-custom pull-left "><input type="submit" name="submit" value="LOGIN"class="btn btn-custom pull-left myclass" /><i class="fa fa-sign-in"></i></span>
                                                   </form> 
                                                </div>
                                                <!-- end returning customers -->
                                                
                                                
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <h2 class="checkout-title">Don't Have An Account Yet?</h2>
                                                    
                                                    <div class="sm-margin"></div>
                                                   
                                                    <p>By creating an account with us, you will be able to move through the checkout process faster, view and track your orders in your account and more.</p>
                                                    
                                                    
                                                    <div class="md-margin"></div>
                                                    <a href="{{ url('create_account') }}" class="btn btn-custom-2">CREATE AN ACCOUNT &nbsp;<i class="fa fa-plus"></i></a>
                                                </div>
                                                <!-- end don't have an account yet -->
                                                
                                            </div>
                                            <!-- end col-md-12 -->
                                            
                                            <!-- Modal Forgot Passwrod start -->
                                            <div class="modal fade" id="modal-forgot-password" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
                                                <form id="login-form-2" method="post" action="login/reset" name="login-form-2" enctype="multipart/form-data" >
                                                 <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <button type="button" onClick="$('.form-horizontal').trigger('reset');" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                        <h4 class="modal-title" id="myModalLabel2">Forgot Your Password?</h4>
                                                        </div><!-- End .modal-header -->
                                                        <div class="modal-body clearfix">
            
                                                            <p>Please enter your registered email address and we will help you to reset the password. The new generated password will be sent to the email address you entered below.</p>
                                                            <div class="xs-margin"></div>
                                                            <div class="col-md-9">
                                                                
                                                                <div class="input-group"><span class="input-group-addon"><i class="fa fa-envelope"></i> <span class="input-text">Email &#42;</span></span>
                                                                    <input id="email"  name="email" type="text" required class="form-control input-lg" placeholder="Your Email">
                                                                </div>
                                                                
                                                                                                             
                                                        
                                                        </div>
            
                                                        </div><!-- End .modal-body -->
                                                        <div class="modal-footer">
                                                            <button name="reset" id="reset" onclick="document.getElementById('login-form-2').submit();" class="btn btn-custom-2">RESET PASSWORD</button>
                                                            <button type="button" class="btn btn-custom" data-dismiss="modal" onClick="$('.form-horizontal').trigger('reset');" >CLOSE</button>
                                                        </div><!-- End .modal-footer -->
                                                    </div><!-- End .modal-content -->
                                                </div><!-- End .modal-dialog -->
                                                </form>
                                            </div><!-- End .modal forgot password -->


                                
    						</div>
                        </div>
                        <div class="lg-margin"></div>

                        
                    </div>
                    <!-- end col-md-12 -->
                    
            	</div>
                <!-- end row -->
                
    		</div>
            <!-- end container -->

    
    </section>

@endsection
