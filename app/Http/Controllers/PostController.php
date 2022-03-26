<?php

namespace App\Http\Controllers;
use App\Models\Contact;
use App\Models\Post;
use Illuminate\Http\Request;
use Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts=Post::all();

        return view('welcome', compact('posts'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
   return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store (Request $request)
    {
        $image = $request->file('image');
        $image_name = rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $image_name);

    $post=new Post();
    $post->name=$request->name;
    $post->description=$request->description;
   $post->image=$image_name;
    $post->save();

    return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $post=Post::find($id);

        return view("edit",compact('post'));
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
        $posts=Post::find($id);
        $image = $request->file('image');
        $data = [

            'name' => $request->name,
            'description' => $request->description,

        ];
        if (!empty($image)){
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/images'), $new_image_name);
            $data['image'] = $new_image_name;
        }
       $posts->update($data);


       return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyform($id)
    {
    Contact::find($id)->delete($id);
     return response()->json(['success'=>'Your Contact is Deleted']);
    }

    public function editform($id)
    {
    $contact_edit=  Contact::find($id);
     return response()->json(['data'=>$contact_edit]);
    }

    public function updateform(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'address' => 'required',
        ]);

        if ($validator->passes()) {
            //DB::table('users')->where('id', $id)->update($data);

            \DB::table('contact')->where('id', $id)->update([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'address' => $request->input('address'),
            ]);
            return response()->json(['success'=>'Added new records.']);
        }

        return response()->json(['error'=>$validator->errors()->all()]);
    }

    public function myform()
    {
        $contacts=Contact::all();
        return view('ajax',compact('contacts'));
    }

    /**
     * Display a listing of the myformPost.
     *
     * @return \Illuminate\Http\Response
     */
    public function myformPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'address' => 'required',
        ]);

        if ($validator->passes()) {
            \DB::table('contact')->insert([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'address' => $request->input('address'),
            ]);
           return response()->json(['success'=>'Added new records.']);
        }

        return response()->json(['error'=>$validator->errors()->all()]);
    }


}
