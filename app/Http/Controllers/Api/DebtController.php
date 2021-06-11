<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Debt;
use App\Api\ApiMessages;
use Illuminate\Http\Request;

class DebtController extends Controller
{
    private $debt;

    public function __construct(Debt $debt)
    {
        $this->debt = $debt;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index () {
        $debt = $this->debt->all();
        return response()->json($debt, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

        public function store(Debt $request){
            $data = $request->all();

            try{

                $debt = $this->debt->create($data);
                return response()->json($debt, 200);

            }catch(\Exception $e){
                $message = new ApiMessages($e->getMessage());
                return response()->json($message->getMessage(), 401);
            }
        }
     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id){

        try{
            $debt = $this->debt->findOrFail($id);

            return response()->json($debt, 200);
        }catch(\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        $data = $request->all();

        try{
            $debt = $this->debt->findOrFail($id);
            $debt->update($data);

            return response()->json($debt, 200);

        }catch(\Exception $e){

            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $debt = $this->debt->findOrFail($id);
            $debt->delete();

            return response()->json([
                'data' => [
                    'msg' => 'Debito Removido '
                ]
            ], 200);
        }catch(\Exception $e){

            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }




}
