@extends('layouts.index')

@section('content')
<!-- Page Wrapper content -->
<!-- Include Chart.js library first -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="page-wrapper">		
	<!-- Page Content -->
	<div class="content container-fluid">
		<!-- Page Header -->
			<div class="page-header">
				<div class="row">
					<div class="col-sm-12">
						<h3 class="page-title">Welcome Super Admin</h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item ">Dashboard</li>
							</ul>
					</div>
				</div>
			</div>
			<!-- /Page Header -->
            
			<div class="row  g-0">
				<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
					<div class="card dash-widget h-75">
						<div class="card-body">
							<span>		
								<img src="{{asset('assets/img/tashicell.png')}}"  height="40" width="40" alt=""></span>
							<span>
								<div class="dash-widget-info">
									<h6>112(Sangay Tenzin)</h6>
									<span><h6>Software Developer</h6></span>
								</div>
							</span>	
						</div>
					</div>
				</div>
					<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
						<div class="card dash-widget h-75">
							<div class="card-body">
								<div class="dash-widget-info">
									<h6>Department:Management Information Syetem</h6>
									<h6>D.O.B:1-March-2000</h6>
									<h6>D.O.B:1-March-2023</h6>
								</div>
								</span>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
						<div class="card dash-widget h-75">
							<div class="card-body">
								<div class="dash-widget-info">
									<h6>Region:Thimphu</h6>
									<h6>Gender:Male</h6>
									<h6>Employment Type: Regular</h6>
								</div>
								</span>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
						<div class="card dash-widget h-75">
							<div class="card-body">
								<div class="dash-widget-info">
									<h6>Grade: A1</h6>
									<h6>Role:Super Admin</h6>
									<h6>Manager:MR.Yeshi Norbu</h6>
								</div>
								</span>
							</div>
						</div>
				    </div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-6 text-center">
							<div class="card align-items-center">
								<div class="card-body">
									<h3 class="card-title">Casual Leave</h3>
										<div style="position: relative;width: 300px; height: 300px">
										    <canvas id="projectStatusChart"></canvas>
                 					    </div>
								</div>
						    </div>
					    </div>
				        <div class="col-md-6 text-center">
						    <div class="card align-items-center">
							    <div class="card-body">
                                    <h3 class="card-title">Earned Leave</h3>
                                        <div style="position: relative; width: 300px; height: 300px;">
                                            <canvas id="EarnedChart" ></canvas>
                                        </div>
							    </div>
						    </div>
					    </div>
					</div>
				</div>
				<div class="container">
				    <div class="row">
					    <div class="col-md-6 d-flex ">
						    <div class="card card-table flex-fill">
							    <div class="card-header">
								    <h3 class="card-title mb-0">Holidays</h3>
							    </div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table custom-table mb-0">
										<thead>
											<tr>
											<th>Name</th>
											<th>StarDate</th>
											<th>EndDate</th>
											</tr>
										</thead>
										<tbody>
											<tr>
											<td>Blessed Raining Day</td>
											<td>23-September-2023</td>
											<td>23-September-2023</td>	
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<div class="card-footer">
								<a href="clients.html">View more holidays</a>
							</div>
						</div>
					</div>
					
				<div class="col-md-6 d-flex">
                    <div class="card card-table flex-fill">
						<div class="card-header">
							<h3 class="card-title mb-0">Recent Projects</h3>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table class="table custom-table mb-0">
									<thead>
								        <tr>
											<th>Project Name </th>
											<th>Progress</th>
											<th class="text-right">Action</th>
										</tr>
									</thead>
									<tbody>
									<tr>
									    <td>
											<h2><a href="project-view.html" style="text-decoration: none;">Office Management</a></h2>
												<small class="block text-ellipsis">
													<span>1</span> <span class="text-muted">open tasks, </span>
													<span>9</span> <span class="text-muted">tasks completed</span>
												</small>
										</td>
										<td>
										    <div class="progress progress-xs progress-striped">
												<div class="progress-bar" role="progressbar" data-toggle="tooltip" title="65%" style="width: 65%"></div>
											</div>
										</td>
										<td class="text-right">
											<div class="dropdown dropdown-action">
											    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="text-decoration: none;"><i class="material-icons">more_vert</i></a>
													<div class="dropdown-menu dropdown-menu-right">
														<a class="dropdown-item" href="javascript:void(0)" style="text-decoration: none;"><i class="fa fa-pencil m-r-5"></i> Edit</a>
														<a class="dropdown-item" href="javascript:void(0)" style="text-decoration: none;"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
													</div>
											</div>
										</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					<div class="card-footer">
						<a href="projects.html" style="text-decoration: none;">View all projects</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /Page Content -->
</div>
<!-- /Page Wrapper -->
@endsection



