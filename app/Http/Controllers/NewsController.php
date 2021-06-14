<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class NewsController extends Controller
{
    
    public $data;
    public $dimen;
    public $path;
    public $dataType;

    public function __construct(News $data)
    {
        $this->data = $data;
        $this->dimen = 750;
        $this->path = public_path().'/img/news/';
        $this->dataType = 'News';
    }

    public function index(Request $request)
    {
        $query = $this->data->query()->with('Category');
        if($request->get('title') != null && $request->get('title')) {
            $data = $query->where('title', 'LIKE', '%'.$request->get('title').'%');
        }
        if($request->get('category') != null && $request->get('category')) {
            $category = $request->get('category');
            $data = $query->whereHas('Category', function($query) use ($category) {
                $query->where('id', $category);
            });
        }
        if($request->get('pagination') != null && $request->get('pagination')) {
            $data = $query->paginate($request->get('pagination'));
        } else {
            $data = $query->get();
        }
        return $this->onSuccess($this->dataType, $data, 'Founded');
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        try {
            $data = new News();
            $data->title = $request->title;
            $data->category_id = $request->category_id;
            $data->date = $request->date;
            $data->body = $request->body;
            $file = $request->file('picture');
            $filename = str_replace(' ', '_', $request->title).'-'.time().'-'.uniqid().'.'.$file->extension();
            if(!File::isDirectory($this->path)) {
                File::makeDirectory($this->path, 0777, true);
            }
            $img = Image::make($file->path());
            $img->resize($this->dimen, $this->dimen, function($constraint) {
                $constraint->aspectRatio();
            })->save($this->path.$filename);
            $data->picture = $filename;
            $data->save();
            return $this->onSuccess($this->dataType, $data, 'Stored');
        } catch (\Exception $e) {
            return $this->onError($e);
        }
    }

    
    public function show($id)
    {
        $data = $this->data->with('Category')->where('id', $id)->first();
        return $this->onSuccess($this->dataType, $data, 'Founded');
    }

    
    public function edit($id)
    {
        //
    }

    
    public function update(Request $request, $id)
    {
        try {
            $data = News::find($id);
            $data->title = $request->title;
            $data->category_id = $request->category_id;
            $data->date = $request->date;
            $data->body = $request->body;
            if($request->file('picture') != null && $request->file('picture')) {
                $file = $request->file('picture');
                $filename = str_replace(' ', '_', $request->title).'-'.time().'-'.uniqid().'.'.$file->extension();
                if(!File::isDirectory($this->path)) {
                    File::makeDirectory($this->path, 0777, true);
                }
                if(File::exists($this->path.$data->picture)) {
                    unlink($this->path.$data->picture);
                }
                $img = Image::make($file->path());
                $img->resize($this->dimen, $this->dimen, function($constraint) {
                    $constraint->aspectRatio();
                })->save($this->path.$filename);
                $data->picture = $filename;
            }
            $data->save();
            return $this->onSuccess($this->dataType, $data, 'Updated');
        } catch (\Exception $e) {
            return $this->onError($e);
        }
    }

    
    public function destroy($id)
    {
        try {
            $data = $this->data->find($id);
            if(File::exists($this->path.$data->picture)) {
                unlink($this->path.$data->picture);
            }
            $data->delete();
            return $this->onSuccess($this->dataType, $data, 'Destroyed');
        } catch (\Exception $e) {
            return $this->onError($e);
        }
    }
}
