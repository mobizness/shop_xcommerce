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
<?php
	$ordersModel = new App\Http\Models\Admin\Orders();
	$orderTax = $ordersModel->getOrderTax($order->id);
//dd($order, $orderTax);
?>
                                            	<td>RM <?php echo str_replace('.', '.<span class="sub-price">', number_format($orderTax->total + $orderTax->shipping_charge*1.06, 2)) . '</span>';?></td>
                                            	<td><?php echo $order->payment_method;?></td>
                                            	<td>
                                                	@if($order->status == 'Processing')
	                                                    <span class="highlight fourth-color text-12px">Processing</span>
                                                    @elseif($order->status == 'New Order')
    	                                                <span class="highlight orange-color text-12px">New Order</span>
                                                    @elseif($order->status == 'Ready To Ship')
        	                                            <span class="highlight fourth-color text-12px">Ready To Ship</span>
                                                    @elseif($order->status == 'Shipped')
            	                                        <span class="highlight blue-color text-12px">Shipped</span>
                                                    @elseif($order->status == 'Completed')
                	                                    <span class="highlight first-color text-12px">Completed</span>
                                                    @elseif($order->status == 'Declined')
                    	                                <span class="highlight third-color text-12px">Declined</span>
                                                    @elseif($order->status == 'Cancelled')
                        	                            <span class="highlight black-color text-12px">Cancelled</span>
                                                    @endif
                                                </td>
                                            	<td>
													@if($order->payment_status == 'Paid')
	                                                    <span class="highlight first-color text-12px">Paid</span>
                                                    @elseif($order->status == 'Processing')
    	                                                <span class="highlight fourth-color text-12px">Processing</span>
                                                    @elseif($order->payment_status == 'Payment Error')
        	                                            <span class="highlight third-color text-12px">Payment Error</span>
                                                    @elseif($order->payment_status == 'Cancelled')
            	                                        <span class="highlight black-color text-12px">Cancelled</span>
                                                    @endif
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

<?php
	// Brands & Services are done in the templateFront.blade.php
	if(isset($brands_scroller)) unset($brands_scroller);
?>

@endsection
