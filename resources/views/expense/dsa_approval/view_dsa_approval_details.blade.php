<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('DSA Settlement Form') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-lg font-semibold mb-4">DSA Settlement ({{ $type }}):</h2>

                    <div class="table-responsive">
                        <table class="table table-bordered table-white">
                            <thead class="table-light">
                                <tr class="table-light">
                                    <th class="table-light">Advance Amount</th>
                                    <th class="table-light">Total Amount Adjusted</th>
                                    <th class="table-light">Net Payable Amount</th>
                                    <th class="table-light">Balance Amount</th>
                                    <th class="table-light">Status</th>
                                    <th class="table-light">Remark</th>
                                    <!-- Add more table headers for DSA Settlement details as needed -->
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="table-light">
                                    <td class="table-light">{{ $dsaSettlement->advance_amount }}</td>
                                    <td class="table-light">{{ $dsaSettlement->total_amount_adjusted }}</td>
                                    <td class="table-light">{{ $dsaSettlement->net_payable_amount }}</td>
                                    <td class="table-light">{{ $dsaSettlement->balance_amount }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap" style="color: {{ $dsaSettlement->status === 'pending' ? 'orange' : ($dsaSettlement->status === 'approved' ? 'green' : 'red') }};">
                                        {{ $dsaSettlement->status }}
                                    </td>
                                    <td class="table-light">{{ $dsaSettlement->remark }}</td>
                                    <!-- Add more table cells for DSA Settlement details as needed -->
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    @if ($dsaManualSettlements->isNotEmpty())
                    <h2 class="text-lg font-semibold">Manual Settlements:</h2>
                    <div class="table-responsive">
                        <table class="table table-bordered table-white">
                            <thead class="table-light">
                                <tr class="table-light">
                                    <th class="table-light">From Date</th>
                                    <th class="table-light">From Location</th>
                                    <th class="table-light">To Date</th>
                                    <th class="table-light">To Location</th>
                                    <th class="table-light">Total Days</th>
                                    <th class="table-light">DA</th>
                                    <th class="table-light">TA</th>
                                    <th class="table-light">Total Amount</th>
                                    <th class="table-light">Remark</th>
                                    <!-- Add more table headers for DSA Manual Settlement details as needed -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dsaManualSettlements as $manualSettlement)
                                <tr class="table-light">
                                    <td class="table-light">{{ $manualSettlement->from_date }}</td>
                                    <td class="table-light">{{ $manualSettlement->from_location }}</td>
                                    <td class="table-light">{{ $manualSettlement->to_date }}</td>
                                    <td class="table-light">{{ $manualSettlement->to_location }}</td>
                                    <td class="table-light">{{ $manualSettlement->total_days }}</td>
                                    <td class="table-light">{{ $manualSettlement->da }}</td>
                                    <td class="table-light">{{ $manualSettlement->ta }}</td>
                                    <td class="table-light">{{ $manualSettlement->total_amount }}</td>
                                    <td class="table-light">{{ $manualSettlement->remark }}</td>
                                    <!-- Add more table cells for DSA Manual Settlement details as needed -->
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-lg font-semibold">No Manual Settlements found for this DSA.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
