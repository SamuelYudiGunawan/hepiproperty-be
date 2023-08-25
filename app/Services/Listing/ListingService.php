<?php

namespace App\Services\Listing;

use LaravelEasyRepository\BaseService;

interface ListingService extends BaseService{

    public function createListing(array $data);
    public function getAllListing();
    public function updateListing(array $data);
    public function deleteListing($id);
}
