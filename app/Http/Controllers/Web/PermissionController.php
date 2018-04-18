<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\ApiController;
use App\Http\Requests\PermissionStoreRequest;
use App\Http\Requests\PermissionUpdateRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;


class PermissionController extends ApiController
{
    const MODEL_CLASS = Permission::class;
    const MODEL_NAME = "Permissions";
    const MODEL_TEMPLATE_PATH = "permission";

    /*
    |--------------------------------------------------------------------------
    | AJAX
    |--------------------------------------------------------------------------
    */

    public function store(PermissionStoreRequest $request)
    {
        $model = self::MODEL_CLASS;

        $entity = $model::create(['name' => $request->get('name')]);
        $entity->save();

        return $this->respond(["message" => self::MODEL_NAME. " created successfully"]);
    }

    public function update(PermissionUpdateRequest $request, $id)
    {
        $model = self::MODEL_CLASS;

        $entity = $model::find($id);

        $entity->update(['name' => $request->get('name')]);

        return $this->respond(["message" => self::MODEL_NAME. " updated successfully"]);
    }

    public function delete(Request $request, $id)
    {
        $model = self::MODEL_CLASS;

        $entity = $model::find($id);

        $entity->delete();

        return $this->respond(["message" => self::MODEL_NAME. "  deleted successfully"]);
    }


    /*
    |--------------------------------------------------------------------------
    | HTML
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $model = self::MODEL_CLASS;

        $entities = $model::all();

        return view(self::MODEL_TEMPLATE_PATH.'/index', ["entities" => $entities]);
    }


    public function show(Request $request, $id)
    {
        $model = self::MODEL_CLASS;

        $entity = $id == "new" ? new $model() : $model::find($id);

        return view(self::MODEL_TEMPLATE_PATH.'/show', ["entity" => $entity]);
    }

}
