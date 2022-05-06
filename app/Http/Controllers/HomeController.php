<?php

namespace App\Http\Controllers;

use App\Models\Contractor;
use App\Models\Expertise;
use App\Models\ExpertiseStatus;
use App\Models\GraphData;
use App\Models\Region;
use Carbon\Carbon;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Статусы экспертиз
        $expertiseStatus = ExpertiseStatus::query()
            ->leftJoin('expertise', function (JoinClause $join) {
                $join->on('expertise_status.id', '=', 'expertise.status_id')
                    ->where('expertise.created_at', '>=', Carbon::now()->startOfYear())
                    ->where('expertise.created', '=', 1);
            })
            ->select('expertise_status.id', DB::raw('SUM(IF(expertise.id IS NULL, 0, 1)) as total'))
            ->groupBy(DB::raw('expertise_status.id WITH ROLLUP'))
            ->pluck('total', 'id')->all();


        // Общее количество назначенных экспертиз
        $expertiseMonth = Expertise::query()
            ->whereNotNull('start_date')
            ->where('start_date', '>=', Carbon::now()->subYears(-1)->startOfYear())
            ->where('start_date', '<=', Carbon::now()->subYears(-1)->endOfYear())
            ->where('expertise.created', '=', 1)
            ->select(DB::raw('COUNT(*)  as total'), DB::raw('MONTH(start_date) as month'))
            ->groupBy('month')
            ->pluck('total', 'month')->all();

        $expertiseMonth2 = Expertise::query()
            ->whereNotNull('start_date')
            ->where('start_date', '>=', Carbon::now()->startOfYear())
            ->where('created', '=', 1)
            ->select(DB::raw('COUNT(*)  as total'), DB::raw('MONTH(start_date) as month'))
            ->groupBy('month')
            ->pluck('total', 'month')->all();

        $expertiseMonths = [$expertiseMonth, $expertiseMonth2];


        // По органу
        $expertiseContractors = Expertise::query()
            ->join('contractors', 'expertise.contractor_id', '=', 'contractors.id')
            ->join('contractor_organs', 'contractors.organ_id', '=', 'contractor_organs.id')
            ->where('expertise.start_date', '>=', Carbon::now()->startOfYear())
            ->where('expertise.created', '=', 1)
            ->select(DB::raw('COUNT(*) as total'), DB::raw('contractor_organs.title as organ'))
            ->groupBy('organ')
            ->orderBy('organ')
            ->get()->all();

        // Общее количество назначенных экспертиз
        $expertiseYears = Expertise::query()
            ->where('start_date', '>=', Carbon::now()->startOfYear()->subYears(2))
            ->where('created', '=', 1)
            ->select(DB::raw('COUNT(*) as total'), DB::raw('YEAR(start_date) as year'))
            ->groupBy('year')
            ->orderBy('year')
            ->pluck('total', 'year')->all();


        // Сведения по регионам

//        $expertiseRegion = Expertise::query()
//            ->join('expertise_decisions', 'expertise.id', '=', 'expertise_decisions.expertise_id')
//            ->whereNotNull('expertise.start_date')
//            ->where('expertise.start_date', '>=', Carbon::now()->subYears(-1)->startOfYear())
//            ->where('expertise.start_date', '<=', Carbon::now()->subYears(-1)->endOfYear())
//            ->where('expertise.created', '=', 1)
//            ->select(DB::raw('COUNT(DISTINCT expertise.id) as total'), DB::raw('expertise_decisions.court_id as region'))
//            ->groupBy('region')
//            ->orderBy('region')
//            ->pluck('total', 'region')->all();
//
//        $expertiseRegion2 = Expertise::query()
//            ->join('expertise_decisions', 'expertise.id', '=', 'expertise_decisions.expertise_id')
//            ->whereNotNull('expertise.start_date')
//            ->where('expertise.start_date', '>=', Carbon::now()->startOfYear())
//            ->where('expertise.created', '=', 1)
//            ->select(DB::raw('COUNT(DISTINCT expertise.id) as total'), DB::raw('expertise_decisions.court_id as region'))
//            ->groupBy('region')
//            ->orderBy('region')
//            ->pluck('total', 'region')->all();

        $unsetKeys = ['year', 'id', 'created_at', 'updated_at'];

        $expertiseRegion = GraphData::where('year', date('Y') - 1)->get();
        $expertiseRegion2 = GraphData::where('year', date('Y'))->get();

        $expertiseRegion = $expertiseRegion->toArray()[0];
        $expertiseRegion2 = $expertiseRegion2->toArray()[0];

        foreach ($unsetKeys as $key){
            unset($expertiseRegion[$key]);
            unset($expertiseRegion2[$key]);
        }

        $expertiseRegions = [$expertiseRegion, $expertiseRegion2];

        return view('home', compact(
            'expertiseStatus', 'expertiseMonths',
            'expertiseRegions', 'expertiseContractors', 'expertiseYears'
        ));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function generateDocx()
    {
        $phpWord = new \PhpOffice\PhpWord\PhpWord();


        $section = $phpWord->addSection();


        $description = "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";


        $section->addImage("http://itsolutionstuff.com/frontTheme/images/logo.png");
        $section->addText($description);


        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        try {
            $objWriter->save(storage_path('helloWorld.docx'));
        } catch (Exception $e) {
        }


        return response()->download(storage_path('helloWorld.docx'));
    }

    public function templateDocx(){
        $my_template = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('app/helloWorld.docx'));

        $my_template->setValue('var', 'Hello Template');

        try{
            $my_template->saveAs(storage_path('app/temp1.docx'));
        }catch (Exception $e){
            //handle exception
        }

        return response()->download(storage_path('app/temp1.docx'));
    }
}
