<x-app-layout>
    <x-slot name="header">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Requisition Details') }}
        </h2>
    </x-slot>
    <div class="container justify-content-center">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card mt-5">
                    <div class="card-header">
                        <h4 class="text-center">Requisition Details</h4>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th>Requisition No:</th>
                                <td>{{ $requisition->requisition_no }}</td>
                            </tr>
                            <tr>
                                <th>Requisition Type:</th>
                                <td>{{ $requisition->requisition_type }}</td>
                            </tr>
                            <tr>
                                <th>Requisition Date:</th>
                                <td>{{ $requisition->requisition_date }}</td>
                            </tr>
                            <tr>
                                <th>Need By Date:</th>
                                <td>{{ $requisition->need_by_date }}</td>
                            </tr>
                            <tr>
                                <th>Employee Name:</th>
                                <td>{{ $requisition->employee_name }}</td>
                            </tr>
                            <tr>
                                <th>Item Category:</th>
                                <td>{{ $requisition->item_category }}</td>
                            </tr>
                            <tr>
                                <th>Item No:</th>
                                <td>{{ $requisition->item_no }}</td>
                            </tr>
                            <tr>
                                <th>Description:</th>
                                <td>{{ $requisition->description }}</td>
                            </tr>
                            <tr>
                                <th>Specification:</th>
                                <td>{{ $requisition->specification }}</td>
                            </tr>
                            <tr>
                                <th>Remarks:</th>
                                <td>{{ $requisition->remarks }}</td>
                            </tr>
                            <tr>
                                <th>UOM:</th>
                                <td>{{ $requisition->uom }}</td>
                            </tr>
                            <tr>
                                <th>Required Qty:</th>
                                <td>{{ $requisition->required_qty }}</td>
                            </tr>
                            <tr>
                            <th>Required Qty:</th>
                            <td>
                                @if ($requisition->file_path)
                                    <a href="{{ route('requisitions.download', ['file' => $requisition->id]) }}">Download File</a>
                                @else
                                    No File Attached
                                @endif
                            </td>    
                            </tr>
                        </table>
                    </div>
                    <div class="card-footer text-center">
                        <a class="btn btn-primary" href="{{ route('requisitions.index') }}"> Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
