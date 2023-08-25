<?php

namespace App\Http\Controllers\Listing;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Services\Listing\ListingService;

class GetAllListingController extends Controller
{
    private $listingService;

    public function __construct(ListingService $listingService)
    {
        $this->listingService = $listingService;
    }

    public function __invoke()
    {
        $result = $this->listingService->getAllListing();

        return response()->success('Success Sent All Listing', Response::HTTP_OK, $result);
    }
}
