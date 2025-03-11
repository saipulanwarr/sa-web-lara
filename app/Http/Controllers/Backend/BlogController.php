<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory;
use App\Models\BlogPost;

class BlogController extends Controller
{
    public function BlogCategory(){
        $category = BlogCategory::latest()->get();

        return view('backend.blog.blog_category', compact('category'));
    }

    public function BlogCategoryStore(Request $request){
        BlogCategory::create([
            'blog_category'   => $request->blog_category,
            'slug'            => strtolower(str_replace(' ', '-', $request->blog_category))
        ]);

        $notification = array(
            'message' => 'BlogCategory Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function EditBlogCategory($id){
        $categories = BlogCategory::find($id);

        return response()->json($categories);
    }
    
    public function BlogCategoryUpdate(Request $request){
        $cat_id = $request->cat_id;
        $category = BlogCategory::find($cat_id);

        $category->update([
            'blog_category'   => $request->blog_category,
            'slug'            => strtolower(str_replace(' ', '-', $request->blog_category))
        ]);

        $notification = array(
            'message' => 'BlogCategory Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function DeleteBlogCategory($id){
        BlogCategory::find($id)->delete();

        $notification = array(
            'message' => 'BlogCategory Delete Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function AllBlogPost(){
        $blogpost = BlogPost::latest()->get();

        return view('backend.blog.all_blog_post', compact('blogpost'));
    }

    public function AddBlogPost(){
        $blogcat = BlogCategory::latest()->get();

        return view('backend.blog.add_blog_post', compact('blogcat'));
    }

    private function deleteOldImage(string $oldPhotoPath): void{
        $fullPath = public_path('upload/blog/'.$oldPhotoPath);
        if(file_exists($fullPath)){
           unlink($fullPath);
        }
    }

    public function StoreBlogPost(Request $request){

        if($request->file('image')){
            $image = $request->file('image');
            $filename = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('upload/blog'), $filename);

            BlogPost::create([
                'post_title' => $request->post_title,
                'post_slug' => strtolower(str_replace(' ', '-', $request->post_title)),
                'blogcat_id' => $request->blogcat_id,
                'long_descp' => $request->long_descp,
                'image' => $filename,
            ]);
        }

        $notification = array(
            'message' => 'Blog Post Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.blog.post')->with($notification);
    }
}
