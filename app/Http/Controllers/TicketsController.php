<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Ticket;
use App\Category;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TicketsController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
	}

    /**
     * Display all tickets.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$tickets = Ticket::paginate(10);
        $categories = Category::all();

        return view('tickets.index', compact('tickets', 'categories'));
    }

    /**
     * Display all tickets by a user.
     *
     * @return \Illuminate\Http\Response
     */
    public function userTickets()
    {
        $tickets = Ticket::where('user_id', Auth::user()->id)->paginate(10);
        $categories = Category::all();

        return view('tickets.user_tickets', compact('tickets', 'categories'));
    }

    /**
     * Show the form for opening a new ticket.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$categories = Category::all();

        return view('tickets.create', compact('categories'));
    }

    /**
     * Store a newly created ticket in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'     => 'required',
            'category'  => 'required',
            'priority'  => 'required',
            'message'   => 'required',
            'picture'   => 'sometimes|file|image|mimes:jpeg,png,gif|max:2048'
        ]);
        
        $ticket = null;
        if($request->hasFile('picture')){
            $image = $request->file('picture');
            $ticket_id = strtoupper(Str::random(10));
            $image->store('public/tickets');
            
            $ticket = new Ticket([
                'title'     => $request->input('title'),
                'user_id'   => Auth::user()->id,
                'ticket_id' => $ticket_id,
                'category_id'  => $request->input('category'),
                'priority'  => $request->input('priority'),
                'message'   => $request->input('message'),
                'status'    => "Open",
                'picture'   => $image->hashName(),
            ]);
        }else{
            $ticket = new Ticket([
                'title'     => $request->input('title'),
                'user_id'   => Auth::user()->id,
                'ticket_id' => strtoupper(Str::random(10)),
                'category_id'  => $request->input('category'),
                'priority'  => $request->input('priority'),
                'message'   => $request->input('message'),
                'status'    => "Open",
            ]);
        }

        $ticket->save();

        return redirect()->back()->with("status", "A ticket with ID: #$ticket->ticket_id has been opened.");
    }

    /**
     * Display a specified ticket.
     *
     * @param  int  $ticket_id
     * @return \Illuminate\Http\Response
     */
    public function show($ticket_id)
    {
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();

        $comments = $ticket->comments;

        $category = $ticket->category;
        

        return view('tickets.show', compact('ticket', 'category', 'comments'));
    }

    public function update_show($ticket_id){
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();

        $category = $ticket->category;

        $categories = Category::all();

        return view('tickets.update', compact('ticket', 'categories','category'));
    }

    public function update($ticket_id, Request $request){
        $this->validate($request, [
            'title'     => 'required',
            'category'  => 'required',
            'priority'  => 'required',
            'message'   => 'required',
            'picture'   => 'sometimes|file|image|mimes:jpeg,png,gif|max:2048'
        ]);

        $tickets = Ticket::where('ticket_id', $ticket_id)->firstOrFail();

        if($request->hasFile('picture')){
            $image = $request->file('picture');
            $image->store('public/tickets');

            if($tickets->picture != null){
                $old_image = $tickets->picture;
                Storage::delete('public/tickets/' . $old_image);
            }

            $tickets->title = $request->input('title');
            $tickets->category_id = $request->input('category');
            $tickets->priority = $request->input('priority');
            $tickets->message = $request->input('message');
            $tickets->picture = $image->hashName();
        }else{
            $tickets->title = $request->input('title');
            $tickets->category_id = $request->input('category');
            $tickets->priority = $request->input('priority');
            $tickets->message = $request->input('message');
        }

        $tickets->save();

        return redirect()->back()->with("status", "A ticket with ID: #$tickets->ticket_id has been edited.");
    }

    /**
     * Close the specified ticket.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function close($ticket_id)
    {
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();

        $ticket->status = 'Closed';

        $ticket->save();

        $ticketOwner = $ticket->user;

        return redirect()->back()->with("status", "The ticket has been closed.");
    }

    public function delete($ticket_id)
    {
        Ticket::where('ticket_id', $ticket_id)->delete();

        return redirect('/admin/tickets');
    }
}
