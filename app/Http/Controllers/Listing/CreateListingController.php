<?php

namespace App\Http\Controllers\Listing;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Services\Listing\ListingService;
use App\Http\Requests\Listing\CreateListingRequest;

class CreateListingController extends Controller
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
    public function __invoke(CreateListingRequest $request)
    {
        $result = $this->listingService->createListing($request->all());

        return response()->success('Success Created Listing', Response::HTTP_CREATED, $result);
    }
}
