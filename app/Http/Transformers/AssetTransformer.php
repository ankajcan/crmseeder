<?php

namespace App\Http\Transformers;

use App\Models\Asset;
use League\Fractal\TransformerAbstract;

class AssetTransformer extends TransformerAbstract {

    /**
     * @param Asset $asset
     * @return array
     */
    public function transform(Asset $asset)
    {
        return [
            'name' => $asset->name,
            'path' => $asset->path,
            'entity_id' => $asset->entity_id,
            'entity_type' => $asset->entity_type,
            'type' => $asset->type,
            'url' => $asset->url
        ];
    }

}