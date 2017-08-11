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
                            <h2>My Dashboard</h2>
                            <span class="small-bottom-border big"></span>
                            <p>View &amp; edit your account information and track of your past orders.</p>
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
                            	<div class="alert alert-success">
                                    <strong>Hello, 
                                    {{ Session::get('userFirstName') }} {{ Session::get('userLastName') }}
                                    </strong>
                                   	<!-- <p>From your My Account Dashboard you have the ability to view a snapshot of your recent account activity and update your account information. You can view your order history or edit your information.</p>
                               		-->
                               		@if(Session::has('success'))
                                		<div class="alert-box success">
                                    		<p>{{ Session::get('success') }}</p>
                                		</div>
                            		@endif
                                </div>
                                <div class="sm-margin"></div>
                                
                                
                                <!-- recent orders start -->
                                <header class="content-title">
                                     <div class="title-bg">
                                         <h3 class="title">Recent Orders</h3>
                                     </div><!-- End .title-bg -->
                                </header>
                                <a href="{{ url('orderhistory') }}" class="pull-right"><button type="button" class="btn btn-custom btn-xs">VIEW ALL <i class="fa fa-list"></i></button></a>
                                <div class="md-margin2x"></div>
                                	<?php  if(count($userOrders)>0){?>
                                    <table class="table cart-table">
                                        <thead>
                                            <tr>
                                                <th class="table-title">Order #</th>
                                                <th class="table-title">Date</th>
                                                <th class="table-title">Order Total</th>
                                                <th class="table-title">Payment</th>
                                                <th class="table-title">Status</th>
                                                <th class="table-title">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($userOrders as $order){?>
                                            <tr>
                                                <td><a href="orderdetails/<?php echo $order->id;?>"><?php echo $order->order_id;?></a></td>
                                                <td><?php echo date('dS M, Y', strtotime($order->modifydate));?></td>
                                                <td>RM <?php echo $order->totalPrice;?>.<span class="sub-price">00</span></td>
                                                <td><?php echo $order->payment_method;?></td>
                                                <td>
                                                	<?php $color=''; if(strtolower($order->status)=='paid' || strtolower($order->status)=='processing'){ $color = 'first-color';}?>
                                                    <?php if(strtolower($order->status)=='fail'){ $color = 'black-color';}?>
                                                	<span class="highlight <?php if(isset($color)){ echo $color;}?> text-12px"><?php echo strtoupper($order->status);?></span>
                                                 </td>
                                                <td><a href="orderdetails/<?php echo $order->id;?>"><button type="button" class="btn btn-danger btn-xs">DETAILS <i class="fa fa-search"></i></button></a></td>
                                            </tr>
                                            <? }?>
                                        </tbody>
                                    </table>
                                    <?php }else{?>
                                    	<p align="center"><strong> No Order Found.</strong></p>
                                    <?php }?>
                                <div class="md-margin"></div>
                                <!-- end recent orders -->
                                
                                <!-- account info start -->
                                <div class="row"> 
                                	<div class="col-md-12">
                                		<header class="content-title">
                                            <div class="title-bg">
                                                <h3 class="title">Account Information</h3>
                                            </div><!-- End .title-bg -->
                                        </header>
                                        <div class="row">
                                        	<div class="col-md-6">
                                            	<h3 class="checkout-title">My Personal Information</h3>
                                                <p>{{ Session::get('userFirstName') }} {{ Session::get('userLastName') }} <br/>
                                                {{ Session::get('userEmail') }}</p>
                                                <a href="{{ url('accountedit') }}"><button type="button" class="btn btn-danger btn-xs">EDIT &nbsp;<i class="fa fa-pencil"></i></button></a>
                                                <a href="{{ url('accountedit') }}"><button type="button" class="btn btn-custom btn-xs">CHANGE PASSWORD &nbsp;<i class="fa fa-lock"></i></button></a>
    
                                            </div>
                                            <!-- end col-md-6 -->
                                            
                                            <div class="col-md-6">
                                                <h3 class="checkout-title">Newsletter Subscription</h3>
                                                <?php if($newsletterStatus==1){?>
                                                	<p>You are currently subscribed to TBM's newsletter.</p>
                                                <?php }else{?>
                                                	<p>You are not subscribed to TBM's newsletter.</p>
                                                <?php }?>
                                                <a href="#" data-toggle="modal" data-target="#modal-newsletter-subscription"><button type="button" class="btn btn-danger btn-xs">EDIT &nbsp;<i class="fa fa-pencil"></i></button></a>
                                              
                                            </div>
                                            <!-- end col-md-6 -->
                                            
                                            
                                            <!-- Modal newsletter subscription start -->
                                            <div class="modal fade" id="modal-newsletter-subscription" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
                                                <form id="login-form-2" name="newsletter" method="post" action="newsletter">
                                                    <input type="hidden" name="userEmail" value="<?php echo $userDetail[0]->email;?>" />
                                                    <input type="hidden" name="userName" value="<?php echo $userDetail[0]->first_name;?> <?php echo $userDetail[0]->last_name;?>" />
                                        			<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
                                                	<div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                            <h4 class="modal-title" id="myModalLabel2">Newsletter Subscription</h4>
                                                            </div><!-- End .modal-header -->
                                                            <div class="modal-body clearfix">
                                                                <div class="input-group custom-checkbox">
                                                                    <input type="radio" name="nwslttr" value="subscribe" <?php if($newsletterStatus==0){ echo 'checked="checked"';}?>> <span class="radio-container"><i class="fa fa-radio"></i></span>Yes, I would like to subscribe to TBM's newsletter.</div>
                                                                <div class="input-group custom-checkbox">
                                                                    <input type="radio" name="nwslttr" value="unsubscribe" <?php if($newsletterStatus==1){ echo 'checked="checked"';}?>> <span class="radio-container"><i class="fa fa-radio"></i></span>Please unsubscribe me.</div>
                                                                
                
                                                            </div><!-- End .modal-body -->
                                                            <div class="modal-footer">
                                                                <button class="btn btn-custom-2" onclick="newsletter.submit();">SAVE</button>
                                                                <button type="button" class="btn btn-custom" data-dismiss="modal">CLOSE</button>
                                                            </div><!-- End .modal-footer -->
                                                        </div><!-- End .modal-content -->
                                                    </div><!-- End .modal-dialog -->
                                                </form>
                                            </div><!-- End .modal forgot password -->
                                        </div>
                                        <!-- end row -->
                                        <div class="md-margin"></div>
                                        
                                        
                                        <!-- billing & shipping address start -->
                                        <header class="content-title">
                                            <div class="title-bg">
                                                <h3 class="title">Billing &amp; Shipping Address</h3>
                                            </div><!-- End .title-bg -->
                                        </header>
                                        <div class="row">
                                        	<div class="col-md-6">
                                                <h3 class="checkout-title">Default Billing Address</h3>
                                                
                                                <p><strong><?php echo $userDetail[0]->billing_first_name;?> <?php echo $userDetail[0]->billing_last_name;?></strong></p>
                                                <p><?php echo $userDetail[0]->billing_address;?> <br/><?php echo $userDetail[0]->billing_post_code;?> <?php echo $userDetail[0]->billing_city;?>, <?php echo $userDetail[0]->billing_state_name;?>, <br/><?php echo $userDetail[0]->billing_country_name;?>.</p>
                                                <p><strong>Email:</strong> <?php echo $userDetail[0]->billing_email;?></p>
                                                <p><strong>Telephone:</strong> <?php echo $userDetail[0]->billing_telephone;?></p>
                                                <a href="{{ url('billingaddress') }}"><button type="button" class="btn btn-danger btn-xs">EDIT &nbsp;<i class="fa fa-pencil"></i></button></a>
                                              
                                            </div>
                                            <!-- end col-md-6 -->
                                            
                                            <div class="col-md-6">
                                                <h3 class="checkout-title">Default Shipping Address</h3>
                                                
                                                <p><strong><?php echo $userDetail[0]->shipping_first_name;?> <?php echo $userDetail[0]->shipping_last_name;?></strong></p>
                                                <p><?php echo $userDetail[0]->shipping_address;?> <br/><?php echo $userDetail[0]->shipping_post_code;?> <?php echo $userDetail[0]->shipping_city;?>, <?php echo $userDetail[0]->shipping_state_name;?>, <br/><?php echo $userDetail[0]->shipping_country_name;?>.</p>
                                                <p><strong>Email:</strong> <?php echo $userDetail[0]->shipping_email;?></p>
                                                <p><strong>Telephone:</strong> <?php echo $userDetail[0]->shipping_telephone;?></p>
                                                <a href="{{ url('shippingaddress') }}"><button type="button" class="btn btn-danger btn-xs">EDIT &nbsp;<i class="fa fa-pencil"></i></button></a>
                                              
                                            </div>
                                            <!-- end col-md-6 -->
                                        </div>
                                        <!-- end row -->
                                        <!-- end billing & shipping address -->
                                        
                                    </div>
                                    <!-- end col-md-12 -->
                                </div>
                                <!-- end row -->
                                
                                <!-- end account info --> 
                                
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
    
    <!-- Brands STARTS
         ========================================================================= -->
      <section id="clients">
        <div class="clients">
            <?php 
            use App\Http\Models\Front\Brands;
            $this->BrandsModel = new Brands();
            $brands = $this->BrandsModel->getBrands();
            $this->data['brands'] = $brands;
            foreach($brands as $brand){?>
                    <div class="items"><img src="{{ asset('/public/admin/brands/'.$brand['image']) }}" alt="<?php echo $brand['title'];?>"></div>
            <?php }	?>
        </div>
      </section>
      <!-- /.brands --> 
    
    <!-- Services STARTS
         ========================================================================= -->
    <section id="facts">
         <div class="container">
            <div class="row">
               <div class="col-md-12 col-sm-4 col-xs-12">
                  <h1>Our Services</h1>
                  <h2>Serving you well and making you happy is what we do best!</h2>
                  <p class="line">&nbsp;</p>
               </div>
            </div>
            <div id="our-facts">
               <div class="items">
                  <div class="circle"><i class="fa fa-truck"></i></div>
                  <div class="heading-2">FREE</div>
                  <div class="heading-1">Delivery</div>
               </div>
               <div class="items">
                  <div class="circle"><i class="fa fa-gavel"></i></div>
                  <div class="heading-2">Installation</div>
                  <div class="heading-1">Services</div>
               </div>
               <div class="items">
                  <div class="circle"><i class="fa fa-comments"></i></div>
                  <div class="heading-2">FREE</div>
                  <div class="heading-1">Teaching/Advice</div>
               </div>
               <div class="items">
                  <div class="circle"><i class="fa fa-book"></i></div>
                  <div class="heading-2">FREE</div>
                  <div class="heading-1">Catalog/Brochures</div>
               </div>
               <div class="items">
                  <div class="circle"><i class="fa fa-shield"></i></div>
                  <div class="heading-2">Extended</div>
                  <div class="heading-1">Warranty</div>
               </div>
               <div class="items">
                  <div class="circle"><i class="fa fa-users"></i></div>
                  <div class="heading-2">Earn/Redeem</div>
                  <div class="heading-1">Points</div>
               </div>
               <div class="items">
                  <div class="circle"><i class="fa fa-dollar"></i></div>
                  <div class="heading-2">Interest</div>
                  <div class="heading-1">FREE</div>
               </div>
               <div class="items">
                  <div class="circle"><i class="fa fa-recycle"></i></div>
                  <div class="heading-2">Product</div>
                  <div class="heading-1">Recycling</div>
               </div>
               <div class="items">
                  <div class="circle"><i class="fa fa-gift"></i></div>
                  <div class="heading-2">FREE</div>
                  <div class="heading-1">Gifts</div>
               </div>
               <div class="items">
                  <div class="circle"><i class="fa fa-dropbox"></i></div>
                  <div class="heading-2">FREE</div>
                  <div class="heading-1">Wrapping</div>
               </div>
               <div class="items">
                  <div class="circle"><i class="fa fa-wrench"></i></div>
                  <div class="heading-2">Repair</div>
                  <div class="heading-1">Services</div>
               </div>
               <div class="items">
                  <div class="circle"><i class="fa fa-tasks"></i></div>
                  <div class="heading-2">Spare</div>
                  <div class="heading-1">Parts</div>
               </div>
            </div>
         </div>
		 <div id="video">
            <video autoplay loop>
               <source src="" type="">
            </video>
         </div>
      </section>
      <!-- /.services -->
@endsection