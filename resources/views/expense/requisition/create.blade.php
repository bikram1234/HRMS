<x-app-layout>
    <x-slot name="header">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Requisition') }}
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
       
        <form action="{{ route('requisitions.store') }}" method="POST" enctype="multipart/form-data" id="yourFormId">
            @csrf
          
            <div class="row">
            <div class="col-md-6 mt-3">
            <div class="form-group">
                <strong>Requisition No</strong>
                @php
                    $latestRequisition = \App\Models\Requisition::latest('id')->first();
                    $latestRequisitionNo = $latestRequisition ? $latestRequisition->requisition_no : 'REQ00000';
                    $newRequisitionNo = 'REQ' . str_pad((int)substr($latestRequisitionNo, 3) + 1, 5, '0', STR_PAD_LEFT);
                @endphp
                <input type="text" name="requisition_no" class="form-control" placeholder="Requisition No" value="{{ $newRequisitionNo }}" readonly>
            </div>

        </div>

                
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <strong>Requisition Type</strong>
                        <select class="form-select" aria-label="Default select example"  name="requisition_type" class="form-control" placeholder="Requisition Type">
                            <option selected>Select</option>
                            <option value="Individual">Individual</option>
                            <option value="Department">Department</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6  mt-3">
                    <div class="form-group">
                        <strong>Requisition Date</strong>
                        <input type="date" name="requisition_date" class="form-control" placeholder="Requisition Date">
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <strong>Need By Date</strong>
                        <input type="date" name="need_by_date" class="form-control" placeholder="Need By Date">
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <strong>Employee Name</strong>
                        <input type="text" name="employee_name" class="form-control"  value="{{ Auth::user()->name }}" readonly>
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <strong>Item Category</strong>
                        <select class="form-select" aria-label="Default select example"  name="item_category" class="form-control" placeholder="Item Category">
                            <option selected>Select</option>
                            <option value="FAQT.MISC">FAQT.MISC</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <strong>Item No</strong>
                        <input type="text" name="item_no" class="form-control" placeholder="Item No">
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <strong>Description</strong>
                        <input type="text" name="description" class="form-control" placeholder="Description">
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <strong>Specification</strong>
                        <input type="text" name="specification" class="form-control" placeholder="Specification">
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <strong>Remarks</strong>
                        <input type="text" name="remarks" class="form-control" placeholder="Remarks">
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <strong>UOM</strong>
                        <input type="text" name="uom" class="form-control" placeholder="UOM">
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <strong>Required Qty</strong>
                        <input type="text" name="required_qty" class="form-control" placeholder="Required Qty">
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
                <button type="button" class="btn btn-info btn-block col-md-4" id="openModalButton">Submit</button>
            </div>
        </form>
    </div>

    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to submit this form?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="confirmSubmit">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var openModalButton = document.getElementById("openModalButton");
        var confirmationModal = document.getElementById("confirmationModal");
        var confirmSubmit = document.getElementById("confirmSubmit");
        var yourForm = document.getElementById("yourFormId");

        openModalButton.addEventListener("click", function() {
            var isValid = validateForm(); // Custom validation function
            if (isValid) {
                $('#confirmationModal').modal('show'); // Show the modal if the form is valid
            }
        });

        confirmSubmit.addEventListener("click", function() {
            yourForm.submit(); // Submit the form if the user confirms
        });

        function validateForm() {
            // Add your form validation logic here
            // Check if all required fields are filled
            var allFieldsFilled = true;
            var requiredFields = yourForm.querySelectorAll("[required]");
            for (var i = 0; i < requiredFields.length; i++) {
                if (requiredFields[i].value.trim() === "") {
                    allFieldsFilled = false;
                    break;
                }
            }

            if (!allFieldsFilled) {
                alert("Please fill in all required fields.");
                return false;
            }

            // Add more validation logic here as needed
            return true; // Return true if the form is valid
        }
    });
</script>
</x-app-layout>

