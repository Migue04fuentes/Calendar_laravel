<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Turnos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('evento.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Evento::$rules);
        $doctor  = $request->{'id_doctor'};
        $start  = $request->{'start'};
        $sql = DB::select("select id,cupos from turnos where id_doctor=? and ? between start and end",[$doctor,$start]);
        
        if($sql){
            $cupos;
            $id;
            foreach ($sql as $key) {
                $cupos = $key->cupos;
                $id = $key->id;
            }
            $sqldos = DB::select("select count(id_doctor) as cupos from eventos where id_doctor=?",[$id]);
            foreach($sqldos as $key){
                $cupos2 = $key->cupos;
            }
            if($cupos == $cupos2){
                return response(1);
            }else{
                $evento = Evento::create($request->all());
                return response(2);
            }
        }else{
            return response(3);
        }
        /* foreach ($sql as $user) {
            if($user->cupos == 4){
                echo 'Igual';
            }else{
                echo 'Desigual';
            }
        } */
        /* $fecha  = $request->{'start'};
        $sql = "select * from eventos where id=".$doctor." and start='".$fecha."'";
        $buscar = DB::select($sql);
        if($buscar){
            return response("Existe");
        }else{
            return response("No Existe");
        } */
        // $evento = Evento::create($request->all());
        // return response()->json($evento);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function show(Evento $evento)
    {
        $evento = Evento::all();
        return response()->json($evento);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $evento = Evento::find($id);
        return response()->json($evento);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Evento $evento)
    {
        request()->validate(Evento::$rules);
        $evento->update($request->all());
        return response()->json($evento);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $evento = Evento::find($id)->delete();
        return response()->json($evento);
    }
}
