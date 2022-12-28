<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Platform;
use App\Models\Series;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){
        $series = Series::take(6)->get();
        $featuredCourses = Course::take(6)->get();
        return view('welcome', [
            'series' => $series,
            'courses' => $featuredCourses,
        ]);
    }

    public function dashboard(){
        if (Auth::user()->type === 1){
            return view('dashboard');
        }else{
            return redirect()->route('home');
        }
    }

    public function archive($archive_type, $slug){
        $allowed_archive_types = ['series', 'duration', 'level', 'platform', 'topic'];
        if (!in_array($archive_type, $allowed_archive_types)){
            return abort(404);
        }
        // duration check
        if ($archive_type === 'duration'){
            $allowed_durations = ['1-5-hours', '5-10-hours', '10-plus-hours'];
            if(!in_array($slug, $allowed_durations)){
                return abort(404);
            }
        }
        // series archive
        if ($archive_type === 'series'){
            $item = Series::where('slug', $slug)->first();

            if (empty($item)){
                return abort(404);
            }
            //dd($item);
            $title = 'Courses on ' . $item->name;
            $courses = $item->courses()->paginate(12);


        }elseif ($archive_type === 'topic') {
            $item = Topic::where('slug', $slug)->first();

            if (empty($item)) {
                return abort(404);
            }
            //dd($item);
            $title = 'Courses/Books on ' . $item->name;
            $courses = $item->courses()->paginate(12);

        }elseif ($archive_type === 'platform'){
            $item = Platform::where('slug', $slug)->first();

            if (empty($item)){
                return abort(404);
            }
            //dd($item);
            $title = 'Courses/Books from ' . $item->name;
            $courses = $item->courses()->paginate(12);


        }elseif ($archive_type === 'level'){
            if($slug == 'beginner'){
                $item = 'Beginner';
                $difficulty_level_db_key = 0;
            }elseif ($slug == 'intermediate'){
                $item = 'Intermediate';
                $difficulty_level_db_key = 1;
            }else{
                $item = 'Advanced';
                $difficulty_level_db_key = 2;
            }
            $title = 'Courses/Books of ' . $item . ' Level';
            $courses = Course::where('difficulty_level', $difficulty_level_db_key)->paginate(12);
        }
        elseif ($archive_type === 'duration'){
            if($slug == '1-5-hours'){
                $item = '1-5 hours';
                $duration_db_key = 0;
            }elseif ($slug == '5-10-hours'){
                $item = '5-10 hours';
                $duration_db_key = 1;
            }else{
                $item = '10+ hours';
                $duration_db_key = 2;
            }
            $title = 'Courses with duration ' . $item;
            $courses = Course::where('duration', $duration_db_key)->paginate(12);
        }
        return view('archive.single',[
           'title' => $title,
            'courses' => $courses
        ]);
    }
}
