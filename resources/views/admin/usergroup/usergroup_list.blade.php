@extends('adminLayout')

@section('content')
<div id="page-wrapper"><!--BEGIN PAGE HEADER & BREADCRUMB-->

        

        <div class="page-header-breadcrumb">

          <div class="page-heading hidden-xs">

            <h1 class="page-title">Customers</h1>

          </div>

          <ol class="breadcrumb page-breadcrumb">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/web88cms/dashboard/') }}">Dashboard</a>&nbsp; <i class="fa fa-angle-right"></i>&nbsp;</li>
            <li>Customers &nbsp;<i class="fa fa-angle-right"></i>&nbsp;</li>
            <li class="active">User Groups - Listing</li>
          </ol>

        </div>

        <!--END PAGE HEADER & BREADCRUMB-->
        
        <!--BEGIN CONTENT-->
        <div class="page-content">

                <div class="row">
            <div class="col-lg-12">
              <h2>User Groups <i class="fa fa-angle-right"></i> Listing</h2>
              <div class="clearfix"></div>  
              
              <p>
                @if (Session::has('flash_message'))
            	<div class="alert alert-success alert-dismissable">
              		<button type="button" data-dismiss="alert" aria-hidden="true" class="close">&times;</button>
              		<i class="fa fa-check-circle"></i> <strong>Success!</strong> <br />{{ Session::get('flash_message') }}
                </div>
                @endif 
              </p>
                        
              <div class="pull-left"> Last updated: <span class="text-blue"><?php echo date("d M, Y @ H.i A", strtotime($lastUpdated));?></span> </div>
              <div class="clearfix"></div>
              <p></p>
              
              
              <div class="clearfix"></div>
                
              
            </div>
            <!-- end col-lg-12 -->
  
                    
                    <div class="col-lg-12">
                    	<div class="portlet">
                            <div class="portlet-header">
                              <div class="caption">User Groups Listing</div>
                              <br/>
                              <p class="margin-top-10px"></p>
                              <a href="#" class="btn btn-success" data-target="#modal-add-group" data-toggle="modal">Add New User Group &nbsp;<i class="fa fa-plus"></i></a>&nbsp;
                              <div class="btn-group">
                                <button type="button" class="btn btn-primary">Delete</button>
                                <button type="button" data-toggle="dropdown" class="btn btn-red dropdown-toggle"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>
                                <ul role="menu" class="dropdown-menu">
                                  <li><a href="if($('.select_items:checked').length == 0){alert('Select items to delete.'); $('#sel').attr('data-toggle', '');return false;}else{ $('#sel').attr('data-toggle', 'modal'); }" data-target="#modal-delete-selected" data-toggle="modal">Delete selected item(s)</a></li>
                                  <li class="divider"></li>
                                  <li><a href="#" data-target="#modal-delete-all" data-toggle="modal">Delete all</a></li>
                                </ul>
                              </div>
                              
                               
            				  <div class="tools"> <i class="fa fa-chevron-up"></i> </div>
                              
                              <!--Modal add new user group start-->
                                <div id="modal-add-group" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                                  <div class="modal-dialog modal-wide-width">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                        <h4 id="modal-login-label2" class="modal-title">Add New User Group</h4>
                                      </div>
                                      <div class="modal-body">
                                        <div class="form">
                                          <form class="form-horizontal" id="addUsergroup">
                            				<input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Status <span class="text-red">*</span></label>
                                                <div class="col-md-6">
                                                  <div data-on="success" data-off="primary" class="make-switch">
                                                    <input name="status" value="1" type="checkbox" checked="checked"/>
                                                  </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputFirstName" class="col-md-4 control-label">User Group <span class="text-red">*</span></label>
                                                <div class="col-md-6">
                                                	<input name="usergroupName" type="text" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="form-group">
                                                <label for="inputFirstName" class="col-md-4 control-label">Type</label>
                                                <div class="col-md-6">
                                                	<select name="type" class="form-control">
                                                    	<option value="Customer">Customer</option>
                                                        <option value="Administrator">Administrator</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="form-actions">
                                              <div class="col-md-offset-5 col-md-8"> <a onclick="addUsergroup();" class="btn btn-red">Save &nbsp;<i class="fa fa-floppy-o"></i></a>&nbsp; <a href="#" data-dismiss="modal" class="btn btn-green">Cancel &nbsp;<i class="glyphicon glyphicon-ban-circle"></i></a> </div>
                                            </div>
                                          </form>
                                          <script>
												function addUsergroup(){
													var form_data = new window.FormData($('#addUsergroup')[0]);
																				
													$.ajax({			
														url: 'usergroups/addUsergroup',
														type:'post',
														dataType:'json',
														data: form_data,
														enctype: 'multipart/form-data',
														processData: false,
														contentType: false,
														success: function(response) {			
															if(response['error'])
															{
																$('#errorAddUsergroup').remove();
																$('#successAddUsergroup').remove();
																var error = '<div id="errorAddUsergroup" class="alert alert-danger"><i class="fa fa-times-circle"></i> <strong>Error!</strong>';
																if(response['error']=='This User Group is Already in Use.'){
																	error += '<p>'+ response['error'] +'</p>';
																}else{
																	for(var i=0; i < response['error'].length; i++)
																	{
																		error += '<p>'+ response['error'][i] +'</p>';
																	}
																}
																	error += '</div>';
																	$('#addUsergroup').before(error);	
																}
																								
																if(response['success'])
																{
																	$('#errorAddUsergroup').remove();
																	$('#successAddUsergroup').remove();
																	var success = '<div id="successAddUsergroup" class="alert alert-success"><i class="fa fa-check-circle"></i> <strong>Success!</strong><p>The information has been saved/updated successfully.<br />Page will be reload in 5 sec, Please Wait....</p></div>';
																	$('#addUsergroup').before(success);
																								
																	$('.addUsergroup').live('load');
																	
																	setTimeout(function(){
																		window.location.reload(1);
																	}, 5000);
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
                              <!--END MODAL add new user group -->
                              <!--Modal delete selected items start-->
                              <div id="modal-delete-selected" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                      <h4 id="modal-login-label3" class="modal-title"><a href=""><i class="fa fa-exclamation-triangle"></i></a> Are you sure you want to delete the selected item(s)? </h4>
                                    </div>
                                    <div class="modal-body">
                                      <div class="form-actions">
                                        <form action="usergroups/deleteUsergroup" method="post" name="deleteRecord">
                                            <input type="hidden" id="usergroupId" name="usergroupId" value="" />
                                            <input type="hidden" id="csrf_token" name="_token" value="{{ csrf_token() }}" />
                                            <div class="col-md-offset-4 col-md-8"> <a onclick="deleteRecord.submit();" class="btn btn-red">Yes &nbsp;<i class="fa fa-check"></i></a>&nbsp; <a href="#" data-dismiss="modal" class="btn btn-green">No &nbsp;<i class="fa fa-times-circle"></i></a> </div>
                                        </form>
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
                                        <div class="col-md-offset-4 col-md-8"> <a href="usergroups/deleteAll" class="btn btn-red">Yes &nbsp;<i class="fa fa-check"></i></a>&nbsp; <a href="#" data-dismiss="modal" class="btn btn-green">No &nbsp;<i class="fa fa-times-circle"></i></a> </div>
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
                                	<script>
										function url(val){
											if(val==10){
												window.open("<?= url('web88cms/usergroups/10/'.$page, $parameters = [], $secure = null); ?>","_self");
											}else if(val==20){
												window.open("<?= url('web88cms/usergroups/20/'.$page, $parameters = [], $secure = null); ?>","_self");
											}else if(val==30){
												window.open("<?= url('web88cms/usergroups/30/'.$page, $parameters = [], $secure = null); ?>","_self");
											}else if(val==50){
												window.open("<?= url('web88cms/usergroups/50/'.$page, $parameters = [], $secure = null); ?>","_self");
											}else if(val==100){
												window.open("<?= url('web88cms/usergroups/100/'.$page, $parameters = [], $secure = null); ?>","_self");
											}
										}
									</script>
                                  <select name="select" class="form-control" onchange="javascript:url(this.value);">
                                    <option <?php if($item==10){ echo 'selected="selected"'; }?>>10</option>
                                    <option <?php if($item==20){ echo 'selected="selected"'; }?>>20</option>
                                    <option <?php if($item==30){ echo 'selected="selected"'; }?>>30</option>
                                    <option <?php if($item==50){ echo 'selected="selected"'; }?>>50</option>
                                    <option <?php if($item==100){ echo 'selected="selected"'; }?>>100</option>
                                  </select>
                                  &nbsp;
                                  <label class="control-label">Records per page</label>
                                </div>
                              </div>
                              <div class="clearfix"></div>
                              <br/>
                              <br/>
                              <div class="table-responsive mtl">
                              	<table id="example1" class="table table-hover table-striped">
                                <thead>
                                  <tr>
                                    <th width="1%"><input type="checkbox" id="select_items"/></th>
                                    <th>#</th>
                                    <th><a href="#sort by user group">User Group</a></th>
                                    <th><a href="#sort by type">Type</a></th>
                                    <th><a href="#sort by status">Status</a></th>
                                    <th>Action</th>
                                  </tr>
                                </thead>
                                <tbody>
                                	<script>
										function selectForDelete(){
												$('#usergroupId').val('');
												
												$('input.select_items').each(function(){
								
													if($(this).is(':checked'))
													{
														id = $(this).attr('value');
														
														if($('#usergroupId').val() == '')
															$('#usergroupId').val(id);
														else
														{
															a = $('#usergroupId').val();
															
															$('#usergroupId').val(a+','+id);	
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
                                	<?php
										$i = 1;
										foreach($usergroups as $details)
										{
											$status_class = ($details->status == '0') ? 'label-red' : 'label-success';
											$status = ($details->status == '0') ? 'In-active' : 'Active';
											$statusChecked = ($details->status == '0') ? '' : 'checked="checked"';
									?>
                                  	<tr>
                                    <td><input type="checkbox" value="<?php echo $details->id; ?>" onclick="selectForDelete();" class="select_items"/></td>
                                    <td><?php echo $i;?></td>
                                    <td><?php echo $details->groupName; ?></td>
                                    <td><?php echo $details->type; ?></td>
                                    <td><span class="label label-sm <?php echo $status_class; ?>" id="subscriber-status-<?php echo $details->id; ?>"><?php echo $status; ?></span></td>
                                    <td><a href="#" data-hover="tooltip" data-placement="top" title="Edit" data-target="#modal-edit-group-<?php echo $details->id; ?>" data-toggle="modal"><span class="label label-sm label-success"><i class="fa fa-pencil"></i></span></a> <a href="#" data-hover="tooltip" data-placement="top" title="Delete" data-target="#modal-delete-<?php echo $details->id; ?>" data-toggle="modal"><span class="label label-sm label-red"><i class="fa fa-trash-o"></i></span></a>
                                        
                                        <!--Modal edit user group start-->
                                        <div id="modal-edit-group-<?php echo $details->id; ?>" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                                          <div class="modal-dialog modal-wide-width">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                                <h4 id="modal-login-label2" class="modal-title">Edit User Group</h4>
                                              </div>
                                              <div class="modal-body">
                                                <div class="form">
                                                  <form class="form-horizontal" id="editUsergroup-<?php echo $details->id; ?>">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                    <input type="hidden" name="usergroupId" value="<?php echo $details->id; ?>"  />
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label">Status <span class="text-red">*</span></label>
                                                        <div class="col-md-6">
                                                          <div data-on="success" data-off="primary" class="make-switch">
                                                            <input name="status" type="checkbox" value="1" <?php echo $statusChecked;?>/>
                                                          </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputFirstName" class="col-md-4 control-label">User Group <span class="text-red">*</span></label>
                                                        <div class="col-md-6">
                                                            <input id="inputUsername" type="text" placeholder="Name" class="form-control" name="usergroupName" value="<?php echo $details->groupName; ?>"/>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div class="form-group">
                                                        <label for="inputFirstName" class="col-md-4 control-label">Type</label>
                                                        <div class="col-md-6">
                                                            <select name="type" class="form-control">
                                                            	<option <?php if($details->type=='Customer'){?> selected="selected"<?php }?> value="Customer">Customer</option>
                                                                <option <?php if($details->type=='Administrator'){?> selected="selected"<?php }?> value="Administrator">Administrator</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-actions">
                                                      <div class="col-md-offset-5 col-md-8"> <a class="btn btn-red" onclick="editUsergroup(<?php echo $details->id;?>);">Save &nbsp;<i class="fa fa-floppy-o"></i></a>&nbsp; <a href="#" data-dismiss="modal" class="btn btn-green">Cancel &nbsp;<i class="glyphicon glyphicon-ban-circle"></i></a> </div>
                                                    </div>
                                                  </form>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                      </div>
                                      <!--END MODAL edit user group -->
                                        <!--Modal delete start-->
                                        <div id="modal-delete-<?php echo $details->id; ?>" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                                          <div class="modal-dialog">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                                <h4 id="modal-login-label3" class="modal-title"><a href=""><i class="fa fa-exclamation-triangle"></i></a> Are you sure you want to delete this user group? </h4>
                                              </div>
                                              <div class="modal-body">
                                                <p><strong>#01:</strong>  <?php echo $details->groupName; ?> - <?php echo $details->type; ?></p>
                                                <div class="form-actions">
                                                	<form id="deleteUsergroup<?php echo $details->id;?>" action="usergroups/deleteUsergroup" method="post" class="form-horizontal">
                                                        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                                        <input type="hidden" name="usergroupId" value="<?php echo $details->id;?>" />
                                                        <div class="col-md-offset-4 col-md-8"> <a onclick="deleteUsergroup<?php echo $details->id;?>.submit();" class="btn btn-red">Yes &nbsp;<i class="fa fa-check"></i></a>&nbsp; <a href="#" data-dismiss="modal" class="btn btn-green">No &nbsp;<i class="fa fa-times-circle"></i></a> </div>
                                                    </form>
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
									} // end foreach
								  ?>
                                  
								  
                                 
                                </tbody>
                                <tfoot>
                                  <tr>
                                    <td colspan="6"></td>
                                  </tr>
                                </tfoot>
                              </table>
                              <div class="tool-footer text-right">
                              	<?php 
									if(isset($countUserGroups) and $countUserGroups!=''){ 
										$totalPage = ceil($countUserGroups/$item);
									}else{
										$totalPage=0;	
									}
											
									$howMany = 2;
											  
								?>
                                <p class="pull-left">Showing 1 to 10 of 57 entries</p>
                                <ul class="pagination pagination mtm mbm">
                                        	<?php if($page<=1 and $totalPage<=1){ $class1 = "disabled"; }else{ $class1 = ""; }?>
                                        		<li class="<?php echo $class1;?>"><a href="<?= url('web88cms/usergroups/'.$item.'/'.($page-1), $parameters = [], $secure = null); ?>">&laquo;</a></li>
                                            
                                            
                                            <?php if ($page > $howMany + 1): ?>
                                                <li><a href="<?= url('web88cms/usergroups/'.$item.'/'.($page-1), $parameters = [], $secure = null); ?>">...</a></li>
                                            <?php endif; ?>
                                        
                                            <?php for ($pageIndex = $page - $howMany; $pageIndex <= $page + $howMany; $pageIndex++):  if($pageIndex==$page){ $active='active';}else{ $active='';}?>
                                                <?php if ($pageIndex >= 1 && $pageIndex <= $totalPage): ?>
                                                    <li class="<?php echo $active;?>">
                                                        <a href="<?= url('web88cms/usergroups/'.$item.'/'.$pageIndex, $parameters = [], $secure = null); ?>"><?php echo $pageIndex?></a>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                        
                                            <?php if ($page < $totalPage - $howMany): ?>
                                                <li><a href="<?= url('web88cms/usergroups/'.$item.'/'.($page+1), $parameters = [], $secure = null); ?>">...</a></li>
                                            <?php endif; ?>
    
                                            <?php if($totalPage<=1 and $page>=$totalPage){ $class2 = "disabled"; }else{ $class2 = ""; }?>
                                        	<li class="<?php echo $class2;?>"><a href="<?= url('web88cms/usergroups/' .$item.'/'.($page+1), $parameters = [], $secure = null); ?>">&raquo;</a></li>
                                            
                                        </ul>
                              </div>
                              <div class="clearfix"></div>
                            </div>
                          </div>
                        </div>
                        <!-- end porlet -->
              
                    </div>
                    <!-- end col-lg-12 -->
          </div>
          <script>
				function editUsergroup(Id){
					var form_data = new window.FormData($('#editUsergroup-'+Id)[0]);
												
					$.ajax({			
						url: 'usergroups/editUsergroup',
						type:'post',
						dataType:'json',
						data: form_data,
						enctype: 'multipart/form-data',
						processData: false,
						contentType: false,
						success: function(response) {			
							if(response['error'])
							{
								$('#errorEditUsergroup').remove();
								$('#successEditUsergroup').remove();
								var error = '<div id="errorEditUsergroup" class="alert alert-danger"><i class="fa fa-times-circle"></i> <strong>Error!</strong>';
								if(response['error']=='This User Group is Already in Use.'){
									error += '<p>'+ response['error'] +'</p>';
								}else{
									for(var i=0; i < response['error'].length; i++)
									{
										error += '<p>'+ response['error'][i] +'</p>';
									}
								}
									error += '</div>';
										$('#editUsergroup-'+Id).before(error);	

								}
																
								if(response['success'])
								{
									$('#errorEditUsergroup').remove();
									$('#successEditUsergroup').remove();
									var success = '<div id="successEditUsergroup" class="alert alert-success"><i class="fa fa-check-circle"></i> <strong>Success!</strong><p>The information has been saved/updated successfully.<br />Page will be reload in 5 sec, Please Wait....</p></p></div>';
									$('#editUsergroup-'+Id).before(success);
																
									$('.editUsergroup-'+Id).live('load');
									
									setTimeout(function(){
										window.location.reload(1);
									}, 5000);
								}
							}
						});
					}
			</script>
        <!--END CONTENT-->

            

            <!--BEGIN FOOTER-->

            <div class="page-footer">

                <div class="copyright"><span class="text-15px">2015 © <a href="http://www.webqom.com" target="_blank">Webqom Technologies Sdn Bhd.</a> Any queries, please contact <a href="mailto:support@webqom.com">Webqom Support</a>.</span>

                	<div class="pull-right"><img src="{{ asset('/public/admin/images/logo_webqom.png') }}" alt="Webqom Technologies"></div>

                </div>

            </div>

    <!--END FOOTER-->
    
   </div>
<!--LOADING SCRIPTS FOR PAGE-->
<script src="{{ URL::asset('public/admin/vendors/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('public/admin/vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ URL::asset('public/admin/vendors/moment/moment.js') }}"></script>
<script src="{{ URL::asset('public/admin/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ URL::asset('public/admin/vendors/bootstrap-timepicker/js/bootstrap-timepicker.js') }}"></script>
<script src="{{ URL::asset('public/admin/vendors/bootstrap-clockface/js/clockface.js') }}"></script>
<script src="{{ URL::asset('public/admin/vendors/bootstrap-colorpicker/js/bootstrap-colorpicker.js') }}"></script>
<script src="{{ URL::asset('public/admin/vendors/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
<script src="{{ URL::asset('public/admin/vendors/jquery-maskedinput/jquery-maskedinput.js') }}"></script>
<script src="{{ URL::asset('public/admin/js/form-components.js') }}"></script>
<!--LOADING SCRIPTS FOR PAGE-->

@endsection

