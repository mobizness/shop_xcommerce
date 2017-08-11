@extends('adminLayout')
@section('content')

<?php

use App\Http\Models\Admin\Product;
use App\Http\Models\Admin\Category;

$this->ProductModel = new Product();
$this->CategoryModel = new Category();
?>
      <div id="page-wrapper">
        
        <div class="page-header-breadcrumb">
          <div class="page-heading hidden-xs">
            <h1 class="page-title">Shipping Setup</h1>
          </div>
          
          <ol class="breadcrumb page-breadcrumb">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/web88cms/dashboard') }}">Dashboard</a>&nbsp; <i class="fa fa-angle-right"></i>&nbsp;</li>
            <li>CSV Import &nbsp;<i class="fa fa-angle-right"></i>&nbsp;</li>
            <li class="active">CSV Import - Listing</li>
          </ol>
          
</div>
        <div class="page-content">
          <div class="row">
            <div class="col-lg-12">
              <h2>CSV Import <i class="fa fa-angle-right"></i> Listing</h2>
              <div class="clearfix"></div>
              @if ($success)
                    <div class="alert alert-success alert-dismissable">
                     <button type="button" data-dismiss="alert" aria-hidden="true" class="close">&times;</button>
                     <i class="fa fa-check-circle"></i> <strong>Success!</strong>
                     <p>{{ $success }}</p>
                    </div>   
              @endif
              
              <div class="pull-left"> Last updated: <span class="text-blue"><?php echo date('d M, Y @ g:i A',strtotime($last_modified)); ?></span> </div>
              <div class="clearfix"></div>
              <p></p>
              <div class="clearfix"></div>
            </div>
                        <div class="col-lg-12">
              <div class="portlet">
                <div class="portlet-header">
                  <div class="caption">CSV Import</div>
                  <br/>
                  <p class="margin-top-10px"></p>
                  <a href="#" class="btn btn-success" data-target="#modal-add-shipping-csv" data-toggle="modal">Add New &nbsp;<i class="fa fa-plus"></i></a>&nbsp;
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
                  <div id="modal-add-shipping-csv" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                    <div class="modal-dialog modal-wide-width">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                          <h4 id="modal-login-label3" class="modal-title">Add New Shipping Method</h4>
                        </div>
                        <div class="modal-body">
                          <div class="form">
                            <form class="form-horizontal" id="form_add_shipping_csv" enctype="multipart/form-data">
                              <div class="form-group">
                                <label class="col-md-4 control-label">Status</label>
                                <div class="col-md-6">
                                  <div data-on="success" data-off="primary" class="make-switch">
                                    <input type="checkbox" name="status" checked="checked"/>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="inputFirstName" class="col-md-4 control-label">Title <span class="text-red">*</span></label>
                                <div class="col-md-6">
                                  <input type="text" class="form-control" name="title" placeholder="">
                                </div>
                              </div>
							  
							  <div class="form-group">
                                <label class="col-md-4 control-label">Import CSV</label>
                                <div class="col-md-6">
                                  <div class="text-15px margin-top-10px">
                                    <div class="text-blue text-12px">You can import shipping details as CSV format.</div>
                                    <div class="xss-margin"></div>
                                    <input id="exampleInputFile2" type="file" name="csv_files" />
                                    <span class="help-block">(CSV only) </span> </div>
                                </div>
                              </div>
							  
							  <div class="form-actions">
                                <div class="col-md-offset-5 col-md-8">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <a href="javascript:void(0)" class="btn btn-red" onclick="save_shipping_csv('modal-add-shipping-csv')">Save &nbsp;<i class="fa fa-floppy-o"></i></a>&nbsp; <a href="#" data-dismiss="modal" class="btn btn-green" onclick="$('#form_add_shipping_csv')[0].reset();">Cancel &nbsp;<i class="glyphicon glyphicon-ban-circle"></i></a> </div>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <!-- delete individual item -->
                  <div id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                          <h4 id="modal-login-label4" class="modal-title"><a href=""><i class="fa fa-exclamation-triangle"></i></a> Are you sure you want to delete this? </h4>
                        </div>
                        <div class="modal-body">                         
                          <div class="form-actions">
                            <div class="col-md-offset-4 col-md-8"> <a href="javascript:void(0)" onclick="continue_delete_process_shipping_amount()" class="btn btn-red">Yes &nbsp;<i class="fa fa-check"></i></a>&nbsp; <a href="javascript:void(0)" data-dismiss="modal" class="btn btn-green" onclick="cancel_delete()">No &nbsp;<i class="fa fa-times-circle"></i></a> </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- end delete individual item -->
                  
                  <!-- delete selected item -->
                  <div id="modal-delete-selected" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                          <h4 id="modal-login-label4" class="modal-title"><a href=""><i class="fa fa-exclamation-triangle"></i></a> Are you sure you want to delete the selected item(s)? </h4>
                        </div>
                        <div class="modal-body">                          
                          <div class="form-actions">
                            <div class="col-md-offset-4 col-md-8"> <a href="javascript:void(0)" onclick="delete_selected('global_discounts')" class="btn btn-red">Yes &nbsp;<i class="fa fa-check"></i></a>&nbsp; <a href="javascript:void(0)" data-dismiss="modal" class="btn btn-green" onclick="cancel_delete()">No &nbsp;<i class="fa fa-times-circle"></i></a> </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- end delete selected item -->
                  
                  <!-- delete all items -->
                  <div id="modal-delete-all" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                          <h4 id="modal-login-label4" class="modal-title"><a href=""><i class="fa fa-exclamation-triangle"></i></a> Are you sure you want to delete all items? </h4>
                        </div>
                        <div class="modal-body">
                          <div class="form-actions">
                            <div class="col-md-offset-4 col-md-8"> <a href="javascript:void(0)" onclick="delete_all('global_discounts')" class="btn btn-red">Yes &nbsp;<i class="fa fa-check"></i></a>&nbsp; <a href="javascript:void(0)" data-dismiss="modal" class="btn btn-green" onclick="cancel_delete()">No &nbsp;<i class="fa fa-times-circle"></i></a> </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- end delete all items -->
                  
                  <!--Modal edit discount start-->
                      <div id="modal-edit-shipping-amount" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                        <div class="modal-dialog modal-wide-width">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                              <h4 id="modal-login-label3" class="modal-title">Edit Discount</h4>
                            </div>
                            <div class="modal-body">
                              <div class="form">
                                <form class="form-horizontal" enctype="multipart/form-data">
                                  <div class="form-group">
                                    <label class="col-md-3 control-label">Status <span class="text-red">*</span></label>
                                    <div class="col-md-6">
                                      <div data-on="success" data-off="primary" class="make-switch">
                                        <input type="checkbox" checked="checked"/>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="inputFirstName" class="col-md-4 control-label">Title <span class="text-red">*</span></label>
                                    <div class="col-md-6">
                                      <input type="text" class="form-control" placeholder="Amount" value="500.00">
                                    </div>
                                  </div>
								  
                                  <div class="clearfix"></div>
                                  <div class="form-group">
                                    <label for="inputFirstName" class="col-md-4 control-label">To Amount <span class="text-red">*</span></label>
                                    <div class="col-md-6">
                                      <input type="text" class="form-control" placeholder="Amount" value="1,000.00">
                                    </div>
                                  </div>
                                  <div class="clearfix"></div>
                                  <div class="form-group">
                                    <label for="inputFirstName" class="col-md-4 control-label">Discount <span class="text-red">*</span></label>
                                    <div class="col-md-6">
                                      <input type="text" class="form-control" placeholder="Amount" value="15">
                                      <div class="xs-margin"></div>
                                      <select name="select" class="form-control">
                                        <option value="%" selected="selected">%</option>
                                        <option value="RM">RM</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="inputFirstName" class="col-md-4 control-label">Apply to Category</label>
                                    <div class="col-md-6">
                                      <div class="xs-margin"></div>
                                      <select name="select" class="form-control">
                                        <option value="">- Select Category -</option>
                                        <option value="">-Audio Visual</option>
                                        <option value="">&nbsp; --Home Entertainment</option>
                                        <option value="">&nbsp; &nbsp; &nbsp; ---Disc Player</option>
                                        <option value="">&nbsp; &nbsp; &nbsp; ---Mini HiFi</option>
                                        <option value="">&nbsp; &nbsp; &nbsp; ---Micro HiFi</option>
                                        <option value="" selected="selected">&nbsp; &nbsp; &nbsp; ---Soundbar</option>
                                        <option value="">&nbsp; &nbsp; &nbsp; ---Home Theatrre System</option>
                                        <option value="">&nbsp; &nbsp; &nbsp; ---AV Component</option>
                                        <option value="">&nbsp; --TV</option>
                                        <option value="">List all product category/sub category here.</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="col-md-4 control-label">Apply to Products</label>
                                    <div class="col-md-9"> note to programmer: display all related products according to the category that admin selects above.
                                      <input type="checkbox" checked="checked">
                                      Apply discount to all products under this category.
                                      <table class="table checkout-table table-responsive">
                                        <thead>
                                          <tr>
                                            <th width="1%"><input type="checkbox" value="select all"/></th>
                                            <th class="table-title">Product Name</th>
                                            <th class="table-title">Product Code</th>
                                            <th class="table-title">Price</th>
                                            <th class="table-title">Quantity</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <tr>
                                            <td><input type="checkbox" checked="checked"/></td>
                                            <td class="item-name-col"><figure><a href="#link to product item"><img src="../images/digital_gadget/digital_imaging/panasonic_DMC-GX1WGC_big1.jpg" alt="Panasonic DMC-GX1WGC Camera Twin Lense (14MM F2.5 &amp; 14-42MM F3.5-5.6)" class="img-responsive"></a></figure>
                                      <header class="item-name"> <a href="#link to product item">Panasonic DMC-GX1WGC Camera Twin Lense (14MM F2.5 &amp; 14-42MM F3.5-5.6)</a> </header>
                                      <ul>
                                        <li>Color: Silver</li>
                                      </ul></td>
                                            <td class="item-code">DMC-GX1WGC</td>
                                            <td class="item-price-col"><span class="item-price-special">RM 670.<span class="sub-price">00</span></span></td>
                                            <td>1000</td>
                                          </tr>
                                          <tr>
                                            <td><input type="checkbox" checked="checked"/></td>
                                            <td class="item-name-col"><figure><a href="#link to product item"><img src="../images/digital_gadget/digital_imaging/panasonic_DMC-GX1WGC_big2.jpg" alt="Panasonic DMC-GX1WGC Camera Twin Lense (14MM F2.5 &amp; 14-42MM F3.5-5.6)" class="img-responsive"></a></figure>
                                      <header class="item-name"> <a href="#link to product item">Panasonic DMC-GX1WGC Camera Twin Lense (14MM F2.5 &amp; 14-42MM F3.5-5.6)</a> </header>
                                      <ul>
                                        <li>Color: Black</li>
                                      </ul></td>
                                            <td class="item-code">DMC-GX1WGC</td>
                                            <td class="item-price-col"><span class="item-price-special">RM 670.<span class="sub-price">00</span></span></td>
                                            <td>300</td>
                                          </tr>
                                        </tbody>
                                      </table>
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
                  
                </div>
                <div class="portlet-body">
                
                <?php					  
					  if(sizeof($shipping_by_csv) > 0)
					  {
						 // echo http_build_query(Input::get());
						 
						 $arr_get = Input::get();
						 unset($arr_get['page']);
						 $query_string = http_build_query($arr_get);
						 
						 $per_page = (Session::has('global_discounts.per_page')) ? Session::get('global_discounts.per_page') : 30;
					  ?>
                
                      <div class="form-inline pull-left">
                        <div class="form-group">
                          <select name="select" class="form-control" onchange="set_per_page(this.value,'global_discounts','{{ Request::path() }}','{{ $query_string }}')">
                           	<option <?php if($per_page == 10){ echo 'selected="selected"'; } ?>>10</option>
                            <option <?php if($per_page == 20){ echo 'selected="selected"'; } ?>>20</option>
                            <option <?php if($per_page == 30){ echo 'selected="selected"'; } ?>>30</option>
                            <option <?php if($per_page == 50){ echo 'selected="selected"'; } ?>>50</option>
                            <option <?php if($per_page == 100){ echo 'selected="selected"'; } ?>>100</option>
                          </select>
                          &nbsp;
                          <label class="control-label">Records per page</label>
                        </div>
                      </div>
                      <div class="clearfix"></div>
                      <br/>
                      <br/>
                      <div class="table-responsive mtl">
                      	
                      <input type="hidden" id="delete_item_ids" value="0" />
                      <input type="hidden" id="csrf_token" name="_token" value="{{ csrf_token() }}" />
                      <input type="hidden" id="query_string" value="{{ $query_string }}" />
                      
                        <table id="example1" class="table table-hover table-striped">
                          <thead>
						  	<tr>
                              <th width="1%"><input type="checkbox" id="select_items"/></th>
                              <th>#</th>
                              <th>Status</th>
                              <th>Title</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                          	<?php
								$i = 1;
								foreach($shipping_by_csv as $details)
								{
									$status_class = ($details->status == '0') ? 'label-red' : 'label-success';
									$status = ($details->status == '0') ? 'In-active' : 'Active';
																		
									// get discount category
									//$discount_category = DB::table('global_discounts_to_category')->where('global_discount_id',$details->id)->lists('category_id');
									
									// get category list with selected category	
									//$discount_products = array();
									//$category_products_list = array();
								/*	if($discount_category)
									{							
										$categoriesList = $this->CategoryModel->getSelectedCategoriesTree($discount_category);
										
										// get discount products
										$discount_products = DB::table('global_discounts_to_products')->where('global_discount_id',$details->id)->lists('product_id');
									
										// get category products										
										$category_products_list = $this->ProductModel->categoryProducts($discount_category[0]);									
										
									}
									else
									{
										$categoriesList = $this->CategoryModel->getCategoriesTree();																				
									} */
									
									
							?>
									<tr>
                                      <td><input type="checkbox" data-id="<?php echo $details->id; ?>" class="select_items"/></td>
                                      <td>{{ $i }}</td>
									  <td><span class="label label-sm <?php echo $status_class; ?>" id="brand-status-<?php echo $details->id; ?>"><?php echo $status; ?></span></td>
									  <td>{{ $details->title }}</td>
                                      <td><a href="#" data-hover="tooltip" data-placement="top" title="Edit" data-target="#modal-edit-shipping-amount-<?php echo $details->id; ?>" data-toggle="modal"><span class="label label-sm label-success"><i class="fa fa-pencil"></i></span></a> <a href="#" onclick="delete_item(<?php echo $details->id; ?>)" data-hover="tooltip" data-placement="top" title="Delete" data-target="#modal-delete" data-toggle="modal"><span class="label label-sm label-red"><i class="fa fa-trash-o"></i></span></a>
                                      
                                      
                                      <!--Modal edit discount start-->
                                          <div id="modal-edit-shipping-amount-<?php echo $details->id; ?>" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                                            <div class="modal-dialog modal-wide-width">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                                  <h4 id="modal-login-label3" class="modal-title">Edit Shipping By CSV</h4>
                                                </div>
                                                <div class="modal-body">
                                                  <div class="form">
                                                    <form class="form-horizontal" id="form_edit_shipping_amount" enctype="multipart/form-data">
                                                      <div class="form-group">
                                                        <label class="col-md-4 control-label">Status <span class="text-red">*</span></label>
                                                        <div class="col-md-6">
                                                          <div data-on="success" data-off="primary" class="make-switch">
                                                            <input type="checkbox" name="status" <?php if($details->status == '1'){ echo 'checked="checked"'; } ?> />
                                                          </div>
                                                        </div>
                                                      </div>
                                                      <div class="form-group">
                                                        <label for="inputFirstName" class="col-md-4 control-label">Title <span class="text-red">*</span></label>
                                                        <div class="col-md-6">
                                                          <input type="text" name="title" class="form-control" placeholder="" value="{{ $details->title }}">
                                                        </div>
                                                      </div>
													  <div class="clearfix"></div>
                                                      <div class="form-actions">
                                                        <div class="col-md-offset-5 col-md-8"> 
                                                        <input type="hidden" name="shipping_amount_id" value="{{ $details->id }}" />
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                        
                                                        <a href="javascript:void(0)" onclick="update_shipping_amount('modal-edit-shipping-amount-<?php echo $details->id; ?>')" class="btn btn-red">Save &nbsp;<i class="fa fa-floppy-o"></i></a>&nbsp; <a href="#" data-dismiss="modal" class="btn btn-green">Cancel &nbsp;<i class="glyphicon glyphicon-ban-circle"></i></a> </div>
                                                      </div>
                                                    </form>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                        </div>
                                      <!--END MODAL edit discount -->
                                                                  
                                      </td>
                                    </tr>
                            <?php
								$i++;
								} // end foreach
							?>
                          </tbody>
                          <tfoot>
                            <tr>
                              <td colspan="8"></td>
                            </tr>
                          </tfoot>
                        </table>
                        <div class="tool-footer text-right">
                          <p class="pull-left"><?php // echo $pagination_report; ?></p>
                          
                          <?php // echo $global_discounts->setPath(Request::url())->appends(Input::get())->render(); ?>
                        </div>
                        <div class="clearfix"></div>
                      </div>
                      
                      <?php
					  } // end if(sizeof($global_discounts) > 0)
					  ?>
					  
                      
                </div>
              </div>
            </div>
          </div>
        </div>
                    
  <div class="page-footer">
                <div class="copyright"><span class="text-15px">2015 &copy; <a href="http://www.webqom.com" target="_blank">Webqom Technologies Sdn Bhd.</a> Any queries, please contact <a href="mailto:support@webqom.com">Webqom Support</a>.</span>
                	<div class="pull-right"><img src="{{ asset('/public/admin/images/logo_webqom.png') }}" alt="Webqom Technologies Sdn Bhd"></div>
                </div>
        </div>
