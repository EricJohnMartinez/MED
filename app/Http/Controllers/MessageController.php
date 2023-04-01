<?php

namespace App\Http\Controllers;

use App\Events\MyEvent;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMessageRequest;

class MessageController extends Controller
{

    public function index()
    {
        $message = Message::orderBy('created_at', 'desc')->get();
        return view('messages.index',['message' =>$message]);
    }

    public function store(StoreMessageRequest $request)
    {
        $message = Message::create($request->validated());
        // $message = Message::create([
        //     'message' => $request->message,
        //     'name' => $request->name,
        // ]);
            event(new MyEvent($message));
        return redirect()->route('messages.index')->with('success', 'Message Added!');
    }

    public function destroy(Message $message)
    {
        $message->delete();
        return redirect()->route('messages.index')->with('Success', 'Delete success');
    }

}
