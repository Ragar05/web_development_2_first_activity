<?php
namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Support\Str;

class TaskEntity
{
    public string $id_task;

    public string $title;

    public string $description;

    public string $expiration_date;

    public bool | null $is_ended;

    public bool $is_active;

    public string $created_at;

    public string $updated_at;

    public function __construct(
        string $title,
        string $description,
        string $expiration_date
    ) {
        $this->id_task = Str::uuid();
        $this->title = $title;
        $this->description = $description;
        $this->expiration_date = $expiration_date;
        $this->is_ended = false;
        $this->is_active = true;
        $this->created_at = Carbon::now();
        $this->updated_at = Carbon::now();
    }
}
