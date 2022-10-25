<?php

namespace App\Http\Controllers;
use App\Http\Requests\CreateArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\Output;
use App\Models\Unit;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$this->authorize('view', Article::class);
        Article::UpdateStatusIsLow();
        $result = Article::ArticlesAll();
        return $result;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateArticleRequest  $request
     * @return Response
     */
    public function store(CreateArticleRequest $request)
    {
        //$this->authorize('manage', Article::class);

        $article=new Article($request->all());
        $article->stock_total=$article->stock;
        $article->save();
        return response()->json([
            'sucess' => true,
            'message' => 'Registro creado correctamente'
        ],201);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return response()->json([
            'success'=> true,
            'category' =>$article
        ],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateArticleRequest  $request
     * @param  Article  $article
     * @return Response
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        //$this->authorize('manage', Article::class);
        $article->update($request->all());
        return response()->json([
            'res' => true,
            'message' => 'Articulo actualizado correctamente'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //$this->authorize('manage', Article::class);
        Article::destroy($id);
        return response()->json([
            'success' => true,
            'message' => 'Se elimino correctamente'
        ],200);
    }

    public function searchArticle(Request $request)
    {
        $result = Article::where('name_article', 'like',$request->txtBuscar.'%')->get();

        if(count($result)){
            return $result;
        } else {
            return response()->json([
                'success'=>false,
                'message'=>'No se encontraron resultados'
            ],404);
        }
    }

    public function searchArticleForCategorgy(Request $request)
    {
        $result =Article::join('categories','articles.category_id','=',"categories.id")
            ->where('categories.name','=',$request->txtBuscar)
            ->select('articles.*')
            ->get();

        if(count($result)){
            return $result;
        } else {
            return response()->json([
                'success'=>false,
                'message'=>'No se encontraron resultados'
            ],404);
        }
    }

    public function peripheralReport(Request $request){
        $periods=[
            'Primer Trimestre'=>[1,3],
            'Segundo Trimestre'=>[4,6],
            'Tercer Trimestre'=>[7,9],
            'Cuarto Trimestre'=>[10,12],
        ];
        $period = $periods[$request->trimestre];
        $year = $request->year;
        $outputs = Output::getOutputs($year, $period[0], $period[1])->get();
        return $outputs;
        $result=Article::ArticlesPeripheralReport($period, $year);
        if(count($result)){
            return $result;
        } else {
            return response()->json([
                'success'=>false,
                'message'=>'No se encontraron resultados'
            ],404);
        }
    }

    public function physicalReport(Request $request){
        $reporteFinal=[];
        $reportsIncomes=Article::getArticlePhysicalReport($request->id,$request->mounthone,$request->mounttwo,$request->year);
            $result = array();
            foreach($reportsIncomes as $income){
                $result[]=[
                    'fecha'=> $income->fecha,
                    'comprobante'=> $income->comprobante,
                    'Origen'=> "Ingreso",
                    'cantidadEntrada'=> $income->cantidadEntrada,
                    'importeEntrada'=> $income->importeEntrada,
                    'cantidadSalida'=> "",
                    'importeSalida'=> "",
                    'cantidadSaldo'=> $income->cantidadSaldo,
                    'importeSaldo'=> $income->importeSaldo,
                    'precioMedio'=> $income->precioMedioEntrada,
                    'created_at'=> $income->created_at->toDateTimeString(),
                ];
                $reportIncome=collect($result);
            }
        $reportsOuputs=Article::getArticlePhysicalReportOutput($request->id,$request->mounthone,$request->mounttwo,$request->year);
            $result2 = array();
            foreach($reportsOuputs as $outputs){
                $result2[]=[
                    'fecha'=> $outputs->fecha,
                    'comprobante'=> $outputs->comprobante,
                    'Origen'=> $outputs->origen,
                    'cantidadEntrada'=> "",
                    'importeEntrada'=> "",
                    'cantidadSalida'=> $outputs->cantidadSalida,
                    'importeSalida'=> $outputs->importeSalida,
                    'cantidadSaldo'=> $outputs->cantidadSaldo,
                    'importeSaldo'=> $outputs->importeSaldo,
                    'precioMedio'=> "",
                    'created_at'=> $outputs->created_at->toDateTimeString(),
                ];
                $reportOutput=collect($result2);
            }
        
        if (count($reportsIncomes)&& count($reportsOuputs)) {
            $reporteFinal=$reportIncome->concat($reportOutput)->sortBy(['fecha','asc'],['created_at','asc']);
        }else{
        if (count($reportsIncomes)) {
            $reporteFinal=$reportIncome->sortBy(['fecha','asc'],['created_at','asc']);
        }
        if(count($reportsOuputs)){
            $reporteFinal=$reportOutput->sortBy(['fecha','asc'],['created_at','asc']);
        }
        }
        return response()->json([
            'success'=>true,
            'report'=>$reporteFinal,
        ],200);
    }
}
