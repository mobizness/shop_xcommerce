@extends('adminLayout')

@section('content')         
 
 <style>
 .cke_editable{ min-height:20px;}
 </style>      
  <!--BEGIN PAGE WRAPPER-->
      <div id="page-wrapper"><!--BEGIN PAGE HEADER & BREADCRUMB-->
        
        <div class="page-header-breadcrumb">
          <div class="page-heading hidden-xs">
            <h1 class="page-title">Products</h1>
          </div>
          
          
          <ol class="breadcrumb page-breadcrumb">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/web88cms/dashboard') }}">Dashboard</a>&nbsp; <i class="fa fa-angle-right"></i>&nbsp;</li>
            <li>Products &nbsp;<i class="fa fa-angle-right"></i>&nbsp;</li>
            <li><a href="{{ url('/web88cms/products/list') }}">Products Listing</a> &nbsp;<i class="fa fa-angle-right"></i>&nbsp;</li>
            <li class="active">Product - Edit</li>
          </ol>
          </div>
        <!--END PAGE HEADER & BREADCRUMB--><!--BEGIN CONTENT-->        
        <div class="page-content">
          <div class="row">
            <div class="col-lg-12">
              <h2>Product <i class="fa fa-angle-right"></i> Edit</h2>
              <div class="clearfix"></div>
              
              @if(session()->has('data.success'))
                    <div class="alert alert-success alert-dismissable">
                    <button type="button" data-dismiss="alert" aria-hidden="true" class="close">&times;</button>
                    <i class="fa fa-check-circle"></i> <strong>Success!</strong>
                    <p>{{  session('data.success') }}</p>
                  </div>
                @endif
                
             @if(session()->has('data.error'))
                    <div class="alert alert-danger alert-dismissable">
                    <button type="button" data-dismiss="alert" aria-hidden="true" class="close">&times;</button>
                    <i class="fa fa-check-circle"></i> <strong>Error!</strong>
                    <p>{{  session('data.error') }}</p>
                  </div>
                @endif   
              
               <!-- validation errors -->
			 	@if($errors->has())
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" data-dismiss="alert" aria-hidden="true" class="close">&times;</button>
                        <i class="fa fa-times-circle"></i> <strong>Error!</strong>
                        @foreach ($errors->all() as $error)
                          <p>{{ $error }}</p>
                        @endforeach
                    </div>
				@endif
              
              <?php
			 // dd($details);
			  $productDetails = $details['productDetails'];
			  ?>
              
              <div class="pull-left"> Last updated: <span class="text-blue"><?php echo date('d M, Y @ g:i A',strtotime($details['productDetails']->last_modified)); ?></span> </div>
              <div class="clearfix"></div>
              <p></p>
              <ul id="myTab" class="nav nav-tabs">
                <li class="active"><a href="#general" data-toggle="tab" onclick="document.getElementById('description-feature').style.height='0px'; document.getElementById('description-feature').style.overflow='hidden';">General</a></li>
                <li><a href="#images" data-toggle="tab" onclick="document.getElementById('description-feature').style.height='0px'; document.getElementById('description-feature').style.overflow='hidden';">Images</a></li>
                <li><a href="#description-feature" data-toggle="tab" onclick="document.getElementById('description-feature').style.height='auto'; document.getElementById('description-feature').style.overflow='none';">Description &amp; Features</a></li>
                <li><a href="#shipping-info" data-toggle="tab" onclick="document.getElementById('description-feature').style.height='0px'; document.getElementById('description-feature').style.overflow='hidden';">Shipping Information</a></li>
                <li><a href="#quantity-discount" data-toggle="tab" onclick="document.getElementById('description-feature').style.height='0px'; document.getElementById('description-feature').style.overflow='hidden';">Quantity Discounts</a></li>
              </ul>
              <div id="myTabContent" class="tab-content">
                
                <div id="general" class="tab-pane fade in active">
                <form class="form-horizontal" method="post" action="{{ url('web88cms/products/editProduct/'.$productDetails->id) }}" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                  <div class="portlet">
                    <div class="portlet-header">
                      <div class="caption">General</div>
                      <div class="tools"> <i class="fa fa-chevron-up"></i> </div>
      
                    </div>
                    
                    
                    <div class="portlet-body">
                      <div class="row">
                          	<div class="col-md-12">
                            	
                               
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Status <span class="text-red">*</span></label>
                                                <div class="col-md-6">
                                                  <div data-on="success" data-off="primary" class="make-switch">
                                                    <input type="checkbox" name="status" <?php if($productDetails->status == '1'){ echo 'checked="checked"'; } ?> />
                                                  </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputFirstName" class="col-md-3 control-label">Product Name <span class="text-red">*</span></label>
                                                <div class="col-md-6">
                                                	<input type="text" class="form-control" placeholder="Product Name" name="product_name" value="<?php echo $productDetails->product_name; ?>">
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="form-group">
                                                <label for="inputFirstName" class="col-md-3 control-label">Product Code <span class="text-red">*</span></label>
                                                <div class="col-md-6">
                                                	<input type="text" class="form-control" placeholder="Product Code" name="product_code" value="<?php echo $productDetails->product_code; ?>">
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                            
                                            <div class="form-group">
                                            	<label for="inputFirstName" class="col-md-3 control-label">Promo Behaviour</label>

                                                <div class="col-md-6">
                                                    <div class="xss-margin"></div>
                                                    <div class="checkbox-list">
                                                        <label><input id="inlineCheckbox1" name="promo_behaviour[]" type="checkbox" value="hot" <?php if(preg_match('/hot/',$productDetails->promo_behaviour)){ echo 'checked="checked"'; } ?> />&nbsp; Hot</label>
                                                        <label><input id="inlineCheckbox2" name="promo_behaviour[]" type="checkbox" value="new" <?php if(preg_match('/new/',$productDetails->promo_behaviour)){ echo 'checked="checked"'; } ?> />&nbsp; New</label>
                                                        <label><input id="inlineCheckbox3" name="promo_behaviour[]" type="checkbox" value="sale" <?php if(preg_match('/sale/',$productDetails->promo_behaviour)){ echo 'checked="checked"'; } ?> />&nbsp; Sale</label>
                                                        <label><input id="inlineCheckbox4" name="promo_behaviour[]" type="checkbox" value="pwp" <?php if(preg_match('/pwp/',$productDetails->promo_behaviour)){ echo 'checked="checked"'; } ?> />&nbsp; PWP</label>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                             <div class="form-group">
                                                <label for="inputFirstName" class="col-md-3 control-label">Category <span class="text-red">*</span></label>
                                                <div class="col-md-6">
                                                	note to programmer: this is the multiple selection. Admin can select multiple categories for this product.
                                                	<select multiple="multiple" name="categories[]" class="form-control" style="height: 350px;">
                                                        <?php echo $categories; ?>   
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="form-group">
                                                <label for="inputFirstName" class="col-md-3 control-label">Product Brand</label>
                                                <div class="col-md-4">
                                                    <select class="form-control" name="brand_id">
                                                    	<option value="0">Not defined</option>
                                                        <?php
														if(sizeof($brands) > 0)
														{
															foreach($brands as $brandDetails)
															{
																$selected = ($details['productDetails']->brand_id == $brandDetails->id) ? 'selected="selected"' : '';
																echo '<option value="'.$brandDetails->id.'" '.$selected.'>'.$brandDetails->title.'</option>';
															}	
														}
														?>
                                                    </select>
                                                    <div class="xss-margin"></div>
                                                    <div class="text-blue text-12px">This field lets you specify the product manufacturer. Customers will be able to use it to sort products in the storefront, search by it and view products for a selected manufacturer.</div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputFirstName" class="col-md-3 control-label">Sale Price (RM) <span class="text-red">*</span></label>
                                                <div class="col-md-6">
                                                	<input type="text" class="form-control" name="sale_price"  placeholder="0.00" value="<?php echo  number_format($productDetails->sale_price,2); ?>">
                                                    <div class="xss-margin"></div>
                                                    <div class="text-blue text-12px">The product sale price. The product is sold to customers at this price.</div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputFirstName" class="col-md-3 control-label">List Price (RM)</label>
                                                <div class="col-md-6">
                                                	<input type="text" class="form-control" name="list_price"  placeholder="0.00" value="<?php echo number_format($productDetails->list_price,2); ?>">
                                                    <div class="xss-margin"></div>
                                                    <div class="text-blue text-12px">Manufacturer suggested retail price.</div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                    <label class="col-md-3 control-label">Upload Large Image <span class='require'>*</span></label>
                                                    <div class="col-md-6">
                                                      <div class="text-15px margin-top-10px">
                                                      @if($productDetails->large_image != '')
                                                      	<img src="{{ asset('/public/admin/products/large/'. $productDetails->large_image) }}" alt="<?php echo $productDetails->product_name; ?>" class="img-responsive" width="100">
                                                        <a href="{{ url('/web88cms/products/deleteImage/large_image/'. $productDetails->id) }}" onclick="return confirm('Are you sure?')" data-hover="tooltip" data-placement="top" title="Delete"><span class="label label-sm label-red"><i class="fa fa-trash-o"></i></span></a>
                                                     @endif
                                                        <div class="margin-top-5px"></div>
                                                        <input id="exampleInputFile1" type="file" name="large_image"/>
                                                        <span class="help-block">(Image dimension: 800 x 800 pixels, JPEG/GIF/PNG only, Max. 2MB) </span> </div>
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                    <label class="col-md-3 control-label">Upload Thumbnail 1 Image</label>
                                                    <div class="col-md-6">
                                                      <div class="text-15px margin-top-10px">
                                                      	<div class="text-blue text-12px">Thumbnails displayed on "Products Listing" pages.</div>
                                                    	@if($productDetails->thumbnail_image_1 != '')
                                                        	<img src="{{ asset('/public/admin/products/medium/'. $productDetails->thumbnail_image_1) }}" alt="<?php echo $productDetails->product_name; ?>" class="img-responsive">
                                                        	<a href="{{ url('/web88cms/products/deleteImage/thumbnail_image_1/'. $productDetails->id) }}" onclick="return confirm('Are you sure?')" data-hover="tooltip" data-placement="top" title="Delete"><span class="label label-sm label-red"><i class="fa fa-trash-o"></i></span></a>
                                                         @endif
                                                        
                                                        <div class="margin-top-5px"></div>
                                                        <input id="exampleInputFile1" type="file" name="thumbnail_image_1"/>
                                                        <span class="help-block">(Image dimension: 153 x 153 pixels, JPEG/GIF/PNG only, Max. 2MB) </span> </div>
                                                    </div>
                                            </div>
											<div class="form-group">
                                                    <label class="col-md-3 control-label">Upload Thumbnail 2 Image <br/>(on hover)</label>
                                                    <div class="col-md-6">
                                                      <div class="text-15px margin-top-10px">
                                                      	<div class="text-blue text-12px">Thumbnails displayed on "Products Listing" pages.</div>
                                                    	@if($productDetails->thumbnail_image_2 != '')
                                                        	<img src="{{ asset('/public/admin/products/medium/'. $productDetails->thumbnail_image_2) }}" alt="<?php echo $productDetails->product_name; ?>" class="img-responsive">
                                                            <a href="{{ url('/web88cms/products/deleteImage/thumbnail_image_2/'. $productDetails->id) }}" onclick="return confirm('Are you sure?')" data-hover="tooltip" data-placement="top" title="Delete"><span class="label label-sm label-red"><i class="fa fa-trash-o"></i></span></a>
                                                         @endif                                                       
                                                        
                                                        <div class="margin-top-5px"></div>
                                                        <input id="exampleInputFile1" type="file" name="thumbnail_image_2"/>
                                                        <span class="help-block">(Image dimension: 153 x 153 pixels, JPEG/GIF/PNG only, Max. 2MB) </span> </div>
                                                    </div>
                                            </div>                                            
                                            <div class="form-group">
                                            	<label for="inputFirstName" class="col-md-3 control-label">Available Colors</label>

                                                <div class="col-md-6">                                                	
                                                    <div class="xss-margin"></div>
                                                    <div class="checkbox-list">
                                                        <?php
														//print_r($details['productColors']); exit;
														//dd($details);
														/*$productColorList = array();
														if(sizeof($details['productColors']) > 0)
														{
															foreach($details['productColors'] as $productColors)
															{
																array_push($productColorList,$productColors->color_id);
															}	
														}*/
														//print_r($productColorList); exit;
														
														if(sizeof($colors) > 0)
														{
															foreach($colors as $colorDetails)
															{
																$checked = (in_array($colorDetails->id, $details['productColors'])) ? 'checked="checked"' : '';
																echo '<label class="checkbox-inline"><input id="inlineCheckbox1" type="checkbox" name="colors[]" value="'.$colorDetails->id.'" '.$checked.'/>&nbsp; '.$colorDetails->title.'</label>';
															}	
														}
														?>
                                                    </div>
                                                </div>
                                            </div> 
                                            
                                            <div class="form-group">
                                                <label for="inputFirstName" class="col-md-3 control-label">Quantity in Stock (items)</label>
                                                <div class="col-md-6">
                                                	<input type="text" class="form-control" name="quantity_in_stock" placeholder="" value="<?php echo $productDetails->quantity_in_stock; ?>">
                                                    <div class="xss-margin"></div>
                                                    <div class="text-blue text-12px">Goods remaining in the warehouse.</div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputFirstName" class="col-md-3 control-label">Low Level in Stock (items)</label>
                                                <div class="col-md-6">
                                                	<input type="text" class="form-control" name="low_level_in_stock" placeholder="" value="<?php echo $productDetails->low_level_in_stock; ?>">
                                                    <div class="xss-margin"></div>
                                                    <div class="text-blue text-12px">Shows the minimum level of a product in the warehouse, at which the stock is considered to be low.</div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="inputFirstName" class="col-md-3 control-label">Manufacturer Part Number</label>
                                                <div class="col-md-6">
                                                	<input type="text" class="form-control" name="manufacturer_part_number" placeholder="" value="<?php echo $productDetails->manufacturer_part_number; ?>">
                                                    <div class="xss-margin"></div>
                                                    <div class="text-blue text-12px">The manufacturers part number for this item.</div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputFirstName" class="col-md-3 control-label">Ships In</label>
                                                <div class="col-md-6">
                                                	<input type="text" class="form-control" name="ships_in" placeholder="" value="<?php echo $productDetails->ships_in; ?>">
                                                    <div class="xss-margin"></div>
                                                    <div class="text-blue text-12px">Brief note about the delivery time for this product if relevant.</div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputFirstName" class="col-md-3 control-label">Display Order</label>
                                                <div class="col-md-3">
                                                	<input type="text" class="form-control" name="display_order"  placeholder="" value="<?php echo $details['productCategories'][0]->display_order; ?>">
                                                    <div class="xss-margin"></div>
                                                    <div class="text-blue text-12px">The display order of the product.</div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                             	<label for="inputFirstName" class="col-md-3 control-label">Tax</label>
                                                    <div class="col-md-6">
                                                        <div class="xss-margin"></div>
                                                        <input type="checkbox" name="is_tax" <?php if($productDetails->is_tax == '1'){ echo 'checked="checked"';} ?>> GST

                                                        
                                                    </div>
                                                    
                                            </div> 
                                            
                                            <div class="form-group">
                                             	<label for="inputFirstName" class="col-md-3 control-label">Tag</label>
                                                    <div class="col-md-5">
                                                    	<div class="xss-margin"></div>
                                                        <!--<div class="text-blue text-15px border-bottom">Please click the text below to edit tag.</div>
                                                        <div contenteditable="true">
                                                        	<p class="form-control-static"> <?php echo $productDetails->tags; ?></p>
                                                        </div>-->
                                                        <div class="input-group">
                                                        <textarea class="form-control" name="tags" placeholder="eg. Digital Gadget "style="width: 488px;"><?php echo $productDetails->tags; ?></textarea>

                                                        <!--<input type="text"  name="tags" class="form-control" placeholder="eg. Digital Gadget"/><span class="input-group-btn"><button type="button" class="btn btn-primary">Add</button></span>-->
                                                        </div>
                                                        <div class="xss-margin"></div>
                                                        <div class="text-blue text-12px">eg. Digital Gadget, Digital Imaging, 50% Extreme Camera Sales.</div>
                                                    </div>
                                                    
                                            </div>
											

                                          
                                          		
                                
                                
                                
                                  
                            </div>
                            <!-- end col-md-12 -->
 
                          </div>
                          <!-- end row -->
                      
                      <div class="clearfix"></div>
                    </div>
                    <!-- end portlet body -->
   
                  </div>
                  <!-- end portlet -->
                  <!-- end general -->
                  
                  <div class="portlet">
                  
                  		<div class="portlet-header">
                          <div class="caption">Purchase Availability</div>
                          <div class="tools"> <i class="fa fa-chevron-up"></i> </div>
          
                        </div>
                        
                        <div class="portlet-body">
                          <div class="row">
                                <div class="col-md-12">
                                    
                                   
                                                
                                                <div class="form-group">
                                                    <label for="inputFirstName" class="col-md-3 control-label">Available</label>
                                                    <div class="col-md-6">
                                                        <div class="xss-margin"></div><input type="checkbox" name="is_available" <?php if($productDetails->is_available == '1'){ echo 'checked="checked"';} ?>> Available<br>
                                                        
                                                    </div>
                                                    
                                                    <div class="col-md-4">
                                                    	Availabile Since
                                                        <div class="input-group">
                                                            <input type="text" class="datepicker-default form-control" name="available_since" value="<?php echo ($productDetails->available_since != '1970-01-01') ? date('d M, Y',strtotime($productDetails->available_since)) : ''; ?>"  data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy"/>
                                                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                                        </div>
                                                        <div class="xss-margin"></div>
                                                        <input type="checkbox" name="in_physical_store_only" <?php if($productDetails->in_physical_store_only == '1'){ echo 'checked="checked"';} ?>> Available in Physical Store Only.
                                                        <div class="xss-margin"></div>
                                                        <div class="text-blue text-12px">Only available items can be ordered.</div>
                                                    </div>

                                                </div>
                                                <div class="clearfix"></div>
                                                
                                                <div class="form-group">
                                                    <label for="inputFirstName" class="col-md-3 control-label">Creation Date</label>
   
                                                    <div class="col-md-4">
                                                        <div class="input-group">
                                                            <input type="text" name="created" class="datepicker-default form-control" data-date-format="dd/mm/yyyy" placeholder="17 Apr, 2015" value="<?php echo date('d M, Y',strtotime($productDetails->created)); ?>"/>
                                                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                                        </div>
                                                    </div>
    
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="inputFirstName" class="col-md-3 control-label">Out of Stock Actions</label>
   
                                                    <div class="col-md-4">
														<select class="form-control" name="out_of_stock_action">
                                                           	<option value="none" <?php if($productDetails->out_of_stock_action == 'none'){ echo 'selected="selected"'; } ?>>None</option>
                                                            <option value="signup" <?php if($productDetails->out_of_stock_action == 'signup'){ echo 'selected="selected"'; } ?> >Sign up for notification</option>                                            
                                                        </select>
                                                            
                                                    </div>
    
                                                </div>

                                            
                                             
                                      
                                </div>
                                <!-- end col-md-12 -->
     
                              </div>
                              <!-- end row -->
                      
                      <div class="clearfix"></div>
                    </div>
                    <!-- end portlet body -->
                    
                  </div>
                  <!-- end portlet -->
                  <!-- end purchase availability --> 
                  
                 	<div class="form-actions">
                      <div class="col-md-offset-5 col-md-7">
                      <button type="submit" class="btn btn-red" />Save &nbsp;<i class="fa fa-floppy-o"></i></button>
                     <!-- <a onclick="$('#addColorForm').submit()" class="btn btn-red" href="#">Save &nbsp;<i class="fa fa-floppy-o"></i></a>-->&nbsp; 
                      <a class="btn btn-green" data-dismiss="modal" href="{{ url('/web88cms/products/list') }}">Cancel &nbsp;<i class="glyphicon glyphicon-ban-circle"></i></a> </div>
                     
                    </div>
               
               </form>
                  
                </div>
                <!-- end tab general -->
                
                
                <div id="images" class="tab-pane fade">
                	<div class="portlet">
                  
                  		<div class="portlet-header">
                          <div class="caption">Additional Product Images</div>
                          <div class="clearfix"></div>
                          <span class="text-blue text-15px">Additional product images will be displayed in "Product Details" page. Thumbnails will be generated from detailed images automatically. Thumbnails will be resized to 128 x 128 pixels.</span>
                          <div class="xs-margin"></div>
                          <div class="clearfix"></div>
                          <a href="javascript:void(0)" class="btn btn-success" id="add_more">Add More Image &nbsp;<i class="fa fa-plus"></i></a>&nbsp;
                          <div class="tools"> <i class="fa fa-chevron-up"></i> </div>
          
                        </div>
                        
                        <div class="portlet-body">
                          <div class="row">
                                <div class="col-md-12">
                                    
                                    <form class="form-horizontal" method="post" action="{{ url('/web88cms/products/addImages/'. $productDetails->id) }}" enctype="multipart/form-data">
                                     <input type="hidden" name="_token" value="{{ csrf_token() }}"  />
                                        
                                        <div class="form-group border-bottom">
                                        
                                       			<?php
													  if(sizeof($additional_images) > 0)
													  {
													  	foreach($additional_images as $product_image)
														{
															echo '<div style="float:left; margin:0 10px 10px;"><img src="'.asset('/public/admin/products/large/'. $product_image->file_name).'" alt="'.$productDetails->product_name.'" class="img-responsive" style="width:125px;">
															<a href="'.url('/web88cms/products/deleteAdditionalImage/'. $product_image->id.'/'. $productDetails->id).'" data-hover="tooltip" data-placement="top" title="Delete" onclick="return confirm(\'Are you sure?\')"><span class="label label-sm label-red"><i class="fa fa-trash-o"></i></span></a></div>';
														}
													  }
													  
												?>
                                                <div class="clearfix"></div>
                                                    <label class="col-md-3 control-label">Upload Popup Larger Image of Additional Thumbnail</label>
                                                    <div class="col-md-6">
                                                      <div class="text-15px">                                                     
                                                      
                                                        <span id="additional_image">
                                                            <div class="margin-top-5px"></div>
                                                            <input id="exampleInputFile1" type="file" name="large_image[]"/>                                                            
                                                        </span>
                                                        <span id="more_image"></span>
                                                        <span class="help-block">(Image dimension: 800 x 800 pixels, JPEG/GIF/PNG only, Max. 2MB) </span>
                                                        
                                                        </div>
                                                    </div>
                                            </div>
                                            
                                        <div class="form-actions">
                                          <div class="col-md-offset-5 col-md-7">
                                          <button type="submit" class="btn btn-red" />Save &nbsp;<i class="fa fa-floppy-o"></i></button>
                                         <!-- <a onclick="$('#addColorForm').submit()" class="btn btn-red" href="#">Save &nbsp;<i class="fa fa-floppy-o"></i></a>-->&nbsp; 
                                          <a class="btn btn-green" data-dismiss="modal" href="{{ url('/web88cms/products/list') }}">Cancel &nbsp;<i class="glyphicon glyphicon-ban-circle"></i></a> </div>
                                         
                                        </div>    

                             		</form>
                                             
                                      
                                </div>
                                <!-- end col-md-12 -->
     
                              </div>
                              <!-- end row -->
                      
                      <div class="clearfix"></div>
                    </div>
                    <!-- end portlet body -->
                    
                  </div>
                  <!-- end portlet -->
                  <!-- end images -->
                  
                </div>
                <!-- end tab images -->
                
                <div id="description-feature" class="tab-pane fade" style="display:block; height:0px; overflow:hidden;">
                	<div class="portlet">
                  
                  		<div class="portlet-header">
                          <div class="caption">Description</div>
                          <div class="clearfix"></div>
                          <span class="text-blue text-15px">You can edit the text by clicking the content below. </span>
                          <div class="tools"> <i class="fa fa-chevron-up"></i> </div>
          
                        </div>
                        
                        <div class="portlet-body">
                          <div class="row">
                                <div class="col-md-12">
                                    
                                    <div id="description" contenteditable="true" onclick="$('#description').attr('contenteditable', true)">
                                    	<?php echo $productDetails->description; ?>
                                    </div>
                                             
                                      
                                </div>
                                <!-- end col-md-12 -->
     
                              </div>
                              <!-- end row -->
                      
                      <div class="clearfix"></div>
                    </div>
                    <!-- end portlet body -->
                    
                  </div>
                  <!-- end portlet -->
                  <!-- end description -->
                  
                  
                  <div class="portlet">
                  
                  		<div class="portlet-header">
                          <div class="caption">Features &amp; Video</div>
                          <div class="clearfix"></div>
                          <span class="text-blue text-15px">You can edit the text by clicking the content below.</span>
                          <div class="tools"> <i class="fa fa-chevron-up"></i> </div>
          
                        </div>
                        
                        <div class="portlet-body">
                          <div class="row">
                                <div class="col-md-12">
                                    <div id="featured_video" contenteditable="true" onclick="$('#featured_video').attr('contenteditable', true)">                                        
                                        <?php echo $productDetails->features_and_video; ?>
                                    </div>
                                    <div class="clearfix"></div>

                                             
                                      
                                </div>
                                <!-- end col-md-12 -->
     
                              </div>
                              <!-- end row -->
                      
                      <div class="clearfix"></div>
                    </div>
                    <!-- end portlet body -->
                    
                  </div>
                  <!-- end portlet -->
                  <!-- end features & video -->
                  
                  <script>
				  
				  $(document).ready(function(){
					  
				
					// The inline editor should be enabled on an element with "contenteditable" attribute set to "true".
					// Otherwise CKEditor will start in read-only mode.
					//var introduction = document.getElementById( 'description' );
					//introduction.setAttribute( 'contenteditable', true );
					
					//var featured_video = document.getElementById( 'featured_video' );
					//featured_video.setAttribute( 'contenteditable', true );
					
			
					/*CKEDITOR.inline( 'description', {
						// Allow some non-standard markup that we used in the introduction.
						extraAllowedContent: 'a(documentation);abbr[title];code',
						removePlugins: 'stylescombo',
						extraPlugins: 'sourcedialog',
						// Show toolbar on startup (optional).
						startupFocus: true
					} );*/
					
					CKEDITOR.inline( 'description', {
						on: {
							blur: function( event ) {
								//var editor_data = event.editor.getData();
								var editor_data = $('#description').html();
								// Do sth with your data...
								//alert(data);
								
								$.ajax({
										type : 'post',
										data : 'content='+editor_data+'&_token=<?php echo csrf_token(); ?>',
										url  : '<?php echo url("/web88cms/products/updateDescription/". $productDetails->id );  ?>',
										success : function(response)
										{
											//alert(response);											
										}
								});
							}
						}
					} );
					
					
					// features & video inline editor
					CKEDITOR.inline( 'featured_video', {
						on: {
							blur: function( event ) {
								//var editor_data = event.editor.getData();
								var editor_data = $('#featured_video').html();
								// Do sth with your data...
								$.ajax({
										type : 'post',
										//dataType: 'json',
										data : 'content='+editor_data+'&_token=<?php echo csrf_token(); ?>',
										url  : '<?php echo url("/web88cms/products/updateFeaturedVideo/". $productDetails->id );  ?>',
										success : function(response)
										{
											//alert(response);											
										}
								});
							}
						}
					} );
					
					
					// warranty and support inline editor
					CKEDITOR.inline( 'warranty_and_support', {
						on: {
							blur: function( event ) {
								//var editor_data = event.editor.getData();
								var editor_data = $('#warranty_and_support').html();
								// Do sth with your data...
								$.ajax({
										type : 'post',
										data : 'content='+editor_data+'&_token=<?php echo csrf_token(); ?>',
										url  : '<?php echo url("/web88cms/products/updateWarrantyAndSupport/". $productDetails->id );  ?>',
										success : function(response)
										{
											//alert(response);											
										}
								});
							}
						}
					} );
					
					// warranty and support inline editor
					CKEDITOR.inline( 'return_policy', {
						on: {
							blur: function( event ) {
								//var editor_data = event.editor.getData();
								var editor_data = $('#return_policy').html();
								// Do sth with your data...
								$.ajax({
										type : 'post',
										data : 'content='+editor_data+'&_token=<?php echo csrf_token(); ?>',
										url  : '<?php echo url("/web88cms/products/updateReturnPolicy/". $productDetails->id );  ?>',
										success : function(response)
										{
											//alert(response);											
										}
								});
							}
						}
					} );
					
				});
				
				$(document).ready(function(){
					$('#add_more').click(function(){
						$('#more_image').append($('#additional_image').html());	
					});
				
				});				
				
				</script>
                  
                  <div class="portlet">
                  
                  		<div class="portlet-header">
                          <div class="caption">Warranty &amp; Support</div>
                          <div class="clearfix"></div>
                          <span class="text-blue text-15px">You can edit the text by clicking the content below.</span>
                          <div class="tools"> <i class="fa fa-chevron-up"></i> </div>
          
                        </div>
                        
                        <div class="portlet-body">
                          <div class="row">
                                <div class="col-md-12">
                                    
                                  	<div id="warranty_and_support" contenteditable="true" onclick="$('#warranty_and_support').attr('contenteditable', true)">
										<?php echo $productDetails->warranty_and_support; ?>
                                    </div>
                                      
                                </div>
                                <!-- end col-md-12 -->
     
                              </div>
                              <!-- end row -->
                      
                      <div class="clearfix"></div>
                    </div>
                    <!-- end portlet body -->
                    
                  </div>
                  <!-- end portlet -->
                  <!-- end warranty & support -->
                  
                  
                  <div class="portlet">
                  
                  		<div class="portlet-header">
                          <div class="caption">Return Policy</div>
                          <div class="clearfix"></div>
                          <span class="text-blue text-15px">You can edit the text by clicking the content below.</span>
                          <div class="tools"> <i class="fa fa-chevron-up"></i> </div>
          
                        </div>
                        
                        <div class="portlet-body">
                          <div class="row">
                                <div class="col-md-12">
                                    
                                  	<div id="return_policy" contenteditable="true" onclick="$('#return_policy').attr('contenteditable', true)">
										<?php echo $productDetails->return_policy; ?>
                                    </div>
                                      
                                </div>
                                <!-- end col-md-12 -->
     
                              </div>
                              <!-- end row -->
                      
                      <div class="clearfix"></div>
                    </div>
                    <!-- end portlet body -->
                    
                  </div>
                  <!-- end portlet -->
                  <!-- end return policy -->
                  
                  
                </div>
               
                <!-- end tab description & features -->
                
                
                <div id="shipping-info" class="tab-pane fade">
                	<div class="portlet">
                  
                  		<div class="portlet-header">
                          <div class="caption">Shipping Information</div>
                          <div class="tools"> <i class="fa fa-chevron-up"></i> </div>
          
                        </div>
                        
                        <div class="portlet-body">
                          <div class="row">
                                <div class="col-md-12">
                                    
                                    <form class="form-horizontal" method="post" action="{{ url('/web88cms/products/updateShippingInfo/'. $productDetails->id) }}">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                        <div class="form-group">
                                       		<label for="inputFirstName" class="col-md-3 control-label">Weight (kg)</label>
                                            <div class="col-md-3">
                                            	<input type="text" name="weight" class="form-control" placeholder="0.00" value="<?php echo $productDetails->weight; ?>">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                       		<label for="inputFirstName" class="col-md-3 control-label">Free Shipping</label>
                                            <div class="col-md-2">
                                            	<select class="form-control" name="free_shipping">
                                                	<option value="0" <?php if($productDetails->free_shipping == '0'){echo 'selected="selected"'; } ?>>No</option>
                                                    <option value="1" <?php if($productDetails->free_shipping == '1'){echo 'selected="selected"'; } ?>>Yes</option>

                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                       		<label for="inputFirstName" class="col-md-3 control-label">Shipping Cost (RM)</label>
                                            <div class="col-md-3">
                                            	<input type="text" name="shipping_cost" class="form-control" placeholder="0.00" value="<?php echo $productDetails->shipping_cost; ?>">
                                            </div>
                                        </div>  
                                    	<div class="clearfix"></div>
                                        
                                        <div class="form-actions">
                                          <div class="col-md-offset-5 col-md-7">
                                          <button type="submit" class="btn btn-red" />Save &nbsp;<i class="fa fa-floppy-o"></i></button>
                                         <!-- <a onclick="$('#addColorForm').submit()" class="btn btn-red" href="#">Save &nbsp;<i class="fa fa-floppy-o"></i></a>-->&nbsp; 
                                          <a class="btn btn-green" data-dismiss="modal" href="{{ url('/web88cms/products/list') }}">Cancel &nbsp;<i class="glyphicon glyphicon-ban-circle"></i></a> </div>
                                         
                                        </div>

                             		</form>
                                             
                                      
                                </div>
                                <!-- end col-md-12 -->
     
                              </div>
                              <!-- end row -->
                      
                      <div class="clearfix"></div>
                    </div>
                    <!-- end portlet body -->
                    
                  </div>
                  <!-- end portlet -->
                  <!-- end images -->
                  
                </div>
                <!-- end tab shipping information -->
                
                
                <div id="quantity-discount" class="tab-pane fade">
                	<div class="portlet">
                  
                  		<div class="portlet-header">
                          <div class="caption">Quantity Discounts</div>
                          <div class="clearfix"></div>
                          <p class="margin-top-10px"></p>  
                          <a href="#" class="btn btn-success" data-hover="tooltip" data-placement="top" data-target="#modal-add-discount" data-toggle="modal">Add Quantity Discount &nbsp;<i class="fa fa-plus"></i></a>&nbsp;
                              <div class="btn-group">
                                <button type="button" class="btn btn-primary">Delete</button>
                                <button type="button" data-toggle="dropdown" class="btn btn-red dropdown-toggle"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>
                                <ul role="menu" class="dropdown-menu">
                                  <li><a href="#" data-target="#modal-delete-selected" data-toggle="modal">Delete selected item(s)</a></li>
                                  <li class="divider"></li>
                                  <li><a href="#" data-target="#modal-delete-all" data-toggle="modal">Delete all</a></li>
                                </ul>
                              </div> 
                          
                          
                          <div class="tools"> <i class="fa fa-chevron-up"></i> </div>
                          
                          
                          <!--Modal add discount start-->
                                  <div id="modal-add-discount" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                                    <div class="modal-dialog modal-wide-width">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                          <h4 id="modal-login-label3" class="modal-title">Add Quantity Discount</h4>
                                        </div>
                                        <div class="modal-body">
                                          <div class="form">
                                            <form class="form-horizontal">
                                              <div class="form-group">
                                                <label class="col-md-3 control-label">Status <span class="text-red">*</span></label>
                                                <div class="col-md-6">
                                                  <div data-on="success" data-off="primary" class="make-switch">
                                                    <input type="checkbox" checked="checked"/>
                                                  </div>
                                                </div>
                                              </div>
                                              <div class="form-group">
                                                <label for="inputFirstName" class="col-md-3 control-label">From Quantity</label>
                                                <div class="col-md-6">
                                                  <input type="text" class="form-control" placeholder="Qty">
                                                </div>
                                              </div>
                                              <div class="clearfix"></div>
                                              <div class="form-group">
                                                <label for="inputFirstName" class="col-md-3 control-label">To Quantity</label>
                                                <div class="col-md-6">
                                                  <input type="text" class="form-control" placeholder="Qty">
                                                </div>
                                              </div>
                                              <div class="clearfix"></div>
                                              <div class="form-group">
                                                <label for="inputFirstName" class="col-md-3 control-label">Discount </label>
                                                <div class="col-md-6">
                                                  <input type="text" class="form-control" placeholder="Amount">
                                                  <div class="xs-margin"></div>
                                                  <select name="select" class="form-control">
                                                    <option value="%" >%</option>
                                                    <option value="RM">RM</option>
                                                  </select>
                                                </div>
                                              </div>
                                             
                    
                                              
                                              <div class="form-actions">
                                                <div class="col-md-offset-5 col-md-8"> <a href="#" class="btn btn-red">Save &nbsp;<i class="fa fa-floppy-o"></i></a>&nbsp; <a href="#" data-dismiss="modal" class="btn btn-green">Cancel &nbsp;<i class="glyphicon glyphicon-ban-circle"></i></a> </div>
                                              </div>
                                            </form>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                <!--END MODAL add new discount -->
                          <!--Modal delete selected items start-->
                          <div id="modal-delete-selected" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                      <h4 id="modal-login-label3" class="modal-title"><a href=""><i class="fa fa-exclamation-triangle"></i></a> Are you sure you want to delete the selected item(s)? </h4>
                                    </div>
                                    <div class="modal-body">
                                      <p><strong>#1:</strong> Price per item - RM 650.00 (Discount - RM 20.00)</p>
                                      <div class="form-actions">
                                        <div class="col-md-offset-4 col-md-8"> <a href="#" class="btn btn-red">Yes &nbsp;<i class="fa fa-check"></i></a>&nbsp; <a href="#" data-dismiss="modal" class="btn btn-green">No &nbsp;<i class="fa fa-times-circle"></i></a> </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <!-- modal delete selected items end -->
                              <!--Modal delete all items start-->
                              <div id="modal-delete-all" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                      <h4 id="modal-login-label3" class="modal-title"><a href=""><i class="fa fa-exclamation-triangle"></i></a> Are you sure you want to delete all items? </h4>
                                    </div>
                                    <div class="modal-body">
                                      <div class="form-actions">
                                        <div class="col-md-offset-4 col-md-8"> <a href="#" class="btn btn-red">Yes &nbsp;<i class="fa fa-check"></i></a>&nbsp; <a href="#" data-dismiss="modal" class="btn btn-green">No &nbsp;<i class="fa fa-times-circle"></i></a> </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <!-- modal delete all items end -->
          
                        </div>
                        
                    
                    
                    <div class="portlet-body">
                      <div class="form-inline pull-left">
                        <div class="form-group">
                          <select name="select" class="form-control">
                            <option>10</option>
                            <option>20</option>
                            <option selected="selected">30</option>
                            <option>50</option>
                            <option>100</option>
                          </select>
                          &nbsp;
                          <label class="control-label">Records per page</label>
                        </div>
                      </div>
                      <div class="clearfix"></div>
                      <br/>
                      <div class="table-responsive mtl">
                      	<span class="text-red"><b>Sale Price: RM 670.00</b></span>
                        <table id="example1" class="table table-hover table-striped">
                          <thead>
                            <tr>
                              <th width="1%"><input type="checkbox"/></th>
                              <th>#</th>
                              <th>Product Quantity</th>
                              <th>Product Price/Discount</th>
                              <th>Status</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td><input type="checkbox"/></td>
                              <td>1</td>
                              <td>From 1 Item(s) to 99 Item(s)</td>
                              <td>Price per item - RM 650.00<br/>(Discount - RM 20.00)</td>
                              <td><span class="label label-sm label-success">Active</span></td>
                              <td><a href="#" data-hover="tooltip" data-placement="top" title="Edit" data-target="#modal-edit-discount" data-toggle="modal"><span class="label label-sm label-success"><i class="fa fa-pencil"></i></span></a> <a href="#" data-hover="tooltip" data-placement="top" title="Delete" data-target="#modal-delete-2" data-toggle="modal"><span class="label label-sm label-red"><i class="fa fa-trash-o"></i></span></a>
                                  <!--Modal edit discount start-->
                                  <div id="modal-edit-discount" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                                    <div class="modal-dialog modal-wide-width">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                          <h4 id="modal-login-label3" class="modal-title">Edit Quantity Discount</h4>
                                        </div>
                                        <div class="modal-body">
                                          <div class="form">
                                            <form class="form-horizontal">
                                              <div class="form-group">
                                                <label class="col-md-3 control-label">Status <span class="text-red">*</span></label>
                                                <div class="col-md-6">
                                                  <div data-on="success" data-off="primary" class="make-switch">
                                                    <input type="checkbox" checked="checked"/>
                                                  </div>
                                                </div>
                                              </div>
                                              <div class="form-group">
                                                <label for="inputFirstName" class="col-md-3 control-label">From Quantity</label>
                                                <div class="col-md-6">
                                                  <input type="text" class="form-control" placeholder="Qty" value="1">
                                                </div>
                                              </div>
                                              <div class="clearfix"></div>
                                              <div class="form-group">
                                                <label for="inputFirstName" class="col-md-3 control-label">To Quantity</label>
                                                <div class="col-md-6">
                                                  <input type="text" class="form-control" placeholder="Qty" value="99">
                                                </div>
                                              </div>
                                              <div class="clearfix"></div>
                                              <div class="form-group">
                                                <label for="inputFirstName" class="col-md-3 control-label">Discount </label>
                                                <div class="col-md-6">
                                                  <input type="text" class="form-control" placeholder="Amount" value="20">
                                                  <div class="xs-margin"></div>
                                                  <select name="select" class="form-control">
                                                    <option value="%" >%</option>
                                                    <option value="RM" selected="selected">RM</option>
                                                  </select>
                                                </div>
                                              </div>
                                             
                                             
                                              
                                              <div class="form-actions">
                                                <div class="col-md-offset-5 col-md-8"> <a href="#" class="btn btn-red">Save &nbsp;<i class="fa fa-floppy-o"></i></a>&nbsp; <a href="#" data-dismiss="modal" class="btn btn-green">Cancel &nbsp;<i class="glyphicon glyphicon-ban-circle"></i></a> </div>
                                              </div>
                                            </form>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                <!--END MODAL edit discount -->
                                  <!--Modal delete start-->
                                  <div id="modal-delete-2" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                          <h4 id="modal-login-label4" class="modal-title"><a href=""><i class="fa fa-exclamation-triangle"></i></a> Are you sure you want to delete this item? </h4>
                                        </div>
                                        <div class="modal-body">
                                          <p><strong>#01:</strong> Price per item - RM 650.00 (Discount - RM 20.00)</p>
                                          <div class="form-actions">
                                            <div class="col-md-offset-4 col-md-8"> <a href="#" class="btn btn-red">Yes &nbsp;<i class="fa fa-check"></i></a>&nbsp; <a href="#" data-dismiss="modal" class="btn btn-green">No &nbsp;<i class="fa fa-times-circle"></i></a> </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                <!-- modal delete end -->
                              </td>
                            </tr>
                            
                          </tbody>
                          <tfoot>
                            <tr>
                              <td colspan="6"></td>
                            </tr>
                          </tfoot>
                        </table>
                        <div class="tool-footer text-right">
                          <p class="pull-left">Showing 1 to 10 of 57 entries</p>
                          <ul class="pagination pagination mtm mbm">
                            <li class="disabled"><a href="#">&laquo;</a></li>
                            <li class="active"><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#">5</a></li>
                            <li><a href="#">&raquo;</a></li>
                          </ul>
                        </div>
                        <div class="clearfix"></div>
                      </div>
                    </div>    
                    <!-- end portlet body -->
                    
                  </div>
                  <!-- end portlet -->
                  <!-- end images -->
                  
                </div>
                <!-- end tab quantity discounts -->
                
                
                
              </div>
              <!-- end tab content -->
              <div class="clearfix"></div>
            </div>
            <!-- end col-lg-12 -->
          </div>
          <!-- end row -->
        </div>        
        <!--END CONTENT-->
            
            <!--BEGIN FOOTER-->
  <div class="page-footer">
                <div class="copyright"><span class="text-15px">2015 &copy; <a href="http://www.webqom.com" target="_blank">Webqom Technologies Sdn Bhd.</a> Any queries, please contact <a href="mailto:support@webqom.com">Webqom Support</a>.</span>
                	<div class="pull-right"><img src="{{ asset('/public/admin/images/logo_webqom.png') }}" alt="Webqom Technologies Sdn Bhd"></div>
                </div>
        </div>
    <!--END FOOTER--></div>
  <!--END PAGE WRAPPER-->      
<!--LOADING SCRIPTS FOR PAGE-->

<script>
/*$(document).ready(function(){
	 $('.datepicker-default').datepicker({ dateFormat: "dd M, yy" });
});*/

</script>

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

<script src="{{ asset('/public/admin/vendors/tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('/public/admin/js/ui-tabs-accordions-navs.js') }}"></script>



@endsection
