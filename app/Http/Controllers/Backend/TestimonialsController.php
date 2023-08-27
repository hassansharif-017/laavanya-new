<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Media_option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Review;
use App\Models\Testimonial;

class TestimonialsController extends Controller
{
    //Review & Ratings page load
    public function getTestimonialsPageLoad()
    {

        $datalist = Testimonial::orderBy('id', 'desc')
            ->paginate(20);
        $media_datalist = Media_option::orderBy('id', 'desc')->paginate(28);
        return view('backend.testimonials', compact('datalist', 'media_datalist'));
    }

    //Get data for Testimonials Ratings Pagination
    public function getTestimonialsTableData(Request $request)
    {

        $search = $request->search;

        if ($request->ajax()) {
            $datalist = Testimonial::
            when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('created_at', 'like', '%' . $search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(20);

            return view('backend.partials.testimonials_table', compact('datalist'))->render();
        }
    }

    //Delete data for Review Ratings
    public function deleteTestimonials(Request $request)
    {

        $res = array();

        $id = $request->id;

        if ($id != '') {
            $response = Testimonial::where('id', $id)->delete();
            if ($response) {
                $res['msgType'] = 'success';
                $res['msg'] = __('Data Removed Successfully');
            } else {
                $res['msgType'] = 'error';
                $res['msg'] = __('Data remove failed');
            }
        }

        return response()->json($res);
    }

    	//Get data for Testimonials by id
        public function getTestimonialsById(Request $request){

            $id = $request->id;
            
            $data = Testimonial::where('id', $id)->first();
            
            return response()->json($data);
        }

    	//Save data for Testimonials
        public function saveTestimonialsData(Request $request){
            $res = array();
            
            $id = $request->input('RecordId');
            $name = $request->input('name');
            $designation = $request->input('designation');
            $description = $request->input('description');
            $status = $request->input('status');
            $photo = $request->input('f_thumbnail');
            
            $validator_array = array(
                'name' => $request->input('name'),
                'designation' => $request->input('designation'),
                'description' => $request->input('description'),
                'status' => $request->input('status'),
                'photo' => $request->input('f_thumbnail')
            );
            
            $validator = Validator::make($validator_array, [
                'name' => 'required|max:191',
                'designation' => 'required|max:191',
                'description' => 'required|max:1000',
                'status' => 'required',
                'photo' => 'required'
            ]);
    
            $errors = $validator->errors();
    
            if($errors->has('name')){
                $res['msgType'] = 'error';
                $res['msg'] = $errors->first('name');
                return response()->json($res);
            }
            
            if($errors->has('designation')){
                $res['msgType'] = 'error';
                $res['msg'] = $errors->first('designation');
                return response()->json($res);
            }
            
            if($errors->has('description')){
                $res['msgType'] = 'error';
                $res['msg'] = $errors->first('description');
                return response()->json($res);
            }
    
            if($errors->has('status')){
                $res['msgType'] = 'error';
                $res['msg'] = $errors->first('status');
                return response()->json($res);
            }
            if($errors->has('photo')){
                $res['msgType'] = 'error';
                $res['msg'] = $errors->first('photo');
                return response()->json($res);
            }
    
            $data = array(
                'name' => $name,
                'designation' => $designation,
                'description' => $description,
                'status' => $status,
                'image' => $photo
            );
    
            if($id ==''){
                $response = Testimonial::create($data);
                if($response){
                    $res['msgType'] = 'success';
                    $res['msg'] = __('New Data Added Successfully');
                }else{
                    $res['msgType'] = 'error';
                    $res['msg'] = __('Data insert failed');
                }
            }else{
                $response = Testimonial::where('id', $id)->update($data);
                if($response){
                    $res['msgType'] = 'success';
                    $res['msg'] = __('Data Updated Successfully');
                }else{
                    $res['msgType'] = 'error';
                    $res['msg'] = __('Data update failed');
                }
            }
            
            return response()->json($res);
        }
        

    //Bulk Action for Testimonials
    public function bulkActionTestimonials(Request $request)
    {

        $res = array();

        $idsStr = $request->ids;
        $idsArray = explode(',', $idsStr);

        $BulkAction = $request->BulkAction;

        $response = Testimonial::whereIn('id', $idsArray)->delete();
        if ($response) {
            $res['msgType'] = 'success';
            $res['msg'] = __('Data Removed Successfully');
        } else {
            $res['msgType'] = 'error';
            $res['msg'] = __('Data remove failed');
        }

        return response()->json($res);
    }
}
