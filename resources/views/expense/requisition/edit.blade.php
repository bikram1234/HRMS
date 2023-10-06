<x-app-layout>
    <x-slot name="header">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Requisition') }}
        </h2>
    </x-slot>
    <div class="container justify-content-center">
        <div class="row">
            <div class="col-lg-12 margin-tb mt-3">
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('requisitions.index') }}"> Back</a>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('requisitions.update', $requisition->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <strong>Requisition No</strong>
                        <input type="text" name="requisition_no" value="{{ $requisition->requisition_no }}" class="form-control" placeholder="Requisition No">
                    </div>
                </div>

                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <strong>Requisition Type</strong>
                        <select class="form-select" aria-label="Default select example"  name="requisition_type" value="{{ $requisition->requisition_type }}" class="form-control" placeholder="Requisition Type">
                            <option selected>Select</option>
                            <option value="Individual" {{ $requisition->requisition_type === 'Individual' ? 'selected' : '' }}> Individual </option>
                            <option value="Department" {{ $requisition->requisition_type === 'Department' ? 'selected' : '' }}> Department </option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <strong>Requisition Date</strong>
                        <input type="date" name="requisition_date" value="{{ $requisition->requisition_date }}" class="form-control" placeholder="Requisition Date">
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <strong>Need By Date</strong>
                        <input type="date" name="need_by_date" value="{{ $requisition->need_by_date }}" class="form-control" placeholder="Need By Date">
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <strong>Employee Name</strong>
                        <input type="text" name="employee_name" value="{{ $requisition->employee_name }}" class="form-control" readonly>
                    </div>
                </div>

                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <strong>Item Category</strong>
                        <select class="form-select" aria-label="Default select example" name="item_category" value="{{ $requisition->item_category }}" class="form-control" placeholder="Item Category">
                            <option selected>Select</option>
                            <option value="FAQT.MISC" {{ $requisition->item_category === 'FAQT.MISC' ? 'selected' : '' }}>FAQT.MISC</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <strong>Item No</strong>
                        <input type="text" name="item_no" value="{{ $requisition->item_no }}" class="form-control" placeholder="Item No">
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <strong>Description</strong>
                        <input type="text" name="description" value="{{ $requisition->description }}" class="form-control" placeholder="Description">
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <strong>Specification</strong>
                        <input type="text" name="specification" value="{{ $requisition->specification }}" class="form-control" placeholder="Specification">
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <strong>Remarks</strong>
                        <input type="text" name="remarks" value="{{ $requisition->remarks }}" class="form-control" placeholder="Remarks">
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <strong>UOM</strong>
                        <input type="text" name="uom" value="{{ $requisition->uom }}" class="form-control" placeholder="UOM">
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <strong>Required Qty</strong>
                        <input type="text" name="required_qty" value="{{ $requisition->required_qty }}" class="form-control" placeholder="Required Qty">
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <strong>Attachment (PDF only)</strong>
                        <input type="file" name="file" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row mt-5 justify-content-center">
                <button type="submit" class="btn btn-info btn-block col-md-4">Update</button>
            </div>
        </form>
    </div>
</x-app-layout>
