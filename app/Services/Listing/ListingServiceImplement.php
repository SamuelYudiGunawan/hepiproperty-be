<?php

namespace App\Services\Listing;

use App\Models\Listing;
use Illuminate\Support\Facades\DB;
use LaravelEasyRepository\Service;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Listing\ListingRepository;

class ListingServiceImplement extends Service implements ListingService{

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    // protected $mainRepository;

    // public function __construct(ListingRepository $mainRepository)
    // {
    //   $this->mainRepository = $mainRepository;
    // }

    public function createListing(array $data){
      try{
        $listing  = Listing::create([
          'judul' => $data['judul'],
          'tipe' => $data['tipe'],
          'tipe_bangunan' => $data['tipe_bangunan'],
          'harga' => $data['harga'],
          'deskripsi' => $data['deskripsi'],
          'area' => $data['area'],
          'luas_tanah' => $data['luas_tanah'],
          'luas_bangunan' => $data['luas_bangunan'],
          'kamar_tidur' => $data['kamar_tidur'],
          'kamar_mandi' => $data['kamar_mandi'],
          'kamar_tidur_pembantu' => $data['kamar_tidur_pembantu'],
          'kamar_mandi_pembantu' => $data['kamar_mandi_pembantu'],
          'listrik' => $data['listrik'],
          'air' => $data['air'],
          'sertifikat' => $data['sertifikat'],
          'hadap' => $data['hadap'],
          'garasi_dan_carport' => $data['garasi_dan_carport'],
          'furnished' => $data['furnished'],
          'user_id' => $data['user_id'],
        ]);

        return ['listing' => $listing];

      } catch (\Throwable $th) {
        DB::rollBack();
        throw $th;
      }
    }

    public function updateListing(){
      try{
        DB::beginTransaction();

        $listing = Listing::findOrFail($id);

        $listing  = Listing->update([
          'judul' => $data['judul'],
          'tipe' => $data['tipe'],
          'tipe_bangunan' => $data['tipe_bangunan'],
          'harga' => $data['harga'],
          'deskripsi' => $data['deskripsi'],
          'area' => $data['area'],
          'luas_tanah' => $data['luas_tanah'],
          'luas_bangunan' => $data['luas_bangunan'],
          'kamar_tidur' => $data['kamar_tidur'],
          'kamar_mandi' => $data['kamar_mandi'],
          'kamar_tidur_pembantu' => $data['kamar_tidur_pembantu'],
          'kamar_mandi_pembantu' => $data['kamar_mandi_pembantu'],
          'listrik' => $data['listrik'],
          'air' => $data['air'],
          'sertifikat' => $data['sertifikat'],
          'hadap' => $data['hadap'],
          'garasi_dan_carport' => $data['garasi_dan_carport'],
          'furnished' => $data['furnished'],
          'user_id' => $data['user_id'],
        ]);
        DB::commit();
        return ['listing' => $listing];

      } catch (\Throwable $th) {
        DB::rollBack();
        throw $th;
      }
    }

    public function getAllListing(){
      try{
        $listings = Listing::all();

        return ['listing' => $listings];
        } catch (\Throwable $th) {
          DB::rollBack();
          throw $th;
      }
    }

    public function deleteListing($id){
      try{
        $listing = Listing::findOrFail($listingId);
        $listing->delete();

        return ['listing' => $listings];
        } catch (\Throwable $th) {
          DB::rollBack();
          throw $th;
      }
    }
    // Define your custom methods :)
}
