<?php

namespace App\Http\Requests\Tasks;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class FetchRequest extends FormRequest
{
    public function authorize() : bool
    {
        return Auth::check();
    }

    public function rules() : array
    {
        return [];
    }

    public function shouldPaginate() : bool
    {
        return $this->get('page') !== '0';
    }

    public function perPage() : int
    {
        return $this->get('limit') ?? Config::get('database.records_per_page');
    }
}
