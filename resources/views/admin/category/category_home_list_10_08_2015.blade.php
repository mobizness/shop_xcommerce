@extends('adminBannerLayout')

@section('content')
<link type="text/css" rel="stylesheet" href="{{ asset('/public/admin/vendors/jquery-nestable/nestable.css') }}" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div id="page-wrapper">
  <div class="page-header-breadcrumb">
    <div class="page-heading hidden-xs">
      <h1 class="page-title">Products</h1>
    </div>
    <ol class="breadcrumb page-breadcrumb">
      <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/web88cms/dashboard') }}">Dashboard</a>&nbsp; <i class="fa fa-angle-right"></i>&nbsp;</li>
      <li>Products &nbsp;<i class="fa fa-angle-right"></i>&nbsp;</li>
      <li><a href="{{ url('/web88cms/categories/list') }}">All Categories Listing</a> &nbsp;<i class="fa fa-angle-right"></i>&nbsp;</li>
      <li class="active">Home Categories - Listing</li>
    </ol>
  </div>
  <div class="page-content">
    <div class="row">
      <div class="col-lg-12">
        <h2>Home Categories <i class="fa fa-angle-right"></i> Listing</h2>
        <div class="clearfix"></div>
        <p>@if (Session::has('flash_message'))
        <div class="alert alert-success alert-dismissable">
          <button type="button" data-dismiss="alert" aria-hidden="true" onClick="$('.form-horizontal').trigger('reset');" class="close">&times;</button>
          <i class="fa fa-check-circle"></i> <strong>Success!</strong> {{ Session::get('flash_message') }} </div>
        @endif
        </p>
        {{ $error = Session::get('error') }}
        {{ Session::get('error') }}
        @if($error)
        <div class="alert alert-danger alert-dismissable">
          <button type="button" data-dismiss="alert" aria-hidden="true" onClick="$('.form-horizontal').trigger('reset');" class="close">&times;</button>
          <i class="fa fa-times-circle"></i> <strong>Error!</strong>
          <p>{{ $error }}</p>
        </div>
        @endif 
        <!--   <div class="alert alert-success alert-dismissable">
        <button type="button" data-dismiss="alert" aria-hidden="true" onClick="$('.form-horizontal').trigger('reset');" class="close">&times;</button>
        <i class="fa fa-check-circle"></i> <strong>Success!</strong>
        <p>The information has been saved/updated successfully.</p>
      </div>
      <div class="alert alert-danger alert-dismissable">
        <button type="button" data-dismiss="alert" aria-hidden="true" onClick="$('.form-horizontal').trigger('reset');" class="close">&times;</button>
        <i class="fa fa-times-circle"></i> <strong>Error!</strong>
        <p>The information has not been saved/updated. Please correct the errors.</p>
      </div>-->
        <div class="pull-left"> Last updated: <span class="text-blue">15 Sept, 2014 @ 12.00PM</span> </div>
        <div class="clearfix"></div>
        <p></p>
        <div class="clearfix"></div>
      </div>
      <div class="col-lg-12">
        <ul id="myTab" class="nav nav-tabs">
          <li class="active"><a href="#brand-image" data-toggle="tab">Home Categories Listing</a></li>
        </ul>
        <div id="myTabContent" class="tab-content">
          <div id="brand-image" class="tab-pane fade in active">
            <div class="portlet">
              <div class="portlet-header">
                <div class="caption">Home Categories Listing</div>
                <br/>
                <p class="margin-top-10px"></p>
                <a href="#" data-target="#modal-add-new" data-toggle="modal" class="btn btn-success">Add New Category &nbsp;<i class="fa fa-plus"></i></a>&nbsp;
                <div class="btn-group">
                  <button type="button" class="btn btn-primary">Delete</button>
                  <button type="button" data-toggle="dropdown" class="btn btn-red dropdown-toggle"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>
                  <ul role="menu" class="dropdown-menu">
                  <li><a id="sel" href="#" onclick="if($('.select_items:checked').length == 0){alert('Select items to delete.'); $('#sel').attr('data-toggle', '');return false;}else{ $('#sel').attr('data-toggle', 'modal'); }" data-target="#modal-delete-selected" data-toggle="modal">Delete selected item(s)</a></li>
                    <li class="divider"></li>
                    <li><a href="#" data-target="#modal-delete-all" data-toggle="modal">Delete all</a></li>
                  </ul>
                </div>
                <div class="tools"> <i class="fa fa-chevron-up"></i> </div>
                <div id="modal-add-new" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                  <div class="modal-dialog modal-wide-width">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" data-dismiss="modal" aria-hidden="true" onClick="$('.form-horizontal').trigger('reset');" class="close">&times;</button>
                        <h4 id="modal-login-label3" class="modal-title">Add New Category</h4>
                      </div>
                      <div class="modal-body">
                        <div class="form">
                          <form class="form-horizontal" method="post" action="" id="catagroy_hom_list_add_form" name="catagroy_hom_list_add_form" enctype="multipart/form-data">
                            <input id="_token" type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                              <label class="col-md-3 control-label">Status</label>
                              <div class="col-md-6">
                                <div data-on="success" data-off="primary" class="make-switch">
                                  <input name="status" id="status"  type="checkbox" checked="checked" value="1"/>
                                </div>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-md-3 control-label">Title</label>
                              <div class="col-md-6">
                                <input type="text" name="cat_title" id="cat_title" class="form-control" required="required">
                              </div>
                            </div>
                            <div class="form-group border-bottom">
                              <label class="col-md-3 control-label">Enable Tab(s)</label>
                              <div class="col-md-6">
                                <div class="radio-list margin-top-10px">
                                  <label>
                                    <input id="enable_tab_yes" name="enable_tab" type="radio" value="1" checked="checked"/>
                                    &nbsp; Yes</label>
                                  <label>
                                    <input id="enable_tab_no" name="enable_tab" type="radio" value="0"/>
                                    &nbsp; No</label>
                                </div>
                              </div>
                              <div class="form-actions"> 
                                <!-- <input type="submit" name="submit" value="save" />-->
                                <div class="col-md-offset-5 col-md-8"> <a  onclick="add_cat_home_list();" href="javascript:void(0);" class="btn btn-red">Save &nbsp;<i class="fa fa-floppy-o"></i></a>&nbsp; <a href="#" data-dismiss="modal" onClick="$('.form-horizontal').trigger('reset');"  class="btn btn-green">Cancel &nbsp;<i class="glyphicon glyphicon-ban-circle"></i></a> </div>
                              </div>
                            </div>
                            
                            <!-- note to prorgammer: if enable tabs is selected, display the table below. if selects no, hide the below entire tab section.-->
                          </form>
                          <script>
								function add_cat_home_list(){
									var form_data = new window.FormData($('#catagroy_hom_list_add_form')[0]);
										//alert("hello");							
									$.ajax({	
										url: 'category_home_list',
										type:'post',
										dataType:'json',
										data: form_data,
										enctype: 'multipart/form-data',
										processData: false,
										contentType: false,
										success: function(response) {			
											if(response['error'])
											{
												$('#errorAddhomelistcat').remove();
												$('#successAddhomelistcat').remove();
												var error = '<div id="errorAddhomelistcat" class="alert alert-danger"><i class="fa fa-times-circle"></i> <strong>Error!</strong>';
												if(response['error']=='This  is already in use.'){
													error += '<p>'+ response['error'] +'</p>';
												}else{
													for(var i=0; i < response['error'].length; i++)
													{
														error += '<p>'+ response['error'][i] +'</p>';
													}
												}
													error += '</div>';
													$('#catagroy_hom_list_add_form').before(error);	
												}
																				
												if(response['success'])
												{
													$('#errorAddhomelistcat').remove();
													$('#successAddhomelistcat').remove();
													var success = '<div id="successAddhomelistcat" class="alert alert-success"><i class="fa fa-check-circle"></i> <strong>Success!</strong><p>The information has been saved/updated successfully.<br />Page will be reload in 2 sec, Please Wait....</p></div>';
													$('#catagroy_hom_list_add_form').before(success);
																				
													$('.catagroy_hom_list_add_form').live('load');
													
													setTimeout(function(){
									   					window.location.reload(1);
													}, 2000);
												}
											}
										});
									}
							</script>
                          <div class="portlet">
                            <div class="portlet-header">
                              <div class="caption">Tabs Listing</div>
                              <br/>
                              <p class="margin-top-10px"></p>
                              <a href="#" data-target="#modal-add-tab" data-toggle="modal" class="btn btn-success">Add New Tab &nbsp;<i class="fa fa-plus"></i></a>&nbsp;
                              <div class="btn-group">
                                   <button type="button" class="btn btn-primary">Delete</button>
                                <button type="button" data-toggle="dropdown" class="btn btn-red dropdown-toggle"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>
                                <ul role="menu" class="dropdown-menu">
                                  <li><a id="sel2" href="#" onclick="if($('.select_items2:checked').length == 0){alert('Select items to delete.'); $('#sel2').attr('data-toggle', '');return false;}else{ $('#sel2').attr('data-toggle', 'modal'); }" data-target="#modal-delete-selected2" data-toggle="modal">Delete selected item(s)</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#" data-target="#modal-delete-all2" data-toggle="modal">Delete all</a></li>
                                  </ul>
                              </div>
                              <div class="tools"> <i class="fa fa-chevron-up"></i> </div>
                              <div id="modal-add-tab" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                                <div class="modal-dialog modal-wide-width">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" data-dismiss="modal" aria-hidden="true" onClick="$('.form-horizontal').trigger('reset');" class="close">&times;</button>
                                      <h4 id="modal-login-label3" class="modal-title">Add New Tab</h4>
                                    </div>
                                    <div class="modal-body">
                                      <div class="form">
                                        <form class="form-horizontal" method="post" action="category_home_list/tablisting" id="tablisting_hom_list_add_form" name="tablisting_hom_list_add_form" enctype="multipart/form-data">
                                          <input id="token" type="hidden" name="_token" value="{{ csrf_token() }}">
                                          <div class="form-group">
                                            <label class="col-md-3 control-label">Status</label>
                                            <div class="col-md-6">
                                              <div data-on="success" data-off="primary" class="make-switch">
                                                <input name="status" id="status" type="checkbox" value="1" checked="checked"/>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-3 control-label">Title</label>
                                            <div class="col-md-6">
                                              <input name="title" id="title" type="text" class="form-control" placeholder="" required="required">
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-md-3 control-label">Display Order</label>
                                            <div class="col-md-6">
                                              <input type="text" name="display_order" id="display_order" class="form-control" placeholder="" required="required">
                                            </div>
                                          </div>
                                          <div class="form-actions"> 
                                            <!-- <input type="submit" name="submit" id="submit" value="save" />-->
                                            <div class="col-md-offset-4 col-md-8"> <a onclick="add_listtabcat_home();" href="javascript:void(0);"  class="btn btn-red">Save &nbsp;<i class="fa fa-floppy-o"></i></a>&nbsp; <a href="#" onClick="$('.form-horizontal').trigger('reset');"  data-dismiss="modal" class="btn btn-green">Cancel &nbsp;<i class="glyphicon glyphicon-ban-circle"></i></a> </div>
                                          </div>
                                        </form>
                                        <script>
								function add_listtabcat_home(){
									var form_data = new window.FormData($('#tablisting_hom_list_add_form')[0]);
										//alert("hello");							
									$.ajax({	
										url: 'category_home_list/tablisting',
										type:'post',
										dataType:'json',
										data: form_data,
										enctype: 'multipart/form-data',
										processData: false,
										contentType: false,
										success: function(response) {			
											if(response['error'])
											{
												$('#errorAddcatlistcat').remove();
												$('#successAddcatlistcat').remove();
												var error = '<div id="errorAddcatlistcat" class="alert alert-danger"><i class="fa fa-times-circle"></i> <strong>Error!</strong>';
												if(response['error']=='This  is already in use.'){
													error += '<p>'+ response['error'] +'</p>';
												}else{
													for(var i=0; i < response['error'].length; i++)
													{
														error += '<p>'+ response['error'][i] +'</p>';
													}
												}
													error += '</div>';
													$('#tablisting_hom_list_add_form').before(error);	
												}
																				
												if(response['success'])
												{
													$('#errorAddcatlistcat').remove();
													$('#successAddcatlistcat').remove();
													var success = '<div id="successAddcatlistcat" class="alert alert-success"><i class="fa fa-check-circle"></i> <strong>Success!</strong><p>The information has been saved/updated successfully.<br />Page will be reload in 2 sec, Please Wait....</p></div>';
													$('#tablisting_hom_list_add_form').before(success);
																				
													$('.tablisting_hom_list_add_form').live('load');
													
													setTimeout(function(){
									   					window.location.reload(1);
													}, 2000);
												}
											}
										});
									}
							</script> 
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                                <div id="modal-delete-selected2" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" data-dismiss="modal" aria-hidden="true" onClick="$('.form-horizontal').trigger('reset');" class="close">&times;</button>
                        <h4 id="modal-login-label4" class="modal-title"><a href=""><i class="fa fa-exclamation-triangle"></i></a> Are you sure you want to delete the selected item(s)? </h4>
                      </div>
                      <div class="modal-body">
                        <div class="form-actions">
                          <form action="category_home_list/deleteselectedtablist" method="post" name="deleteRecord2">
                            <input type="hidden" name="id" id="cathome_id" value="" />
                            <input type="hidden" id="csrf_token" name="_token" value="{{ csrf_token() }}" />
                            <div class="col-md-offset-4 col-md-8"> <a onclick="deleteRecord2.submit();" class="btn btn-red">Yes &nbsp;<i class="fa fa-check"></i></a>&nbsp; <a href="#" data-dismiss="modal" class="btn btn-green">No &nbsp;<i class="fa fa-times-circle"></i></a> </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div id="modal-delete-all2" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" data-dismiss="modal" aria-hidden="true" onClick="$('.form-horizontal').trigger('reset');" class="close">&times;</button>
                        <h4 id="modal-login-label4" class="modal-title"><a href=""><i class="fa fa-exclamation-triangle"></i></a> Are you sure you want to delete all items? </h4>
                      </div>
                      <div class="modal-body">
                        <div class="form-actions">
                          <div class="col-md-offset-4 col-md-8"> <a href="category_home_list/deleteselectedAllhometablistdata" class="btn btn-red">Yes &nbsp;<i class="fa fa-check"></i></a>&nbsp <a href="#" data-dismiss="modal" class="btn btn-green">No &nbsp;<i class="fa fa-times-circle"></i></a> </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
                            </div>
                          </div>
                            <script>
							function uniquefun(val, sn)
							{ 
								var inputs = $(".displayord");

								for(var i = 0; i <= inputs.length; i++){
									if($(inputs[i]).val()==val && i!=sn-1){
										alert("Order '"+val+"' is already in use. Please try another!");
										return false;	
									}
								}
							}
							</script>
                            
                            <form action="category_home_list/updatealltaborder" method="post" name="updatedisplayhome_tab_order" id="updatedisplayhome_tab_order" enctype="multipart/form-data" >
                          		
                        		
                                <input type="hidden" id="up_csrf_token" name="_token"  value="{{ csrf_token() }}" />
                                <?php foreach($hometabslistviewdata as $details)
								{?>
                               
                   <input type="hidden" name="display_order[<?php echo $details->id; ?>]" id="displayorder_<?php echo $details->id; ?>" class="form-control" value="<?php echo $details->display_order; ?>">
                    			
                    <?php } ?>
                    </form>
                          <div class="portlet-body">
                          <div class="pull-right"> <a onclick="document.getElementById('updatedisplayhome_tab_order').submit();" href="javascript:" class="btn btn-danger">Update Display Order &nbsp;<i class="fa fa-refresh"></i></a> </div>
                    <div class="clearfix"></div>
                            <div class="table-responsive mtl">
                              <table class="table table-hover table-striped">
                                <thead>
                                  <tr>
                                    <th width="1%"><input type="checkbox" id="select_items2" name="select_items2"/></th>
                                    <th>#</th>
                                    <th>Status</th>
                                    <th>Title</th>
                                    <th width="12%">Display Order</th>
                                    <th>Action</th>
                                  </tr>
                                </thead>
                                <script>
								function selectForDelete2(){
										$('#cathome_id').val('');
										
										$('input.select_items2').each(function(){
						
											if($(this).is(':checked'))
											{
												id = $(this).attr('value');
												
												if($('#cathome_id').val() == '')
													$('#cathome_id').val(id);
												else
												{
													a = $('#cathome_id').val();
													
													$('#cathome_id').val(a+','+id);	
												}
												
											}
									});
								}
								
								// select all checkboxes
								$(document).ready(function(){
									$('#select_items2').click(function(){
										//alert('asd');
										//if($('.select_items').length() > 0)
										if($('#select_items2').is(':checked'))
										{
											$('.select_items2').prop('checked',true);
										}
										else
											$('.select_items2').prop('checked',false);
											
										selectForDelete2();
									});	
								});
							</script>
                                <?php echo "<pre>";
			  $j=0;
			foreach($hometabslistviewdata as $details2){
				$status_class2 = ($details2->status == '1') ? 'label-success' : 'label-red';
									$status2 = ($details2->status == '1')? 'Active' : 'In-active';
			?>
                                <tbody>
                                  <tr>
                                    <td><input type="checkbox" value="<?php echo $details2->id; ?>" onclick="selectForDelete2();" class="select_items2"/></td>
                                    <td><?php echo ++$j;?></td>
                                    <td><span class="label label-sm <?php echo $status_class2; ?>" id="tabs-home-list-status-<?php echo $details2->id; ?>"><?php echo $status2; ?></span></td>
                                    <td><?php echo $details2->title; ?></td>
                                    <td>
                                    <input type="text" name="display_order" id="displayorder" onchange="uniquefun(this.value, <?php echo $j;?>);document.getElementById('displayorder_<?php echo $details2->id; ?>').value=this.value" class="form-control displayord" value="<?php echo $details2->display_order; ?>">
                  </td>
                                    </td>
                                    <td><a href="category_home_products_list?tabid=<?php echo $details2->id; ?>&homecatid=0" data-hover="tooltip" data-placement="top" title="View/Edit Products"><span class="label label-sm label-yellow"><i class="fa fa-search"></i></span></a> <a href="#" data-hover="tooltip" data-placement="top" data-target="#modal-edit-tab-<?php echo $details2->id; ?>" data-toggle="modal" title="Edit"><span class="label label-sm label-success"><i class="fa fa-pencil"></i></span></a>
                                     <a href="#" data-hover="tooltip" data-placement="top" title="Delete" data-target="#modal-delete-<?php echo $details2->id;?>" data-toggle="modal"><span class="label label-sm label-red"><i class="fa fa-trash-o"></i></span></a>
                                      <div id="modal-edit-tab-<?php echo $details2->id; ?>" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                                        <div class="modal-dialog modal-wide-width">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <button type="button" data-dismiss="modal" aria-hidden="true" onClick="$('.form-horizontal').trigger('reset');" class="close">&times;</button>
                                              <h4 id="modal-login-label3" class="modal-title">Edit Tab</h4>
                                            </div>
                                            <div class="modal-body">
                                              <div class="form">
                                                <form class="form-horizontal" name="edittablisthome-<?php echo $details2->id; ?>" id="edittablisthome-<?php echo $details2->id; ?>" method="post" action="category_home_list/edittablist" enctype="multipart/form-data" >
                                                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                  <input type="hidden" name="id" id="tabhome_id" value="<?php echo $details2->id; ?>" />
                                                  <div class="form-group">
                                                    <label class="col-md-3 control-label">Status</label>
                                                    <div class="col-md-6">
                                                      <div data-on="success" data-off="primary" class="make-switch">
                                                        <?php  
											if($details2->status=='1'){ $check2='checked="checked"';}else { $check2='';}?>
                                                        <input id="status" type="checkbox" name="status"  <?php echo $check2;?> value="1"  />
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="form-group">
                                                    <label class="col-md-3 control-label">Title</label>
                                                    <div class="col-md-6">
                                                      <input name="title" id="title" type="text" class="form-control" placeholder="" value="<?php echo $details2->title;?>">
                                                    </div>
                                                  </div>
                                                  <div class="form-group">
                                                    <label class="col-md-3 control-label">Display Order</label>
                                                    <div class="col-md-6">
                                                      <input type="text" name="display_order" id="display_order<?php echo $details2->id;  ?>" class="form-control" placeholder="" value="<?php echo $details2->display_order;?>">
                                                    </div>
                                                  </div>
                                                  <div class="form-actions">
                                                 <!-- <input type="submit" name="submit" value="submit" />-->
                                                    <div class="col-md-offset-5 col-md-8"> 
                                                    <a  onClick="edithometablsitdata(<?php echo $details2->id;  ?>);" class="btn btn-red">Save &nbsp;<i class="fa fa-floppy-o"></i></a>&nbsp; <a onClick="$('.form-horizontal').trigger('reset');"  href="#" data-dismiss="modal" class="btn btn-green">Cancel &nbsp;<i class="glyphicon glyphicon-ban-circle"></i></a> </div>
                                                  </div>
                                                </form>
                                                <script>
				function edithometablsitdata(Id){
					var form_data = new window.FormData($('#edittablisthome-'+Id)[0]);
												
					$.ajax({			
						url: 'category_home_list/edittablist',
						type:'post',
						dataType:'json',
						data: form_data,
						enctype: 'multipart/form-data',
						processData: false,
						contentType: false,
						success: function(response) {			
							if(response['error'])
							{
								$('#errorEdittablist').remove();
								$('#successEdittablist').remove();
								var error = '<div id="errorEdittablist" class="alert alert-danger"><i class="fa fa-times-circle"></i> <strong>Error!</strong>';
								if(response['error']=='This Email Id is already in use.'){
									error += '<p>'+ response['error'] +'</p>';
								}else{
									for(var i=0; i < response['error'].length; i++)
									{
										error += '<p>'+ response['error'][i] +'</p>';
									}
								}
									error += '</div>';
										$('#edittablisthome-'+Id).after(error);	

								}
																
								if(response['success'])
								{
									$('#errorEdittablist').remove();
									$('#successEdittablist').remove();
									var success = '<div id="successEdittablist" class="alert alert-success"><i class="fa fa-check-circle"></i> <strong>Success!</strong><p>The information has been saved/updated successfully.<br />Page will be reload in 2 sec, Please Wait....</p></p></div>';
									$('#edittablisthome-'+Id).after(success);
																
									$('.edittablisthome-'+Id).live('load');
									
									setTimeout(function(){
										window.location.reload(1);
									}, 2000);
								}
							}
						});
					}
			</script> 
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div id="modal-delete-<?php echo $details2->id;?>" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                                        <div class="modal-dialog">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <button type="button" data-dismiss="modal" aria-hidden="true" onClick="$('.form-horizontal').trigger('reset');" class="close">&times;</button>
                                              <h4 id="modal-login-label4" class="modal-title"><a href=""><i class="fa fa-exclamation-triangle"></i></a> Are you sure you want to delete this? </h4>
                                            </div>
                                            <div class="modal-body">
                                              <p><strong>#<?php echo $j;?>:</strong> <?php echo $details2->title;?></p>
                                              <div class="form-actions">
                                                <form  name="deleteform2" id="deleteform2-<?php echo $details2->id; ?>" method="post" action="category_home_list/deletetablist" enctype="multipart/form-data" >
                                                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                  <input type="hidden" name="id" id="cathome_id" value="<?php echo $details2->id; ?>" />
                                                  <div class="col-md-offset-4 col-md-8"> <a href="#" onclick="javascript:document.getElementById('deleteform2-<?php echo $details2->id; ?>').submit();" class="btn btn-red">Yes &nbsp;<i class="fa fa-check"></i></a>&nbsp; <a href="#" data-dismiss="modal" class="btn btn-green">No &nbsp;<i class="fa fa-times-circle"></i></a> </div>
                                                </form>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div></td>
                                  </tr>
                                </tbody>
                                <?php }?>
                                <tfoot>
                                  <tr>
                                    <td colspan="6"></td>
                                  </tr>
                                </tfoot>
                              </table>
                              <div class="clearfix"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div id="modal-delete-selected" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" data-dismiss="modal" aria-hidden="true" onClick="$('.form-horizontal').trigger('reset');" class="close">&times;</button>
                        <h4 id="modal-login-label4" class="modal-title"><a href=""><i class="fa fa-exclamation-triangle"></i></a> Are you sure you want to delete the selected item(s)? </h4>
                      </div>
                      <div class="modal-body">
                        <div class="form-actions">
                          <form action="category_home_list/deleteselectedcatlist" method="post" name="deleteRecord">
                            <input type="hidden" name="id" id="cathmainome_id" value="" />
                            <input type="hidden" id="csrf_token" name="_token" value="{{ csrf_token() }}" />
                            <div class="col-md-offset-4 col-md-8"> <a onclick="deleteRecord.submit();" class="btn btn-red">Yes &nbsp;<i class="fa fa-check"></i></a>&nbsp; <a href="#" data-dismiss="modal" class="btn btn-green">No &nbsp;<i class="fa fa-times-circle"></i></a> </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div id="modal-delete-all" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" data-dismiss="modal" aria-hidden="true" onClick="$('.form-horizontal').trigger('reset');" class="close">&times;</button>
                        <h4 id="modal-login-label4" class="modal-title"><a href=""><i class="fa fa-exclamation-triangle"></i></a> Are you sure you want to delete all items? </h4>
                      </div>
                      <div class="modal-body">
                        <div class="form-actions">
                          <div class="col-md-offset-4 col-md-8"> <a href="category_home_list/deleteselectedAllhomecategorylistdata" class="btn btn-red">Yes &nbsp;<i class="fa fa-check"></i></a>&nbsp <a href="#" data-dismiss="modal" class="btn btn-green">No &nbsp;<i class="fa fa-times-circle"></i></a> </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
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
              
                <div class="table-responsive mtl">
                  <table class="table table-hover table-striped">
                    <script>
								function selectForDelete(){
										$('#cathmainome_id').val('');
										
										$('input.select_items').each(function(){
						
											if($(this).is(':checked'))
											{
												id = $(this).attr('value');
												
												if($('#cathmainome_id').val() == '')
													$('#cathmainome_id').val(id);
												else
												{
													a = $('#cathmainome_id').val();
													
													$('#cathmainome_id').val(a+','+id);	
												}
												
											}
									});
								}
								
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
											
										selectForDelete();
									});	
								});
							</script>
                    <thead>
                      <tr>
                        <th width="1%"><input type="checkbox" id="select_items"/></th>
                        <th>#</th>
                        <th>Status</th>
                        <th>Title</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <?php echo "<pre>";
			  $i=0;
			foreach($catagroyhomelistviewdata as $details){
				$status_class = ($details->status == '1') ? 'label-success' : 'label-red';
									$status = ($details->status == '1')? 'Active' : 'In-active';
									
			?>
                    <tbody>
                      <tr>
                        <td><input type="checkbox" value="<?php echo $details->id; ?>" onclick="selectForDelete();" class="select_items"/></td>
                        <td><?php echo ++$i;?></td>
                        <td><span class="label label-sm <?php echo $status_class; ?>" id="category-home-list-status-<?php echo $details->id; ?>"><?php echo $status; ?></span></td>
                        <td><?php echo $details->cat_title; ?></td>
                        <td><?php $enabletab= $details->enable_tab; if($enabletab!=1) {?>
                        <a href="http://<?php echo $_SERVER['HTTP_HOST'];?>/web88cms/categories/category_home_products_list?tabid=0&homecatid=<?php echo $details->id; ?>" data-hover="tooltip" data-placement="top" title="View/Edit Products"><span class="label label-sm label-yellow"><i class="fa fa-search"></i></span></a>
                        <?php }?>
                        
                        <a href="#" data-hover="tooltip" data-placement="top" data-target="#modal-edit-category-<?php echo $details->id;?>" data-toggle="modal" title="Edit"><span class="label label-sm label-success"><i class="fa fa-pencil"></i></span></a> 
                        <a href="#" data-hover="tooltip" data-placement="top" title="Delete" data-target="#modal2-delete-<?php echo $details->id;?>" data-toggle="modal"><span class="label label-sm label-red"><i class="fa fa-trash-o"></i></span></a>
                                        <div id="modal-edit-category-<?php echo $details->id;?>" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                            <div class="modal-dialog modal-wide-width">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" data-dismiss="modal" aria-hidden="true" onClick="$('.form-horizontal').trigger('reset');" class="close">&times;</button>
                                  <h4 id="modal-login-label3" class="modal-title">Category Edit</h4>
                                </div>
                                <div class="modal-body">
                                  <div class="form">
                                    <form class="form-horizontal" name="editcathome-<?php echo $details->id; ?>" id="editcathome-<?php echo $details->id; ?>" method="post" action="category_home_list/editcatlist" enctype="multipart/form-data" >
                                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                      <input type="hidden" name="id" id="cathome_id" value="<?php echo $details->id; ?>" />
                                      <div class="form-group">
                                        <label class="col-md-3 control-label">Status</label>
                                        <div class="col-md-6">
                                          <div data-on="success" data-off="primary" class="make-switch">
                                            <?php  
											if($details->status=='1'){ $check='checked="checked"';}else { $check='';}?>
                                            <input id="status" type="checkbox" name="status"  <?php echo $check;?> value="1"  />
                                          </div>
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <label class="col-md-3 control-label">Title </label>
                                        <div class="col-md-6">
                                          <input id="cat_title" name="cat_title" required="required" type="text" class="form-control" value="<?php echo $details->cat_title;?>">
                                        </div>
                                      </div>
                                      <div class="form-actions">
                                       <!-- <input type="submit" value="edit" name="edit" />-->
                                        <div class="col-md-offset-5 col-md-8"> <a onClick="edithomecategorylsitdata(<?php echo $details->id;  ?>);" class="btn btn-red">Save &nbsp;<i class="fa fa-floppy-o"></i></a>&nbsp; <a onClick="$('.form-horizontal').trigger('reset');"  href="#" data-dismiss="modal" class="btn btn-green">Cancel &nbsp;<i class="glyphicon glyphicon-ban-circle"></i></a> </div>
                                      </div>
                                    </form>
                                    <script>
				function edithomecategorylsitdata(Id){
					var form_data = new window.FormData($('#editcathome-'+Id)[0]);
												
					$.ajax({			
						url: 'category_home_list/editcatlist',
						type:'post',
						dataType:'json',
						data: form_data,
						enctype: 'multipart/form-data',
						processData: false,
						contentType: false,
						success: function(response) {			
							if(response['error'])
							{
								$('#errorEditcatlist').remove();
								$('#successEditcatlist').remove();
								var error = '<div id="errorEditcatlistr" class="alert alert-danger"><i class="fa fa-times-circle"></i> <strong>Error!</strong>';
								if(response['error']=='This Email Id is already in use.'){
									error += '<p>'+ response['error'] +'</p>';
								}else{
									for(var i=0; i < response['error'].length; i++)
									{
										error += '<p>'+ response['error'][i] +'</p>';
									}
								}
									error += '</div>';
										$('#editcathome-'+Id).after(error);	

								}
																
								if(response['success'])
								{
									$('#errorEditcatlist').remove();
									$('#successEditcatlist').remove();
									var success = '<div id="successEditcatlist" class="alert alert-success"><i class="fa fa-check-circle"></i> <strong>Success!</strong><p>The information has been saved/updated successfully.<br />Page will be reload in 2 sec, Please Wait....</p></p></div>';
									$('#editcathome-'+Id).after(success);
																
									$('.editcathome-'+Id).live('load');
									
									setTimeout(function(){
										window.location.reload(1);
									}, 2000);
								}
							}
						});
					}
			</script> 
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                         
                          <div id="modal2-delete-<?php echo $details->id;?>" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" data-dismiss="modal" aria-hidden="true" onClick="$('.form-horizontal').trigger('reset');" class="close">&times;</button>
                                  <h4 id="modal-login-label4" class="modal-title"><a href=""><i class="fa fa-exclamation-triangle"></i></a> Are you sure you want to delete this? </h4>
                                </div>
                                <div class="modal-body">
                                  <p><strong>#<?php echo $i;?>:</strong> <?php echo $details->cat_title;?></p>
                                  <div class="form-actions">
                                    <form  name="deleteform" id="deleteform<?php echo $details->id; ?>" method="post" action="category_home_list/deletecatlist" enctype="multipart/form-data" >
                                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                      <input type="hidden" name="enable_tab" value="<?php echo $details->enable_tab; ?>" />
                                      <?php $enabletab= $details->enable_tab; if($enabletab!=1) {?>
                                      <input type="hidden" name="tabid" value="0">
                                      <input type="hidden" name="homecatid" value="<?php echo $details->id; ?>">
                         <?php }?>
                         
                                      <input type="hidden" name="id" id="cathome_id" value="<?php echo $details->id; ?>" />
                                      <div class="col-md-offset-4 col-md-8"> <a href="#" onclick="javascript:document.getElementById('deleteform<?php echo $details->id; ?>').submit();" class="btn btn-red">Yes &nbsp;<i class="fa fa-check"></i></a>&nbsp; <a href="#" data-dismiss="modal" class="btn btn-green">No &nbsp;<i class="fa fa-times-circle"></i></a> </div>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div></td>
                      </tr>
                    </tbody>
                    <?php } ?>
                    <tfoot>
                      <tr>
                        <td colspan="5"></td>
                      </tr>
                    </tfoot>
                  </table>
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
          </div>

        </div>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
    <!--BEGIN FOOTER-->
  <div class="page-footer">
        <div class="copyright"><span class="text-15px">2015 © <a href="http://www.webqom.com" target="_blank">Webqom Technologies Sdn Bhd.</a> Any queries, please contact <a href="mailto:support@webqom.com">Webqom Support</a>.</span>
        <div class="pull-right"><img src="{{ asset('/public/admin/images/logo_webqom.png')}}" alt="Webqom Technologies Sdn Bhd"></div>
        </div>
    </div>
  <!--END FOOTER-->

