<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\ApiController;
use App\Http\Requests\NoteStoreRequest;
use App\Http\Requests\NoteUpdateRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Transformers\UserTransformer;
use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class NoteController extends ApiController
{

    const MODEL_CLASS = Note::class;
    const MODEL_NAME = "Note";
    const MODEL_TEMPLATE_PATH = "note";

    public function __construct()
    {
        parent::__construct();
    }

    /*
    |--------------------------------------------------------------------------
    | AJAX
    |--------------------------------------------------------------------------
    */

    public function store(NoteStoreRequest $request)
    {
        $model = self::MODEL_CLASS;

        $entity = $model::create(array_merge(['user_id' => Auth::id()],$request->all()));
        $entity->save();

        $entities = $model::where($request->only('entity_id','entity_id'))->get();

        return $this->respond(["message" => self::MODEL_NAME. " created successfully", "data" => view('components/notes_list', ['entities' => $entities])->render()]);
    }

    public function update(NoteUpdateRequest $request, $id)
    {
        $model = self::MODEL_CLASS;

        $entity = $model::find($id);

        $entity->update($request->all());

        $entities = $model::where($request->only('entity_id','entity_id'))->get();

        return $this->respond(["message" => self::MODEL_NAME. " updated successfully", "data" => view('components/notes_list', ['entities' => $entities])->render()]);
    }

    public function delete(Request $request, $id)
    {
        $model = self::MODEL_CLASS;

        $model::find($id)->delete();

        return $this->respond(["message" => self::MODEL_NAME. "  deleted successfully"]);
    }

}
