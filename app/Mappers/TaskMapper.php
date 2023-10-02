<?php

namespace App\Mappers;

use App\DTO\TaskDTO;
use App\Entities\TaskEntity;

class TaskMapper {
    public static function toDTO(TaskEntity $entity): TaskDTO {
        $dto = new TaskDTO();

        $dto->id = $entity->id_task;
        $dto->title = $entity->title;
        $dto->description = $entity->description;
        $dto->expirationDate = $entity->expiration_date;
        $dto->isEnded = $entity->is_ended;
        $dto->creation_date = $entity->created_at;

        return $dto;
    }
}
