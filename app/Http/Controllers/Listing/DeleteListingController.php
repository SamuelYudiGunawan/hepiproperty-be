<?php

namespace App\Http\Controllers\Listing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeleteListingController extends Controller
{
    private $listingService;

    public function __construct(ListingService $listingService)
    {
        $this->listingService = $listingService;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($request, $id)
        // UpdateListingRequest $request)
    {
        $result = $this->listingService->deleteListing($request->id());

        return response()->success('Success Delete Listing', Response::HTTP_OK, $result);
    }
}
