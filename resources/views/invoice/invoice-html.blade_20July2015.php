<div style="padding:0px; margin:0px;">
    <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" style="padding:10px; background:#fff;">
        <tr>
            <td width="550" align="left" valign="top"><img src="{{ asset('/public/front/images/index/logo.jpg') }}" /></td>
            <td width="450" align="right" valign="top" style="border-bottom:1px solid #ccc; padding:10px 0 20px; text-align:right;">
                <strong>TAN BOON MING SDN BHD</strong> (494355-D) <br />
                PS 4,5,6 & 7, Taman Evergreen, Batu 4, <br />Jalan Klang Lama, 58100 Kuala Lumpur.<br />
                Tel: (603) 7983-2020 (Hunting Lines)<br />
                Fax: (603) 7982-8141<br />
                info@tbm.com.my<br />
                Business Hours:<br />
                Mon. - Sat.: 9.30am - 9.00pm<br />
                Sun.: 10.00am - 9.00pm<br />
            </td>
        </tr>
        <tr>
            <td width="550" align="left" valign="top" style="border-bottom:1px solid #ccc; padding:10px 0 20px;"><h2 style="padding:0px; margin:0px; color:#444645; font-size:32px;">Invoice</h2></td>
            <td width="450" align="right" valign="top" style="border-bottom:1px solid #ccc; padding:10px 0 20px;"><h2 style="padding:0px; margin:0px; color:#444645; font-size:32px;">Order #{{ $order->order_id }}</h2></td>
        </tr>
        <tr>
        	<td colspan="2" align="left" valign="top">&nbsp;</td>
        </tr>
        <tr>
        	<td align="left" valign="top" style="color:#646464; font-size:20px; padding:5px 0; margin:0px;"><strong>Billed To:</strong></td>
        	<td align="right" valign="top" style="color:#646464; font-size:20px; padding:5px 0; margin:0px;"><strong>Shipped To:</strong></td>
        </tr>
        <tr>
        	<td align="left" valign="top" style="color:#646464; font-size:14px; padding:3px 0; margin:0px;">{{ $order->billing_first_name . ' ' . $order->billing_last_name }}</td>
        	<td align="right" valign="top" style="color:#646464; font-size:14px; padding:3px 0; margin:0px;">{{ $order->shipping_first_name . ' ' . $order->shipping_last_name }}</td>
        </tr>
        <tr>
        	<td align="left" valign="top" style="color:#646464; font-size:14px; padding:3px 0; margin:0px;">{{ $order->billing_address }},<br/> {{ $order->billing_post_code }} {{ $order->billing_city }}, <br/>{{ $order->billing_state_name }}, {{ $order->billing_country_name }}.</td>
        	<td align="right" valign="top" style="color:#646464; font-size:14px; padding:3px 0; margin:0px;">{{ $order->shipping_address }},<br/> {{ $order->shipping_post_code }} {{ $order->shipping_city }}, <br/>{{ $order->shipping_state_name }}, {{ $order->shipping_country_name }}.</td>
        </tr>
        <tr>
        	<td align="left" valign="top">&nbsp;</td>
        	<td align="right" valign="top">&nbsp;</td>
        </tr>
        <tr>
        	<td align="left" valign="top" style="color:#646464; font-size:20px; padding:5px 0; margin:0px;"><strong>Payment Status:</strong></td>
        	<td align="right" valign="top" style="color:#646464; font-size:20px; padding:5px 0; margin:0px;"><strong>Order Status:</strong></td>
        </tr>
        <tr>
        	<td align="left" valign="top" style="color:#646464; font-size:14px; padding:3px 0; margin:0px;">{{ $order->status }}</td>
        	<td align="right" valign="top" style="color:#646464; font-size:14px; padding:3px 0; margin:0px;">{{ $order->payment_status }}</td>
        </tr>
        
        <tr>
        	<td align="left" valign="top" style="color:#646464; font-size:20px; padding:5px 0; margin:0px;"><strong>Payment Method:</strong></td>
        	<td align="right" valign="top" style="color:#646464; font-size:20px; padding:5px 0; margin:0px;"><strong>Order Date:</strong></td>
        </tr>
        <tr>
        	<td align="left" valign="top" style="color:#646464; font-size:14px; padding:3px 0; margin:0px;">{{ $order->payment_method }}</td>
        	<td align="right" valign="top" style="color:#646464; font-size:14px; padding:3px 0; margin:0px;">{{ date('dS M, Y', strtotime($order->createdate)) }}</td>
        </tr>
        <tr>
        	<td align="left" valign="top" style="color:#646464; font-size:14px; padding:3px 0; margin:0px;">{{ $order->billing_email }}</td>
        	<td align="right" valign="top" style="color:#646464; font-size:14px; padding:3px 0; margin:0px;">&nbsp;</td>
        </tr>
        <tr>
        	<td colspan="2" align="left" valign="top" style=" padding:0px 0 20px; margin:0 0 0px;"><h2 style="border-bottom:1px dashed #ccc; padding:10px 0; margin:0px; color:#444645; font-size:22px;">Order summary</h2></td>
        </tr>
        <tr>
            <td align="left" valign="top" style="color:#403e3d; font-size:16px; padding:0 0 10px;"><strong>Item</strong></td>
            <td align="right" valign="top">
            	<table width="450" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="180" align="center" valign="top" style="color:#403e3d; font-size:16px;"><strong>Product Code</strong></td>
                        <td width="97" align="center" valign="top" style="color:#403e3d; font-size:16px;"><strong>Price</strong></td>
                        <td width="99" align="center" valign="top" style="color:#403e3d; font-size:16px;"><strong>Quantity</strong></td>
                        <td width="74" align="right" valign="top" style="color:#403e3d; font-size:16px;"><strong>Totals</strong></td>
                    </tr>
                </table>
            </td>
        </tr>
        
         <?php 
        $subtotal = 0;
        $shipping = 0;
        ?>
        @foreach($order_to_products as $orderProduct)
            <tr>
                <td align="left" valign="top" style="color:#403e3d; font-size:15px; border-top:1px solid #ccc; padding:5px 0 0;">{{ $orderProduct->product_name }} </td>
                <td align="right" valign="top">
                    <table width="450" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="180" align="center" valign="top" style="color:#403e3d; font-size:15px; border-top:1px solid #ccc; padding:5px 0 0;">{{ $orderProduct->product_code }}</td>
                            <td width="98" align="center" valign="top" style="color:#403e3d; font-size:15px; border-top:1px solid #ccc; padding:5px 0 0;">RM {{ number_format($orderProduct->amount, 2) }}</td>
                            <td width="98" align="center" valign="top" style="color:#403e3d; font-size:15px; border-top:1px solid #ccc; padding:5px 0 0;">{{ $orderProduct->quantity }}</td>
                            <td width="74" align="right" valign="top" style="color:#403e3d; font-size:15px; border-top:1px solid #ccc; padding:5px 0 0;">RM {{ number_format(($orderProduct->quantity * $orderProduct->amount), 2) }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            @if($orderProduct->color_name)
            	<tr>
	                <td align="left" valign="top" style="color:#403e3d; font-size:15px; padding:5px 0 0;">Color: {{ $orderProduct->color_name }}</td>
    	            <td align="right" valign="top">&nbsp;</td>
                </tr>
            @endif
            <?php
                $subtotal += $orderProduct->quantity * $orderProduct->amount;
                $shipping += $orderProduct->shipping_amount;
            ?>
            @if($orderProduct->event_type)
                <tr>
                    <td align="left" valign="top" style="color:#d72d1a ; font-size:15px; padding:5px 0 5px;"><strong><img src="{{ asset('/public/images/gift.png') }}" style="padding:3px 5px 0 0; float:left;" />For: {{ $orderProduct->event_type }}</strong></td>
                    <td align="right" valign="top">&nbsp;</td>
                </tr>
            @endif
        @endforeach
        
        <tr>
			<td colspan="2" align="left" valign="top">
            	<table width="1000" border="0" cellspacing="0" cellpadding="0" style="border-top:2px solid #666; padding:10px 0 0; margin:10px 0 0;">
                    <tr>
                	    <td width="860" align="right" valign="top" style="color:#403e3d; font-size:16px; padding:0 0 10px;"><strong>Subtotal</strong></td>
                    	<td width="140" align="right" valign="top" style="color:#403e3d; font-size:16px; padding:0 0 10px;">RM {{ number_format($subtotal, 2) }}</td>
                    </tr>
                    <tr>
                   		<td align="right" valign="top" style="color:#403e3d; font-size:16px; padding:0 0 10px;"><strong>Shipping</strong></td>
                    	<td align="right" valign="top" style="color:#403e3d; font-size:16px; padding:0 0 10px;">RM {{ number_format($shipping, 2) }}</td>
                    </tr>
                    <tr>
                    	<td align="right" valign="top" style="color:#d72d1a ; font-size:15px; padding:0px 0 10px;"><strong>Discount</strong></td>
                    	<td align="right" valign="top" style="color:#d72d1a ; font-size:15px; padding:0px 0 10px;">- RM {{ number_format($order->discount, 2) }}</td>
                    </tr>
                    <tr>
                    	<td align="right" valign="top" style="color:#403e3d; font-size:16px; padding:0 0 10px;"><strong>Total</strong></td>
                    	<td align="right" valign="top" style="color:#403e3d; font-size:16px; padding:0 0 10px;">RM {{ number_format($order->totalPrice, 2) }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>