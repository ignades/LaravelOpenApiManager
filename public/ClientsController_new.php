<?php

namespace App\Http\Controllers;

use App\Models\Comune;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\ComuniResource;
use Illuminate\Support\Facades\Validator;
use App\Models\Citizen;


class ClientsController extends Controller
{

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    public function show(string $id):JsonResponse
    {
        $test = '
        {
             "firstName": "John",
             "lastName": "Smith",
             "age": 25,
             "address":
             {
                 "streetAddress": "21 2nd Street",
                 "city": "New York",
                 "state": "NY",
                 "postalCode": "10021"
             },
             "phoneNumber":
             [
                 {
                   "type": "home",
                   "number": "212 555-1234"
                 },
                 {
                   "type": "fax",
                   "number": "646 555-4567"
                 }
             ]
        }
        ';

        $data = json_decode($test, true);

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function searchCity(Request $request) {

        if(!empty($request->q)) {
            $q = addslashes($request->q);
        } else {
            return response()->json([]);
        }

        $builder = Comune::where('denominazione',  "like", "%{$q}%")
            ->orWhere('denominazione_regionale',  "like", "%{$q}%")
            ->orWhere('sigla_automobilistica',  "like", "%{$q}%")
            ->orWhere('codice_catastale_del_comune',  "like", "%{$q}%")
            ->orWhere('cap',  "like", "%{$q}%")
            ->orWhere('prefisso',  "like", "%{$q}%")
            ->orWhere('denominazione_unita_territoriale_sovracomunale',  "like", "%{$q}%");


        $response['items'] = $builder->orderByRaw("IF(denominazione = '{$q}',2,IF(denominazione LIKE '{$q}%',1,0)) DESC")->get()->map(function($item){
            $title = $item->denominazione . ", " . $item->denominazione_regionale;
            $title .= ", " . $item->denominazione_unita_territoriale_sovracomunale;
            $title .= ", " . $item->sigla_automobilistica;
            if($item->cap) $title .= ", " . $item->cap;
            $title .= ", " . 'ITALIA';

            return [
                'text' => $title,
                'id' => $item->id,
                'de' => $item->denominazione,
                're' => $item->denominazione_regionale,
                'pr' => $item->denominazione_unita_territoriale_sovracomunale,
                'sg' => $item->sigla_automobilistica,
                'ca' => $item->cap
            ];
        });

        return ComuniResource::collection($response);
    }

    public function getCitizen($id,$project_id):JsonResponse

                   /**
                     * @OA\GET(
                     *      path="api/citizen/{id}/{project_id}",
                     *      operationId="getClientsByID",
                     *      tags={"Clients"},
                     *      summary="Get list of clients",
                     *      description="Returns client detail",
                     *      @OA\Response(
                     *          response=200,
                     *          description="successful operation"
                     *       ),
                    *       @OA\Parameter(
                    *       in="path",
                    *       name="{id}",
                    *       required=true,
                    *       @OA\Schema(type="string")
                    *        )
                    
                     *     )
                     *
                     */
                   
    {

        $request = request()->merge(['id' => $id,'project_id' => $project_id]);

        $validator = Validator::make($request->all(), [
            'id' => 'required|string|min:0|max:3',
            'project_id' => 'required|string|min:0|max:3',
        ]);

        if($validator->fails()){
            return response()->json($validator->messages(), '404');
        }

        $citizen = Citizen::select(
            'first_name',
            'last_name',
            'sex',
            'data_nascita',
            'cf',
            'ragione_sociale',
            'piva',
            'pec',
            'email',
            'web_site',
            'phone',
            'mobile_number',
            'age',
            'address',
            'comune',
            'cap',
            'provincia',
            'regione',
            'nazione',
            'note')
            ->where('id',$id)
            ->where('project_id',$project_id)
            ->first();

        if(empty($citizen) || $citizen=='[]'){
            return response()->json('Resource not found', '404');
        }

        $citizen["type"] = !empty($citizen->ragione_sociale) ? 1 : 0 ;

        return response()->json($citizen);

    }

}