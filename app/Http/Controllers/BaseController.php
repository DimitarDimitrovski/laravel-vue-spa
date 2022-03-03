<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    protected function deleteComments($comments)
    {
        foreach ($comments as $comment) {
            if ($comment->Replies) {
                $this->deleteComments($comment->Replies);
            }

            $comment->delete();
        }
    }
}
