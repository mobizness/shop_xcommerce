@extends('front/templateFront')

@section('content')
              
        <section id="content">
        	<div id="page-header">
                <h1>Welcome Members!</h1>
                <div class="sm-margin"></div>
                <h2>The TBM Shopping Experience</h2>
                <p class="line">&nbsp;</p>

            </div>
            <div class="md-margin2x"></div>
            <div class="container">
                <div class="row">
                	<div class="col-md-12">
						<div class="hero-unit">
                            <h2>Edit Account Information</h2>
                            <span class="small-bottom-border big"></span>
                            <p>View &amp; edit your personal information. Keep your profile up-to-date.</p>
                        </div>
                        <div class="md-margin2x"></div>
                        
                        <div class="row">
                        	
                            <aside class="col-md-3 col-sm-4 col-xs-12 sidebar">
                            	<div class="widget">
                                    <div class="panel-group custom-accordion sm-accordion" id="category-filter">
   										
                                        <div class="panel">
                                            <div class="accordion-header">
                                                <div class="accordion-title"><span>My Account</span>
                                                </div>
                                                <a class="accordion-btn opened" data-toggle="collapse" data-target="#category-list-1"></a>
                                            </div>
                                            <div id="category-list-1">
                                                <div class="panel-body">
                                                    <?= $user_left; ?>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
                                    </div>
                                </div>
                                <!-- end widget -->
  
                            </aside>
                            
                            <div class="col-md-9 col-sm-9 col-xs-12">
                            	
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
                                
                                <div class="sm-margin"></div>
                                
                                
                               	<h3 class="checkout-title">Account Information</h3>
                               	<form method="post" action="" id="billing_form" name="billing_form">
                                	<div class="row">
                                    	<input type="hidden" name="userId" value="<?php echo $userDetail[0]->id;?>" />
                                        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
                                     
                                              <div class="col-md-6 col-sm-6 col-xs-12">          
													<div class="input-group"><span class="input-group-addon"><i class="fa fa-user"></i> <span class="input-text">First Name &#42;</span></span>
                                                    	<input name="billing_first_name" type="text" class="form-control input-lg" value="<?php echo $userDetail[0]->first_name;?>" required placeholder="Your First Name">
                                                    </div>
                                                        
                                                    <div class="input-group"><span class="input-group-addon"><i class="fa fa-phone"></i> <span class="input-text">Telephone &#42;</span></span>
                                                    	<input name="billing_telephone" type="text" class="form-control input-lg" value="<?php echo $userDetail[0]->telephone;?>" required placeholder="Your Telephone">
                                                    </div>
                                                    
                                                    <div class="input-group"><span class="input-group-addon"><i class="fa fa-lock"></i>  <span class="input-text">Current Password &#42;</span></span>
                                                            
                                                            <input name="current_password" type="password" required class="form-control input-lg" placeholder="Current Password">                                                      
                                                                 
                                                    </div>
                                                    
                                                    <div class="input-group"><span class="input-group-addon"><i class="fa fa-lock"></i>  <span class="input-text">New Password &#42;</span></span>
                                                            
                                                            <input name="password" id="password" type="password" required class="form-control input-lg" placeholder="New Password">                                                      
                                                                 
                                                     </div>
                                                     
                                                     <div class="input-group"><span class="input-group-addon"><i class="fa fa-lock"></i>  <span class="input-text">Confirm New Password &#42;</span></span>
                                                            <input  required="required" type="password" name="passconf" id="passconf" onkeyup="checkPass(); return false;" class="form-control input-lg" placeholder="Verify Password">
                                                            <span id="confirmMessage" class="confirmMessage"></span>
                                                       </div>
                                                        
                                                 </div>
                                                 <!-- end col-md-6 -->
                                                 
                                                 <div class="col-md-6 col-sm-6 col-xs-12">          
                                                     <div class="input-group"><span class="input-group-addon"><i class="fa fa-user"></i> <span class="input-text">Last Name &#42;</span></span>
                                                          <input name="billing_last_name" type="text" class="form-control input-lg" value="<?php echo $userDetail[0]->last_name;?>" required placeholder="Your Last Name">
                                                      </div>
                                                      
                                                       <div class="form-group">
                                                           <div class="input-group"><span class="input-group-addon"><i class="fa fa-calendar"></i> <span class="input-text">Birth Date &#42;</span></span>
                                                               <input name="birth_date" type="text" class="form-control input-lg" placeholder="dd/mm/yyyy" value="<?php echo $userDetail[0]->birth_date;?>">
                                                           </div>
                                                        </div>

                                                      <div class="input-group"><span class="input-group-addon"><i class="fa fa-envelope"></i> <span class="input-text">Email &#42;</span></span>
                                                          <input name="billing_email" type="text" class="form-control input-lg" value="<?php echo $userDetail[0]->email;?>" required placeholder="Your Email (Login ID)">
                                                       </div>
                                                        
                                                      
                                                    	<div class="clearfix"></div>
                                                    
                                                    

                                                    	</div> 
                                                    	<!-- end col-md-6 -->    
           							 </div>
                                     <!-- end your details -->
                                                    
                                                    <div class="alert alert-info"><i class="fa fa-info-circle"></i> &nbsp;<strong>Note:</strong> Password length should be between 8-12 characters with combination of alphabet letters, digits &amp; special characters (eg. *@$!+%~)</div>
                                                    
                                                    
                                                    <div class="xs-margin"></div>
                                                    <h2 class="checkout-title">Contact Address</h2>
													<div class="xs-margin"></div>
                                                         <div class="input-group"><span class="input-group-addon"><i class="fa fa-building-o"></i> <span class="input-text">Address &#42;</span></span>
                                                                <textarea name="billing_address" id="billing_addresse" class="form-control" cols="30" rows="2" placeholder="Your Address"><?php echo $userDetail[0]->billing_address;?></textarea>

                                                        </div>
                                                        <div class="row">
                                                        	<div class="col-md-6 col-sm-6 col-xs-12">

                                                            	<div class="input-group"><span class="input-group-addon"><i class="fa fa-map-marker"></i> <span class="input-text">City &#42;</span></span>
                                                                <input name="billing_city" type="text" class="form-control input-lg" value="<?php echo $userDetail[0]->billing_city;?>" required placeholder="Your City">
                                                            	</div>

                                                        	</div>
                                                        
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                <div class="input-group"><span class="input-group-addon"><i class="fa fa-map-marker"></i> <span class="input-text">Post Code &#42;</span></span>
                                                                    <input name="billing_post_code" type="text" class="form-control input-lg" value="<?php echo $userDetail[0]->billing_post_code;?>" required placeholder="Your Post Code">
                                                                </div>
                                                            </div>  
                                                            <!-- end col-md-6 -->                                                    
                                                        </div>
                                                        <!-- end row -->
                                                        
                                                        <div class="input-group"><span class="input-group-addon"><i class="fa fa-map-marker"></i> <span class="input-text">State &#42;</span></span>
                                                                <div class="large-selectbox clearfix">
                                                                    <select id="billing_state" name="billing_state" class="selectbox">
                                                                    	@foreach($states as $state)
                                                                            <option <?php if($userDetail[0]->billing_state==$state->zone_id){?> selected="selected"<?php }?> value="{{ $state->zone_id }}">{{ $state->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                        </div>
                                                        
                                                        <div class="input-group"><span class="input-group-addon"><i class="fa fa-flag"></i> <span class="input-text">Country &#42;</span></span>
                                                                <div class="large-selectbox clearfix">
                                                                    <select id="billing_country" name="billing_country" class="selectbox">
                                                                        <option value="">Country</option>
                                                                        @foreach($countries as $country)
                                                                            <option <?php if($userDetail[0]->billing_country==$country->country_id){?> selected="selected"<?php }?> value="{{ $country->country_id }}">{{ $country->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                        </div>
                 
                                                    <!-- end your address -->
                                                    <div class="md-margin"></div>
                                        <a href="javascript:window.history.back();" class="btn btn-custom"><i class="fa fa-angle-double-left"></i> BACK</a>
                                        <a onclick="javascript:billing_form.submit();" class="btn btn-custom">SAVE &nbsp;<i class="fa fa-floppy-o"></i></a>
                                 </form>
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


                   
                                                    
  
                                        
                                
                            </div>
                            
                        </div>
                        <!-- end row -->    
  
                        
                       
                    </div>
                    <!-- end col-md-12 -->
                    
            	</div>
                <!-- end row -->
                
    		</div>
            <!-- end container -->
            
            
    
    </section>
    
<?php
	// Brands & Services are done in the templateFront.blade.php
	if(isset($brands_scroller)) unset($brands_scroller);
?>
    
@endsection
