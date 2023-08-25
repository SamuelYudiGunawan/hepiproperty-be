<?php

namespace App\Http\Controllers\Listing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Listing\ListingService;

class UpdateListingController extends Controller
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
    public function __invoke(Request $request)
        // UpdateListingRequest $request)
    {
        $result = $this->listingService->updateListing($request->all());

        return response()->success('Success Update Listing', Response::HTTP_OK, $result);
    }
}