</div>

<script>

function load_category_products(model_id,category_id)
{
	$('#'+model_id+' #category_products').html('');
	$('#'+model_id+' #apply_to_all').hide();
	$.ajax({
			url: '{{ url("/web88cms/promotions/categoryProducts") }}',
			type: 'POST',
			dataType: 'json',
			data: '_token=<?php echo csrf_token() ?>&category_id='+category_id,
			beforeSend: function(){
				
			},
			complete: function(){
				
			},
			success: function(response){
				if(response['products'])
				{
					$('#'+model_id+' #apply_to_all').show();					
					var products = '<table class="table checkout-table table-responsive"><thead><tr><th width="1%">#</th><th class="table-title">Product Name</th><th class="table-title">Product Code</th><th class="table-title">Price</th><th class="table-title">Quantity</th></tr></thead><tbody>';
					for(var i=0; i < response['products'].length; i++)
					{
						elm = response['products'][i];
						products += '<tr><td><input type="checkbox" name="product_id[]" value="'+ elm.id +'" class="select_products"/></td><td class="item-name-col"><figure><a href="#link to product item"><img src="<?php echo asset('/public/admin/products/large') ?>/'+ elm.large_image +'" alt="'+ elm.product_name +'" class="img-responsive" width="100"></a></figure><header class="item-name"> <a href="#link to product item">'+ elm.product_name +'</a> </header></td><td class="item-code">'+ elm.product_code +'</td><td class="item-price-col"><span class="item-price-special">RM '+ parseFloat(elm.sale_price).toFixed(2) +'</span></td><td>'+ elm.quantity_in_stock +'</td></tr>';
						//products += '<p>'+ response['products'][i].product_name +'</p>';
						//alert(response['products'][i].product_name);
					}
					products += '</tbody></table>';
					$('#'+model_id+' #category_products').html(products);	
				}
			}
		});	
}

