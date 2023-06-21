<?php

namespace App\Http\Requests\Tasks;

use App\Enum\TaskPriority;
use App\Enum\TaskStatus;
use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function authorize() : bool
    {
        if (! Auth::check()) {
            return false;
        }

        /** @var Task $task */
        $task = $this->route('task');

        return Auth::id() === $task->user_id;
    }

    public function rules() : array
    {
        return [
            'name' => 'string|max:150',
            'description' => 'string|max:255',
            'priority' => ['string', Rule::in(TaskPriority::values())],
            'status' => ['string', Rule::in(TaskStatus::values())],
            'deadline_at' => 'date_format:"Y-m-d"',
        ];
    }

    public function payload() : array
    {
        $payload = $this->validated();

        if ($status = $this->get('status')) {
            $payload['completed_at'] = $status == TaskStatus::COMPLETED->value
                ? now()->toDateTimeString()
                : null;
        }

        return $payload;
    }
}
