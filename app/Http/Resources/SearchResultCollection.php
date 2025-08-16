<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SearchResultCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'meta' => [
                'pagination' => [
                    'current_page' => $this->currentPage(),
                    'per_page' => $this->perPage(),
                    'total' => $this->total(),
                ],
            ],
        ];
    }

    public function withResponse($request, $response)
    {
        // Remove wrapping entirely (prevents links/meta being added)
        $response->setData((object) $this->toArray($request));
    }
}
