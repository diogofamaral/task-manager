<?php

namespace App\Http\Requests\Tasks;

use App\Enum\TaskPriority;
use App\Enum\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public function authorize() : bool
    {
        return Auth::check();
    }

    public function rules() : array
    {
        return [
            'name' => 'required|string|max:150',
            'description' => 'required|string|max:255',
            'priority' => Rule::in(TaskPriority::values()),
            'deadline_at' => 'date',
        ];
    }

    public function payload() : array
    {
        $payload = array_merge([
            'user_id' => Auth::id(),
            'status' => TaskStatus::PENDING,
        ], $this->validated());

        if (! Arr::has($payload, 'priority')) {
            Arr::add($payload, 'priority', TaskPriority::LOW);
        }

        return $payload;
    }
}
