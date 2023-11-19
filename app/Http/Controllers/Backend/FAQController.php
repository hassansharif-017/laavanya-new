<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Media_option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Review;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Cache;

class FAQController extends Controller
{
    public function __construct()
    {
        Cache::forget('globalFaq');
    }
    //Faqs page load
    public function getfaqsPageLoad()
    {

        $datalist = Faq::orderBy('display_order', 'asc')
            ->paginate(20);
        $media_datalist = Media_option::orderBy('id', 'desc')->paginate(28);
        return view('backend.faqs', compact('datalist', 'media_datalist'));
    }

    //Get data for Faqs Pagination
    public function getFaqsTableData(Request $request)
    {

        $search = $request->search;

        if ($request->ajax()) {
            $datalist = Faq::
            when($search, function ($query) use ($search) {
                $query->where('question', 'like', '%' . $search . '%')
                    ->orWhere('answer', 'like', '%' . $search . '%')
                    ->orWhere('created_at', 'like', '%' . $search . '%');
            })
            ->orderBy('display_order', 'asc')
            ->paginate(20);

            return view('backend.partials.faqs_table', compact('datalist'))->render();
        }
    }

    //Delete data for Faq
    public function deleteFaq(Request $request)
    {

        $res = array();

        $id = $request->id;

        if ($id != '') {
            $response = Faq::where('id', $id)->delete();
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

    	//Get data for Faq by id
        public function getFaqById(Request $request){

            $id = $request->id;
            
            $data = Faq::where('id', $id)->first();
            
            return response()->json($data);
        }

    	//Save data for Testimonials
        public function saveFaqsData(Request $request){
            $res = array();
            
            $id = $request->input('RecordId');
            $question = $request->input('question');
            $answer = $request->input('answer');
            $status = $request->input('status');
            $display_order = $request->input('display_order');
            
            $validator_array = array(
                'question' => $request->input('question'),
                'answer' => $request->input('answer'),
                'status' => $request->input('status'),
                'display_order' => $request->input('display_order')
            );
            
            $validator = Validator::make($validator_array, [
                'question' => 'required|max:191',
                'answer' => 'required|max:191',
                'status' => 'required',
                'display_order' => 'required'
            ]);
    
            $errors = $validator->errors();
    
            if($errors->has('question')){
                $res['msgType'] = 'error';
                $res['msg'] = $errors->first('question');
                return response()->json($res);
            }
            
            if($errors->has('answer')){
                $res['msgType'] = 'error';
                $res['msg'] = $errors->first('answer');
                return response()->json($res);
            }
    
            if($errors->has('status')){
                $res['msgType'] = 'error';
                $res['msg'] = $errors->first('status');
                return response()->json($res);
            }
            if($errors->has('display_order')){
                $res['msgType'] = 'error';
                $res['msg'] = $errors->first('display_order');
                return response()->json($res);
            }
    
            $data = array(
                'question' => $question,
                'answer' => $answer,
                'status' => $status,
                'display_order' => $display_order
            );
    
            if($id ==''){
                $response = Faq::create($data);
                if($response){
                    $res['msgType'] = 'success';
                    $res['msg'] = __('New Data Added Successfully');
                }else{
                    $res['msgType'] = 'error';
                    $res['msg'] = __('Data insert failed');
                }
            }else{
                $response = Faq::where('id', $id)->update($data);
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
        

    //Bulk Action for Faqs
    public function bulkActionFaqs(Request $request)
    {

        $res = array();

        $idsStr = $request->ids;
        $idsArray = explode(',', $idsStr);

        $BulkAction = $request->BulkAction;

        $response = Faq::whereIn('id', $idsArray)->delete();
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
