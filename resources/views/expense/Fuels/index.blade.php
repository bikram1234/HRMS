<x-app-layout>

    <x-slot name="header">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
        
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Fuel Claims') }}
        </h2>
    </x-slot>
    
    <div class="container justify-content-center">
        <div class="row">
            <div class="col-lg-12 margin-tb mt-5">
                <div class="pull-right">
                    <a class="btn btn-success" href="{{ route('fuels.create') }}">Create New Fuel Claim</a><br><br>
                </div>
            </div>
        </div>
   
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
    
        <table class="table table-bordered ">
            <tr>
                <th>Sl.No</th>
                <th>Employee Name</th>
                <th>Location</th>
                <th>Date</th>
                <th>Vehicle No</th>
                <th>Vehicle Type</th>
                <th>Initial KM</th>
                <th>Final KM</th>
                <th>Quantity</th>
                <th>Mileage</th>
                <th>Rate</th>
                <th>Amount</th>
                <th width="240px">Action</th>
            </tr>
            @foreach ($fuels as $fuel)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $fuel->employee_name }}</td>
                <td>{{ $fuel->location }}</td>
                <td>{{ $fuel->date }}</td>
                <td>{{ $fuel->vehicle_no }}</td>
                <td>{{ $fuel->vehicle_type }}</td>
                <td>{{ $fuel->initial_km }}</td>
                <td>{{ $fuel->final_km }}</td>
                <td>{{ $fuel->quantity }}</td>
                <td>{{ $fuel->mileage }}</td>
                <td>{{ $fuel->rate }}</td>
                <td>{{ $fuel->amount }}</td>
                <td>
                    <form action="{{ route('fuels.destroy', $fuel->id) }}" method="POST">
                    <a class="btn btn-info" href="{{ route('fuels.show', $fuel->id) }}">Show</a>
                        <a class="btn btn-primary" href="{{ route('fuels.edit', $fuel->id) }}">Edit</a> 
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $fuel->id }}">Delete</button>
                    </form>
                </td>
            </tr>
            <!-- Delete Modal -->
            <div class="modal fade" id="deleteModal{{ $fuel->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $fuel->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel{{ $fuel->id }}">Confirm Deletion</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete this?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <form action="{{ route('fuels.destroy', $fuel->id) }}" method="POST">
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
    
    {!! $fuels->links() !!}
</x-app-layout>
