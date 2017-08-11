@extends('front/templateFront')

@section('content')
    <section id="content">
        	<div id="breadcrumb-container" class="light">
                <div class="container">
                    <ul class="breadcrumb">
                        <li><a href="index.html"><i class="fa fa-home"></i> Home</a></li>
                        <li class="active">Create An Account</li>
                    </ul>
                </div>
            </div>
            <div class="container">
                <div class="row">
                	<div class="col-md-12">
                        <header class="content-title">
                            <div class="title-bg">
								<h2 class="title">Create An Account</h2>
							</div><!-- End .title-bg -->
                        </header>
                        <div class="xs-margin"></div>
                        <div class="row">
                        	<div class="col-md-12">	        
         
        
       
        <p>
        
        @if(Session::has('error'))
                                    	<div class="alert alert-danger">
                                        	<div class="alert-box success">
                                            	<p>{{ Session::get('error') }}</p>
                                                <p>
                                                	@if (count($errors)>0)
                                                    <ul>
                                                        @foreach ($errors as $e)
                                                        <li>{{ $e }}</li>
                                                        @endforeach
                                                    </ul>
                                                    @endif
                                                </p>
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
         </div> <form action="create_account" id="billing-form" method="post" enctype="multipart/form-data" name="registration-form">
                                                        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
        
                                            <div class="row">
                                             <div class=" col-md-6 col-sm-6 col-xs-12"  >
                                                
                                               
                                                    <h2 class="checkout-title">Your Details</h2>
                                                    <div class="xs-margin"></div>
                                                   
                                                       
                                                        <div class="form-group">
                                                            <div class="input-group"><span class="input-group-addon"><i class="fa fa-user"></i> <span class="input-text">First Name &#42;</span></span>
                                                                <input value="{{ old('billing_first_name') }}"  name="billing_first_name" id="billing_first_name" type="text" required class="form-control input-lg" placeholder="Your First Name">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="input-group"><span class="input-group-addon"><i class="fa fa-user"></i> <span class="input-text">Last Name &#42;</span></span>
                                                                <input  value="{{ old('billing_last_name') }}"  name="billing_last_name" id="billing_last_name" type="text" required class="form-control input-lg" placeholder="Your Last Name">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="input-group"><span class="input-group-addon"><i class="fa fa-phone"></i> <span class="input-text">Telephone &#42;</span></span>
                                                                <input value="{{ old('billing_telephone') }}"  name="billing_telephone" id="billing_telephone" type="text" required class="form-control input-lg" placeholder="Your Telephone">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                           <div class="input-group"><span class="input-group-addon"><i class="fa fa-calendar"></i> <span class="input-text">Birth Date &#42;</span></span>
                                                           	   <input   value="{{ old('birth_date') }}" type="text" data-date-format="d/mm/yyyy" placeholder="dd/mm/yyyy" class="datepicker-default form-control input-lg"  name="birth_date" />	
                                                           </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="input-group"><span class="input-group-addon"><i class="fa fa-envelope"></i> <span class="input-text">Email &#42;</span></span>
                                                                <input  value="{{ old('billing_email') }}" name="billing_email" id="billing_email" type="text"  required="required" class="form-control input-lg" placeholder="Your Email (Login ID)" email>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                        	<div class="input-group"><span class="input-group-addon"><i class="fa fa-lock"></i>  <span class="input-text">Password &#42;</span></span>
                                                            
                                                            <input type="password" name="password" id="password"  required="required" class="form-control input-lg" placeholder="Your Password">                                                      
                                                                 
                                                            </div>
                                                        </div>
                                                         <div class="form-group">
                                                        	<div class="input-group"><span class="input-group-addon"><i class="fa fa-lock"></i>  <span class="input-text">Verify Password &#42;</span></span>
                                                            <input  required="required" type="password" name="passconf" id="passconf" onkeyup="checkPass(); return false;" class="form-control input-lg" placeholder="Verify Password">
                                                            <span id="confirmMessage" class="confirmMessage"></span>
                                                            </div>
                                                            <script>
 
 function checkPass()
{
    //Store the password field objects into variables ...
    var password = document.getElementById('password');
    var passconf = document.getElementById('passconf');
    //Store the Confimation Message Object ...
    var message = document.getElementById('confirmMessage');
    //Set the colors we will be using ...
    var goodColor = "#66cc66";
    var badColor = "#ff6666";
    //Compare the values in the password field 
    //and the confirmation field
    if(password.value == passconf.value){
        //The passwords match. 
        //Set the color to the good color and inform
        //the user that they have entered the correct password 
        passconf.style.backgroundColor = goodColor;
        message.style.color = goodColor;
        message.innerHTML = "Passwords Match!"
    }else{
        //The passwords do not match.
        //Set the color to the bad color and
        //notify the user.
        passconf.style.backgroundColor = badColor;
        message.style.color = badColor;
        message.innerHTML = "Passwords Do Not Match!"
    }
}   </script>
                                                            
                                                            <div class="alert alert-info"><i class="fa fa-info-circle"></i> &nbsp;<strong>Note:</strong> Password length should be between 8-12 characters with combination of alphabet letters, digits &amp; special characters (eg. *@$!+%~)</div>
                                                            
                                                            <div class="input-group custom-checkbox">
                                                                 <input  name="newsletter_subscription"id="newsletter_subscription" type="checkbox" checked="checked" value="1"> <span class="checbox-container"><i class="fa fa-check"></i></span> Yes! I would like to subscribe to TBM's newsletter to receive latest offers, promotions, discounts and FREE gifts.
                                							</div>
                                                            
                                                            <div class="input-group custom-checkbox">
                                                                 <input required="required" type="checkbox" name="agree" id="agree" value="1"> <span class="checbox-container"><i class="fa fa-check"></i></span> I agree TBM's <a href="#">terms &amp; conditions</a>, <a href="#">privacy policy</a>.
                                							</div>
                                                            
                                                            <p class="item-desc">Please enter the security code shown below:
                                           					<!--<img src="{{ asset('/public/front/images/login/reCAPTCHA_Sample_White.png') }}" alt="Recaptcha"></p>
                                                            -->
                                                             <script src="https://www.google.com/recaptcha/api.js"></script>
                                                             <div id="g-recaptcha" class="g-recaptcha" data-sitekey="6LdnSggTAAAAAC2GJgujWiVIxRPk8wtzAm_BjkzS"></div>
                                                        </div> 
                                                        
           
                                                  <!--  </form>-->
                                                    
  
                                                    
                                                    <div class="md-margin"></div>
                                                    <!--<a  href="javascript:void(0);" onclick="submit_create_accountform();"  class="btn btn-custom pull-left"> &nbsp;<i class="fa fa-plus"></i></a> 
                                                  --> 
                                                    <span class="btn btn-custom pull-left"><input type="submit" name="submit" value="CREATE AN ACCOUNT NOW" class="btn btn-custom myclass" /><i class="fa fa-plus"></i></span>
                                                </div> 
                                                <!-- end returning customers -->
                                                

                                                
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <h2 class="checkout-title">Your Address</h2>
													<div class="xs-margin"></div>
                                                   <!-- <form action="#" id="billing-form">-->
														<div class="form-group">
                                                            <div class="input-group"><span class="input-group-addon"><i class="fa fa-building-o"></i> <span class="input-text">Address &#42;</span></span>
                                                                <textarea name="billing_address" id="billing_address" class="form-control" cols="30" rows="2" placeholder="Your Address"> {{ old('billing_address') }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="input-group"><span class="input-group-addon"><i class="fa fa-map-marker"></i> <span class="input-text">City &#42;</span></span>
                                                                <input value="{{ old('billing_city') }}"  name="billing_city" id="billing_city" type="text" required class="form-control input-lg" placeholder="Your City">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="input-group"><span class="input-group-addon"><i class="fa fa-map-marker"></i> <span class="input-text">Post Code &#42;</span></span>
                                                                <input value="{{ old('billing_post_code') }}" type="text" name="billing_post_code" id="billing_post_code" required class="form-control input-lg" placeholder="Your Post Code">
                                                            </div>
                                                        </div>                                                      
                                                        <div class="form-group">
                                                            <div class="input-group"><span class="input-group-addon"><i class="fa fa-map-marker"></i> <span class="input-text">State &#42;</span></span>
                                                                <div class="large-selectbox clearfix">
                                                                    <select id="billing_state" name="billing_state" class="selectbox"><option value="">States</option><option value="1971">Johor</option><option value="1972">Kedah</option><option value="1973">Kelantan</option><option value="1985">Kuala Lumpur</option><option value="1974">Labuan</option><option value="1975">Melaka</option><option value="1976">Negeri Sembilan</option><option value="1977">Pahang</option><option value="1978">Perak</option><option value="1979">Perlis</option><option value="1980">Pulau Pinang</option><option value="4035">Putrajaya</option><option value="1981">Sabah</option><option value="1982">Sarawak</option><option value="1983">Selangor</option><option value="1984">Terengganu</option></select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="input-group"><span class="input-group-addon"><i class="fa fa-flag"></i> <span class="input-text">Country &#42;</span></span>
                                                                <div class="large-selectbox clearfix">
                                                                    <select id="billing_country" name="billing_country" class="selectbox">
                                                                        <option value="">Country</option>
                                                        @foreach($countries as $country)
                                                            <option <?php if($country->country_id==129){ echo "selected=selected";} ?> value="{{ $country->country_id }}">{{ $country->name }}</option>
                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                
                                                  
                                                   
                                                    
                                                    <div class="md-margin"></div>
                                                </div>
                                                  </div>
                                                  
                                                  </form>
                                                <!-- end your address -->
                                                
                                          
                                            <!-- end col-md-12 -->
                                            
                                            <!-- Modal Forgot Passwrod start -->
                                            <div class="modal fade" id="modal-forgot-password" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
                                                <form id="login-form-2" method="get" action="#">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                        <h4 class="modal-title" id="myModalLabel2">Forgot Your Password?</h4>
                                                        </div><!-- End .modal-header -->
                                                        <div class="modal-body clearfix">
            
                                                            <p>Please enter your registered email address and we will help you to reset the password. The new generated password will be sent to the email address you entered below.</p>
                                                            <div class="xs-margin"></div>
                                                            <div class="col-md-9">
                                                                
                                                                <div class="input-group"><span class="input-group-addon"><i class="fa fa-envelope"></i> <span class="input-text">Email &#42;</span></span>
                                                                    <input type="text" required class="form-control input-lg" placeholder="Your Email">
                                                                </div>
                                                                
                                                                                                             
                                                        
                                                        </div>
            
                                                        </div><!-- End .modal-body -->
                                                        <div class="modal-footer">
                                                            <button class="btn btn-custom-2">RESET PASSWORD</button>
                                                            <button type="button" class="btn btn-custom" data-dismiss="modal">CLOSE</button>
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

<!--LOADING SCRIPTS FOR PAGE-->
<link type="text/css" rel="stylesheet" href="{{ asset('/public/admin/vendors/bootstrap-datepicker/css/datepicker.css') }}">
<script src="{{ asset('/public/admin/vendors/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/moment/moment.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/bootstrap-timepicker/js/bootstrap-timepicker.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/bootstrap-clockface/js/clockface.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/bootstrap-colorpicker/js/bootstrap-colorpicker.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/jquery-maskedinput/jquery-maskedinput.js') }}"></script>
<script src="{{ asset('/public/admin/js/form-components.js') }}"></script>
<!--LOADING SCRIPTS FOR PAGE-->
	
   <script>
$(function (){
	$('select[name="billing_country"]').change(function(){
		var country_id = $(this).val();
		if(country_id != ''){
			$.ajax({
				url: "{{ url('users/getStates') }}",
				type: 'POST',
				data: {country_id:country_id, _token: $('#_token').val()},
				dataType: 'json',
				async: false,
				cache: false,
				beforeSend:function (){
					$('select[name="billing_state"]').html('<option value="">Loading...</option>');
				},
				complete: function(){
					
				},
				success: function (response) {
					var html = '';
					html += '<option value="">States</option>';
					if(response['states']){
						for(var i = 0; i < response['states'].length; i++){
							html += '<option value="' + response['states'][i]['zone_id'] + '">' + response['states'][i]['name'] + '</option>';
						}
					}
					
					$('select[name="billing_state"]').html(html);
				}
			});
		}
		else{
			$('select[name="billing_state"]').html('<option value="">State</option>');
		}
	});
});
</script>   
    
@endsection
