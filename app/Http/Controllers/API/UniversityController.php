<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\University;
use App\Http\Resources\UniversityCollection;
use App\Http\Resources\UniversityResource;
use App\Services\University\CreateUniversity;

class UniversityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $records = University::query();
        $sort_by = $request->input('sort_by','created_at');
        $order_by = $request->input('order_by','desc');
        $per_page = $request->input('per_page',10);

        $paginate_amount = self::getPaginationSize($per_page);
        $records = self::searchRow($request, $records);
        $records = self::sortRow($sort_by, $order_by, $records);

        return (new UniversityCollection($records->paginate($paginate_amount)))
        ->additional([
            'status' => 'success',
            'message' => 'List of universities'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $university = new CreateUniversity;
        list($university,$error) = $university->execute($request->all());
        
        if ($error != null) {
            $response = [
                'status' => 'failed',
                'message' => $error,
                'data' => $university
            ];

            return response()->json($response,400);
        }

        return new UniversityResource($university);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(University $university)
    {
        return (new UniversityResource($university))
        ->additional([
            'status' => 'success',
            'message' => 'University details'
        ])
        ->response()
        ->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

       /**
     * Private function to defined size of pagination
     *
     * @param [Integer] $perPage
     * @return Integer
     */
    public function getPaginationSize($per_page)
    {
        $per_page_allowed = [20,50,100,500];

        if (in_array($per_page, $per_page_allowed)) {
            return $per_page;
        }
        return  10;
    }

    /**
     * Private function to search row
     * @param [String] $request
     * @param [Collection] $records
     * @return Integer
     */
    protected function searchRow($request, $records)
    {
        if ($request->has('name')) {
            $records = $records->where('name','LIKE','%' . $request->name . '%');
        }

        if ($request->has('address')) {
            $records = $records->where('address','LIKE', '%' . $request->address . '%');
        }
        
        return $records;
    }

    /**
     * Private function to sorting
     *
     * @param [String] $sort_by
     * @param [String] $order_by
     * @param [Collection] $records
     * @return Collection
     */

     protected function sortRow(string $sort_by, string $order_by, $records)
     {
        if ($sort_by == 'name') {
           $records->orderBy('status', 'asc');
        }

        return $records->orderBy($sort_by, $order_by);
     }
}
