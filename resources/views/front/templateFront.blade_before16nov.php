<?php 
use App\Http\Models\Front\Categories;
$CategoriesModel  = new Categories();
$categories = $CategoriesModel->getCategories();

$footer_categories = $CategoriesModel->getParentCategories();

if(!isset($page_title)){
	$page_title = 'Home';
}
?>
<!DOCTYPE html>
<!--[if IE 8]><html class="ie8"><![endif]-->
<!--[if IE 9]><html class="ie9"><![endif]-->
<!--[if !IE]><!-->
<html>
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <title>{{ $page_title }}</title>
    <meta name="description" content="Your Friendly Electrical Appliances Store">
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge"><![endif]-->
    <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta Http-Equiv="Cache-Control" Content="no-cache">
    <meta Http-Equiv="Pragma" Content="no-cache">
    <meta Http-Equiv="Expires" Content="0">
    <link href="//fonts.googleapis.com/css?family=PT+Sans:400,700,400italic,700italic%7CPT+Gudea:400,700,400italic%7CPT+Oswald:400,700,300" rel="stylesheet" id="googlefont">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,500,500italic,700,700italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,300italic,300,400italic,700,700italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{ asset('/public/front/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/front/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/front/css/prettyPhoto.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/front/css/colpick.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/front/css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/front/css/revslider.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/front/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/front/css/responsive.css') }}">
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script src="{{ asset('/public/front/js/jquery.min.js') }}"></script>
    <script>
        window.jQuery || document.write("<script src=\"{{ asset('/public/front/js/jquery-1.11.1.min.js') }}\"><\/script>");
    </script>
    <!--[if lt IE 9]><script src="{{ asset('/public/front/js/html5shiv.js') }}"></script>
            <script src="{{ asset('/public/front/js/respond.min.js') }}"></script><![endif]-->
	<script type="text/javascript">
		function addToCompare(product_id){
			$.ajax({
				url: '{{ url("/compare/addToCompare") }}',
				type: 'post',
				dataType: 'json',
				data: {product_id: product_id, _token: '{{ csrf_token() }}'},
				beforeSend:function(){
					
				},
				complete:function(){
					
				},
				success:function(response){
					if(response['success']){
						var html = '';
						html += '<div class="alert alert-success">';
							html += '<i class="fa fa-check-circle"></i>';
							html += ' &nbsp;' + response['success'] + '';
						html += '</div>';
						
						$('#content > .container').prepend(html);
						setTimeout(function(){
							$('.alert-success').remove();
						},5000);
					}
					
					if(response['warning']){
						var html = '';
						html += '<div class="alert alert-danger">';
							html += '<i class="fa fa-exclamation-triangle"></i>';
							html += ' &nbsp;' + response['warning'] + '';
						html += '</div>';
						
						$('#content > .container').prepend(html);
						setTimeout(function(){
							$('.alert-danger').remove();
						},5000);
					}
				}
			});
		}
	</script>
</head>

