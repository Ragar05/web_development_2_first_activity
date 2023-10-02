<?php
namespace App\Mocks;

use App\Entities\TaskEntity;
use App\Utils\ValidateDate;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class MockTaskDatabase
{
    private static string $DbName = "task_database";

    public function __construct()
    {
        $this->init();
    }

    private function __clone()
    {
    }

    private function init()
    {
        $data = $this->getData();
        $dataExist = isset($data);

        if (!$dataExist) {
            $data = collect([]);
        }

        Cache::put(self::$DbName, $data, 3600);
    }

    private function saveData(Collection $data)
    {
        Cache::put(self::$DbName, $data, 3600);
    }

    public function getData()
    {
        $data = Cache::get(self::$DbName);
        return $data;
    }

    public function getTaskActives() {
        $data = $this->getData();

        $taskFiltered = $data->where(function (TaskEntity $task) {
            return $task->is_active == true;
        })->values();

        return $taskFiltered;
    }

    public function add(string $title, string $description, string $expiration_date): TaskEntity
    {
        $data = $this->getData();
        $task = new TaskEntity($title, $description, $expiration_date);

        $data->push($task);
        $this->saveData($data);

        return $task;
    }

    public function update(TaskEntity $entity): TaskEntity|null
    {
        $data = $this->getData();

        $id = $entity->id_task;

        $taskFinded = $data->where(function (TaskEntity $task) use ($id) {
            return $task->id_task == $id && $task->is_active == true;
        })->values();

        if ($taskFinded->count() === 0) {
            return null;
        }

        $canUpdate = false;
        $taskFinded = $taskFinded[0];

        if (isset($entity->title) && str($entity->title)->isNotEmpty()) {
            $taskFinded->title = $entity->title;
            $canUpdate = true;
        }

        if (isset($entity->description) && str($entity->description)->isNotEmpty()) {
            $taskFinded->description = $entity->description;
            $canUpdate = true;
        }

        $expirationDateIsValid = ValidateDate::run($entity->expiration_date);

        if (isset($entity->expiration_date) && str($entity->expiration_date)->isNotEmpty() && !$expirationDateIsValid) {
            $taskFinded->expiration_date = $entity->expiration_date;
            $canUpdate = true;
        }

        $isEndedOnDBisDifferent = $entity->is_ended != $taskFinded->is_ended;

        if (isset($entity->is_ended) && is_bool($entity->is_ended) && $isEndedOnDBisDifferent) {
            $taskFinded->is_ended = $entity->is_ended;
            $canUpdate = true;
        }

        if ($canUpdate) {
            $data = $data->map(function (TaskEntity $task) use ($id, $taskFinded) {
                if ($task->id_task == $id) {
                    return $taskFinded;
                }
                return $task;
            });

            $this->saveData($data);
        }

        return $taskFinded;
    }

    public function delete(string $id): TaskEntity|null
    {
        $data = $this->getData();

        $taskFinded = $data->where(function (TaskEntity $task) use ($id) {
            return $task->id_task == $id && $task->is_active == true;
        })->values();

        if ($taskFinded->count() === 0) {
            return null;
        }

        $taskFinded = $taskFinded[0];

        $data = $data->map(function (TaskEntity $task) use ($id) {
            if ($task->id_task == $id) {
                $task->is_active = false;
            }
            return $task;
        });

        $this->saveData($data);

        $taskFinded->is_active = false;

        return $taskFinded;
    }
}
