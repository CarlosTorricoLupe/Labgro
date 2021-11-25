<?php

namespace App\Http\Controllers;

use App\Http\Requests\SectionRequest;
use App\Models\Section;
use App\Values\SectionStatusValues;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    private static $SECTION_FRUTAS = "Producción Frutas";
    private static $SECTION_CARNICOS = "Producción Cárnicos";
    private static $SECTION_LACTEOS = "Producción Lácteos";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections=Section::ActiveDescending()->get();

        if(count($sections)){
            return $this->addRoleInSections($sections);
        } else {
            return response()->json([
                'success'=>false,
                'message'=>'No se encontraron resultados'
            ],404);
        }
    }
    private function addRoleInSections($sections){
        foreach ($sections as $section){
            if($section->name == self::$SECTION_CARNICOS || $section->name == self::$SECTION_FRUTAS || $section->name == self::$SECTION_LACTEOS){
                $strategy_class = SectionStatusValues::STRATEGY[$section->name];
                $section['role_id'] = (new $strategy_class)->getRoleSectionState();
            }
        }
        return $sections;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SectionRequest $request)
    {
        Section::create($request->all());
        return response()->json([
            'sucess' =>true,
            'message' =>'Unidad creada correctamente'
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        return response()->json([
            'success'=> true,
            'category' =>$section
        ],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(SectionRequest $request, Section $section)
    {
        if($section == self::$SECTION_CARNICOS || $section == self::$SECTION_FRUTAS || $section == self::$SECTION_LACTEOS){
            $response = [
                'success' => false,
                'message' =>'La Unidad no puede modificarse, por que es necesario para producción'
            ];
        }else{
            $section->update($request->all());
            $response = [
                'success' => true,
                'message' =>'Unidad actualizada correctamente'
            ];
        }
        return response()->json($response,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $section = Section::find($id);
        if($section['Active']==true){
        $section->update(['Active'=>0]);
        $message="Unidad desactivada correctamente";
        }else{
            $section->update(['Active'=>1]);
            $message="Unidad activada correctamente";
        }
            return response()->json([
                'success'=>true,
                'message'=>$message,
            ],200);
    }
}
