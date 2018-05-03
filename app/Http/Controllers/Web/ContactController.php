<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\ApiController;
use App\Http\Requests\ContactStoreRequest;
use App\Http\Requests\ContactUpdateRequest;
use App\Models\Contact;
use App\Models\Country;
use Illuminate\Http\Request;
use Project\Services\FileService;


class ContactController extends ApiController
{
    const MODEL_CLASS = Contact::class;
    const MODEL_NAME = "Contact";
    const MODEL_TEMPLATE_PATH = "contact";

    public function __construct()
    {
        parent::__construct();
    }

    /*
    |--------------------------------------------------------------------------
    | AJAX
    |--------------------------------------------------------------------------
    */

    public function store(ContactStoreRequest $request)
    {
        $model = self::MODEL_CLASS;

        $entity = $model::create($request->all());
        $entity->save();

        $entity->manageAddress($request);
        $entity->saveFiles($request);

        return $this->respond(["message" => self::MODEL_NAME. " created successfully"]);
    }

    public function update(ContactUpdateRequest $request, $id)
    {
        $model = self::MODEL_CLASS;

        $entity = $model::find($id);

        $entity->update($request->all());

        $entity->manageAddress($request);

        return $this->respond(["message" => self::MODEL_NAME. " updated successfully"]);
    }

    public function delete(Request $request, $id)
    {
        $model = self::MODEL_CLASS;

        $model::find($id)->delete();

        return $this->respond(["message" => self::MODEL_NAME. "  deleted successfully"]);
    }

    public function delete_multiple(Request $request)
    {
        $model = self::MODEL_CLASS;

        $entities = $model::find($request->get('ids'));

        foreach($entities as $entity) {
            $entity->delete();
        }

        return $this->respond(["message" => self::MODEL_NAME. "s deleted successfully"]);
    }

    public function fileUpload(Request $request, $id)
    {
        $file = FileService::saveFileLocal($request->files->get('file'));
        // New entity
        if($id == "new") {
            $response = FileService::uploadAsset($file);
        } else {
            $model = self::MODEL_CLASS;
            $entity = $model::find($id);
            // Upload to AWS
            $response = $entity->uploadFile($file);
        }

        if(!$response["status"]) {
            return $this->setStatusCode(400)->respondWithError($response['message']);
        }

        $uploadedFile = $response['data'];

        return $this->respond(view('components/entity_file', ['file' => $uploadedFile])->render());
    }

    /*
    |--------------------------------------------------------------------------
    | HTML
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $model = self::MODEL_CLASS;

        $entities = $model::search($request);

        return view(self::MODEL_TEMPLATE_PATH.'/index', ["entities" => $entities]);
    }

    public function search(Request $request)
    {
        $model = self::MODEL_CLASS;

        $entities = $model::search($request);

        return $this->respond(view(self::MODEL_TEMPLATE_PATH.'/list', ["entities" => $entities])->render());
    }

    public function show(Request $request, $id)
    {
        $model = self::MODEL_CLASS;

        $entity = $id == "new" ? new $model(['type' => $model::TYPE_PERSON]) : $model::find($id);

        $countries = Country::all();

        return view(self::MODEL_TEMPLATE_PATH.'/show', ["entity" => $entity, "countries" => $countries]);
    }

}
