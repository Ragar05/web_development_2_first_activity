<?php

namespace App\DTO;

class TaskDTO {
    public string $id;

    public string $title;

    public string $description;

    public string $expirationDate;

    public bool $isEnded;

    public string $creation_date;
}
