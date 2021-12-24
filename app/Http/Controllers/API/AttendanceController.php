<?php

namespace App\Http\Controllers\API;

use App\Attendance;
use App\branch;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'lat' => 'required',
            'lang' => 'required',
            'ip_address' => 'required',
        ]);
        $employee = auth()->user();
        $lat = $request->lat;
        $lng = $request->lang;

        $branches = branch::get();
        $existInHisBranch = false;



        foreach ($branches as $branch){

            if($this->distance($lat, $lng, $branch->lat, $branch->lng, 'M') < 0.05){
                $existInHisBranch = true;
            }
        }

        if($existInHisBranch == false){
            return response()->json([
                "status" => false,
                "message" => "عفوا انت غير متواجد بالشركة!",
            ]);
        }

        $dateTime = Carbon::now();
        $dateTime->minute = $this->roundToQuarterHour($dateTime);
        $response =  $this->storeAttendance($dateTime, $employee, $request);

        return response()->json($response);
    }

    public function storeAttendance(Carbon $dateTime, $employee, $request)
    {
        $workShift = $employee->workShift ?? null;
        $response  = [];
        if(!isset($workShift)){
            $response = [
                "status" => false,
                "message" => "There is No Work shift for employee ". $employee->name(),
            ];
        }else{
            switch($workShift->type){
                case "divided": // time_in, time_out, time_in2, time_out2
                    $todayAttendance = $employee->attendances()->whereDate('date', $dateTime)->first();
                    if(!isset($todayAttendance)){ //check in

                        Attendance::create([
                            'employee_id' => $employee->id,
                            'time_in' => $dateTime->format('H:i'),
                            'date' => $dateTime->format('Y-m-d'),
                            'lat' => $request->lat,
                            'lang' => $request->lang,
                            'ip_address' => $request->ip_address,
                            
                        ]);
                        $response = [
                            "status" => true,
                            "type" => 'time_in',
                            "message" => "The operation check in  has been done successfully for employee"
                        ];

                    }elseif (!isset($todayAttendance->time_out)){

                        $timeBetween = $todayAttendance->time_in->diffInHours($dateTime);
                        if($timeBetween >=1) {
                            $todayAttendance->update([
                                'time_out' => $dateTime->format('H:i'),
                            ]);
                            $response = [
                                'status' => true,
                                'type' => 'time_out',
                                "message" => "The operation check out  has been done successfully for employee "
                            ];
                        }else{
                            $response = [
                                'status' => false,
                                'type' => 'not_allowed',
                                "message" => "It is not possible to record the time out process for the employee until after at least an hour."
                            ];
                        }
                    }elseif (!isset($todayAttendance->time_in2)){

                        $timeBetween = $todayAttendance->time_out->diffInHours($dateTime);
                        if($timeBetween >=1) {
                            $todayAttendance->update([
                                'time_in2' => $dateTime->format('H:i'),
                            ]);
                            $response = [
                                'status' => true,
                                'type' => 'time_in2',
                                "message" => "The operation check in  has been done successfully for employee "
                            ];
                        }else{
                            $response = [
                                'status' => false,
                                'type' => 'not_allowed',
                                "message" => "It is not possible to record the time out process for the employee until after at least an hour."
                            ];
                        }


                    }elseif (!isset($todayAttendance->time_out2)){

//                    $workingHoursForShift1 = (new Carbon($todayAttendance->time_in))->diff(new Carbon($todayAttendance->time_out));
//                    $workingHoursForShift2 = (new Carbon($todayAttendance->time_in2))->diff($dateTime->format('H:i:s'));
//                    $totalWorkingHours = $workingHoursForShift2->addHours($workingHoursForShift1->format('H'));
//                    $totalWorkingHours->addMinutes($workingHoursForShift1->format('i'));

                        $timeBetween = $todayAttendance->time_in2->diffInHours($dateTime);
                        if($timeBetween >=1) {
                            $totalWorkingHours = (new Carbon($todayAttendance->time_in))->diff(new Carbon($dateTime->format('H:i:s')));
                            $todayAttendance->update([
                                'time_out2' => $dateTime->format('H:i'),
                                'total_working_hours' => $totalWorkingHours->format('%h:%I:%s')
                            ]);
                            $response = [
                                'status' => true,
                                'type' => 'time_out2',
                                "message" => "The operation check out  has been done successfully for employee"
                            ];
                        }else{
                            $response = [
                                'status' => false,
                                'type' => 'not_allowed',
                                "message" => "It is not possible to record the time out process for the employee until after at least an hour."
                            ];
                        }

                    }else{

                        $response = [
                            'status' => false,
                            'type' => 'not_allowed',
                            'message' => 'The attendance has been already record for employee',
                        ];

                    }
                    break;
                case "once":
                    $todayAttendance = $employee->attendances()->whereDate('date', $dateTime)->first();
                    if(!isset($todayAttendance)){ //check in

                        Attendance::create([
                            'employee_id' => $employee->id,
                            'time_in' => $dateTime->format('H:i'),
                            'time_out' => $dateTime->addHours($workShift->work_hours),
                            'date' => $dateTime->format('Y-m-d'),
                            'total_working_hours' => Carbon::createFromTime($workShift->work_hours)->format('H:i:s'),
                            'lat' => $request->lat,
                            'lang' => $request->lang,
                            'ip_address' => $request->ip_address,
                            
                        ]);
                        $response = [
                            "status" => true,
                            'type' => 'time_in',
                            "message" => "The operation check in  has been done successfully for employee "
                        ];

                    }else{
                        $response = [
                            'status' => false,
                            'type' => 'not_allowed',
                            'message' => 'The attendance has been already record for employee ',
                        ];
                    }
                    break;
                default: // normal && flexible

                    $todayAttendance = $employee->attendances()->whereDate('date', $dateTime)->first();
                    if(!isset($todayAttendance)){ //check in

                        Attendance::create([
                            'employee_id' => $employee->id,
                            'time_in' => $dateTime->format('H:i'),
                            'date' => $dateTime->format('Y-m-d'),
                            'lat' => $request->lat,
                            'lang' => $request->lang,
                            'ip_address' => $request->ip_address,
                            
                        ]);
                        $response = [
                            "status" => true,
                            'type' => 'time_in',
                            "message" => "The operation check in  has been done successfully for employee"
                        ];

                    }elseif (!isset($todayAttendance->time_out)){
                        $timeBetween = $todayAttendance->time_in->diffInHours($dateTime);
                        if($timeBetween >=1){
                            $totalWorkingHours = (new Carbon($todayAttendance->time_in))->diff(new Carbon($dateTime->format('H:i:s')))->format('%h:%I:%s');

                            $todayAttendance->update([
                                'time_out' => $dateTime->format('H:i'),
                                'total_working_hours' => $totalWorkingHours
                            ]);
                            $response = [
                                'status' => true,
                                'type' => 'time_out',
                                "message" => "The operation check out  has been done successfully for employee "
                            ];
                        }else{
                            $response = [
                                'status' => false,
                                'type' => 'not_allowed',
                                "message" => "It is not possible to record the time out process for the employee until after at least an hour."
                            ];
                        }


                    }else{

                        $response = [
                            'status' => false,
                            'type' => 'not_allowed',
                            'message' => 'The attendance has been already record for employee ',
                        ];

                    }
                    break;
            }
        }
        return $response;
    }

    function roundToQuarterHour($time) {
        $minutes = $time->minute;
        return $minutes - ($minutes % 15);
    }

    function distance($lat1, $lon1, $lat2, $lon2, $unit) {
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
        }
        else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);

            if ($unit == "K") {
                return ($miles * 1.609344);
            } else if ($unit == "N") {
                return ($miles * 0.8684);
            } else {
                return $miles;
            }
        }
    }

}
