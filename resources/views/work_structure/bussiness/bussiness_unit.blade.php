@extends('layouts.index')

@section('content')
<style>
    .required-icon {
        color: red;
        margin-left: 5px;
    }
</style>
<div class="page-wrapper">		
	<!-- Page Content -->
	<div class="content container-fluid">
	<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<div class="col-sm-12">
					<h3 class="page-title">Bussiness Unit</h3>
						<ul class="breadcrumb">
							<li class="breadcrumb-item active">Dashboard/Work Structure/Bussiness Unit</li>
						</ul>
				</div>
			</div>
		</div>
    <!-- /Page Header -->
		<div class="row">
			<div class="col-md-12 stretch-card">
				<div class="card">
					<div class="card-body">
						<form>
							<div class="row">
                                <div class="col-sm-12">
									<div class="mb-3">
                                        <label class="form-label">Company Name <span class="required-icon">*</span></label>
										<input type="text" class="form-control" placeholder="Tashi infoComm Limited" style="background-color:#EFEFEF; height:55px">
									</div>
								</div>
							</div>
                            <!-- Row -->
							<div class="row">
								<div class="col-sm-4">
									<div class="mb-3">
										<label class="form-label">Company Short Name<span class="required-icon">*</span></label>
										<input type="text" class="form-control" placeholder="TICL" style="background-color:#EFEFEF; height:55px">
									</div>
								</div><!-- Col -->
								<div class="col-sm-4">
									<div class="mb-3">
										<label class="form-label">Incorporation Date<span class="required-icon">*</span></label>
										<input type="text" class="form-control" placeholder="23-JAN-2007"style="background-color:#EFEFEF; height:55px">
									</div>
								</div><!-- Col -->
								<div class="col-sm-4">
									<div class="mb-3">
										<label class="form-label">TPN Number<span class="required-icon">*</span></label>
										<input type="text" class="form-control" placeholder="TAC00084"style="background-color:#EFEFEF; height:55px">
									</div>
								</div><!-- Col -->
							</div><!-- Row -->
                            <div class="row">
                                <div class="col-sm-12">
									<div class="mb-3">
                                        <label class="form-label">Address<span class="required-icon">*</span></label>
										<input type="text" class="form-control" placeholder="Norzin Lam, Lungtenzampa BOD Complex, Post Box 1502 Thimphu, Bhutan"style="background-color:#EFEFEF; height:55px">
									</div>
								</div>
                            </div>
                            <div class="row">
								<div class="col-sm-3">
									<div class="mb-3">
										<label class="form-label">Country<span class="required-icon">*</span></label>
											<input type="text" class="form-control" placeholder="Bhutan"style="background-color:#EFEFEF; height:55px">
									</div>
								</div><!-- Col -->
								<div class="col-sm-3">
									<div class="mb-3">
										<label class="form-label">Region<span class="required-icon">*</span></label>
										<input type="text" class="form-control" placeholder="Thimphu"style="background-color:#EFEFEF; height:55px">
									</div>
								</div><!-- Col -->
								<div class="col-sm-3">
									<div class="mb-3">
										<label class="form-label">Dzongkha<span class="required-icon">*</span></label>
										<input type="text" class="form-control" placeholder="Thimphu"style="background-color:#EFEFEF; height:55px">
									</div>
								</div><!-- Col -->
                                <div class="col-sm-3">
									<div class="mb-3">
										<label class="form-label">Location<span class="required-icon">*</span></label>
										<input type="text" class="form-control" placeholder="TICL_Thimphu"style="background-color:#EFEFEF; height:55px">
									</div>
								</div><!-- Col -->
							</div><!-- Row -->
                                        <div class="row">
											<div class="col-sm-3">
												<div class="mb-3">
													<label class="form-label">Postal Code<span class="required-icon">*</span></label>
													<input type="text" class="form-control" placeholder="11001"style="background-color:#EFEFEF; height:55px">
												</div>
											</div><!-- Col -->
											<div class="col-sm-6">
												<div class="mb-3">
													<label class="form-label">Company Email<span class="required-icon">*</span></label>
													<input type="text" class="form-control" placeholder="info@tashicell.com"style="background-color:#EFEFEF; height:55px">
												</div>
											</div><!-- Col -->
											<div class="col-sm-3">
												<div class="mb-3">
													<label class="form-label">Phone No<span class="required-icon">*</span></label>
													<input type="text" class="form-control" placeholder="77889977"style="background-color:#EFEFEF; height:55px">
												</div>
											</div><!-- Col -->
                                            
										</div><!-- Row -->

                                        <div class="row">
											<div class="col-sm-3">
												<div class="mb-3">
													<label class="form-label">Contact Person<span class="required-icon">*</span></label>
													<input type="text" class="form-control" placeholder="Tashi"style="background-color:#EFEFEF; height:55px">
												</div>
											</div><!-- Col -->
											<div class="col-sm-6">
												<div class="mb-3">
													<label class="form-label">Contact Email<span class="required-icon">*</span></label>
													<input type="text" class="form-control" placeholder="info@tashicell.com"style="background-color:#EFEFEF; height:55px">
												</div>
											</div><!-- Col -->
											<div class="col-sm-3">
												<div class="mb-3">
													<label class="form-label">Mobile No<span class="required-icon">*</span></label>
													<input type="text" class="form-control" placeholder="77889977"style="background-color:#EFEFEF; height:55px">
												</div>
											</div><!-- Col -->
                                            
										</div><!-- Row -->
                                        <div class="row">
											<div class="col-sm-3">
												<div class="mb-3">
													<label class="form-label">Financial Year From<span class="required-icon">*</span></label>
													<input type="text" class="form-control" placeholder="01"style="background-color:#EFEFEF; height:55px">
												</div>
											</div><!-- Col -->
											<div class="col-sm-3">
												<div class="mb-3">
													<label class="form-label">Financial Year To<span class="required-icon">*</span></label>
													<input type="text" class="form-control" placeholder="12"style="background-color:#EFEFEF; height:55px">
												</div>
											</div><!-- Col -->
											<div class="col-sm-3">
												<div class="mb-3">
													<label class="form-label">Calendar Year From<span class="required-icon">*</span></label>
													<input type="text" class="form-control" placeholder="01"style="background-color:#EFEFEF; height:55px">
												</div>
											</div><!-- Col -->
                                            <div class="col-sm-3">
												<div class="mb-3">
													<label class="form-label">Calendar Year To<span class="required-icon">*</span></label>
													<input type="text" class="form-control" placeholder="12"style="background-color:#EFEFEF; height:55px">
												</div>
											</div><!-- Col -->
										</div><!-- Row -->
                                        <div class="row">
                                        <div class="col-sm-12">
												<div class="mb-3">

                                                    <label class="form-label">Website <span class="required-icon">*</span></label>
													<input type="text" class="form-control" placeholder="https://www.tashicell.com"style="background-color:#EFEFEF; height:55px">
												</div>
											</div>
										</div>

									</form>
									<!-- <button type="button" class="btn btn-primary submit">Submit form</button> -->
							</div>
						</div>
					</div>
				</div>
            </div>
			<!-- /Page Content -->
		</div>
		<!-- /Page Wrapper -->
@endsection