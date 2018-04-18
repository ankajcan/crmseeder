<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\ApiController;
use App\Http\Requests\ContactStoreRequest;
use App\Http\Requests\ContactUpdateRequest;
use App\Http\Requests\RoleStoreRequest;
use App\Http\Requests\RoleUpdateRequest;
use App\Models\Contact;
use App\Models\Country;
use Illuminate\Http\Request;
use Project\Services\FileService;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class RoleController extends ApiController
{
    const MODEL_CLASS = Role::class;
    const MODEL_NAME = "Role";
    const MODEL_TEMPLATE_PATH = "role";

    /*
    |--------------------------------------------------------------------------
    | AJAX
    |--------------------------------------------------------------------------
    */

    public function store(RoleStoreRequest $request)
    {
        $model = self::MODEL_CLASS;

        $entity = $model::create(['name' => $request->get('name')]);
        $entity->save();

        $entity->syncPermissions($request->get('permissions') ? $request->get('permissions') : []);

        return $this->respond(["message" => self::MODEL_NAME. " created successfully"]);
    }

    public function update(RoleUpdateRequest $request, $id)
    {
        $model = self::MODEL_CLASS;

        $entity = $model::find($id);

        $entity->update(['name' => $request->get('name')]);

        $entity->syncPermissions($request->get('permissions') ? $request->get('permissions') : []);

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

        $permissions = Permission::all();

        return view(self::MODEL_TEMPLATE_PATH.'/show', ["entity" => $entity, "permissions" => $permissions]);
    }

}