</div>
<input id="_token" type="hidden" name="_token" value="{{ csrf_token() }}">
<script src="{{ asset('/public/admin/js/jquery-1.9.1.js') }}"></script> 
<script src="{{ asset('/public/admin/js/jquery-migrate-1.2.1.min.js') }}"></script> 
<script src="{{ asset('/public/admin/js/jquery-ui.js') }}"></script> 
<!--loading bootstrap js--> 
<script src="{{ asset('/public/admin/vendors/bootstrap/js/bootstrap.min.js') }}"></script> 
<script src="{{ asset('/public/admin/vendors/bootstrap-hover-dropdown/bootstrap-hover-dropdown.js') }}"></script> 
<script src="{{ asset('/public/admin/js/html5shiv.js') }}"></script> 
<script src="{{ asset('/public/admin/js/respond.min.js') }}"></script> 
<script src="{{ asset('/public/admin/vendors/metisMenu/jquery.metisMenu.js') }}"></script> 
<script src="{{ asset('/public/admin/vendors/slimScroll/jquery.slimscroll.js') }}"></script> 
<script src="{{ asset('/public/admin/vendors/jquery-cookie/jquery.cookie.js') }}"></script> 
<script src="{{ asset('/public/admin/js/jquery.menu.js') }}"></script> 
<script src="{{ asset('/public/admin/vendors/jquery-pace/pace.min.js') }}"></script> 

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

<!--CORE JAVASCRIPT--> 
<script src="{{ asset('/public/admin/js/main.js') }}"></script> 
<script src="{{ asset('/public/admin/js/holder.js') }}"></script> 
<script type="text/javascript">
$(function(){
	$('select[name="select_per_page"]').change(function(){
		window.location = '{{ url("web88cms/categories/homeList") }}/' + $(this).val();
	});
})
</script> 
@endsection