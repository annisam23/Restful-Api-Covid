<?php

namespace App\Http\Controllers;

use App\Models\Patients;
use App\Models\StatusPatient;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PatientController extends Controller
{
    //get all data by status patient
    public function getPatientByStatus($idstatus)
    {
        return Patients::where('status_patient_id', $idstatus)->get();
    }

    //get id status patient
    public function getIdStatusPatient($statusName)
    {
        $statusPatient = Patients::where('status', $statusName)->first();
        return $statusPatient->id;
    }

    //get all data
    function index()
    {
        //use eloquent join
        $patients = DB::table('patients')->join('status_patients', 'patients.id', '=', 'status_patient_id')->select(['name', 'phone', 'address', 'in_date_at', 'out_date_at', 'status'])->get();

        $data = [
            'message' => 'Get All Resource',
            'data' => $patients,
        ];

        //mengirim data (json) dengan kode 200
        return response()->json($data, 200);
    }

    //add new data
    public function store(Request $request)
    {
        $input = [
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'status_patient_id' => $request->status_patient_id,
            'in_date_at' => $request->in_date_at,
            'out_date_at' => $request->out_date_at,
        ];

        $patient = Patients::create($input);

        $data = [
            'message' => "patient is created succesfully",
            'data' => $patient,
        ];

        //mengembalikan data json dan kode 201
        return response()->json($data, 201);
    }

    //Get detail source
    public function show($id)
    {
        $patients = Patients::find($id);

        if ($patients) {
            $data = [
                'message' => 'Get detail Patient',
                'data' => $patients
            ];
            //mengembalikan data(json) dan kode 200
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Patient not found',
            ];
            //mengembalikan data(json) dan kode 404
            return response()->json($data, 404);
        }
    }

    //update daata
    public function update($id, Request $request)
    {
        $patient = Patients::find($id);

        if ($patient) {
            $input = [
                'name' => $request->name ?? $patient->name,
                'phone' => $request->phone ?? $patient->phone,
                'address' => $request->address ?? $patient->address,
                'status_patient_id' => $request->status_patient_id ?? $patient->status_patient_id,
                'in_date_at' => $request->in_date_at ?? $patient->in_date_at,
                'out_date_at' => $request->in_date_at ?? $patient->out_date_at,
            ];

            //melakukan update data
            $patient->update($input);

            $data = [
                'message' => 'patient is updated',
                'data' => $patient
            ];

            // mengembalikan data (json) dan kode 200
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Patient not found',
            ];

            // mengembalikan data (json) dan kode 404
            return response()->json($data, 404);
        }
    }

    //delete data
    public function destroy($id)
    {
        $patients = Patients::find($id);

        if ($patients) {
            //hapus patient tersebut
            $patients->delete();

            $data = [
                "message" => "patient is deleted",
            ];
            // mengembalikan data (json) dan kode 200
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'patient not found',
            ];

            // mengembalikan data (json) dan kode 404
            return response()->json($data, 404);
        }
    }

    //search name
    public function search($name)
    {
        $patient = DB::table('patients')->where('name', 'like', "%" . $name . "%")->join('status_patients', 'patients.status_patient_id', "=", "status_patients.id")->get(['name', 'phone', 'address', 'in_date_at', 'out_date_at', 'status']);

        if (count($patient) == 0) {
            return response()->json([
                'message' => 'resource not found',
            ], 404);
        }

        $response = [
            'message' => 'get searched resource',
            'data' => $patient
        ];
        return response()->json($response, 200);
    }

    public function positive()
    {
        $patients = $this->getPatientByStatus(1);
        $data = [
            'message' => 'The Request sucessfull',
            'total' => count($patients),
            'data' => $patients,
        ];
        return response()->json($data, 200);
    }

    public function dead()
    {
        $patients = $this->getPatientByStatus(2);
        $data = [
            'message' => 'The Request sucessfull',
            'total' => count($patients),
            'data' => $patients,
        ];
        return response()->json($data, 200);
    }

    public function recovered()
    {
        $patients = $this->getPatientByStatus(3);
        $data = [
            'message' => 'The Request sucessfull',
            'total' => count($patients),
            'data' => $patients,
        ];
        return response()->json($data, 200);
    }
}
