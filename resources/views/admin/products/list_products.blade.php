@extends('adminLayout')

@section('content')         
       
  <!--BEGIN PAGE WRAPPER-->
      <div id="page-wrapper"><!--BEGIN PAGE HEADER & BREADCRUMB-->
        
        <div class="page-header-breadcrumb">
          <div class="page-heading hidden-xs">
            <h1 class="page-title">Products</h1>
          </div>
          
          
          <ol class="breadcrumb page-breadcrumb">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/web88cms/dashboard') }}">Dashboard</a>&nbsp; <i class="fa fa-angle-right"></i>&nbsp;</li>
            <li>Products &nbsp;<i class="fa fa-angle-right"></i>&nbsp;</li>
            <li class="active">Products - Listing</li>
          </ol>
         </div>
        <!--END PAGE HEADER & BREADCRUMB--><!--BEGIN CONTENT-->
        <div class="page-content">
          <div class="row">
            <div class="col-lg-12">
              <h2>Products <i class="fa fa-angle-right"></i> Listing</h2>
              <div class="clearfix"></div>
              
             <div class="pull-left"> Last updated: <span class="text-blue"><?php echo date('d M, Y @ g:i A',strtotime($last_modified)); ?></span> </div>
              <div class="clearfix"></div>
              @if ($success)
                    <div class="alert alert-success alert-dismissable">
                     <button type="button" data-dismiss="alert" aria-hidden="true" class="close">&times;</button>
                     <i class="fa fa-check-circle"></i> <strong>Success!</strong>
                     <p>{{ $success }}</p>
                    </div>   
              @endif             
             
              
              <div class="clearfix"></div>
            </div>
            <!-- end col-lg-12 -->
            <div class="col-md-6">
              <div class="portlet portlet-blue">
                <div class="portlet-header">
                  <div class="caption text-white">Search Products</div>
                </div>
                <div class="portlet-body">
                  <form class="form-horizontal">
                    <div class="form-group">
                      <label class="col-md-4 control-label">Name </label>
                      <div class="col-md-8">
                        <input type="text" name="product_name" class="form-control" value="{{ Input::get('product_name') }}">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-4 control-label">Product Code </label>
                      <div class="col-md-8">
                        <input type="text" name="product_code" class="form-control" value="{{ Input::get('product_code') }}">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-4 control-label">Price From </label>
                      <div class="col-md-8">
                        <input type="text" name="price_from" class="form-control" placeholder="0.00" value="{{ Input::get('price_from') }}">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-4 control-label">Price To </label>
                      <div class="col-md-8">
                        <input type="text" name="price_to" class="form-control" placeholder="0.00" value="{{ Input::get('price_to') }}">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-4 control-label">Brand </label>
                      <div class="col-md-8">
                        <select name="brand_id" class="form-control">
                          <option value="all">All Brands</option>
                           <?php
							if(sizeof($brands) > 0)
							{
								foreach($brands as $brandDetails)
								{
									$selected = (Input::get('brand_id') == $brandDetails->id) ? 'selected="selected"' : '';
									echo '<option value="'.$brandDetails->id.'" '.$selected.'>'.$brandDetails->title.'</option>';
								}	
							}
							?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-4 control-label">Category </label>
                      <div class="col-md-8">
                        <select name="category_id" class="form-control">
                          <option value="all">- All Categories -</option>
                          <?php echo $categories; ?>
                        </select>
                      </div>
                    </div>
                    <!-- save button start -->
                    <div class="form-actions text-center"> <button type="submit" class="btn btn-red">Search &nbsp;<i class="fa fa-search"></i></button> </div>
                    <!-- save button end -->
                  </form>
                </div>
                <!-- end portlet-body -->
              </div>
              <!-- end portlet -->
            </div>
            <!-- end col-md-6 -->
            <div class="col-lg-12">
              <ul id="myTab" class="nav nav-tabs">
                <li class="active"><a href="#brand-image" data-toggle="tab">Products Listing</a></li>
              </ul>
              <div id="myTabContent" class="tab-content">
                <div id="brand-image" class="tab-pane fade in active">
                  <div class="portlet">
                    <div class="portlet-header">
                      <div class="caption">Products Listing</div>
                      <br/>
                      <p class="margin-top-10px"></p>
                      <a href="{{ url('/web88cms/products/addProduct') }}" class="btn btn-success">Add New Product &nbsp;<i class="fa fa-plus"></i></a>&nbsp;
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
                      <!--Modal delete selected items start-->
                      <div id="modal-delete-selected" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                              <h4 id="modal-login-label4" class="modal-title"><a href=""><i class="fa fa-exclamation-triangle"></i></a> Are you sure you want to delete the selected item(s)? </h4>
                            </div>
                            <div class="modal-body">
                              <div class="form-actions">
                                <div class="col-md-offset-4 col-md-8"> <a href="javascript:void(0)" onclick="delete_selected('products')" class="btn btn-red">Yes &nbsp;<i class="fa fa-check"></i></a>&nbsp; <a href="javascript:void(0)" data-dismiss="modal" onclick="cancel_delete()" class="btn btn-green">No &nbsp;<i class="fa fa-times-circle"></i></a> </div>
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
                              <h4 id="modal-login-label4" class="modal-title"><a href=""><i class="fa fa-exclamation-triangle"></i></a> Are you sure you want to delete all items? </h4>
                            </div>
                            <div class="modal-body">
                              <div class="form-actions">
                                <div class="col-md-offset-4 col-md-8"> <a href="javascript:void(0)" onclick="delete_all('products')" class="btn btn-red">Yes &nbsp;<i class="fa fa-check"></i></a>&nbsp; <a href="javascript:void(0)" data-dismiss="modal" onclick="cancel_delete()"  class="btn btn-green">No &nbsp;<i class="fa fa-times-circle"></i></a> </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- modal delete all items end -->
                    </div>
                    <div class="portlet-body">                      
                     
                      <div class="table-responsive mtl">
                      
                      <script>
					 	// select all checkboxes
						$(document).ready(function(){
							$('#select_items').click(function(){
								//alert('asd');
								//if($('.select_items').length() > 0)
								if($('#select_items').is(':checked'))
								{
									$('.select_items').prop('checked',true);
								}
								else
									$('.select_items').prop('checked',false);
							});	
						});
					  
					  </script>
                      <?php					  
					  if(sizeof($products) > 0)
					  {
						 // echo http_build_query(Input::get());
						 
						 $arr_get = Input::get();
						 unset($arr_get['page']);
						 $query_string = http_build_query($arr_get);
						 
						 $per_page_records = (Session::has('product.per_page')) ? Session::get('product.per_page') : 100;
						 
					  ?>
                      <div class="form-inline pull-left">
                        <div class="form-group">
                          <select name="select" class="form-control" onchange="set_per_page(this.value,'product','{{ Request::path() }}','{{ $query_string }}')">                      <option <?php if($per_page_records == 10){ echo 'selected="selected"'; } ?>>10</option>
                            <option <?php if($per_page_records == 20){ echo 'selected="selected"'; } ?>>20</option>
                            <option <?php if($per_page_records == 30){ echo 'selected="selected"'; } ?>>30</option>
                            <option <?php if($per_page_records == 50){ echo 'selected="selected"'; } ?>>50</option>
                            <option <?php if($per_page_records == 100){ echo 'selected="selected"'; } ?>>100</option>
                          </select>
                          &nbsp;
                          <label class="control-label">Records per page</label>
                        </div>
                      </div>
                      <div class="clearfix"></div>
                      <input type="hidden" id="delete_item_ids" value="0" />
                      <input type="hidden" id="csrf_token" name="_token" value="{{ csrf_token() }}" />
                      <input type="hidden" id="query_string" value="{{ $query_string }}" />
                      
                        <table class="table table-hover table-striped">
                          <thead>
                            <tr>
                              <th width="1%"><input type="checkbox" id="select_items"/></th>
                              <th>#</th>
                              <th><a herf="sort by status">Status</a></th>
                              <th>Image</th>
                              <th><a herf="sort by name">Name</a> / <a herf="sort by product code">Product Code</a></th>
                              <th><a herf="sort by sale price">Sale Price (RM)</a></th>
                              <th><a herf="sort by list price">List Price (RM)</a></th>
                              <th><a herf="sort by qty">Qty</a></th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php
						  	//$i = 1;
							$current_page = (Input::get('page')) ? Input::get('page') : 1;
							//echo $current_page;
							$i = ($per_page_records*($current_page-1))+1;
                            foreach($products as $details)
                            {
								$status_class = ($details->status == '0') ? 'label-red' : 'label-success';
								$status = ($details->status == '0') ? 'In-active' : 'Active';
								
							?>
                            	<tr>
										 <td><input type="checkbox" data-id="<?php echo $details->id; ?>" class="select_items"/></td>
                                   		 <td><?php echo $i; ?></td>
										 <td><span class="label label-sm <?php echo $status_class; ?>" id="brand-status-<?php echo $details->id; ?>"><?php echo $status; ?></span></td>
										 <td><img src="{{ asset('/public/admin/products/large/' .$details->large_image) }}" alt="{{ $details->product_name }}" class="img-responsive" width="100px"></td>
										  <td><a href="{{ url('/web88cms/products/editProduct/'. $details->id) }}">{{ $details->product_name }}</a> <br/>
											Product Code: {{ $details->product_code }}</td>
										  <td>{{ number_format($details->sale_price, 2) }}</td>
										  <td>{{ number_format($details->list_price, 2) }}</td>
										  <td>{{ $details->quantity_in_stock }}</td>
										  <td><a href="{{ url('/web88cms/products/editProduct/'. $details->id) }}" data-hover="tooltip" data-placement="top" title="Edit"><span class="label label-sm label-success"><i class="fa fa-pencil"></i></span></a> <a href="#" data-hover="tooltip" data-placement="top" title="Delete" data-target="#modal-delete-<?php echo $details->id; ?>" data-toggle="modal" onclick="delete_item(<?php echo $details->id; ?>)"><span class="label label-sm label-red"><i class="fa fa-trash-o"></i></span></a>
											  <!--Modal delete start-->
											  <div id="modal-delete-<?php echo $details->id; ?>" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
												<div class="modal-dialog">
												  <div class="modal-content">
													<div class="modal-header">
													  <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
													  <h4 id="modal-login-label4" class="modal-title"><a href=""><i class="fa fa-exclamation-triangle"></i></a> Are you sure you want to delete this? </h4>
													</div>
													<div class="modal-body">
													  <p><strong>#1:</strong> <?php echo $details->product_name; ?> <br/>
														Product Code: <?php echo $details->product_code; ?></p>
													  <div class="form-actions">
														<div class="col-md-offset-4 col-md-8"> <a href="javascript:void(0)" class="btn btn-red" onclick="continue_delete_process_products()">Yes &nbsp;<i class="fa fa-check"></i></a>&nbsp; <a href="javascript:void(0)" data-dismiss="modal" class="btn btn-green" onclick="cancel_delete()">No &nbsp;<i class="fa fa-times-circle"></i></a> </div>
													  </div>
													</div>
												  </div>
												</div>
											</div>
											<!-- modal delete end -->
										  </td>
										</tr>
                         <?php 	 
						 	$i++; 
                            }
						?>
                            
                          </tbody>
                          <tfoot>
                            <tr>
                              <td colspan="9"></td>
                            </tr>
                          </tfoot>
                        </table>
                       
                        <div class="tool-footer text-right">
                          <p class="pull-left"><?php echo $pagination_report; ?></p>
                          
                          <?php echo $products->setPath(Request::url())->appends(Input::get())->render(); ?>
                        </div>
                       <?php
					  }
					  else
					  {
						echo 'No product found.';  
					  }
					?>
                        <div class="clearfix"></div>
                      </div>
                      <!-- end table responsive -->
                    </div>
                  </div>
                </div>
                <!-- end background image -->
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
