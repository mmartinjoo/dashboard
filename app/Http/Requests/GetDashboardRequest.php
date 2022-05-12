<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;

class GetDashboardRequest extends FormRequest
{
    /**
     * @return Collection<Product>
     */
    public function products(): Collection
    {
        return Product::whereIn('id', $this->product_ids)->get();
    }

    public function rules()
    {
        return [
            'product_ids' => ['required', 'array'],
            'product_ids.*' => ['exists:products,id'],
        ];
    }
}
