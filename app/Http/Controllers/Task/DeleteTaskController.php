<?php
namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Mappers\TaskMapper;
use App\Mocks\MockTaskDatabase;
use Illuminate\Http\Request;

class DeleteTaskController extends Controller {

    public function __construct(
        private MockTaskDatabase $taskDb
    ) {
    }

    public function run(Request $request)
    {
        $response = [
            "ok" => true,
            "message" => "El mensaje se elimino de manera exitosa",
            "data" => null,
        ];

        $idTask = $request->route('id');

        $taskDeleted = $this->taskDb->delete($idTask);

        if(!isset($taskDeleted)) {
            $response["ok"] = false;
            $response["message"] = "El identificador de la tarea no existe";
            return response()->json($response, 400);
        }

        $taskDeleted = TaskMapper::toDTO($taskDeleted);
        $response["data"] = $taskDeleted;

        return response($response, 200);
    }
}
