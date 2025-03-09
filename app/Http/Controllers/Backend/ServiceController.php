<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    //
    public function AllService(){
        $service = Service::latest()->get();

        return view('backend.service.all_service', compact('service'));
    }

    public function AddService(){
        return view('backend.service.add_service');
    }

    public function StoreService(Request $request){

        if($request->file('image')){
            $image = $request->file('image');
            $filename = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('upload/service'), $filename);

            Service::create([
                'service_name' => $request->service_name,
                'slug' => strtolower(str_replace(' ', '-', $request->service_name)),
                'service_short' => $request->service_short,
                'service_desc' => $request->service_desc,
                'icon' => $request->icon,
                'image' => $filename,
            ]);
        }

        $notification = array(
            'message' => 'Service Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.service')->with($notification);
    }
}
