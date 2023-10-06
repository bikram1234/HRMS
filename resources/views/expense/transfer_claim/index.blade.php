<x-app-layout>
    <x-slot name="header">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
        
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transfer Claim') }}
        </h2>
    </x-slot>
    <div class="container justify-content-center">
        <div class="row">
            <div class="col-lg-12 margin-tb mt-5">
                <div class="pull-right">
                    <a class="btn btn-success" href="{{ route('products.create') }}">Create New Transfer Claim</a><br><br>
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
                <th>Employee ID</th>
                <th>Transfer Claim Type</th>
                <th>Claim Amount</th>
                <th>Current Location</th>
                <th>New Location</th>
                <!-- Include Distance KM if needed -->
                <!-- <th>Distance KM</th> -->
                <th width="230px">Action</th>
            </tr>
            @foreach ($products as $product)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $product->employee_id }}</td>
                    <td>{{ $product->transfer_claim_type }}</td>
                    <td>{{ $product->claim_amount }}</td>
                    <td>{{ $product->current_location }}</td>
                    <td>{{ $product->new_location }}</td>
                    <!-- Include Distance KM if needed -->
                    <!-- <td>{{ $product->distance_km }}</td> -->
                    <td>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                        <a class="btn btn-info" href="{{ route('products.show', $product->id) }}">Show</a>
                            <a class="btn btn-primary" href="{{ route('products.edit', $product->id) }}">Edit</a>
                    
                        
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $product->id }}">Delete</button>
                        </form>
                    </td>
                </tr>
                <!-- Delete Modal -->
                <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $product->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel{{ $product->id }}">Confirm Deletion</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete this?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST">
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
  
    {!! $products->links() !!}
      
</x-app-layout>
