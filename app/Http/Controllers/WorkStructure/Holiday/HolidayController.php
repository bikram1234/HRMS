<?php

namespace App\Http\Controllers\WorkStructure\Holiday;

use App\Http\Controllers\Controller;
use App\Models\holidaytype;
use App\Models\region;
use App\Models\holiday;
use App\Http\Requests\StoreholidayRequest;
use App\Http\Requests\UpdateholidayRequest;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $holidays = holiday::all();
        $holidaytypes = holidaytype::all();
        $regions = region::all();
        return view('work_structure.holiday.holiday',  compact('regions', 'holidaytypes', 'holidays'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(StoreholidayRequest $request)
    // {
    //     $validatedData = $request->validated();

    //     // Convert the array of region_ids to a comma-separated string
    //     $regionIds = implode(',', $validatedData['region_id']);

    //     dd($regionIds);
    //     // Create a new holiday record and set the region_ids
    //     $holiday = new Holiday();
    //     $holiday->name = $validatedData['name'];
    //     $holiday->holiday_id = $validatedData['holiday_id'];
    //     $holiday->region_id = $regionIds; // Assign the comma-separated region_ids
    //     $holiday->optradioholidayfrom = $validatedData['optradioholidayfrom'];
    //     $holiday->optradioholidaylto = $validatedData['optradioholidaylto'];
    //     $holiday->txt_istartdate = $validatedData['txt_istartdate'];
    //     $holiday->txt_ienddate = $validatedData['txt_ienddate'];
    //     $holiday->number_of_days = $validatedData['number_of_days'];
    //     $holiday->description = $validatedData['description'];
    //     $holiday->status = $validatedData['status'];

    //     // Save the holiday record to the database
    //     $holiday->save();

    //     return redirect()->route('holiday.index')->with('success', 'Holiday added successfully');
    // }

    public function store(Request $request)
        {
            // Validate the request data

            $validatedData = $request->validate([
                'name' => 'required|string',
                'year' => 'required|integer',
                'holidaytype_id' => 'required|integer',
                'region_id' => 'required|array',
                'region_id.*' => 'integer', // Make sure each region_id is an integer
                'optradioholidayfrom' => 'string', // Validation rules for other fields
                'start_date' => 'date',
                'optradioholidaylto' => 'string',
                'end_date' => 'date',
                'number_of_days' => 'numeric|min:0.5',
                'description' => 'nullable|string',
            ]);


            $holiday = new Holiday();
            $holiday->name = $validatedData['name'];
            $holiday->year = $validatedData['year'];
            $holiday->holidaytype_id = $validatedData['holidaytype_id'];
            $holiday->optradioholidayfrom = $request->input('optradioholidayfrom')?? null;
            $holiday->start_date = $validatedData['start_date'];
            $holiday->optradioholidaylto = $request->input('optradioholidaylto') ?? null;
            $holiday->end_date = $validatedData['end_date'];
            $holiday->number_of_days = $validatedData['number_of_days'];
            $holiday->description = $validatedData['description'];

            // Save the holiday record
            $holiday->save();

            // Attach selected regions to the holiday
            $holiday->regions()->attach($validatedData['region_id']);

            // Redirect or return a response
                //display the message 
            $notification = array(
                'message' => 'Holiday Added successfully',
                'alert-type' =>'success'
            );
            return redirect()->route('holiday.index')->with($notification);
        }


    /**
     * Display the specified resource.
     */
    public function show(holiday $holiday)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(holiday $holiday)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateholidayRequest $request, holiday $holiday)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(holiday $holiday)
    {
        //
    }
    public function fetchHolidayDates()
    {
        try {
            // Retrieve the currently logged-in user's region ID
            $userRegionId = auth()->user()->region_id;
    
            // Retrieve the holiday dates from your database using the Holiday model
            $holidays = Holiday::select('start_date', 'end_date')
                ->whereHas('regions', function ($query) use ($userRegionId) {
                    // Filter holidays by the user's region ID
                    $query->where('regions.id', $userRegionId);
                })
                ->get();
    
            $allDates = [];
    
            // Iterate through the holidays and extract all the dates within each range
            foreach ($holidays as $holiday) {
                $startDate = new \DateTime($holiday->start_date);
                $endDate = new \DateTime($holiday->end_date);
    
                // Create a DatePeriod object to iterate through the dates in the range
                $dateInterval = new \DateInterval('P1D');
                $dateRange = new \DatePeriod($startDate, $dateInterval, $endDate);
    
                // Add each date to the $allDates array
                foreach ($dateRange as $date) {
                    $allDates[] = $date->format('Y-m-d');
                }
    
                // Add the end_date as well
                $allDates[] = $endDate->format('Y-m-d');
            }
    
            // Remove duplicates and sort the dates
            $uniqueDates = array_unique($allDates);
            sort($uniqueDates);
    
            return response()->json(['holiday_dates' => $uniqueDates]);
        } catch (\Exception $e) {
            // Handle any errors that may occur during the database query
            return response()->json(['error' => 'An error occurred while fetching holiday dates.'], 500);
        }
    }
    
    
    
}
