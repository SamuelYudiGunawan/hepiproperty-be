<?php

namespace App\Http\Requests\Listing;

use Illuminate\Foundation\Http\FormRequest;

class CreateListingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'judul' => 'required|string',
            'tipe' => 'required|string',
            'tipe_bangunan' => 'required|string',
            'harga' => 'required|string',
            'deskripsi' => 'required|string',
            'area' => 'required|string',
            'luas_tanah' => 'required|integer',
            'luas_bangunan' => 'required|integer',
            'kamar_tidur' => 'required|integer',
            'kamar_mandi' => 'required|integer',
            'kamar_tidur_pembantu' => 'required|integer',
            'kamar_mandi_pembantu' => 'required|integer',
            'listrik' => 'required|string',
            'air' => 'required|string',
            'sertifikat' => 'required|string',
            'hadap' => 'required|string',
            'garasi_dan_carport' => 'required|boolean',
            'furnished' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ];
    }
}
