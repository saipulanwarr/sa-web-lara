<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gatewayone;

class GatewayOneController extends Controller
{
    public function GateWayOne(){
        $gateone = Gatewayone::find(1);

        return view('backend.gateway.gateway_one', compact('gateone'));
    }

    private function deleteOldImage(string $oldPhotoPath): void{
        $fullPath = public_path('upload/gateone/'.$oldPhotoPath);
        if(file_exists($fullPath)){
           unlink($fullPath);
        }
    }

    public function UpdateGateWayOne(Request $request){
        $getone_id = $request->id;
        $getone = Gatewayone::find($getone_id);

        if($request->file('image')){
            $oldPhotoPath = $getone->image;
            $image = $request->file('image');
            $filename = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('upload/gateone'), $filename);

            $getone->update([
                'title' => $request->title,
                'description' => $request->description,
                'phone' => $request->phone,
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
            $getone->update([
                'title' => $request->title,
                'description' => $request->description,
                'phone' => $request->phone,
            ]);

            $notification = array(
                'message' => 'Updated without Image Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->back()->with($notification);
        }
    }
}
