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

    private function deleteOldImage(string $oldPhotoPath): void{
        $fullPath = public_path('upload/service/'.$oldPhotoPath);
        if(file_exists($fullPath)){
           unlink($fullPath);
        }
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

    public function EditService($id){
        $service = Service::find($id);

        return view('backend.service.edit_service', compact('service'));
    }

    public function updateService(Request $request){
        $service_id = $request->id;
        $service = Service::find($service_id);

        if($request->file('image')){
            $oldPhotoPath = $service->image;
            $image = $request->file('image');
            $filename = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('upload/service'), $filename);

            $service->update([
               'service_name' => $request->service_name,
                'slug' => strtolower(str_replace(' ', '-', $request->service_name)),
                'service_short' => $request->service_short,
                'service_desc' => $request->service_desc,
                'icon' => $request->icon,
                'image' => $filename,
            ]);

            if($oldPhotoPath && $oldPhotoPath !== $filename){
                $this->deleteOldImage($oldPhotoPath);
             }

            $notification = array(
                'message' => 'Service Updated with Image Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->route('all.service')->with($notification);

        }else{
            $service->update([
                'service_name' => $request->service_name,
                'slug' => strtolower(str_replace(' ', '-', $request->service_name)),
                'service_short' => $request->service_short,
                'service_desc' => $request->service_desc,
                'icon' => $request->icon,
            ]);

            $notification = array(
                'message' => 'Service Updated without Image Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->route('all.service')->with($notification);
        }
    }

    public function DeleteService($id){
        $item = Service::find($id);
        $img = $item->image;
        unlink('upload/service/'.$img);
 
        Service::find($id)->delete();
 
        $notification = array(
             'message' => 'Service Deleted Successfully',
             'alert-type' => 'success'
        );
 
         return redirect()->back()->with($notification);
     }
}