<body>
    
    <div id="wrapper">
        <header id="header" class="header3">
            <div id="header-top">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="header-top-left">
                                <ul id="top-links" class="clearfix">
                                    <li><a href="{{ url('accountedit') }}" title="My Account"> <i class="fa fa-user"></i> <span class="hide-for-xs">My Account</span></a></li>
                                    <li>
                                    
                                    <?php 
									// check if user is logged in
									if(Session::has('userId'))
										echo '<a href="'.url('/wishlist').'" title="My Wishlist"> <i class="fa fa-heart"></i> <span class="hide-for-xs">My Wishlist</span></a>';
									else
										echo '<a href="#" data-toggle="modal" data-target="#login_model" data-placement="top" title="My Wishlist"> <i class="fa fa-heart"></i> <span class="hide-for-xs">My Wishlist</span></a>';
									?>
                                    
                                    </li>
                                    <li>
                                    <?php 
									// check if user is logged in
									if(Session::has('userId'))
										echo '<a href="'.url('/events').'" title="My Special List"> <i class="fa fa-edit"></i> <span class="hide-for-xs">My Special List</span></a>';
									else
										echo '<a href="#" data-toggle="modal" data-target="#login_model" data-placement="top" title="My Special List"> <i class="fa fa-edit"></i> <span class="hide-for-xs">My Special List</span></a>';
									?>
                                    </li>
                                    <li><a href="{{ url('/compare') }}" title="Compare List"> <i class="fa fa-bars"></i> <span class="hide-for-xs">Compare List</span></a></li>
                                    
                                    <li><a href="{{ url('/cart') }}" title="My Cart"><i class="fa fa-shopping-cart"></i> <span class="hide-for-xs">My Cart</span></a></li>
                                    <li><a href="{{ url('/checkout') }}" title="Checkout"><i class="fa fa-sign-out"></i> <span class="hide-for-xs">Checkout</span></a></li>
                                </ul>
                            </div>
                            <div class="header-top-right">
                                <div class="header-text-container pull-right">
                                	<?php if(Session::get('userId')!='' and Session::get('userEmail')!=''){?>
                                    	<p class="header-link">Hello, {{ Session::get('userFirstName') }} {{ Session::get('userLastName') }}&nbsp;&nbsp;<a href="{{ url('logout') }}">Logout</a></p>
                                    <?php }else{ ?>
                                    	<p class="header-link"><a href="{{ url('login') }}">login</a>&nbsp;or&nbsp;<a href="{{ url('create_account') }}">create an account</a></p>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                  </div>
                </div>
            </div>
            <div id="inner-header">
                <div class="container">
                    <div class="row">
                        <div class="col-md-5 col-sm-5 col-xs-12 logo-container">
                            <h1 class="logo clearfix"><span>Your Friendly Electrical Appliances Store:: Tan Boon Ming Sdn Bhd</span> <a href="{{ url('/') }}" title="Your Friendly Electrical Appliances Store:: Tan Boon Ming Sdn Bhd"><img src="{{ asset('/public/front/images/index/logo.jpg') }}" alt="Your Friendly Electrical Appliances Store:: Tan Boon Ming Sdn Bhd" width="196" height="83"></a></h1>
                        </div>
                  <div class="col-md-7 col-sm-7 col-xs-12 header-inner-right">
                            <div class="header-inner-right-wrapper clearfix">

                                @include('front/cart/cart_header')
                                <div id="quick-access">
                                    <form class="form-inline quick-search-form" role="form" action="{{ url('/saveSearchTerm') }}" method="get">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="keyword" placeholder="Search here" value="{{ Input::get('keyword') }}">
                                        </div>
                                        <button type="submit" id="quick-search" class="btn btn-custom"></button>
                                    </form>
                                </div>
                                
                            </div>
                            
                            <p class="quick-contact-text">CUSTOMER SERVICE: +(603) 7983-2020</p>
                      </div>
                  </div>
                </div>
                <div id="main-nav-container">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 clearfix">
                                <nav id="main-nav">
                                    <div id="responsive-nav">
                                        <div id="responsive-nav-button">Menu <span id="responsive-nav-button-icon"></span>                                        </div>
                                    </div>
                                    <ul class="menu clearfix">
                                        <li><a class="active" href="<?= url('/', $parameters = [], $secure = null); ?>">
                                            <span class="hide-for-xs">
                                            	<img src="{{ asset('/public/front/images/home-icon.png') }}" alt="home icon">
                                            </span> <span class="hide-for-lg">Home</span>
                                        </a></li>
                                        
                                        <?php $count = 1; ?>
                                        @foreach($categories as $category)
                                            <li class="mega-menu-container">
                                                <a href="{{ url('products/' . $category['category_id'].'/new/') }}">{{ $category['title'] }}</a>
	                                            @if($category['sub_categories'])
                                                	@if($count > 1)
                                                    	@if($category['image'])
															<div class="mega-menu clearfix" style="background-image: url({{ asset('/public/images/category/' . $category['image']) }}); background-position: 100% 100%; background-repeat: no-repeat; position: absolute; ">
                                                        @else
                                                        	<div class="col-2 mega-menu clearfix">
														@endif
													@else
														<div class="col-2 mega-menu clearfix">
														
														@if($category['image'])
															<div class="col-4">
																<a href="{{ url('products/' . $category['category_id'] . '/new/') }}">
																	<img src="{{ asset('/public/images/category/' . $category['image']) }}" class="img-responsive" alt="{{ $category['alt_text'] }}" />
																</a>
															</div>
														@endif
														@if($category['image2'])
															<div class="col-4">
																<a href="{{ url('products/' . $category['category_id'] . '/new/') }} ">
																	<img src="{{ asset('/public/images/category/' . $category['image2']) }}" class="img-responsive" alt="{{ $category['alt_text2'] }}" />
																</a>
															</div>
														@endif
													@endif
                                                	
                                                        @foreach($category['sub_categories'] as $sub_categories)
                                                        <div class="col-5">
                                                            <a href="{{ url('products/' . $sub_categories['category_id'].'/new/') }}" class="mega-menu-title">{{ $sub_categories['title'] }}</a>
                                                            @if($sub_categories['sub_categories'])
                                                            <ul class="mega-menu-list clearfix">
                                                                @foreach($sub_categories['sub_categories'] as $lvl3_categories)
                                                                    <li><a href="{{ url('products/' . $lvl3_categories['category_id'].'/new/') }}">{{ $lvl3_categories['title'] }}</a></li>
                                                                @endforeach
                                                            </ul>
                                                            @endif
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </li>
                                        	<?php $count++; ?>
										@endforeach
                                    </ul>
                                </nav>
                               
                            </div>
                      </div>
                    </div>
                </div>
            </div>
        </header>
        
        @yield('content')
    <footer id="footer">

        <div id="inner-footer">
            <div class="container">
                <div class="row">
                
               <?php 
				
				
				if(count($footer_categories) > 0)
				{
				?>
                
                    <div class="col-md-3 col-sm-4 col-xs-12 widget">
                        <h3>Categories</h3>
                        <ul class="links">
                        <?php
						foreach($footer_categories as $category)
						{
							echo '<li><a href="'.url('/products/'.$category->id.'/new').'">'.$category->title.'</a></li>';
						}
						?>                           
                        </ul>
                    </div>
                  <?php
				} // end if
				?>
              		<div class="col-md-3 col-sm-4 col-xs-12 widget">
                        <h3>About TBM</h3>
                        <ul class="links">
                            <li><a href="about_us.html">About us</a></li>
                            <li><a href="careers.html">Careers</a></li>
                            <li><a href="services.html">Our services</a></li>
                            <li><a href="our_stores.html">Our stores</a></li>
                            <li><a href="contact_us.html">Contact us</a></li>
                        </ul>
                    </div>
              		<div class="col-md-3 col-sm-4 col-xs-12 widget">
                        <h3>Contact Us</h3>
                        <ul class="contact-list">
                            <li><strong>TAN BOON MING SDN BHD</strong> (494355-D)</li>
                            <li>PS 4,5,6 &amp; 7, Taman Evergreen, Batu 4, Jalan Klang Lama, 58100 Kuala Lumpur.</li>
                            <li><i class="fa fa-phone"></i> Tel: (603) 7983-2020 (Hunting Lines)</li>
                            <li><i class="fa fa-fax"></i> Fax: (603) 7982-8141</li>
                            <li><i class="fa fa-envelope"></i> <a href="mailto:info@tbm.com.my">info@tbm.com.my</a></li>
                            <li><i class="fa fa-history"></i> Business Hours: </li>
                            <li>Mon. - Sat.: 9.30am - 9.00pm</li>
                            <li>Sun.: 10.00am - 9.00pm</li>
                        </ul>
                    </div>
                  <div class="clearfix visible-sm"></div>
                    <div class="col-md-3 col-sm-12 col-xs-12 widget">
                       <div class="md-margin"></div>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3983.986191765057!2d101.676021!3d3.098329!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x4f927fdab737f312!2sTAN+BOON+MING+SDN+BHD!5e0!3m2!1sen!2s!4v1415724613461" width="100%" height="260" frameborder="0" style="border:0"></iframe>
                    </div>
              </div>
            </div>
        </div>
        <div id="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-12 footer-social-links-container">
                        <ul class="social-links clearfix">
                            <li><a href="#" class="social-icon icon-facebook"></a></li>
                            <!--<li><a href="#" class="social-icon icon-twitter"></a></li>-->
                            <li><a href="mailto:info@tbm.com.my" class="social-icon icon-email"></a></li>
                        </ul>
                    </div>
              		<div class="col-md-5 col-sm-7 col-xs-12 footer-text-container pull-left">
                        <p>&copy; 2014 Tan Boon Ming Sdn Bhd (494355-D). All Rights Reserved.<br/>Powered by: <a href="http://www.webqom.com" target="_blank">Webqom Technologies Sdn Bhd.</a> </p>
                    </div>
              </div>
            </div>
        </div>
    </footer>
    </div><a href="#" id="scroll-top" title="Scroll to Top"><i class="fa fa-angle-up"></i></a> 
    <script src="{{ asset('/public/front/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/public/front/js/smoothscroll.js') }}"></script>
    <script src="{{ asset('/public/front/js/jquery.debouncedresize.js') }}"></script>
    <script src="{{ asset('/public/front/js/retina.min.js') }}"></script>
    <script src="{{ asset('/public/front/js/jquery.placeholder.js') }}"></script>
    <script src="{{ asset('/public/front/js/jquery.hoverIntent.min.js') }}"></script>
    <script src="{{ asset('/public/front/js/twitter/jquery.tweet.min.js') }}"></script>
    <script src="{{ asset('/public/front/js/jquery.flexslider-min.js') }}"></script>
    <script src="{{ asset('/public/front/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('/public/front/js/jflickrfeed.min.js') }}"></script>
    <script src="{{ asset('/public/front/js/jquery.prettyPhoto.js') }}"></script>
    <script src="{{ asset('/public/front/js/jquery.themepunch.tools.min.js') }}"></script>
    <script src="{{ asset('/public/front/js/jquery.themepunch.revolution.min.js') }}"></script>
    <script src="{{ asset('/public/front/js/colpick.js') }}"></script>
    <script src="{{ asset('/public/front/js/main.js') }}"></script>

    <script>
        $(function() {
            jQuery("#slider-rev").revolution({
                delay: 5e3,
                startwidth: 870,
                startheight: 520,
                onHoverStop: "true",
                hideThumbs: 250,
                navigationHAlign: "center",
                navigationVAlign: "bottom",
                navigationHOffset: 0,
                navigationVOffset: 15,
                soloArrowLeftHalign: "left",
                soloArrowLeftValign: "center",
                soloArrowLeftHOffset: 0,
                soloArrowLeftVOffset: 0,
                soloArrowRightHalign: "right",
                soloArrowRightValign: "center",
                soloArrowRightHOffset: 0,
                soloArrowRightVOffset: 0,
                touchenabled: "on",
                stopAtSlide: -1,
                stopAfterLoops: -1,
                dottedOverlay: "none",
                fullWidth: "on",
                spinned: "spinner4",
                shadow: 0,
                hideTimerBar: "on"
            });
            var o = function() {
                var o = $(window).width();
                if (767 >= o && $("#slider-rev-container").length) {
                    var e = $("#slider-rev").height();
                    console.log(e), $(".slider-position").css("padding-top", e), $(".main-content").css("position", "static")
                } else $(".slider-position").css("padding-top", 0), $(".main-content").css("position", "relative")
            };
            o(), $.event.special.debouncedresize ? $(window).on("debouncedresize", function() {
                o()
            }) : $(window).on("resize", function() {
                o()
            })
        });
    </script>
    
    <!-- Animation --> 
    <script type="text/javascript" src="{{ asset('/public/front/js/animation/jquery.appear.js') }}"></script>
    <!-- Custom -->
    <script src="{{ asset('/public/front/js/custom.js') }}"></script> 
    
    <!--  move modal start, add to wishlist popup -->
    <?php
	use App\Http\Models\Front\Wishlist;
	$this->WishlistModel = new Wishlist();
	
	if(Session::has('userId'))
	{		
		$user_id = Session::get('userId');
	?>
    <div class="modal fade" id="wishlist_model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
              <form id="login-form-2" method="POST" action="{{ url('/addToWishlist') }}">
              	
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title" id="myModalLabel2">Select List to Add to:</h4>
                            </div><!-- End .modal-header -->
                            <div class="modal-body clearfix">

                                <div class="col-md-2">
                                    <img src="images/digital_gadget/digital_imaging/panasonic_DMC-GX1WGC_big2.jpg" alt="Panasonic DMC-GX1WGC Camera Twin Lense (14MM F2.5 &amp; 14-42MM F3.5-5.6)" class="img-responsive">
                                    
                                    <div id="product_attr"></div>
                                    
                                </div>
                                <div class="col-md-10">
                                
                                <?php
								
								
								$list_wishlist = $this->WishlistModel->getWishlist($user_id);
								
								if(count($list_wishlist) > 0)
								{
								?>                                
                                    <p>Please select the following list to add this item to: </p>
                                    
                                    <?php
									foreach($list_wishlist as $wishlist_details)
									{
									?>
                                    
                                    <div class="custom-checkbox">
                                        <input type="checkbox" class="wishlist_id" name="wishlist_id[]" required value="{{ $wishlist_details->id }}" > <span class="checbox-container"><i class="fa fa-check"></i></span> {{ $wishlist_details->list_name }}
                                    </div>
                                    <?php
									} // end foreach
									?>
                                    <div class="sm-margin"></div>
                                    <p>Or add a new list to add this item to: </p>
                                <?php
									$required = '';
								}
								else
								{
									echo '<p>Add a new list to add this item to: </p>';
									$required = 'required="required"';
								}
								
								?>
                                    <div class="form-group">
                                   <div class="input-group"><span class="input-group-addon"><i class="fa fa-list-alt"></i> <span class="input-text">Name</span></span>
                                       <input type="text" class="form-control input-lg" name="list_name" id="list_name" placeholder="Create a list..." <?php echo $required; ?> >
                                   </div>
                                </div>
                                </div>			

                            </div><!-- End .modal-body -->
                            <div class="modal-footer">
                            	<input type="hidden" name="product_id" id="wishlist_product_id">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit" class="btn btn-custom-2" onClick="validate_wishlist()">SAVE</button>
                                <button type="button" class="btn btn-custom" data-dismiss="modal">CANCEL</button>
                            </div><!-- End .modal-footer -->
                        </div><!-- End .modal-content -->
                    </div><!-- End .modal-dialog -->
                    </form>
                </div>
    
    	<!--  delete list modal start -->
     	<div class="modal fade" id="delete-list" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
          <form id="login-form-2" method="post" action="{{ url('/deleteWishlist') }}">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel2">Delete List</h4>
                        </div><!-- End .modal-header -->
                        <div class="modal-body clearfix">
    
                            <p>Delete list cannot be recovered. Are you sure you want to delete this list?</p>
    
                        </div><!-- End .modal-body -->
                        <div class="modal-footer">
                        	<input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="delete_wishlist_id" id="delete_wishlist_id"  value="">
                            <button type="submit" class="btn btn-custom-2">DELETE</button>
                            <button type="button" class="btn btn-custom" data-dismiss="modal">CANCEL</button>
                        </div><!-- End .modal-footer -->
                    </div><!-- End .modal-content -->
                </div><!-- End .modal-dialog -->
                </form>
            </div><!-- End .modal delete list -->            
    
                
	<script>
    function validate_wishlist()
    {
        if($('#wishlist_model #list_name').val() != '')
        { 
            $('#wishlist_model .wishlist_id').attr('required',false);
        }
        else
        {
            /*$('#wishlist_model .wishlist_id').each(function(elm){
                if($(elm).is(':checked'))
                {
                        
                }
            });	*/
            
            if($('#wishlist_model .wishlist_id').is(':checked'))
                $('#wishlist_model .wishlist_id').attr('required',false);
            
        }
        
    }
	
	$(document).ready(function(){
	
		$('#product_attr').on('click','span',function(){
			
			// add class
			$('#product_attr span').css('box-shadow','none');
			$(this).css('box-shadow','0 0 2px #999');
			
			//$(this).next('input:radio').prop('checked',true);
			//$('#product_attr input:radio').attr('checked',false);
			//$(this).next('input:radio').attr('checked','checked');
			$(this).next('input:radio').prop('checked',true);
			
		});
		
		
	});
	
	function load_product_attr(productId)
	{
		$('#product_attr').html();
		$.ajax({
			url: '<?php echo url('/getProductColors') ?>/'+productId,
				type:'post',
				dataType:'json',
				data: '_token=<?php echo csrf_token(); ?>',
				success: function(response) {			
									
					if(response['success'])
					{
						var success = '';
						for(var i=0; i < response['success'].length; i++)
						{
							obj = response['success'][i];
							success += '<span style="background:'+ obj.hex_code +'; border: 1px solid #ddd; padding:1px 10px; margin:-3px; cursor:pointer;">&nbsp;</span><input type="radio" name="color_id" value="'+ obj.id +'" required="required" style="left: -20px; position: relative; z-index: -1;">';
							//alert(response['success'][i].id);
						}
						//success += '</div>';
						
						//var success = '<div id="successPassword" class="alert alert-success"><i class="fa fa-check-circle"></i> <strong>Success!</strong><p>The information has been saved/updated successfully.</p></div>';
						$('#product_attr').html(success);
					}
				}	
		});
		//alert(productId);
	}
    
    </script>
                
    <?php
	}
	?>
    <!-- End .modal move -->
    
     <!-- login required popup message -->
    <div class="modal fade" id="login_model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
             
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel2">Login required !</h4>
                </div><!-- End .modal-header -->
                <div class="modal-body clearfix">

                    <div class="col-md-10">
                        <p>You must be logged in. Please click on login link below to continue...</p>
                    </div>			

                </div><!-- End .modal-body -->
                <div class="modal-footer">                            	
                    <a class="btn btn-custom-2" href="{{ url('/login') }}">Login</a>
                    <button type="button" class="btn btn-custom" data-dismiss="modal">CANCEL</button>
                </div><!-- End .modal-footer -->
            </div><!-- End .modal-content -->
        </div><!-- End .modal-dialog -->       
    </div>
    <!-- end login required popup message -->
    
</body>

</html>
