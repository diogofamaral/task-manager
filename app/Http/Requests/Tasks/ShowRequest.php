<?php

namespace App\Http\Requests\Tasks;

use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ShowRequest extends FormRequest
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
        return [];
    }
}
