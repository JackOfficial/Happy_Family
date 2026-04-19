<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cause;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Comment;
use App\Models\Photo;
use App\Models\Project;
use App\Models\Team;
use App\Models\Event;
use App\Models\Page;
use App\Models\Partner;
use App\Models\Story;
use App\Models\Organization;

class PageController extends Controller
{
public function index()
{
    // 1. Load basic organization/header info
    $organization = Organization::first();
    $header = Page::where('page_name', 'Home')->first();

    // 2. Fetch Projects (Updated to use 'causes' and 'project_photos')
    $projects = Project::with(['featured_photo', 'project_photos', 'causes'])
    ->latest()
    ->take(3)
    ->get();

    // Pull current project from the collection
    $current_project = $projects->first();

    // 3. Optimized Blogs
    $blogs = Blog::with(['blogPhoto', 'cause', 'user', 'likes', 'comments'])
        ->latest()
        ->take(3) 
        ->get();

    // 4. Other Sections
    $events = Event::latest()->take(3)->get();
    
    // Updated 'causes' to match the plural relationship if you updated that model too
    $causes = Cause::with('mainPhoto')->latest()->take(4)->get(); 
    
    $partners = Partner::with('organization')->latest()->get();
    $stories = Story::with(['organization', 'user', 'cause', 'featuredPhoto'])
                ->where('status', 'published') 
                ->latest()
                ->take(3)
                ->get();
    
    // 5. Gallery
    $gallery = Photo::latest()->take(6)->get();

    return view('index', compact(
        'header', 
        'blogs', 
        'projects', 
        'current_project', 
        'events', 
        'causes', 
        'partners', 
        'stories', 
        'gallery', 
        'organization'
    )); 
}

    function about(){
        $causes = Cause::with('mainPhoto')->latest()->take(4)->get(); 
        $team = Team::all();
        $eventsCounter = Event::count();
        $projectsCounter = Project::count();
        $organization = Organization::first();
        return view('about', compact('causes', 'team', 'eventsCounter', 'projectsCounter', 'organization')); 
    }
    
   public function cause($id)
{
    $cause = Cause::with('mainPhoto')->findOrFail($id);
    $projects = Project::with('project_photo', 'cause')
                        ->where('cause_id', $id)
                        ->latest()
                        ->take(4)
                        ->get();

    return view('cause', compact('cause', 'projects'));
}
    
    function gallery(){
        $gallery = Gallery::orderBy('id', 'DESC')
        ->get();
        return view('gallery', compact('gallery')); 
    }

    function search($keyword){
        $blogs = Blogs::join('blog_categories', 'blogs.blog_category_id', 'blog_categories.id')
        ->join('bloggers', 'blogs.blogger_id', 'bloggers.id')
        ->select('blogs.*', 'blog_categories.blog_category', 'bloggers.first_name', 'bloggers.last_name')
        ->where('blogs.title', 'like', '%' . $keyword .'%')
        ->paginate(6);
        return Inertia::render('Blogs', compact('blogs', 'keyword')); 
    }
    function blogs(){
        $blogs = Blogs::join('blog_categories', 'blogs.blog_category_id', 'blog_categories.id')
        ->join('bloggers', 'blogs.blogger_id', 'bloggers.id')
        ->select('blogs.*', 'blog_categories.blog_category', 'bloggers.first_name', 'bloggers.last_name')
        ->paginate(6);
        return view('blogs', compact('blogs')); 
    }

    function blog_category($id){
        $blogs = Blogs::join('blog_categories', 'blogs.blog_category_id', 'blog_categories.id')
        ->join('bloggers', 'blogs.blogger_id', 'bloggers.id')
        ->where('blogs.blog_category_id', $id)
        ->select('blogs.*', 'blog_categories.blog_category', 'bloggers.first_name', 'bloggers.last_name')
        ->paginate(6);
        return Inertia::render('Blogs', compact('blogs')); 
     }

    function deleteComment($id){
        Comments::where('id', $id)->delete();
        return redirect()->back();
    }
    function blog($title){
        $blog = Blogs::join('blog_categories', 'blogs.blog_category_id', 'blog_categories.id')
        ->join('bloggers', 'blogs.blogger_id', 'bloggers.id')
        ->where('blogs.title', $title)
        ->select('blogs.*', 'blog_categories.blog_category', 'bloggers.first_name', 'bloggers.last_name')
        ->first();

        $latest_blogs= Blogs::join('blog_categories', 'blogs.blog_category_id', 'blog_categories.id')
        ->join('bloggers', 'blogs.blogger_id', 'bloggers.id')
        ->select('blogs.*', 'blog_categories.blog_category', 'bloggers.first_name', 'bloggers.last_name')
        ->get();

        $categories = Blog_categories::all();

        $related = Blogs::join('blog_categories', 'blogs.blog_category_id', 'blog_categories.id')
        ->join('bloggers', 'blogs.blogger_id', 'bloggers.id')
        ->select('blogs.*', 'blog_categories.blog_category', 'bloggers.first_name', 'bloggers.last_name')
        ->get();

        $comments = Comments::join('blogs', 'comments.blog_id', 'blogs.id')
        ->join('users', 'comments.user_id', 'users.id')
        ->where('comments.blog_id', $blog->id)
        ->select('comments.*', 'users.name', 'users.avatar')
        ->orderBy('comments.id', 'DESC')
        ->get();

        return view('blog', compact('blog', 'latest_blogs', 'related', 'categories', 'comments')); 
    }

    function donate(){
        return view('donation');  
    }

    function volunteer(){
        return view('volunteer');  
    }

    function post(Request $request){
        $request->validate([
          'comment' => 'required|string'
        ]);
        $comment = Comments::create([
            'user_id' => auth()->user()->id,
            'comment' => $request->comment,
            'blog_id' => $request->blogId,
        ]);
        if($comment){
           session()->flash('message', 'Your comment has been Posted!');
        }
        else{
            session()->flash('message', 'Your comment could not be posted!');
        }
    }

    function stories(){
        $stories = Stories::join('bloggers', 'stories.blogger_id', 'bloggers.id')
        ->select('stories.*', 'bloggers.first_name', 'bloggers.last_name')
        ->orderBy('id', 'DESC')
        ->paginate(6);
        return view('stories', compact('stories')); 
    }

    function story($id){
         $story = stories::join('bloggers', 'stories.blogger_id', 'bloggers.id')
        ->where('stories.id', $id)
        ->select('stories.*', 'bloggers.first_name', 'bloggers.last_name')
        ->first();
        return view('story', compact('story'));  
    }
    
    function causes(){
        $causes = Cause::with('mainPhoto')->latest()->get(); 
        return view('causes', compact('causes')); 
    }

    function application_sent(){
        return Inertia::render('ApplicationSent');  
    }

    function events(){
        $upcomingEvents = Events::where('date', '>=', date('Y-m-d'))->get();
        $passedEvents = Events::where('date', '<', date('Y-m-d'))->get();
        return view('events', compact('upcomingEvents', 'passedEvents'));  
    }

    function show($event){
        $event = Events::where('event', $event)->first();
        return view('event', compact('event'));  
    }
    
}
