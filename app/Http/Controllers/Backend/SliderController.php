<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class SliderController extends Controller
{
    public function AllSlider(){
        $slider = Slider::latest()->get();
        return view('backend.slider.all_slider', compact('slider'));
    }

    public function AddSlider(){
        return view('backend.slider.add_slider');
    }

    private function deleteOldImage(string $oldPhotoPath): void{
        $fullPath = public_path('upload/slider/'.$oldPhotoPath);
        if(file_exists($fullPath)){
           unlink($fullPath);
        }
    }

    public function StoreSlider(Request $request){

        if($request->file('image')){
            $image = $request->file('image');
            $filename = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('upload/slider'), $filename);

            Slider::create([
                'heading' => $request->heading,
                'description' => $request->description,
                'link' => $request->link,
                'image' => $filename,
            ]);
        }

        $notification = array(
            'message' => 'Slider Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.slider')->with($notification);
    }

    public function EditSlider($id){
        $slider = Slider::find($id);

        return view('backend.slider.edit_slider', compact('slider'));
    }

    public function updateSlider(Request $request){
        $slider_id = $request->id;
        $slider = Slider::find($slider_id);

        if($request->file('image')){
            $oldPhotoPath = $slider->image;
            $image = $request->file('image');
            $filename = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('upload/slider'), $filename);

            $slider->update([
                'heading' => $request->heading,
                'description' => $request->description,
                'link' => $request->link,
                'image' => $filename,
            ]);

            if($oldPhotoPath && $oldPhotoPath !== $filename){
                $this->deleteOldImage($oldPhotoPath);
             }

            $notification = array(
                'message' => 'Slider Updated with Image Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->route('all.slider')->with($notification);

        }else{
            $slider->update([
                'heading' => $request->heading,
                'description' => $request->description,
                'link' => $request->link,
            ]);

            $notification = array(
                'message' => 'Slider Updated without Image Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->route('all.slider')->with($notification);
        }
    }

    public function DeleteSlider($id){
       $item = Slider::find($id);
       $img = $item->image;
       unlink('upload/slider/'.$img);

       Slider::find($id)->delete();

       $notification = array(
            'message' => 'Slider Deleted Successfully',
            'alert-type' => 'success'
       );

        return redirect()->back()->with($notification);
    }
}
