<?php

namespace App\Http\Controllers;

use App\Models\VideoDocumentation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class VideoDocumentationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $video = VideoDocumentation::all();
        return $this->onSuccess('Video', $video, 'Founded');
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
    public function store(Request $request)
    {
        $video = new VideoDocumentation();
        $video->title = $request->title;
        $fileVideo = $request->file('video');
        $filename = 'Video_'.uniqid().'_'.time().'.'.$fileVideo->extension();
        $path = public_path().'/img/videos/';
        if(!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true);
        }
        $fileVideo->move($path, $filename);
        $video->video = $filename;
        $video->save();
        return $this->onSuccess('Video', $video, 'Stored');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VideoDocumentation  $videoDocumentation
     * @return \Illuminate\Http\Response
     */
    public function show(VideoDocumentation $videoDocumentation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VideoDocumentation  $videoDocumentation
     * @return \Illuminate\Http\Response
     */
    public function edit(VideoDocumentation $videoDocumentation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VideoDocumentation  $videoDocumentation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VideoDocumentation $videoDocumentation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VideoDocumentation  $videoDocumentation
     * @return \Illuminate\Http\Response
     */
    public function destroy(VideoDocumentation $videoDocumentation)
    {
        //
    }
}
