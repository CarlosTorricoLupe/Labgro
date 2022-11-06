<?php

namespace App\Http\Controllers;

use App\Exports\PhysicalReportExport;
use App\Http\Requests\CreateArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\Output;
use App\Models\Unit;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use function PHPUnit\Framework\isEmpty;

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
            'gestion'=>[1,12]
        ];
        $period = $periods[$request->trimestre];
        $year = $request->year;
        $incomes = Article::getInputs($year, $period[0], $period[1])->get();
        foreach($incomes as $income){
            $outputs = Output::getOutputs($income->article_id , $year, $period[0], $period[1])->get();
            if(count($outputs)>0){
                $r_outputs = $outputs->sum('outputs');
                $r_balance_stock = @$outputs->last()->balance_stock;
                $r_balance_stock = $r_balance_stock ? $r_balance_stock : 0;
                $income->outputs = $r_outputs;
                $income->amount1 = $income->unit_price * $r_outputs;
                $income->balance_stock = $r_balance_stock;
                $income->amount2 = $income->unit_price * $r_balance_stock;
            }else {
                $r_balance_stock = $income->quantity;
                $income->outputs = 0;
                $income->amount1 = 0;
                $income->balance_stock = $r_balance_stock;
                $income->amount2 = $income->unit_price * $r_balance_stock;
            }
        }
        if(count($incomes)){
            return $incomes;
        } else {
            return response()->json([
                'success'=>false,
                'message'=>'No se encontraron resultados'
            ],404);
        }
    }

    public function physicalReport(Request $request){
        $reporteFinal=[];
        $article=Article::find($request->id,['name_article']);
        $reportsIncomes=Article::getArticlePhysicalReport($request->id,$request->monthone,$request->monthtwo,$request->year,$request->area);
            $result = array();
            foreach($reportsIncomes as $income){
                $importeSaldo=($income->stock+$income->cantidadEntrada)*$income->valUnit;
                $result[]=[
                    'fecha'=> $income->fecha,
                    'comprobante'=> $income->comprobante,
                    'Origen'=> $income->origen,
                    'cantidadEntrada'=> $income->cantidadEntrada,
                    'importeEntrada'=> $income->importeEntrada,
                    'cantidadSalida'=> "",
                    'importeSalida'=> "",
                    'cantidadSaldo'=> $income->stock+$income->cantidadEntrada,
                    'importeSaldo'=> $importeSaldo,
                    'precioMedio'=> $income->precioMedioEntrada,
                    'created_at'=> $income->created_at->toDateTimeString(),
                    'valorUnit'=> $income->valUnit,
                ];
                $reportIncome=collect($result);
            }
        $reportsOuputs=Article::getArticlePhysicalReportOutput($request->id,$request->monthone,$request->monthtwo,$request->year,$request->area);
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
                    'cantidadSaldo'=> $outputs->cantidadSaldo == 0 ? "0":$outputs->cantidadSaldo,
                    'importeSaldo'=> $outputs->importeSaldo == 0 ? "0":$outputs->importeSaldo,
                    'precioMedio'=> "",
                    'created_at'=> $outputs->created_at->toDateTimeString(),
                    'valorUnit'=> $outputs->valUnit,
                ];
                $reportOutput=collect($result2);
            }

        if (count($reportsIncomes)&& count($reportsOuputs)) {
            $reporteFinal=($reportIncome->concat($reportOutput))->sortBy(['fecha','ASC']);
        }else{
            if (count($reportsIncomes)) {
                $reporteFinal=$reportIncome;
            }
            if(count($reportsOuputs)){
                $reporteFinal=$reportOutput;
            }
        }
            if ($request->year > date('Y')) {
                $reporteFinal=collect([$reporteFinal->last()]);
            }
        return response()->json([
            'success'=>true,
            'article'=>$article->name_article,
            'report'=>$reporteFinal,
        ],200);
    }

    public function PhysicalExport(Request $request) 
    {
        $controller=app('App\Http\Controllers\ArticleController')->physicalReport($request);
        $art=$controller->getOriginalContent()['report'];
        $name=$controller->getOriginalContent()['article'];
        $monthone=$request->monthone;
        $monthtwo=$request->monthtwo;
        $year=$request->year;
        
        return Excel::download(new PhysicalReportExport($art,$name,$monthone,$monthtwo,$year), 'Reporte Fisico '.$name.' '.$monthone.'-'.$monthtwo.'-'.$year.'.xlsx');

    }
}
