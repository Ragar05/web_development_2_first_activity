<?php

namespace App\Http\Controllers\Task;

use App\Entities\TaskEntity;
use App\Http\Controllers\Controller;
use App\Mappers\TaskMapper;
use App\Mocks\MockTaskDatabase;
use Illuminate\Http\Request;


class GetAllTaskController extends Controller {

    public function __construct(
        private MockTaskDatabase $taskDb
    ) {}

    public function run(Request $request)
    {
        $data = $this->taskDb->getTaskActives();

        $data = $data->map(function (TaskEntity $task) {
            return TaskMapper::toDTO($task);
        });

        $response = [
            "ok" => true,
            "data" => $data
        ];

        return response()->json($response,  200);
    }
}
