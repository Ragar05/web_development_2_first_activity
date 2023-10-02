<?php
namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Mappers\TaskMapper;
use App\Mocks\MockTaskDatabase;
use App\Utils\ValidateDate;
use Illuminate\Http\Request;

class CreateTaskController extends Controller
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

        $body = json_decode($request->getContent());

        if (!isset($body->title) || str($body->title)->isEmpty()) {
            $response["ok"] = false;
            $response["message"] = "El titulo de la tarea es requerido y debe ser una cadena de texto";
            return response()->json($response, 400);
        }


        if (!isset($body->description) || str($body->description)->isEmpty()) {
            $response["ok"] = false;
            $response["message"] = "La descripcion de la tarea es requerida y debe ser una cadena de texto";
            return response()->json($response, 400);
        }

        if (!isset($body->expirationDate) || str($body->expirationDate)->isEmpty()) {
            $response["ok"] = false;
            $response["message"] = "La fecha de expiracion de la tarea es requerida";
            return response()->json($response, 400);
        }


        if(ValidateDate::run($body->expirationDate) == false){
            $response["ok"] = false;
            $response["message"] = "La fecha de expiracion de la tarea no es valida, debe ser en formato YYYY-MM-DD";
            return response()->json($response, 400);
        }


        $created = $this->taskDb->add($body->title, $body->description, $body->expirationDate);
        $created = TaskMapper::toDTO($created);
        $response["data"] = $created;

        return response()->json($response, 200);
    }
}
