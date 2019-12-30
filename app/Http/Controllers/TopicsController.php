<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use App\Models\Category;
use Auth;
use App\Handlers\ImageUploadHandler;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index(Request $request)
	{
		$topics = Topic::withOrder($request->order)->with('user', 'category')->paginate(20);
		return view('topics.index', compact('topics'));
	}

    public function show(Request $request, Topic $topic)
    {
        //repair the url with no slug
        if (!empty($topic->slug) && $topic->slug != $request->slug){
            //if previous request has a session message, we need to get redirect request have it
            session()->reflash();
            return redirect($topic->link(), 301);//301 permanent URL redirection (to correct url)
        }
        return view('topics.show', compact('topic'));
    }

	public function create(Topic $topic)
	{
        $categories = Category::all();
		return view('topics.create_and_edit', compact('topic', 'categories'));
	}

	public function store(TopicRequest $request, Topic $topic)
	{
		$topic->fill($request->all());
        $topic->user_id = Auth::id();
        $topic->save();

		return redirect()->to($topic->link())->with('success', 'Post is created successfully.');
	}

	public function edit(Topic $topic)
	{
        $this->authorize('update', $topic);
        $categories = Category::all();
		return view('topics.create_and_edit', compact('topic', 'categories'));
	}

	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

		return redirect()->to($topic->link())->with('success', 'Updated successfully.');
	}

	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

		return redirect()->route('topics.index')->with('success', 'Deleted successfully.');
	}

    //In laravel's controller, if return an array, it will automatically be processed into JSON
    public function uploadImage(Request $request, ImageUploadHandler $uploader){
        //Initialize the return data, defaultly failed
        $data = [
            'success' => false,
            'msg' => 'Upload failed',
            'file_path' => ''
        ];

        //Check if there is an uploading file, and assign it to $file
        if($file = $request->upload_file){
            //Save image to local folder
            $result = $uploader->save($file, 'topics', \Auth::id(), 1024);

            //If image is successfully saved
            if($result){
                $data['file_path'] = $result['path'];
                $data['msg'] = 'Uploaded successfully';
                $data['success'] = true;
            }
        }
        return $data;
    }
}
