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
    public function single($board, $threadID, $formErrors = false)
    {
        try {
            
            $thread = Thread::find($threadID);
            $captcha = Captcha::create('default', true);
            
            return view("larachan::thread.single", [
                "thread" => $thread,
                "captcha" => $captcha['img'],
                "key" => $captcha['key'],
                "formErrors" => $formErrors, //TODO - improve this.
            ]); 
            
        } catch (\Exception $e) {
            return view("larachan::404"); 
        }     
    }


    public function newThread($board, $formErrors = false)
    {
        $captcha = Captcha::create('default', true);

        return view("larachan::thread.new", [
            "board" => Board::findByBoard($board),
            "captcha" => $captcha['img'],
            "key" => $captcha['key'],
            "formErrors" => $formErrors, //TODO - improve this.
        ]);        
    }


    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'key'     => 'required',
            'title'   => 'required|min:5|max:255',
            'body'    => 'required|min:10',
            'captcha' => 'required|captcha_api:'.request('key'),
            'image'   => 'required|image|mimes:jpeg,png,jpg,gif|max:10000',
            'board'   => 'exists:boards,name',
        ]);

        if ($validator->fails()) {            
            return $this->newThread($request->get('board'), [
                'data'   => (object) $validator->getData(),
                'errors' => $validator->errors(),
            ]);
        }

        $id = Str::uuid()->toString();
        $imageName = $id.'.'.$request->image->extension();
        $request->image->move(storage_path('app/public/larachan/images'), $imageName);

        $thread = Thread::create([
            'id'     => $id,          
            'board'  => strip_tags($request->get('board')),          
            'title'  => strip_tags($request->get('title')),
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
        $validator = Validator::make($request->all(), [
            'comment' => 'required',
            'captcha' => 'required|captcha_api:'.request('key'),
            'image'   => 'image|mimes:jpeg,png,jpg,gif|max:10000',
            'board'   => 'exists:boards,name',
            'thread'  => 'uuid|exists:threads,id',
        ]);

        if ($validator->fails()) { //TODO Improve this            
            return $this->single($board, $threadID,  [
                'data'   => (object) $validator->getData(),
                'errors' => $validator->errors(),
            ]);
        }

        $id = Str::uuid()->toString();
        $imagePath = null;
        if ($request->image) {
            $imageName = $id.'.'.$request->image->extension();
            $request->image->move(storage_path('app/public/larachan/images'), $imageName);
            $imagePath = env('APP_URL').'/storage/larachan/images/'.$imageName;
        }

        $thread = Thread::find($threadID);

        $reply = Reply::create([
            'id'      => $id,
            'board'   => $thread->board,
            'thread'  => $thread->id, 
            'image'   => $imagePath,
            'comment' => strip_tags($request->get('comment')),
        ]);

        return back();
    }
}
