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
                            <h2>My Order History</h2>
                            <span class="small-bottom-border big"></span>
                            <p>Here are the orders you've placed since your account was created.</p>
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
                                   @if(Session::has('success'))
                                   		<div class="alert alert-success">
                                            <div class="alert-box success">
                                                <p>{{ Session::get('success') }}</p>
                                            </div>
                                        </div>
                                    @endif
                                <div class="row">
                        	
                                    
                            
   								<div class="category-toolbar clearfix">
                                	<div class="toolbox-pagination clearfix">
                                    	<?php 
											if(isset($countOrders) and $countOrders!=''){ 
												$totalPage = ceil($countOrders/$item);
											}else{
												$totalPage=0;	
											}
											
											$howMany = 2;
											  
										?>
                                        <ul class="pagination">
                                        	<?php if($page>1 and $totalPage>1){?>
                                        		<li><a href="<?= url('orderhistory/'.$sort.'/'.($page-1), $parameters = [], $secure = null); ?>"><i class="fa fa-angle-left"></i></a></li>
                                            <?php }?>
                                            
                                            <?php if ($page > $howMany + 1): ?>
                                                <li><a href="<?= url('orderhistory/'.$sort.'/'.($page-1), $parameters = [], $secure = null); ?>">...</a></li>
                                            <?php endif; ?>
                                        
                                            <?php for ($pageIndex = $page - $howMany; $pageIndex <= $page + $howMany; $pageIndex++):  if($pageIndex==$page){ $active='active';}else{ $active='';}?>
                                                <?php if ($pageIndex >= 1 && $pageIndex <= $totalPage): ?>
                                                    <li class="<?php echo $active;?>">
                                                        <a href="<?= url('orderhistory/'.$sort.'/'.$pageIndex, $parameters = [], $secure = null); ?>"><?php echo $pageIndex?></a>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                        
                                            <?php if ($page < $totalPage - $howMany): ?>
                                                <li><a href="<?= url('orderhistory/'.$sort.'/'.($page+1), $parameters = [], $secure = null); ?>">...</a></li>
                                            <?php endif; ?>
    
                                            <?php if($totalPage>1 and $page<$totalPage){?>
                                        		<li><a href="<?= url('orderhistory/' .$sort.'/'.($page+1), $parameters = [], $secure = null); ?>"><i class="fa fa-angle-right"></i></a></li>
                                            <?php }?>
                                        </ul>
                                        <div class="view-count-box"><span class="separator">View orders:</span>
                                            <div class="btn-group select-dropdown">
                                                <button type="button" class="btn select-btn">
                                                	<?php 
                                                        if($sort == '3months'){
                                                            echo 'Last 3 months';
                                                        }else if($sort == '6months'){
                                                            echo 'Last 6 months';
                                                        }else if($sort == '1year'){
                                                            echo 'Last 1 year';
                                                        }else if($sort == 'all'){
                                                            echo 'All';
                                                        }else{
                                                            echo 'Last 7 days';
                                                        }
                                                    ?>
                                                </button>
                                                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown"><i class="fa fa-angle-down"></i>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li><a href="<?= url('orderhistory/7days/'.$page, $parameters = [], $secure = null); ?>">Last 7 days</a></li>
                                                    <li><a href="<?= url('orderhistory/3months/'.$page, $parameters = [], $secure = null); ?>">Last 3 months</a></li>
                                                    <li><a href="<?= url('orderhistory/6months/'.$page, $parameters = [], $secure = null); ?>">Last 6 months</a></li>
                                                    <li><a href="<?= url('orderhistory/1year/'.$page, $parameters = [], $secure = null); ?>">Last 1 year</a></li>
                                                    <li><a href="<?= url('orderhistory/all/'.$page, $parameters = [], $secure = null); ?>">All</a></li>
                                                </ul>
                                                <!--<span class="separator">&nbsp; per page</span>-->
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <!-- end category toolbar -->
                                <div class="md-margin"></div>
                                <?php  if(count($userOrders)>0){?>
                                    <table class="table cart-table">
                                        <thead>
                                            <tr>
                                                <th class="table-title"><a href="#sort by order ID">Order ID</a></th>
                                                <th class="table-title"><a href="#sort by date">Order Date</a></th>
                                                <th class="table-title"><a href="#sort by order total">Total</a></th>
                                                <th class="table-title"><a href="#sort by payment">Payment</a></th>
                                                <th class="table-title"><a href="#sort by order status">Order Status</a></th>
                                                <th class="table-title"><a href="#sort by payment status">Payment Status</a></th>
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
                                            	<td><span class="highlight orange-color text-12px">NEW ORDER</span></td>
                                            	<td>
													<?php $color=''; if(strtolower($order->status)=='paid' || strtolower($order->status)=='processing'){ $color = 'first-color';}?>
                                                    <?php if(strtolower($order->status)=='fail'){ $color = 'black-color';}?>
                                                	<span class="highlight <?php echo $color;?> text-12px"><?php echo strtoupper($order->status);?></span>
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
                                <!-- end order history list -->
                                
                                <div class="pagination-container clearfix">
                                    <div class="pull-right">
                                        <ul class="pagination">
                                        	<?php if($page>1 and $totalPage>1){?>
                                        		<li><a href="<?= url('orderhistory/'.$sort.'/'.($page-1), $parameters = [], $secure = null); ?>"><i class="fa fa-angle-left"></i></a></li>
                                            <?php }?>
                                            
                                            <?php if ($page > $howMany + 1): ?>
                                                <li><a href="<?= url('orderhistory/'.$sort.'/'.($page-1), $parameters = [], $secure = null); ?>">...</a></li>
                                            <?php endif; ?>
                                        
                                            <?php for ($pageIndex = $page - $howMany; $pageIndex <= $page + $howMany; $pageIndex++):  if($pageIndex==$page){ $active='active';}else{ $active='';}?>
                                                <?php if ($pageIndex >= 1 && $pageIndex <= $totalPage): ?>
                                                    <li class="<?php echo $active;?>">
                                                        <a href="<?= url('orderhistory/'.$sort.'/'.$pageIndex, $parameters = [], $secure = null); ?>"><?php echo $pageIndex?></a>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                        
                                            <?php if ($page < $totalPage - $howMany): ?>
                                                <li><a href="<?= url('orderhistory/'.$sort.'/'.($page+1), $parameters = [], $secure = null); ?>">...</a></li>
                                            <?php endif; ?>
    
                                            <?php if($totalPage>1 and $page<$totalPage){?>
                                        		<li><a href="<?= url('orderhistory/' .$sort.'/'.($page+1), $parameters = [], $secure = null); ?>"><i class="fa fa-angle-right"></i></a></li>
                                            <?php }?>
                                        </ul>
                                    </div>
                                    <div class="view-count-box"><span class="separator">View orders:</span>
                                            <div class="btn-group select-dropdown">
                                                <button type="button" class="btn select-btn">
                                                	<?php 
                                                        if($sort == '3months'){
                                                            echo 'Last 3 months';
                                                        }else if($sort == '6months'){
                                                            echo 'Last 6 months';
                                                        }else if($sort == '1year'){
                                                            echo 'Last 1 year';
                                                        }else if($sort == 'all'){
                                                            echo 'All';
                                                        }else{
                                                            echo 'Last 7 days';
                                                        }
                                                    ?>
                                                </button>
                                                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown"><i class="fa fa-angle-down"></i>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li><a href="<?= url('orderhistory/7days/'.$page, $parameters = [], $secure = null); ?>">Last 7 days</a></li>
                                                    <li><a href="<?= url('orderhistory/3months/'.$page, $parameters = [], $secure = null); ?>">Last 3 months</a></li>
                                                    <li><a href="<?= url('orderhistory/6months/'.$page, $parameters = [], $secure = null); ?>">Last 6 months</a></li>
                                                    <li><a href="<?= url('orderhistory/1year/'.$page, $parameters = [], $secure = null); ?>">Last 1 year</a></li>
                                                    <li><a href="<?= url('orderhistory/all/'.$page, $parameters = [], $secure = null); ?>">All</a></li>
                                                </ul>
                                                <!--<span class="separator">&nbsp; per page</span>-->
                                            </div>
                                        </div>
                                </div>
                                <!-- end pagination container -->
                                <div class="md-margin"></div>
                                
                                <a href="javascript:window.history.back();" class="btn btn-custom"><i class="fa fa-angle-double-left"></i> BACK</a>
                                
                                
                            <!-- end col-md-9 -->
                            
                        	</div> 
                                
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
