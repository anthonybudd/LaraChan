<?php

namespace LaraChan\Core\Http\Controllers;

use LaraChan\Core\Http\LaraChanBaseController;
use Illuminate\Support\Facades\Validator;
use LaraChan\Core\Models\Thread;
use LaraChan\Core\Models\Board;
use LaraChan\Core\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Captcha;

class ThreadController extends LaraChanBaseController
{

    public function single($board, $threadID)
    {
        try {
            
            $thread = Thread::find($threadID);
            $captcha = Captcha::create('default', true);
            
            return view("larachan::thread.single", [
                "thread" => $thread,
                "captcha" => $captcha['img'],
                "key" => $captcha['key'],
            ]); 
            
        } catch (\Exception $e) {
            return view("larachan::404"); 
        }     
    }


    public function newThread($board)
    {
        $captcha = Captcha::create('default', true);

        return view("larachan::thread.new", [
            "board" => Board::findByBoard($board),
            "captcha" => $captcha['img'],
            "key" => $captcha['key'],
        ]);        
    }


    public function create(Request $request)
    {
        Validator::make($request->all(), [
            'key'     => 'required',
            'title'   => 'required',
            'body'    => 'required',
            'captcha' => 'required|captcha_api:'.request('key'),
            'image'   => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'board'   => 'exists:boards,name',
        ])->validate();

        $imageName = Str::uuid()->toString().'.'.$request->image->extension();
        $request->image->move(storage_path('app/public/larachan/images'), $imageName);

        $thread = Thread::create([
            'board'  => $request->get('board'),          
            'title'  => $request->get('title'),
            'body'   => $request->get('body'),
            'image'  => env('APP_URL').'/storage/larachan/images/'.$imageName,
        ]);

        return redirect()->route('singleThread', [
            'board' => $request->get('board'),
            'threadID' => $thread->id,
        ]);
    }


    public function reply(Request $request, $board, $threadID) 
    {
        Validator::make($request->all(), [
            'comment' => 'required',
            'captcha' => 'required|captcha_api:'.request('key'),
            'image'   => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'board'   => 'exists:boards,name',
            'thread'  => 'exists:threads,id',
        ])->validate();

        $imagePath = null;
        if ($request->image) {
            $imageName = Str::uuid()->toString().'.'.$request->image->extension();
            $request->image->move(storage_path('app/public/larachan/images'), $imageName);
            $imagePath = env('APP_URL').'/storage/larachan/images/'.$imageName;
        }

        $thread = Thread::find($threadID);

        $reply = Reply::create([
            'board'   => $thread->board,
            'thread'  => $thread->id, 
            'image'   => $imagePath,
            'comment' => $request->get('comment'),
        ]);

        return back();
    }
}
