<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

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
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|max:191',
        ]);

        $request->user()->kadaitasklists()->create([
            'content' => $request->content,
        ]);

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