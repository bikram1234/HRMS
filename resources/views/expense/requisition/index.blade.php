<x-app-layout>
    <x-slot name="header">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Requisitions') }}
        </h2>
    </x-slot>
    <div class="container justify-content-center">
        <div class="row">
            <div class="col-lg-12 margin-tb mt-5">
                <div class="pull-right">
                    <a class="btn btn-success" href="{{ route('requisitions.create') }}"> Create New Requisition </a><br><br>
                </div>
            </div>
        </div>
       
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        
        <table class="table table-bordered">
            <tr>
                <th>Sl.No</th>
                <th>Requisition No</th>
                <th>Requisition Type</th>
                <th>Requisition Date</th>
                <th>Item Description</th>
                <th>Required Qty</th>
                <th width="240px">Actions</th>
                <th>Attachment</th>
            </tr>
            @foreach ($requisitions as $requisition)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $requisition->requisition_no }}</td>
                    <td>{{ $requisition->requisition_type }}</td>
                    <td>{{ $requisition->requisition_date }}</td>
                    <td>{{ $requisition->description }}</td>
                    <td>{{ $requisition->required_qty }}</td>
                    <td>
                        <form action="{{ route('requisitions.destroy', $requisition->id) }}" method="POST">
                            <a class="btn btn-info" href="{{ route('requisitions.show', $requisition->id) }}">Show</a>
                            <a class="btn btn-primary" href="{{ route('requisitions.edit', $requisition->id) }}">Edit</a>
                    
                        
                            <!-- Delete Button with Modal -->
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $requisition->id }}">Delete</button>
                        </form>
                    </td>
                    <td>
                        @if ($requisition->file_path)
                            <a href="{{ route('requisitions.download', ['file' => $requisition->id]) }}" class="btn btn-primary">Download</a>
                        @else
                            No File Attached
                        @endif
                    </td>
                </tr>

                

                <!-- Delete Modal -->
                <div class="modal fade" id="deleteModal{{ $requisition->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $requisition->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel{{ $requisition->id }}">Confirm Deletion</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete this requisition?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <form action="{{ route('requisitions.destroy', $requisition->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </table>
    </div>

    {!! $requisitions->links() !!}
    
    <!-- Bootstrap JavaScript and jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</x-app-layout>
