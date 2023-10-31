        <!-- Sidebar -->
            <style>
            .nav-link {
            text-decoration: none;
            }
            </style>
                <div class="sidebar" id="sidebar">
                <div class="sidebar-inner slimscroll">
					<div id="sidebar-menu" class="sidebar-menu">
						<ul class="nav-link">
							<li class="menu-title"> 
								<span class="fw-light">Main</span>
							</li>
							<li class="submenu">
								<li><a href="{{ route('dashboard')}}" style="text-decoration: none;"><i class="la la-dashboard"></i> <span> Dashboard</span></a></li>
								
							</li>
							<li class="menu-title"> 
								<span class="fw-light"></span>
							</li>
							<li class="submenu">
								<a href="#" style="text-decoration: none;"><i class="fa fa-sitemap" aria-hidden="true" style="font-size:16px" ></i><span style="font-size:14px">Work Structure</span> <span class="menu-arrow"></span></a>
								<ul style="display: none;" style="text-decoration: none;">
                                    <li><a href="{{route('bussiness_unit')}}"style="text-decoration: none;">Business Unit</a></li>
                                    <li><a href="{{ route('country.index')}}"style="text-decoration: none;">{{__('Geography')}}</a></li>
                                    <li><a href="{{route('department.index')}}"style="text-decoration: none;">{{ __('Department') }}</a></li>
                                    <li><a href="{{route('section.index') }}"style="text-decoration: none;">{{__('Section')}}</a></li>
                                    <li><a href="{{route('designation.index') }}"style="text-decoration: none;">{{ __('Designation') }}</a></li>
                                    <li><a href="{{route('grade.index')}}"style="text-decoration: none;">{{__('Grade')}}</a></li>
                                    <li><a href="{{route('holiday.index')}}"style="text-decoration: none;">{{__('Holiday')}}</a></li>
									<li><a href="{{route('basic_pay.index')}}"style="text-decoration: none;">{{__('Basic Pay')}}</a></li>
	
								</ul>
							</li>
                            <li class="menu-title"> 
								<span class="fw-light"></span>
							</li>
                            <li class="submenu">
								<a href="#"style="text-decoration: none;"><i class="bi bi-person-check" style="font-size:16px"></i> <span style="font-size:14px">Employee</span> <span class="menu-arrow"></span></a>
								<ul style="display: none;">
                                    <li><a href=""style="text-decoration: none;">Employee List</a></li>
									<li><a href=""style="text-decoration: none;">Directory</a></li>
								</ul>
							</li>

							<li class="menu-title"> 
								<span class="fw-light"></span>
							</li>
							<li class="submenu">
								<a href="#"style="text-decoration: none;"><i class="bi bi-person-check" style="font-size:16px"></i> <span style="font-size:14px"> Attendance</span> <span class="menu-arrow"></span></a>
								<ul style="display: none;">
                                    <li><a href=""style="text-decoration: none;">Attendance Entry</a></li>
									<li><a href=""style="text-decoration: none;">Attendance Register</a></li>
                                    <li><a href=""style="text-decoration: none;">Attendance Approval</a></li>
									<li><a href=""style="text-decoration: none;">Attendance Summary</a></li>
								</ul>
							</li>
							<li class="menu-title"> 
								<span class="fw-light"></span>
							</li>
							<li class="submenu">
								<a href="#" style="text-decoration: none;"><i class="bi bi-calendar-x" style="font-size:16px"></i> <span style="font-size:14px">Leave Management</span> <span class="menu-arrow"></span></a>
								<ul style="display: none;">
									<li><a href="{{route('leavetype.index')}}" style="text-decoration: none;">{{__('Types')}}</a></li>
									<li><a href="{{route('leavepolicy.index')}}" style="text-decoration: none;">{{__('Policy')}}</a></li>
									<li><a href="{{route('leave.history')}}" style="text-decoration: none;">{{__('Apply')}}</a></li>
									<li><a href="{{route('leaveApproval.index')}}" style="text-decoration: none;">{{__('Approval')}}</a></li>
									<li><a href=""style="text-decoration: none;">Cancellation</a></li>
									<li><a href=""style="text-decoration: none;">History</a></li>
                                    <li><a href=""style="text-decoration: none;">Encashment Approval</a></li>
								</ul>
							</li>

							<li class="menu-title"> 
								<span class="fw-light"></span>
							</li>
							<li class="submenu">
								<a href="#"style="text-decoration: none;"><i class="bi bi-cash-coin" style="font-size:16px"></i><span style="font-size:14px">Expense</span> <span class="menu-arrow"></span></a>
								<ul style="display: none;">
									<li><a href="{{ route ('expense-types') }} "style="text-decoration: none;">{{__('Types')}}</a></li>
									<li><a href="{{ route ('add-policy')}} "style="text-decoration: none;">{{__('Policy')}}</a></li>
									<li><a href="{{ route ('show-application-form')}} "style="text-decoration: none;">{{__('Apply Expense')}}</a></li>
									<li><a href="{{ route ('expense.approval.index')}} "style="text-decoration: none;">{{__('Expense Approval')}}</a></li>
									<li><a href="{{ route ('dsa-settlement-form') }}"style="text-decoration: none;">Apply DSA Claim/Settlement</a></li>
									<li><a href="{{ route ('dsa.approval.index') }}"style="text-decoration: none;">DSA Approval</a></li>
									<li><a href="{{ route ('dsa-data')}}"style="text-decoration: none;">DSA Claim List</a></li>
									<li><a href="{{ route ('vehicles.index')}}"style="text-decoration: none;">Add Vehicle</a></li>   
									<li><a href="{{ route ('fuels.index')}}"style="text-decoration: none;">Apply Expense Fuel</a></li>
									<li><a href="{{ route ('fuel.approval.index')}}"style="text-decoration: none;">Expense Fuel Approval</a></li>
									<li><a href="{{ route ('products.index')}}"style="text-decoration: none;">Apply Transfer Claim</a></li>
									<li><a href="{{ route ('transfer.approval.index')}}"style="text-decoration: none;">Transfer Claim Approval</a></li>
                                </ul>
									
							</li>

							<li class="menu-title"> 
								<span class="fw-light"></span>
							</li>
							<li class="submenu">
								<a href="#"style="text-decoration: none;"><i class="bi bi-cash-coin" style="font-size:16px"></i><span style="font-size:14px">Advance Loan</span> <span class="menu-arrow"></span></a>
								<ul style="display: none;">
									<li><a href="{{ route('show-advance-form')}}"style="text-decoration: none;">{{__('Advance Type')}}</a></li>
									<li><a href="{{ route('device.index')}}"style="text-decoration: none;">{{__('Add Device')}}</a></li>
									<li><a href="{{ route('advance-details')}}"style="text-decoration: none;">{{__('Apply Advance')}}</a></li>
									<li><a href="{{ route('advance.approval.index')}}"style="text-decoration: none;">{{__('Advance Approval')}}</a></li>
								</ul>
							</li>


                            <li class="menu-title"> 
								<span class="fw-light"></span>
							</li>
                            <li class="submenu">
								<a href="#"style="text-decoration: none;"><i class="bi bi-gear" style="font-size:16px"></i><span style="font-size:14px">Setting</span><span class="menu-arrow"></span></a>
                                <ul style="display: none;">
									<li><a href="{{route('users.create')}}"style="text-decoration: none;">{{__('System User')}}</a></li>
									<li><a href="{{route('role.index')}}"style="text-decoration: none;">{{__('Role')}}</a></li>
                                    <li><a href="{{route('permission.index')}}"style="text-decoration: none;">{{__('Permissions')}}</a></li>
									<li><a href="{{route('hierarchy.index')}}"style="text-decoration: none;">{{__('Hierarchy')}}</a></li>
									<li><a href="{{route('approval.index')}}"style="text-decoration: none;">{{__('LeaveApproval Rules')}}</a></li>
									<li><a href="{{ route('advance-approvalrule.index') }}" style="text-decoration: none;">{{__('AdvanceApproval Rules')}}</a></li>
									<li><a href="{{ route('expense-approvalrule.index') }}" style="text-decoration: none;">{{__('ExpenseApproval Rules')}}</a></li>
                                    <li><a href=""style="text-decoration: none;">Notification </a></li>


								</ul>
							</li>
							</ul>
							</li>
						</ul>
					</div>
                </div>
            </div> 
			 <!-- /Sidebar -->
