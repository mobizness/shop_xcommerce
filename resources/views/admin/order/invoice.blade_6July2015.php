@extends('adminLayout')
@section('content')
<div id="page-wrapper">
    <div class="page-header-breadcrumb">
    	<div class="page-heading hidden-xs">
		    <h1 class="page-title">Orders</h1>
	    </div>
    
        <ol class="breadcrumb page-breadcrumb">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('web88cms/dashboard') }}">Dashboard</a>&nbsp; <i class="fa fa-angle-right"></i>&nbsp;</li>
            <li>Orders &nbsp;<i class="fa fa-angle-right"></i>&nbsp;</li>
            <li><a href="{{ url('web88cms/orders') }}">Orders Listing</a> &nbsp;<i class="fa fa-angle-right"></i>&nbsp;</li>
            <li><a href="{{ url('web88cms/orders/detail/' . $order->id) }}">Order Details</a>&nbsp; <i class="fa fa-angle-right"></i>&nbsp;</li>
            <li class="active">Invoice</li>
        </ol>

        <div class="page-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <div class="invoice-title">
                            	<h2>Invoice</h2>
	                            <h3 class="pull-right">Order #{{ $order->order_id }}</h3>
                            </div>
                        	<hr/>
                            <div class="row">
                            	<div class="col-md-6">
		                            <address><strong>Billed To:</strong><br/>{{ $order->billing_first_name . ' ' . $order->billing_last_name }}<br/>{{ $order->billing_address }},<br/> {{ $order->billing_post_code }} {{ $order->billing_city }}, <br/>{{ $order->billing_state_name }}, {{ $order->billing_country_name }}.</address>
	                            </div>
	                            <div class="col-md-6 text-right">
		                            <address><strong>Shipped To:</strong><br/>{{ $order->shipping_first_name . ' ' . $order->shipping_last_name }}<br/>{{ $order->shipping_address }},<br/> {{ $order->shipping_post_code }} {{ $order->shipping_city }}, <br/>{{ $order->shipping_state_name }}, {{ $order->shipping_country_name }}.</address>
	                            </div>
                            </div>
                            <div class="row">
	                            <div class="col-md-6">
		                            <address><strong>Payment Method:</strong><br/>{{ $order->payment_method }}<br/>{{ $order->billing_email }}</address>
	                            </div>
    	                        <div class="col-md-6 text-right">
        		                    <address><strong>Order Date:</strong><br/>{{ date('dS M, Y', strtotime($order->createdate)) }}<br/><br/></address>
                	            </div>
                            </div>
                            	                
                            <h4 class="block-heading">Order summary</h4>
                            <div class="table-responsive">
                                <table class="table table-condensed">
                                    <thead>
                                    	<tr>
                                            <td><strong>Item</strong></td>
                                            <td><strong>Product Code</strong></td>
                                            <td class="text-center"><strong>Price</strong></td>
                                            <td class="text-center"><strong>Quantity</strong></td>
                                            <td class="text-right"><strong>Totals</strong></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<?php 
										$subtotal = 0;
										$shipping = 0;
										?>
                                    	@foreach($order_to_products as $orderProduct)
                                            <tr>
                                                <td>{{ $orderProduct->product_name }}
	                                                <ul>
                                                        @if($orderProduct->color_name)
                                                        	<li>Color: {{ $orderProduct->color_name }}</li>
                                                        @endif
            		                                    @if($orderProduct->event_type)
                                                          <li><i class="fa fa-gift text-red"></i> <span class="text-red"><b>For: {{ $orderProduct->event_type }}</b></span></li>
                                                      @endif
	                                                </ul>
                                                </td>
                                                <td>{{ $orderProduct->product_code }}</td>
                                                <td class="text-center">RM {{ number_format($orderProduct->amount, 2) }}</td>
                                                <td class="text-center">{{ $orderProduct->quantity }}</td>
                                                <td class="text-right">RM {{ number_format(($orderProduct->quantity * $orderProduct->amount), 2) }}</td>
                                            </tr>
                                            <?php
												$subtotal += $orderProduct->quantity * $orderProduct->amount;
												$shipping += $orderProduct->shipping_amount;
											?>
                                        @endforeach
                                        <tr>
                                            <td class="thick-line"></td>
                                            <td class="thick-line"></td>
                                            <td class="thick-line"></td>
                                            <td class="thick-line text-center"><strong>Subtotal</strong></td>
                                            <td class="thick-line text-right">RM {{ number_format($subtotal, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="no-line"></td>
                                            <td class="no-line"></td>
                                            <td class="no-line"></td>
                                            <td class="no-line text-center"><strong>Shipping</strong></td>
                                            <td class="no-line text-right">RM {{ number_format($shipping, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="no-line"></td>
                                            <td class="no-line"></td>
                                            <td class="no-line"></td>
                                            <td class="no-line text-center text-red"><strong>Discount</strong></td>
                                            <td class="no-line text-right text-red">- RM {{ number_format($order->discount, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="no-line"></td>
                                            <td class="no-line"></td>
                                            <td class="no-line"></td>
                                            <td class="no-line text-center"><strong>Total</strong></td>
                                            <td class="no-line text-right">RM {{ number_format($order->totalPrice, 2) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
   	                    	<div class="clearfix"></div>
                        	<div class="form-actions text-center"> 
                        		<a href="{{ url('web88cms/orders/detail/' . $order->id) }}" class="btn btn-dark"><i class="fa fa-angle-double-left"></i> &nbsp;Back</a>
	                        </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="page-footer">
        <div class="copyright"><span class="text-15px">2015 © <a href="http://www.webqom.com" target="_blank">Webqom Technologies Sdn Bhd.</a> Any queries, please contact <a href="mailto:support@webqom.com">Webqom Support</a>.</span>
        <div class="pull-right"><img src="{{ asset('/public/admin/images/logo_webqom.png') }}" alt="Webqom Technologies Sdn Bhd"></div>
        </div>
        </div>
	</div>
</div>
@endsection