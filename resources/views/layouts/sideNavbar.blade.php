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
								<span class="fw-light">Work Structure</span>
							</li>
							<li class="submenu">
								<a href="#" style="text-decoration: none;"><i class="fa fa-sitemap" aria-hidden="true" style="font-size:20px" ></i><span>Work Structure</span> <span class="menu-arrow"></span></a>
								<ul style="display: none;" style="text-decoration: none;">
                                    <li><a href="{{route('bussiness_unit')}}"style="text-decoration: none;">Business Unit</a></li>
                                    <li><a href=""style="text-decoration: none;">Geography</a></li>
                                    <li><a href="{{route('department.index')}}"style="text-decoration: none;">{{ __('Department') }}</a></li>
                                    <li><a href="{{route('section.index') }}"style="text-decoration: none;">{{__('Section')}}</a></li>
                                    <li><a href="{{route('designation.index') }}"style="text-decoration: none;">{{ __('Designation') }}</a></li>
                                    <li><a href="{{route('grade.index')}}"style="text-decoration: none;">{{__('Grade')}}</a></li>
                                    <li><a href=""style="text-decoration: none;">Holiday</a></li>
									<li><a href=""style="text-decoration: none;">Store Geo Tagging</a></li>	
								</ul>
							</li>
                            <li class="menu-title"> 
								<span class="fw-light">Employees Management</span>
							</li>
                            <li class="submenu">
								<a href="#"style="text-decoration: none;"><i class="bi bi-person-check" style="font-size:20px"></i> <span>Employee</span> <span class="menu-arrow"></span></a>
								<ul style="display: none;">
                                    <li><a href=""style="text-decoration: none;">Employee List</a></li>
									<li><a href=""style="text-decoration: none;">Directory</a></li>
								</ul>
							</li>

							<li class="menu-title"> 
								<span class="fw-light">Attendance Management</span>
							</li>
							<li class="submenu">
								<a href="#"style="text-decoration: none;"><i class="bi bi-person-check" style="font-size:20px"></i> <span> Attendance</span> <span class="menu-arrow"></span></a>
								<ul style="display: none;">
                                    <li><a href=""style="text-decoration: none;">Attendance Entry</a></li>
									<li><a href=""style="text-decoration: none;">Attendance Register</a></li>
                                    <li><a href=""style="text-decoration: none;">Attendance Approval</a></li>
									<li><a href=""style="text-decoration: none;">Attendance Summary</a></li>
								</ul>
							</li>
							<li class="menu-title"> 
								<span class="fw-light">Leave Management</span>
							</li>
							<li class="submenu">
								<a href="#" style="text-decoration: none;"><i class="bi bi-calendar-x" style="font-size:20px"></i> <span>Leave</span> <span class="menu-arrow"></span></a>
								<ul style="display: none;">
									<li><a href="{{route('leavetype.index')}}"style="text-decoration: none;">{{__('Types')}}</a></li>
									<li><a href="{{route('leavepolicy.index')}}"style="text-decoration: none;">{{__('Policy')}}</a></li>
									<li><a href="{{route('leaveapply.create')}}"style="text-decoration: none;">{{__('Apply')}}</a></li>
                                    <li><a href=""style="text-decoration: none;">Approval</a></li>
									<li><a href=""style="text-decoration: none;">Cancellation</a></li>
									<li><a href=""style="text-decoration: none;">History</a></li>
                                    <li><a href=""style="text-decoration: none;">Encashment Approval</a></li>
								</ul>
							</li>

							<li class="menu-title"> 
								<span class="fw-light">Expense Management</span>
							</li>
							<li class="submenu">
								<a href="#"style="text-decoration: none;"><i class="bi bi-cash-coin" style="font-size:20px"></i><span>Expense</span> <span class="menu-arrow"></span></a>
								<ul style="display: none;">
									<li><a href="{{ route ('expense-types') }}"style="text-decoration: none;">{{__('Types')}}</a></li>
									<li><a href="{{ route ('add-policy')}}"style="text-decoration: none;">{{__('Policy')}}</a></li>
									<li><a href=""style="text-decoration: none;">Apply </a></li>
									<li><a href=""style="text-decoration: none;">DSA Claim/Settlement</a></li>
									<li><a href=""style="text-decoration: none;">Expense Fuel/Fuel Claim </a></li>
									<li><a href=""style="text-decoration: none;">Transfer Claim</a></li>
                                    <li><a href=""style="text-decoration: none;">Expense Paid List</a></li>
                                    <li><a href=""style="text-decoration: none;">Requisition Apply</a></li>
                                    <li><a href=""style="text-decoration: none;">Requisition History</a></li>
                                    <li><a href=""style="text-decoration: none;">Requisition Approval</a></li>
                                </ul>
									
							</li>
                            <li class="menu-title"> 
								<span class="fw-light">Setting Management</span>
							</li>
                            <li class="submenu">
								<a href="#"style="text-decoration: none;"><i class="bi bi-gear" style="font-size:20px"></i><span>Setting</span><span class="menu-arrow"></span></a>
                                <ul style="display: none;">
									<li><a href=""style="text-decoration: none;">System User </a></li>
                                    <li><a href="{{route('permission.index')}}"style="text-decoration: none;">{{__('Permissions')}}</a></li>
									<li><a href="{{route('role.index')}}"style="text-decoration: none;">{{__('Role')}}</a></li>
                                    <li><a href=""style="text-decoration: none;">Notification </a></li>
                                    <li><a href=""style="text-decoration: none;">Approval Rules</a></li>
                                    <li><a href=""style="text-decoration: none;">Hierarchy</a></li>
								</ul>
							</li>
							</ul>
							</li>
						</ul>
					</div>
                </div>
            </div> 
			 <!-- /Sidebar -->