// select all checkboxes
$(document).ready(function(){
	$('#select_products').click(function(){
		//alert('asd');
		//if($('.select_items').length() > 0)
		if($('#select_products').is(':checked'))
		{
			$('.select_products').prop('checked',true);
		}
		else
			$('.select_products').prop('checked',false);
	});	
	
});


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

function save_shipping_csv(model_id)
{
	$.ajax({
			url: '{{ url("/web88cms/shippingbycsv/addShippingByCsv") }}',
			type: 'POST',
			dataType: 'json',
			data: $('#form_add_shipping_csv').serialize(),
			beforeSend: function(){
			
			},
			complete: function(){
				
			},
			success: function(response){
				if(response['error'])
				{
					$('#'+model_id+' #errorElement').remove();
					$('#'+model_id+' #successElement').remove();
					var error = '<div id="errorElement" class="alert alert-danger"><i class="fa fa-times-circle"></i> <strong>Error!</strong>';
					for(var i=0; i < response['error'].length; i++)
					{
						error += '<p>'+ response['error'][i] +'</p>';
					}
					error += '</div>';
					$('#'+model_id+' #form_add_shipping_csv').before(error);	
				}
				
				if(response['success'])
				{
					$('#'+model_id+' #errorElement').remove();
					$('#'+model_id+' #successElement').remove();
					var success = '<div id="successElement" class="alert alert-success"><i class="fa fa-check-circle"></i> <strong>Success!</strong><p>The information has been saved/updated successfully.</p></div>';
					$('#'+model_id+' #form_add_shipping_csv').before(success);
					
					$('#'+model_id+' #apply_to_all').hide();
					$('#'+model_id+' #form_add_shipping_csv')[0].reset();
					
					setTimeout(function(){
						location.reload();
					}, 300);
				}
			}
		});		
}


