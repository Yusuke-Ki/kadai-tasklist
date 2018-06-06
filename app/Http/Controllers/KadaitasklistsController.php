<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Kadaitasklist;

class KadaitasklistsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        if (\Auth::check()) {
            $user = \Auth::user();
            $kadaitasklists = $user->kadaitasklists()->orderBy('created_at', 'desc')->paginate(10);

            $data = [
                'user' => $user,
                'kadaitasklists' => $kadaitasklists,
            ];
            $data += $this->counts($user);
            return view('users.show', $data);
        }else {
            return view('welcome');
        }
    }
    
    public function show($id)
    {
         $kadaitasklist = Kadaitasklist::find($id);

        return view('tasklists.show', [
            'kadaitasklist' => $kadaitasklist,
        ]);
    }
    
    public function create()
    {
          $kadaitasklist = new Kadaitasklist;

        return view('tasklists.create', [
            'kadaitasklist' => $kadaitasklist,
        ]);
    }

    
    
    public function store(Request $request)
    {
        
        $this->validate($request, [
            'content' => 'required|max:191',
            'status' => 'required|max:10',
        ]);

        $request->user()->kadaitasklists()->create([
            'content' => $request->content,
            'status' => $request->status,
        ]);

        return redirect('/');
    }
    
    public function edit($id)
    {
         $kadaitasklist = Kadaitasklist::find($id);

        return view('tasklists.edit', [
            'kadaitasklist' => $kadaitasklist,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|max:191',
            'content' => 'required|max:191',
        ]);
        
         $kadaitasklist = Kadaitasklist::find($id);
         $kadaitasklist->status = $request->status;  
         $kadaitasklist->content = $request->content;
         $kadaitasklist->save();

        return redirect('/');
    }
    
   
    
    public function destroy($id)
    {
        $kadaitasklist = \App\Kadaitasklist::find($id);

        if (\Auth::user()->id === $kadaitasklist->user_id) {
            $kadaitasklist->delete();
        }

        return redirect()->back();
    }
}