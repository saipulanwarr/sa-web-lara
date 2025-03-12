<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory;
use App\Models\BlogPost;

class BlogController extends Controller
{
    public function ApiBlogCat(){
        $blogcat = BlogCategory::latest()->get();

        return $blogcat;
    }

    public function ApiAllBlog(){
        $blogpost = BlogPost::with('blog')->latest()->get();

        $response = $blogpost->map(function($post){
            return[
                'id' => $post->id,
                'post_title' => $post->post_title,
                'post_slug' => $post->post_slug,
                'image' => $post->image,
                'long_descp' => $post->long_descp,
                'created_at' => $post->created_at,
                'updated_at' => $post->updated_at,
                'category_name' => $post->blog ? $post->blog->blog_category : null,
            ];
        });

        return response()->json($response);
    }

    public function getBlogsByCategory($category_id){
        $blogs = BlogPost::where('blogcat_id', $category_id)->join('blog_categories', 'blog_posts.blogcat_id', '=', 'blog_categories.id')->select('blog_posts.*', 'blog_categories.blog_category')->get();

        return response()->json($blogs);
    }

    public function ApiAllBlogSlug($slug){
        $blogpost = BlogPost::with('blog')->where('post_slug', $slug)->first();

        if(!$blogpost){
            return response()->json(['error' => 'Blog Post not found', 404]);
        }

        $response = [
            'id' => $blogpost->id,
            'post_title' => $blogpost->post_title,
            'post_slug' => $blogpost->post_slug,
            'image' => $blogpost->image,
            'long_descp' => $blogpost->long_descp,
            'created_at' => $blogpost->created_at,
            'updated_at' => $blogpost->updated_at,
            'category_name' => $blogpost->blog ? $blogpost->blog->blog_category : null,
        ];

        return response()->json($response);
    }

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

    public function EditBlogPost($id){
        $blogcat = BlogCategory::latest()->get();
        $post = BlogPost::find($id);

        return view('backend.blog.edit_blog_post', compact('blogcat', 'post'));
    }

    public function updateBlogPost(Request $request){
        $blogpost_id = $request->id;
        $blogpost = BlogPost::find($blogpost_id);

        if($request->file('image')){
            $oldPhotoPath = $blogpost->image;
            $image = $request->file('image');
            $filename = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('upload/blog'), $filename);

            $blogpost->update([
                'post_title' => $request->post_title,
                'post_slug' => strtolower(str_replace(' ', '-', $request->post_title)),
                'blogcat_id' => $request->blogcat_id,
                'long_descp' => $request->long_descp,
                'image' => $filename,
            ]);

            if($oldPhotoPath && $oldPhotoPath !== $filename){
                $this->deleteOldImage($oldPhotoPath);
             }

            $notification = array(
                'message' => 'Blog Post Updated with Image Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->route('all.blog.post')->with($notification);

        }else{
            $blogpost->update([
                'post_title' => $request->post_title,
                'post_slug' => strtolower(str_replace(' ', '-', $request->post_title)),
                'blogcat_id' => $request->blogcat_id,
                'long_descp' => $request->long_descp,
            ]);

            $notification = array(
                'message' => 'Blog Post Updated without Image Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->route('all.blog.post')->with($notification);
        }
    }

    public function DeleteBlogPost($id){
        $item = BlogPost::find($id);
        $img = $item->image;
        unlink('upload/blog/'.$img);
 
        BlogPost::find($id)->delete();
 
        $notification = array(
             'message' => 'Blog Post Deleted Successfully',
             'alert-type' => 'success'
        );
 
         return redirect()->back()->with($notification);
     }
}
