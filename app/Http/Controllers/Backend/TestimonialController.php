<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    public function AllTestimonial(){
        $testi = Testimonial::latest()->get();

        return view('backend.testimonial.all_testimonial', compact('testi'));
    }

    public function AddTestimonial(){
        return view('backend.testimonial.add_testimonial');
    }

    public function StoreTestimonial(Request $request){
        Testimonial::create([
            'name'      => $request->name,
            'position'  => $request->position,
            'message'   => $request->message,
        ]);

        $notification = array(
            'message' => 'Testimonial Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.testimonial')->with($notification);
    }

    public function EditTestimonial($id){
        $testi = Testimonial::find($id);

        return view('backend.testimonial.edit_testimonial', compact('testi'));
    }

    public function UpdateTestimonial(Request $request){
        $testi_id = $request->id;
        $testimonial = Testimonial::find($testi_id);

        $testimonial->update([
            'name'      => $request->name,
            'position'  => $request->position,
            'message'   => $request->message,
        ]);

        $notification = array(
            'message' => 'Testimonial Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.testimonial')->with($notification);
    }

    public function DeleteTestimonial($id){
        Testimonial::find($id)->delete();

        $notification = array(
            'message'       => 'Testimonial Delete Successfully',
            'alert-type'    => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
