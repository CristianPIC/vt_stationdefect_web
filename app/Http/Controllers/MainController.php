<?php

namespace App\Http\Controllers;

use App\Resourcekeys;
use App\Places;
use App\Fault_type;
use App\Job_types;
use App\Priority;
use App\Accesslog;
use App\Reported_problems;

use Illuminate\Http\Request;


class MainController extends Controller
{
    public function postCheckversion(Request $request){
       $result = array();

       $result['result'] = 'Unauthorized.';
       if (!$request->has('resourcekey') ) {
           return response($result, 401);
       }elseif ( $request->has('resourcekey') ) {
           $key = ResourceKeys::where( 'key', $request->get('resourcekey') )->get()->toarray();
           
           if ( count($key) != 1 ) {
               return response($result, 401);
           }
       }
       $result['result'] = 'not_ok';
       if ( $request->has('version') ) {
           $version = $request->get('version');
           if ( $version >= 8 ) {
                   $result['result'] = 'ok';
                   return $result;
           }else return $result;
       }else return $result;
    }

    public function checkApiKey($request){
    	
  		if($request->has('resourcekey')){
  			$countKeys = Resourcekeys::where('key', $request->get('resourcekey'))->count();
  			if($countKeys > 0){
  				return true;
  			}else{
  				return false;
  			}
  		}else{
  			return false;
  		}
  	}

  	public function postDataStatic(Request $request){


    	$result = array();
    	
    	if(!$this->checkApiKey($request)){
			 return response(array('result' => 'Unauthorized.'), 401);
		  }

        

    	$result['result'] = 'ok';
      $result['places'] = array();
      $result['fault_type'] = array();
      $result['job_types'] = array();
      $result['priority'] = array();

      $allPlaces = Places::get();

      foreach($allPlaces as $places){
        $pItem = array();
        $pItem['id'] = $places->id;
        $pItem['station'] = $places->station;
        $pItem['area'] = $places->area;
        $pItem['location'] = $places->location;
        $result['places'][] = $pItem;
      }

      $allFault_type = Fault_type::get();

      foreach($allFault_type as $fault_type){
        $f_tItem = array();
        $f_tItem['id'] = $fault_type->id;
        $f_tItem['fault_type'] = $fault_type->fault_type;
        $result['fault_type'][] = $f_tItem;
      }

      $allJob_types = Job_types::get();

      foreach($allJob_types as $job_types){
        $j_tItem = array();
        $j_tItem['id'] = $job_types->id;
        $j_tItem['job_types'] = $job_types->job_types;
        $result['job_types'][] = $j_tItem;
      }

      $allPriority = Priority::get();

      foreach($allPriority as $priority){
        $pItem = array();
        $pItem['id'] = $priority->id;
        $pItem['priority'] = $priority->priority;
        $result['priority'][] = $pItem;
      }

      return $result;
	    
    }

    public function postData(Request $request){

    	$result = array();
    	
    	if(!$this->checkApiKey($request)){
			 return response(array('result' => 'Unauthorized.'), 401);
		  }

        

    	$result['result'] = 'ok';

    	$result['problems'] = array();


      $allProblems = Reported_problems::all();
      foreach($allProblems as $problems){
      	$pItem = array();
      	$pItem['id'] = $problems->id;
      	$pItem['vtwcid'] = $problems->vtwcid;
      	$pItem['place_id'] = $problems->place_id;
      	$pItem['station'] = $problems->station;
      	$pItem['area'] = $problems->area;
      	$pItem['location'] = $problems->location;
      	$pItem['staff_id'] = $problems->staff_id;
      	$pItem['staff_name'] = $problems->staff_name;
      	$pItem['staff_role'] = $problems->staff_role;
      	$pItem['staff_tel'] = $problems->staff_tel;
      	$pItem['date'] = $problems->date;
      	$pItem['fault_type'] = $problems->fault_type;
      	$pItem['job_type'] = $problems->job_type;
      	$pItem['job_budget'] = $problems->job_budget;
      	$pItem['job_authorised'] = $problems->job_authorised;
      	$pItem['fault_details'] = $problems->fault_details;
      	$pItem['priority'] = $problems->priority;
      	$pItem['reason'] = $problems->reason;
      	$pItem['is_fixed'] = $problems->is_fixed;
      	$pItem['staff_fixed'] = $problems->staff_fixed;
      	$pItem['comment_fixed'] = $problems->comment_fixed;
      	$pItem['job_number'] = $problems->job_number;
      	$pItem['staff_job'] = $problems->staff_job;

        if($problems['created_at'] != NULL && $problems['updated_at'] != NULL){
        	$pItem['created_at'] = $problems['created_at']->toDateTimeString();
        	$pItem['updated_at'] = $problems['updated_at']->toDateTimeString();
        }

      	$result['problems'][] = $pItem;
      }


      $logExists = Accesslog::where('staff_email', $request->email)
            ->where('created_at', '>', date('Y-m-d', strtotime('today midnight')))
            ->where('created_at', '<', date('Y-m-d', strtotime('tomorrow midnight')))
            ->first();
      if($logExists){
          $logExists->increment('counter');
      }else{
          $newAccessLog = new Accesslog;
          $newAccessLog->staff_email = $request->email;
          $newAccessLog->date = date("Y-m-d");
          $newAccessLog->counter = 1;
          $newAccessLog->save();
      }
        

    	return $result;

    }

    public function postReportProblem(Request $request){

    	$result = array();
    	
    	if(!$this->checkApiKey($request)){
			 return response(array('result' => 'Unauthorized.'), 401);
		  }

        

    	$result['result'] = 'ok';

    	$result['problems'] = array();


      $allProblems = Reported_problems::all();
      foreach($allProblems as $problems){
      	$pItem = array();
      	$pItem['id'] = $problems->id;
      	$pItem['vtwcid'] = $problems->vtwcid;
      	$pItem['place_id'] = $problems->place_id;
      	$pItem['station'] = $problems->station;
      	$pItem['area'] = $problems->area;
      	$pItem['location'] = $problems->location;
      	$pItem['staff_id'] = $problems->staff_id;
      	$pItem['staff_name'] = $problems->staff_name;
      	$pItem['staff_role'] = $problems->staff_role;
      	$pItem['staff_tel'] = $problems->staff_tel;
      	$pItem['date'] = $problems->date;
      	$pItem['fault_type'] = $problems->fault_type;
      	$pItem['job_type'] = $problems->job_type;
      	$pItem['job_budget'] = $problems->job_budget;
      	$pItem['job_authorised'] = $problems->job_authorised;
      	$pItem['fault_details'] = $problems->fault_details;
      	$pItem['priority'] = $problems->priority;
      	$pItem['reason'] = $problems->reason;
      	$pItem['is_fixed'] = $problems->is_fixed;
      	$pItem['staff_fixed'] = $problems->staff_fixed;
      	$pItem['comment_fixed'] = $problems->comment_fixed;
      	$pItem['job_number'] = $problems->job_number;
      	$pItem['staff_job'] = $problems->staff_job;

        if($problems['created_at'] != NULL && $problems['updated_at'] != NULL){
        	$pItem['created_at'] = $problems['created_at']->toDateTimeString();
        	$pItem['updated_at'] = $problems['updated_at']->toDateTimeString();
        }

      	$result['problems'][] = $pItem;
      }

      
        

    	return $result;

    }
}
