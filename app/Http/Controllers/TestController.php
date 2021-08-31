<?php

namespace App\Http\Controllers;
use App\Models\Test;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests\StoreTestRequest;
class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $test= Test::all();
        return view("showtest",[
            'test' => DB::table('tests')->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTestRequest $request)
    {
       //$this->authorize('create',Test::class);
       $validated = $request->validated();
        $test=Test::create($validated
            );
        if($request->hasFile('avtar')){
            $file=$request->file('avtar');
            $extn =$file->extension();
            $test->update([
                //with default in locale to downlod
                'avtar'=>$file->storeAs('avatars',$request['name'] . '.'.$extn,'public')
            ]);
           // $file = $request->file('avtar');
            //$extn = $file->getClientOriginalExtension();
            //$filename = $request['name'].'.'.$extn;
            //$file->move('avatars',$filename);
            
        }
        
           
            return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyadmin($id)
    {
        $user=  User::find($id);
        $user->destroy($id);

        return redirect()->back();
    }
}
