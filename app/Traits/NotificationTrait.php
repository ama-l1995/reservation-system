<?php

namespace App\Traits;

trait NotificationTrait
{
    protected function notifySuccess($message)
    {
        session()->flash('toastr_type', 'success');
        session()->flash('toastr_message', $message);
    }

    protected function notifyError($message)
    {
        session()->flash('toastr_type', 'error');
        session()->flash('toastr_message', $message);
    }
}
