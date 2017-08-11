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
                            <h2>Order Details</h2>
                            <span class="small-bottom-border big"></span>
                            <p>View your order details &amp; track your order.</p>
                        </div>
                        <div class="md-margin2x"></div>
                        
  
                                <table class="table cart-table">
                                    <thead>
                                        <tr>
                                            <th class="table-title">Order ID</th>
                                            <th class="table-title">Date</th>
                                            <th class="table-title">Order Total</th>
                                            <th class="table-title">Payment Method</th>
                                            <th class="table-title">Shipping Method</th>
                                            <th class="table-title">Order Status</th>
                                            <th class="table-title">Payment Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?php echo $userOrderDetails[0]->order_id;?></td>
                                            <td><?php echo date('dS M, Y', strtotime($userOrderDetails[0]->modifydate));?></td>
                                            <td>RM <?php echo $userOrderDetails[0]->totalPrice;?>.<span class="sub-price">00</span></td>
                                            <td><?php echo $userOrderDetails[0]->payment_method;?></td>
                                            <td>Poslaju National Courier</td>
                                            <td><span class="highlight first-color text-12px">COMPLETED</span></td>
                                            <td>
                                            	<?php if(strtolower($userOrderDetails[0]->status)=='paid'){ $color = 'first-color';}?>
                                                <span class="highlight <?php if(isset($color)){ echo $color;}?> text-12px"><?php echo strtoupper($userOrderDetails[0]->status);?></span>
                                            </td>
                                        </tr>
                                        
                                        
                                    </tbody>
                                </table> 
                                <div class="md-margin"></div>
                                
                                <div class="row">
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <h2 class="checkout-title">Billing Details</h2>
                                                    <ul>
                                                    	<li><b>Bill to:</b> <?php echo $userOrderDetails[0]->billing_first_name;?> <?php echo $userOrderDetails[0]->billing_last_name;?> </li>
                                                        <li><b>Email:</b> <?php echo $userOrderDetails[0]->billing_email;?></li>
                                                        <li><b>Telephone:</b> <?php echo $userOrderDetails[0]->billing_telephone;?></li>
                                                        <li><b>Address: </b><?php echo $userOrderDetails[0]->billing_address;?>, <?php echo $userOrderDetails[0]->billing_post_code;?> <?php echo $userOrderDetails[0]->billing_city;?>, <?php echo $userOrderDetails[0]->billing_state_name;?>, <?php echo $userOrderDetails[0]->billing_country_name;?>.</li>
                                                    </ul> 
                                                    
                                                    <div class="sm-margin"></div>

                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <h2 class="checkout-title">Shipping Details</h2>
                                                    <ul>
                                                    	<li><b>Ship to:</b> <?php echo $userOrderDetails[0]->shipping_first_name;?> <?php echo $userOrderDetails[0]->shipping_last_name;?> </li>
                                                        <li><b>Email:</b> <?php echo $userOrderDetails[0]->shipping_email;?></li>
                                                        <li><b>Telephone:</b> <?php echo $userOrderDetails[0]->shipping_telephone;?></li>
                                                        <li><b>Address: </b><?php echo $userOrderDetails[0]->shipping_address;?>, <?php echo $userOrderDetails[0]->shipping_post_code;?> <?php echo $userOrderDetails[0]->shipping_city;?>, <?php echo $userOrderDetails[0]->shipping_state_name;?>, <?php echo $userOrderDetails[0]->shipping_country_name;?>.</li>
                                                    </ul> 
                                                    
                                                </div>    
                                         </div>
                                         <!-- end row -->
                                
                                
                                <div class="lg-margin"></div>
                                <!-- end billing & shipping details -->
                                
                                <div class="row">
                            
                                    <div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
                        <h2 class="checkout-title">Your Order Details</h2>
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
                            	<?php 
								$subtotal = 0;
								$shipping = 0;
								?>
                            	@foreach($orderProducts as $orderProduct)
                                <tr>
                                    <td class="item-name-col">
                                        <figure><a href="{{ url('/product/' . $orderProduct->id) }}">
                                        	<img src="{{ asset('/public/admin/products/medium/' . $orderProduct->thumbnail_image_2) }}" alt="{{ $orderProduct->product_name }}" class="img-responsive">
                                        </a></figure>
                                        <header class="item-name">
                                            <a href="{{ url('/product/' . $orderProduct->id) }}">{{ $orderProduct->product_name }}</a>
                                        </header>
                                        <ul>
                                          @if($orderProduct->color_name)
                                          <li>Color: {{ $orderProduct->color_name }}</li>
                                          @endif
                                          <!--<li><i class="fa fa-gift text-red"></i> <span class="text-red"><b>For: Hock Lim &amp; Test Test</b></span></li>-->
                                        </ul>                                          
                                    </td>
                                    <td class="item-code">{{ $orderProduct->product_code }}</td>
                                    <td class="item-price-col"><span class="item-price-special">RM {{ $orderProduct->amount }}</span></td>
                                    <td>{{ $orderProduct->quantity }}</td>
                                    <td class="item-total-col"><span class="item-price-special">RM {{ $orderProduct->quantity * $orderProduct->amount }}</span></td>
                                </tr>
                                <?php
									$subtotal += $orderProduct->quantity * $orderProduct->amount;
									$shipping += $orderProduct->shipping_amount;
								?>
                                @endForeach
                                
                                <tr>
                                    <td class="checkout-table-title" colspan="4">Subtotal:</td>
                                    <td class="checkout-table-price">RM {{ $subtotal }}</td>
                                </tr>
                                <tr>
                                    <td class="checkout-table-title" colspan="4">Shipping:</td>
                                    <td class="checkout-table-price">RM {{ $shipping }}</td>
                                </tr>
                                <tr>
                                    <td class="checkout-table-title text-red" colspan="4">Discount:</td>
                                    <td class="checkout-table-price text-red">- RM <?php echo $userOrderDetails[0]->discount;?></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="checkout-total-title" colspan="4"><b>TOTAL:</b></td>
                                    <td class="checkout-total-price cart-total">RM <?php echo $userOrderDetails[0]->totalPrice;?></td>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="md-margin"></div>
                    </div>
                                </div>
                                <!-- end order details -->
                                
                                
                                <div class="md-margin"></div>
                                
                                <a href="javascript:window.history.back();" class="btn btn-custom"><i class="fa fa-angle-double-left"></i> BACK</a>
                                

                        
                       
                    </div>
                    <!-- end col-md-12 -->
                    
            	</div>
                
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
