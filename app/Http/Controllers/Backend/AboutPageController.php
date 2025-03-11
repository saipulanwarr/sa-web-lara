<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AboutPage;
use App\Models\ContactPage;

class AboutPageController extends Controller
{
    public function ApiAboutPage(){
        $about = AboutPage::find(1);

        return $about;
    }
    
    public function AboutPage(){
        $about = AboutPage::find(1);

        return view('backend.about.about_us', compact('about'));
    }   

    private function deleteOldImage(string $oldPhotoPath): void{
        $fullPath = public_path('upload/about/'.$oldPhotoPath);
        if(file_exists($fullPath)){
           unlink($fullPath);
        }
    }

    public function UpdateAboutPage(Request $request){
        $about_id = $request->id;
        $about = AboutPage::find($about_id);

        if($request->file('image')){
            $oldPhotoPath = $about->image;
            $image = $request->file('image');
            $filename = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('upload/about'), $filename);

            $about->update([
                'title' => $request->title,
                'phone' => $request->phone,
                'setup_growth' => $request->setup_growth,
                'problem_solving' => $request->problem_solving,
                'passive_income' => $request->passive_income,
                'goal_achiever' => $request->goal_achiever,
                'description' => $request->description,
                'image' => $filename,
            ]);

            if($oldPhotoPath && $oldPhotoPath !== $filename){
                $this->deleteOldImage($oldPhotoPath);
             }

            $notification = array(
                'message' => 'Updated with Image Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->back()->with($notification);

        }else{
            $about->update([
                'title' => $request->title,
                'phone' => $request->phone,
                'setup_growth' => $request->setup_growth,
                'problem_solving' => $request->problem_solving,
                'passive_income' => $request->passive_income,
                'goal_achiever' => $request->goal_achiever,
                'description' => $request->description,
            ]);

            $notification = array(
                'message' => 'Updated without Image Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->back()->with($notification);
        }
    }

    public function ContactMessage(){
        $contact = ContactPage::latest()->get();

        return view('backend.contact.all_contact', compact('contact'));
    }
}
