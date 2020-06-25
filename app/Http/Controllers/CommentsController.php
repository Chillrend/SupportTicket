<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Ticket;
use App\Comment;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    /**
	 * Persist comment and mail user
	 * @param  Request  $request
	 * @param  AppMailer $mailer
	 * @return Response
	 */
    public function postComment(Request $request)
    {
    	$this->validate($request, [
            'comment'   => 'required'
        ]);

        $comment = Comment::create([
        	'ticket_id' => $request->input('ticket_id'),
        	'user_id'	=> Auth::user()->id,
        	'comment'	=> $request->input('comment'),
        ]);
        
        return redirect()->back()->with("status", "Your comment has be submitted.");
    }
}