function select_edit_products_list(modal_id)
{	
	if($('#'+modal_id+' #select_edit_products').is(':checked'))
	{
		$('#'+modal_id+' .select_products').prop('checked',true);
	}
	else
		$('#'+modal_id+' .select_products').prop('checked',false);
}

function update_shipping_amount(model_id)
{
	
	$.ajax({
			url: '{{ url("/web88cms/shipping/updateShippingOrderAmount") }}',
			type: 'POST',
			dataType: 'json',
			data: $('#'+model_id+' #form_edit_shipping_amount').serialize(),
			beforeSend: function(){
				
			},
			complete: function(){
				
			},
			success: function(response){
				if(response['error'])
				{
					$('#'+model_id+' #errorElement').remove();
					$('#'+model_id+' #successElement').remove();
					var error = '<div id="errorElement" class="alert alert-danger"><i class="fa fa-times-circle"></i> <strong>Error!</strong>';
					for(var i=0; i < response['error'].length; i++)
					{
						error += '<p>'+ response['error'][i] +'</p>';
					}
					error += '</div>';
					$('#'+model_id+' #form_edit_shipping_amount').before(error);	
				}
				
				if(response['success'])
				{
					$('#'+model_id+' #errorElement').remove();
					$('#'+model_id+' #successElement').remove();
					var success = '<div id="successElement" class="alert alert-success"><i class="fa fa-check-circle"></i> <strong>Success!</strong><p>The information has been saved/updated successfully.</p></div>';
					$('#'+model_id+' #form_edit_shipping_amount').before(success);
					
					//$('#'+model_id+' #apply_to_all').hide();
					setTimeout(function(){
						location.reload();
					}, 300);
					
				}
			}
		});		
}

function continue_delete_process_shipping_amount()
{
	item_id = $('#delete_item_ids').val();
	
	query_string = $('#query_string').val();
	
	
	// ajax call to delete messages
	$.ajax({	   
		   type : 'POST',
		   url : '{{ url("/web88cms/shipping/deleteShippingOrderAmount") }}',
		   data : 'id='+item_id+'&_token='+$('#csrf_token').val(),
		   success : function(response){	
		   		if(query_string == '')				
					window.location.href = "{{ url("/web88cms/shipping") }}";
				else
					window.location.href = "{{ url("/web88cms/shipping") }}?"+query_string;
		   }
	});	// end ajax	
}

</script>



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

@endsection
