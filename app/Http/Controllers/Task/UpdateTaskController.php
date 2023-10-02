<?php
namespace App\Http\Controllers\Task;

use App\Entities\TaskEntity;
use App\Http\Controllers\Controller;
use App\Mappers\TaskMapper;
use App\Mocks\MockTaskDatabase;
use App\Utils\ValidateDate;
use Illuminate\Http\Request;

class UpdateTaskController extends Controller
{
    public function __construct(
        private MockTaskDatabase $taskDb
    ) {
    }

    public function run(Request $request)
    {
        $response = [
            "ok" => true,
            "message" => "El mensaje se creo de manera exitosa",
            "data" => null,
        ];

        $idTask = $request->route('id');
        $body = json_decode($request->getContent());
        $taskToUpdate = new TaskEntity("", "", "");

        if (isset($body->title)) {
            if (str($body->title)->isEmpty()) {
                $response["ok"] = false;
                $response["message"] = "El titulo de la tarea es requerido";
                return response()->json($response, 400);
            }
            $taskToUpdate->title = $body->title;
        }

        if (isset($body->description)) {
            if (str($body->description)->isEmpty()) {
                $response["ok"] = false;
                $response["message"] = "La descripcion de la tarea es requerida";
                return response()->json($response, 400);
            }
            $taskToUpdate->description = $body->description;
        }

        if (isset($body->expirationDate)) {
            if (str($body->expirationDate)->isEmpty()) {
                $response["ok"] = false;
                $response["message"] = "La fecha de expiracion de la tarea es requerida";
                return response()->json($response, 400);
            }
        }

        if (isset($body->expirationDate)) {
            if (ValidateDate::run($body->expirationDate) == false) {
                $response["ok"] = false;
                $response["message"] = "La fecha de expiracion de la tarea no es valida";
                return response()->json($response, 400);
            }
            $taskToUpdate->expiration_date = $body->expirationDate;
        }

        if (isset($body->isEnded)) {
            if (is_bool($body->isEnded)) {
                $taskToUpdate->is_ended = $body->isEnded;
            }else {
                $taskToUpdate->is_ended = null;
            }
        }else{
            $taskToUpdate->is_ended = null;
        }

        $taskToUpdate->id_task = $idTask;

        $updated = $this->taskDb->update($taskToUpdate);
        $updated = TaskMapper::toDTO($updated);
        $response["data"] = $updated;

        return response()->json($response, 200);
    }
}
