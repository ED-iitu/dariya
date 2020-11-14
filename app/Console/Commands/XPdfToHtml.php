<?php

namespace App\Console\Commands;

use App\Jobs\ProcessParsePdfBooks;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class XPdfToHtml extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'utils:x-pdf-to-html {--file=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert pdf file to html with Xpdf utils';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $html = '<body>
<img class="background" style="position:absolute; left:0px; top:0px;" width="411" height="609" src="page69.png">
<div class="txt" style="position:absolute; left:125px; top:31px;"><span class="f2" style="font-size:9px;vertical-align:baseline;">Мұхаммед пайғамбардың </span><span class="f2" style="font-size:7px;vertical-align:baseline;">(саллаллаһу аләйһи уә сәлләм) </span><span class="f2" style="font-size:9px;vertical-align:baseline;">балалық шағы</span></div>
<div class="txt" style="position:absolute; left:39px; top:48px;"><span class="f1" style="font-size:12px;vertical-align:baseline;">адамның жүрегіне жол тауып, ақиқатқа тартқан парасатты</span></div>
<div class="txt" style="position:absolute; left:39px; top:63px;"><span class="f1" style="font-size:12px;vertical-align:baseline;">тұлғаның бір қыры еді бұл.</span></div>
<div class="txt" style="position:absolute; left:107px; top:87px;"><span class="f3" style="font-size:12px;vertical-align:baseline;">Әзіpeт Мұхаммед </span><span class="f3" style="font-size:9px;vertical-align:baseline;">(саллаллаһу аләйһи</span></div>
<div class="txt" style="position:absolute; left:138px; top:102px;"><span class="f3" style="font-size:9px;vertical-align:baseline;">уә сәлләм) </span><span class="f3" style="font-size:12px;vertical-align:baseline;">қой да баққан</span></div>
<div class="txt" style="position:absolute; left:53px; top:122px;"><span class="f1" style="font-size:12px;vertical-align:baseline;">Әзіpeт Мұхаммед он жаста…</span></div>
<div class="txt" style="position:absolute; left:53px; top:137px;"><span class="f1" style="font-size:12px;vertical-align:baseline;">Ойланып-толғанып көкесі Әбу Тәліпке:</span></div>
<div class="txt" style="position:absolute; left:53px; top:151px;"><span class="f1" style="font-size:12px;vertical-align:baseline;">«Сіздің қой-ешкіңізді мұнан былай мен бағайын, бөлек</span></div>
<div class="txt" style="position:absolute; left:39px; top:166px;"><span class="f1" style="font-size:12px;vertical-align:baseline;">бақташы жалдап қажеті жоқ», – дейді. Әрине, Әбу Тәліп бұған</span></div>
<div class="txt" style="position:absolute; left:39px; top:181px;"><span class="f1" style="font-size:12px;vertical-align:baseline;">алғашында қарсы болды. Үйтіп-бүйтіп оны әрең көндірдім-ау де-</span></div>
<div class="txt" style="position:absolute; left:39px; top:196px;"><span class="f1" style="font-size:12px;vertical-align:baseline;">генде, Фатима наразылығын білдіреді:</span></div>
<div class="txt" style="position:absolute; left:53px; top:211px;"><span class="f1" style="font-size:12px;vertical-align:baseline;">«Ботам-ау, сенің табаныңа қадалар шөңге менің маңдайыма</span></div>
<div class="txt" style="position:absolute; left:39px; top:226px;"><span class="f1" style="font-size:12px;vertical-align:baseline;">кірсін деп, күндіз-түні тілеуіңді тілеп отырғанда, бұл не дегенің?</span></div>
<div class="txt" style="position:absolute; left:39px; top:241px;"><span class="f1" style="font-size:12px;vertical-align:baseline;">Қалайша сені дәтім шыдап шыжыған шөлге қоя берем? Жоқ,</span></div>
<div class="txt" style="position:absolute; left:39px; top:256px;"><span class="f1" style="font-size:12px;vertical-align:baseline;">балам, болмайды бұлай. Алтыным-ау, саған қой бақтырып</span></div>
<div class="txt" style="position:absolute; left:39px; top:270px;"><span class="f1" style="font-size:12px;vertical-align:baseline;">үнемдегенше, қайыр тілеп кеткенім көп артық», – деп шала</span></div>
<div class="txt" style="position:absolute; left:39px; top:285px;"><span class="f1" style="font-size:12px;vertical-align:baseline;">бүлінді.</span></div>
<div class="txt" style="position:absolute; left:53px; top:300px;"><span class="f1" style="font-size:12px;vertical-align:baseline;">Бірақ, әзіpeт Мұхаммед те айтқанынан қайтпады, тәтті тілімен</span></div>
<div class="txt" style="position:absolute; left:39px; top:315px;"><span class="f1" style="font-size:12px;vertical-align:baseline;">түсіндіріп жүріп, анасының да бұл іске ризашылығын алды.</span></div>
<div class="txt" style="position:absolute; left:39px; top:330px;"><span class="f1" style="font-size:12px;vertical-align:baseline;">Сол күннен бастап Ол таңертең ертемен азын-аулақ қой-ешкіні</span></div>
<div class="txt" style="position:absolute; left:39px; top:345px;"><span class="f1" style="font-size:12px;vertical-align:baseline;">айдап өріске шығып жүрді. Сөйтіп, онсыз да тұрмысы нашар</span></div>
<div class="txt" style="position:absolute; left:39px; top:360px;"><span class="f1" style="font-size:12px;vertical-align:baseline;">көкесіне бақташы жалдатпай, көмек қолын созды. Әрі оңашада</span></div>
<div class="txt" style="position:absolute; left:39px; top:374px;"><span class="f1" style="font-size:12px;vertical-align:baseline;">жер мен көктің сырын сыналай сүзіп, ойлануға мүмкіндік тап-</span></div>
<div class="txt" style="position:absolute; left:39px; top:389px;"><span class="f1" style="font-size:12px;vertical-align:baseline;">ты. Табиғаттың тамашаларын, оны Жаратушының ұлылығын</span></div>
<div class="txt" style="position:absolute; left:39px; top:404px;"><span class="f1" style="font-size:12px;vertical-align:baseline;">жай көріп қана қоймай, астарына үңілетін, ләззат алатын.</span></div>
<div class="txt" style="position:absolute; left:39px; top:419px;"><span class="f1" style="font-size:12px;vertical-align:baseline;">У-шуға толы, өтірік-өсек, алдап-арбау, бір сөзбен айтқанда,</span></div>
<div class="txt" style="position:absolute; left:39px; top:434px;"><span class="f1" style="font-size:12px;vertical-align:baseline;">нәпсіқұмарлық жайлаған жамағаттан ұзақ жүргеніне қуанған.</span></div>
<div class="txt" style="position:absolute; left:53px; top:448px;"><span class="f1" style="font-size:12px;vertical-align:baseline;">Мүбәрак</span><span class="f1" style="font-size:6px;vertical-align:super;">15 </span><span class="f1" style="font-size:12px;vertical-align:baseline;">өмірінің бір жылын қой бағуға арнаған</span></div>
<div class="txt" style="position:absolute; left:39px; top:464px;"><span class="f1" style="font-size:12px;vertical-align:baseline;">пайғамбарымыз, Алла тарапынан елшілік міндеті жүктелгеннен</span></div>
<div class="txt" style="position:absolute; left:39px; top:479px;"><span class="f1" style="font-size:12px;vertical-align:baseline;">кейін асхабымен бірге табиғат аясына демалуға шыққанда жа-</span></div>
<div class="txt" style="position:absolute; left:39px; top:493px;"><span class="f1" style="font-size:12px;vertical-align:baseline;">байы жеміс жинамақ болады. Сонда әзіpeт Мұхаммед </span><span class="f1" style="font-size:9px;vertical-align:baseline;">(саллаллаһу</span></div>
<div class="txt" style="position:absolute; left:39px; top:508px;"><span class="f1" style="font-size:9px;vertical-align:baseline;">аләйһи уә сәлләм) </span><span class="f1" style="font-size:12px;vertical-align:baseline;">сахабаларына:</span></div>
<div class="txt" style="position:absolute; left:53px; top:523px;"><span class="f1" style="font-size:12px;vertical-align:baseline;">«Әбден қарайғанын алыңыздар, сонысы тәтті болады», – дейді.</span></div>
<div class="txt" style="position:absolute; left:53px; top:538px;"><span class="f1" style="font-size:12px;vertical-align:baseline;">Асхабы:</span></div>
<div class="txt" style="position:absolute; left:48px; top:559px;"><span class="f1" style="font-size:5px;vertical-align:super;">15 </span><span class="f1" style="font-size:10px;vertical-align:baseline;">Қайырлы берекелі.</span></div>
<div class="txt" style="position:absolute; left:200px; top:577px;"><span class="f1" style="font-size:11px;vertical-align:baseline;">77</span></div>
</body>';
        //$html = \App\Helpers\XPdfToHtml::generateCorrectHtml($html);
        //dd($html,'exit');
        $file = $this->option('file');
        if(!$file){
            $file = $this->ask('Укажите файл');
        }
        if(file_exists(base_path($file))){
            $this->info("Selected file: {$file}");

            $options = [];
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                // change pdftohtml bin location
                $options['bin'] = base_path('bin/win/xpdf/pdftohtml.exe');
                $options['info_bin'] = base_path('bin/win/xpdf/pdfinfo.exe');
            }

            $pdf_pages_dir = storage_path('app/public/pdf/book_'.Str::random());
            $this->info("Set output dir: {$pdf_pages_dir}");
            $options['output_dir'] = $pdf_pages_dir;
            $options['file'] = base_path($file);

            $this->info("Output dir: {$pdf_pages_dir}");
            $pdf_to_html = new \App\Helpers\XPdfToHtml($options);
            $pdf_to_html->parse();
            $page  = 1;
            $book_pages = $pdf_to_html->getHtml();
            if(is_array($book_pages) && !empty($book_pages)){
                $titles = [];
                foreach ($book_pages as $html){
                    \App\Helpers\XPdfToHtml::findPageTitle($html, $titles);
                }
                arsort($titles);
                $title = array_key_first($titles);
                foreach ($book_pages as $html){
                    if($page == 10){
                        $html = \App\Helpers\XPdfToHtml::generateCorrectHtml($html, $title);
                        file_put_contents('page.html', '<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
    '.$html.'
</html>');
                        $this->info("Page Number : {$page}");
                        $this->info("Content : {$html}");
                        break;
                    }
                    $page++;
                }
            }
            ProcessParsePdfBooks::delTree($pdf_pages_dir);
        }else{
            $this->info("File not found : {$file}");
        }
        return 0;
    }
}
