@extends('front/templateFront')

@section('content')

<section id="content">
    <div id="breadcrumb-container" class="light">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a></li>
                <li><a href="{{ url('/cart') }}">My Shopping Cart</a></li>
                <li class="active">Checkout</li>
            </ul>
        </div>
    </div>
    
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <header class="content-title">
                    <div class="title-bg">
                        <h2 class="title">Checkout</h2>
                    </div><!-- End .title-bg -->
                </header>
                <div class="xs-margin"></div>
                @if(!$isUserLogin)
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <h2 class="checkout-title">Returning Customers</h2>
                            @if($warning)
                                <div class="alert alert-danger">
                                    <i class="fa fa-exclamation-triangle"></i> &nbsp;{{ $warning }}
                                </div>
                            @endif
                                
                            <p>If you have an account with us, please log in.</p>
                            <div class="xs-margin"></div>
                            <form action="{{ url('/login')}}" id="login-form" method="post" name="login-form" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <input type="hidden" name="redirect" value="checkout" />
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-envelope"></i> <span class="input-text">Email &#42;</span>
                                    </span>
                                    <input type="text" required class="form-control input-lg" placeholder="Your Email" name="email" />
                                </div>
                                
                                <div class="input-group xs-margin">
                                    <span class="input-group-addon">
                                        <i class="fa fa-lock"></i>  <span class="input-text">Password &#42;</span>
                                    </span>
                                    <input type="password" required class="form-control input-lg" placeholder="Your Password" name="password" />
                                </div>
                                
                                <span class="help-block"><a href="#" data-toggle="modal" data-target="#modal-forgot-password">Forgot your password?</a></span>
                                
                                <div class="md-margin"></div>
                                <button type="submit" class="btn btn-custom pull-left">CONTINUE &nbsp;<i class="fa fa-angle-double-right"></i></button>
                            </form>
                        </div>
                        <!-- end returning customers -->
                        
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <h2 class="checkout-title">Don't Have An Account Yet?</h2>
                            <div class="sm-margin"></div>
                            <p>By creating an account with us, you will be able to move through the checkout process faster, view and track your orders in your account and more.</p>
                            <div class="md-margin"></div>
                            <a href="{{ url('/create_account') }}" class="btn btn-custom-2">CREATE AN ACCOUNT &nbsp;<i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                @else
                    <div class="row">
                        <form method="post" action="{{ url('checkout') }}">
                            <div class="col-md-12 col-sm-12 col-xs-12 md-margin">
                                <h2 class="checkout-title">Your Billing &amp; Shipping Details</h2>
                                
                                @if($errors)
                                    <div class="alert alert-danger">
                                        @foreach ($errors as $error)
                                        	<i class="fa fa-exclamation-triangle"></i> &nbsp;{{ $error }} <br />
                                        @endforeach
                                    </div>
                                @endif
                                
                                @if($warning)
                                    <div class="alert alert-danger">
                                       	<i class="fa fa-exclamation-triangle"></i> &nbsp;<?= $warning ?>
                                    </div>
                                @endif
                                <div class="tab-container left clearfix">
                                    <ul class="nav-tabs">
                                        <li class="active"><a href="#billing" data-toggle="tab">Billing Details</a></li>
                                        <li><a href="#shipping" data-toggle="tab">Shipping Details</a></li>
                                    </ul>
                                    <div class="tab-content clearfix">
                                        <div class="tab-pane active" id="billing">
                                                <p class="shipping-desc">Please enter your billing information below.</p>
                                                <hr>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-user"></i> <span class="input-text">First Name &#42;</span>
                                                        </span>
                                                        <input type="text" required class="form-control input-lg" placeholder="Your First Name" name="billing_first_name" value="{{ $customer->billing_first_name }}" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-user"></i> <span class="input-text">Last Name &#42;</span>
                                                        </span>
                                                        <input type="text" required class="form-control input-lg" placeholder="Your Last Name" name="billing_last_name" value="{{ $customer->billing_last_name }}" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-group"><span class="input-group-addon"><i class="fa fa-envelope"></i> <span class="input-text">Email &#42;</span></span>
                                                        <input type="text" required class="form-control input-lg" placeholder="Your Email" name="billing_email" value="{{ $customer->billing_email }}" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-group"><span class="input-group-addon"><i class="fa fa-phone"></i> <span class="input-text">Telephone &#42;</span></span>
                                                        <input type="text" required class="form-control input-lg" placeholder="Your Telephone" name="billing_telephone" value="{{ $customer->billing_telephone }}" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-group"><span class="input-group-addon"><i class="fa fa-flag"></i> <span class="input-text">Country &#42;</span></span>
                                                        <div class="large-selectbox clearfix">
                                                            <select name="billing_country" class="selectbox">
                                                                <option value="">Country</option>
                                                                @foreach ($countries as $country)
                                                                    @if ($country->country_id == $customer->billing_country)
                                                                        <option selected="selected" value="{{ $country->country_id }}">{{ $country->name }}</option>
                                                                    @else
                                                                        <option value="{{ $country->country_id }}">{{ $country->name }}</option>
                                                                    @endif                                                    
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-group"><span class="input-group-addon"><i class="fa fa-map-marker"></i> <span class="input-text">State &#42;</span></span>
                                                        <div class="large-selectbox clearfix">
                                                            <select name="billing_state" class="selectbox">
                                                                <option value="">States</option>
                                                                @foreach ($billing_states as $state)
                                                                    @if ($customer->billing_state == $state->zone_id)
                                                                        <option selected="selected" value="{{ $state->zone_id }}">{{ $state->name }}</option>
                                                                    @else
                                                                        <option value="{{ $state->zone_id }}">{{ $state->name }}</option>
                                                                    @endif                                                    
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-group"><span class="input-group-addon"><i class="fa fa-building-o"></i> <span class="input-text">Address &#42;</span></span>
                                                        <textarea id="contact-message" name="billing_address" class="form-control" cols="30" rows="2" placeholder="Your Address">{{ $customer->billing_address }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-group"><span class="input-group-addon"><i class="fa fa-map-marker"></i> <span class="input-text">City &#42;</span></span>
                                                        <input type="text" required class="form-control input-lg" placeholder="Your City" name="billing_city" value="{{ $customer->billing_city }}" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-group"><span class="input-group-addon"><i class="fa fa-map-marker"></i> <span class="input-text">Post Code &#42;</span></span>
                                                        <input type="text" required class="form-control input-lg" placeholder="Your Post Code" name="billing_post_code" value="{{ $customer->billing_post_code }}" />
                                                    </div>
                                                </div>
        
                                        </div>
                                        <div class="tab-pane" id="shipping">
                                            <div class="input-group custom-checkbox sm-margin">
                                                 <input type="checkbox" name="same_billing_address"> <span class="checbox-container"><i class="fa fa-check"></i></span> My shipping and billing addresses are the same.</div>
                                           
                                            <hr>
                                            <p>If you would like to ship to a different address, please enter the shipping information below.</p>
                                            <div class="xs-margin"></div>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-user"></i> <span class="input-text">First Name &#42;</span>
                                                        </span>
                                                        <input type="text" required class="form-control input-lg" placeholder="Your First Name" name="shipping_first_name" value="{{ $customer->shipping_first_name }}" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-user"></i> <span class="input-text">Last Name &#42;</span>
                                                        </span>
                                                        <input type="text" required class="form-control input-lg" placeholder="Your Last Name" name="shipping_last_name" value="{{ $customer->shipping_last_name }}" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-group"><span class="input-group-addon"><i class="fa fa-envelope"></i> <span class="input-text">Email &#42;</span></span>
                                                        <input type="text" required class="form-control input-lg" placeholder="Your Email" name="shipping_email" value="{{ $customer->shipping_email }}" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-group"><span class="input-group-addon"><i class="fa fa-phone"></i> <span class="input-text">Telephone &#42;</span></span>
                                                        <input type="text" required class="form-control input-lg" placeholder="Your Telephone" name="shipping_telephone" value="{{ $customer->shipping_telephone }}" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-group"><span class="input-group-addon"><i class="fa fa-flag"></i> <span class="input-text">Country &#42;</span></span>
                                                        <div class="large-selectbox clearfix">
                                                            <select name="shipping_country" class="selectbox">
                                                                <option value="">Country</option>
                                                                @foreach ($countries as $country)
                                                                    @if ($country->country_id == $customer->shipping_country)
                                                                        <option selected="selected" value="{{ $country->country_id }}">{{ $country->name }}</option>
                                                                    @else
                                                                        <option value="{{ $country->country_id }}">{{ $country->name }}</option>
                                                                    @endif                                                    
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-group"><span class="input-group-addon"><i class="fa fa-map-marker"></i> <span class="input-text">State &#42;</span></span>
                                                        <div class="large-selectbox clearfix">
                                                            <select name="shipping_state" class="selectbox">
                                                                <option value="">States</option>
                                                                @foreach ($shipping_states as $state)
                                                                    @if ($customer->shipping_state == $state->zone_id)
                                                                        <option selected="selected" value="{{ $state->zone_id }}">{{ $state->name }}</option>
                                                                    @else
                                                                        <option value="{{ $state->zone_id }}">{{ $state->name }}</option>
                                                                    @endif                                                    
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-group"><span class="input-group-addon"><i class="fa fa-building-o"></i> <span class="input-text">Address &#42;</span></span>
                                                        <textarea id="contact-message" name="shipping_address" class="form-control" cols="30" rows="2" placeholder="Your Address">{{ $customer->shipping_address }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-group"><span class="input-group-addon"><i class="fa fa-map-marker"></i> <span class="input-text">City &#42;</span></span>
                                                        <input type="text" required class="form-control input-lg" placeholder="Your City" name="shipping_city" value="{{ $customer->shipping_city }}" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-group"><span class="input-group-addon"><i class="fa fa-map-marker"></i> <span class="input-text">Post Code &#42;</span></span>
                                                        <input type="text" required class="form-control input-lg" placeholder="Your Post Code" name="shipping_post_code" value="{{ $customer->shipping_post_code }}" />
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <h2 class="checkout-title">Review Your Order &amp; Pay</h2>
                                <div class="table-responsive">
                                    <table class="table checkout-table">
                                        <thead>
                                            <tr>
                                                <th class="table-title">Product Name</th>
                                                <th class="table-title">Product Code</th>
                                                <th class="table-title">Unit Price</th>
                                                <th class="table-title">Quantity</th>
                                                <th class="table-title">SubTotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<?php $discount = 0; ?>
                                            @foreach($cartProducts['products'] as $cartProduct)
                                            	<?php $discount += ($cartProduct->cart['quantityDiscount'] * $cartProduct->cart['quantity']) + $cartProduct->cart['globalDiscount'] + $cartProduct->cart['promocodeDiscount']; ?>
                                                <tr>
                                                    <td class="item-name-col">
                                                        <figure>
                                                            <a href="{{ url('/product/' . $cartProduct->id) }}">
                                                                <img src="{{ asset('/public/admin/products/medium/' . $cartProduct->thumbnail_image_2) }}" alt="{{ $cartProduct->product_name }}" class="img-responsive">
                                                            </a>
                                                        </figure>
                                                        
                                                        <header class="item-name">
                                                            <a href="{{ url('/product/' . $cartProduct->id) }}">{{ $cartProduct->product_name }}</a>
                                                        </header>
                
                                                        <ul>
                                                            @if($cartProduct->cart['colorName'])
                                                                <li>Color: {{ $cartProduct->cart['colorName'] }}</li>
                                                            @endif
                                                            
                                                            @if($cartProduct->cart['eventName'])
                                                                <li><i class="fa fa-gift text-red"></i> <span class="text-red"><b>For: {{ $cartProduct->cart['eventName'] }}</b></span></li>
                                                            @endif
                                                        </ul> 
                                                        @if($cartProduct->cart['eventToken'])
                                                            <a href="{{ url('event/view') . '?token=' . $cartProduct->cart['eventToken'] }}" class="btn btn-custom btn-xs"><i class="fa fa-angle-double-left"></i>&nbsp; BACK TO SPECIAL LIST</a>
                                                        @endif
                                                    </td>
                                                    <td class="item-code">{{ $cartProduct->product_code }}</td>
                                                    <td class="item-price-col"><span class="item-price-special">RM {{ number_format($cartProduct->sale_price, 2) }}</span></td>
                                                    <td>{{ $cartProduct->cart['quantity'] }}</td>
                                                    <td class="item-total-col">
                                                        <span class="item-price-special">RM {{ number_format(($cartProduct->cart['quantity'] * $cartProduct->sale_price), 2) }}</span> 
                                                    </td>
                                                </tr>
                                            @endforeach
                                            
                                            <tr>
                                                <td class="checkout-table-title" colspan="4">Subtotal:</td>
                                                <td class="checkout-table-price">RM {{ number_format($cartProducts['totalPrice'], 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="checkout-table-title" colspan="4">Shipping:</td>
                                                <td class="checkout-table-price">RM {{ number_format($cartProducts['shippingTotal'], 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="checkout-table-title text-red" colspan="4">Discount:</td>
                                                <td class="checkout-table-price text-red">- RM {{ number_format($discount, 2) }}</td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td class="checkout-total-title" colspan="4"><b>TOTAL:</b></td>
                                                <td class="checkout-total-price cart-total">RM {{ number_format(($cartProducts['totalPrice'] + $cartProducts['shippingTotal'] - $discount), 2) }}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <!-- end table responsive -->
                                <div class="md-margin"></div>
                                <p><strong>Please select the payment option and proceed.</strong></p>
                                <div class="input-group custom-checkbox sm-margin">
                                     <input type="checkbox" value="ipay88" name="payment_method" checked="checked" />
                                     <span class="checbox-container"><i class="fa fa-check"></i></span> ipay88
                                     <img src="{{ asset('/public/front/images/checkout/ipay88.jpg') }}" alt="iPay88">
                                     <!--<p class="help-block">You can pay with your credit card if you don't have a ipay88 account.</p>-->
                                </div>
                                <button type="submit" class="btn btn-custom-2">Place Order &amp; Pay &nbsp; <i class="fa fa-angle-double-right"></i></button>
                            </div>
                        	<input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
    
<?php
	// Brands & Services are done in the templateFront.blade.php
	if(isset($brands_scroller)) unset($brands_scroller);
?>

<script>
$(function(){
	$('input[name=same_billing_address]').click(function(){
		if($(this).is(':checked')){
		
			$('input[name=shipping_first_name]').val($('input[name=billing_first_name]').val());
			$('input[name=shipping_last_name]').val($('input[name=billing_last_name]').val());
			$('input[name=shipping_email]').val($('input[name=billing_email]').val());
			$('input[name=shipping_telephone]').val($('input[name=billing_telephone]').val());
			$('textarea[name=shipping_address]').val($('textarea[name=billing_address]').val());
			$('input[name=shipping_city]').val($('input[name=billing_city]').val());
			$('input[name=shipping_post_code]').val($('input[name=billing_post_code]').val());
			
			$('select[name=shipping_state]').html($('select[name=billing_state]').html());
			$('select[name=shipping_country]').html($('select[name=billing_country]').html());
			
			$('select[name=shipping_state]').val($('select[name=billing_state]').val());
			$('select[name=shipping_country]').val($('select[name=billing_country]').val());
		}
	});
});

$(function (){
	$('select[name="billing_country"]').change(function(){
		var country_id = $(this).val();
		if(country_id != ''){
			$.ajax({
				url: "{{ url('checkout/getStates') }}",
				type: 'POST',
				data: {country_id:country_id, _token: '{{ csrf_token() }}'},
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

$(function (){
	$('select[name="shipping_country"]').change(function(){
		var country_id = $(this).val();
		if(country_id != ''){
			$.ajax({
				url: "{{ url('checkout/getStates') }}",
				type: 'POST',
				data: {country_id:country_id, _token: '{{ csrf_token() }}'},
				dataType: 'json',
				async: false,
				cache: false,
				beforeSend:function (){
					$('select[name="shipping_state"]').html('<option value="">Loading...</option>');
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
					
					$('select[name="shipping_state"]').html(html);
				}
			});
		}
		else{
			$('select[name="shipping_state"]').html('<option value="">State</option>');
		}
	});
});
</script>
@endsection