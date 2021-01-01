<?php


namespace App\Helpers;


use DOMDocument;
use DOMNode;
use DOMXPath;
use PHPHtmlParser\Dom;

class XPdfToHtml extends Dom
{
    protected $file;

    protected $output_dir;

    protected $bin = '/usr/local/bin/pdftohtml';
    protected $info_bin = '/usr/local/bin/pdfinfo';

    protected $info;
    protected $contents;

    public function __construct($options = [])
    {
        foreach ($options as $option => $value) {
            if (property_exists($this, $option)) {
                $this->{$option} = $value;
            }
        }
    }

    public function parse()
    {
        $this->generate();

        $pages = $this->getPages();

        $base_path = $this->output_dir;
        $contents = [];
        for ($i = 1; $i <= $pages; $i++) {
            $content = file_get_contents($base_path.'/page'.$i.'.html');
            $content = str_replace("Â", "", $content);
            $content = str_replace("id=\"", "class=\"", $content);
            $content = str_replace("­ ", "", $content);

            $content = preg_replace('/color:rgba\([0-9]{1,},[0-9]{1,},[0-9]{1,},[0-9]{1,}\);/m','',$content);

            $dom = new DOMDocument();
            $dom->loadHTML($content);
            $xpath = new DOMXPath($dom);
            foreach ($xpath->query('//comment()') as $comment) {
                $comment->parentNode->removeChild($comment);
            }
            $body = $xpath->query('//body')->item(0);
            $content = $body instanceof DOMNode ? $dom->saveHTML($body) : 'something failed';

            file_put_contents($base_path.'/page'.$i.'.html', $content);
            $contents[ $i ] = file_get_contents($base_path.'/page'.$i.'.html');
            unlink($base_path.'/page'.$i.'.html');
            unlink($base_path.'/page'.$i.'.png');
        }
        $this->contents = $contents;
    }

    public function generate()
    {
        $output = $this->output_dir;
        //$options = $this->generateOptions();
        $options = '';

        if (PHP_OS === 'WINNT') {
            $command = '"' . $this->bin . '" ' . $options . ' "' . $this->file . '" "' . $output . '"';
        } else {
            $command = $this->bin . " " . $options . " '" . $this->file . "' '" . $output . "'";
        }

        exec($command);

        return $this;
    }

    public function getInfo()
    {
        $this->checkInfo();

        return $this->info;
    }

    private function checkInfo()
    {
        if ($this->info == null)
            $this->info();
    }

    protected function info()
    {

        if (PHP_OS === 'WINNT') {
            $content = shell_exec('"' . $this->info_bin . '" "' . $this->file . '"');
        } else {
            $content = shell_exec($this->info_bin . " '" . $this->file . "'");
        }

        // print_r($info);
        $options = explode("\n", $content);
        $info = [];
        foreach ($options as &$item) {
            if (!empty($item)) {
                list($key, $value) = explode(":", $item);
                $info[str_replace([" "], ["_"], strtolower($key))] = trim($value);
            }
        }
        $this->info = $info;

        return $this;
    }

    public function getPages()
    {
        $this->checkInfo();

        return $this->info['pages'];
    }

    public function getHtml(){
        return $this->contents;
    }

    public static function findPageTitle(string $html, array &$titles)
    {
        $page = new Dom();
        $page->loadStr($html,[]);
        /**
         * @var Dom\Collection $elements
         */
        $body = $page->find('body');
        /**
         * @var Dom\HtmlNode $element
         */
        $body->each(function ($collection)use (&$titles) {
            $elements = $collection->getChildren();
            /**
             * @var Dom\HtmlNode $element
             */
            foreach ($elements as $key => &$element) {
                if ($element instanceof Dom\HtmlNode && !empty($element->innerHtml())) {
                    if(array_key_exists($element->innerHtml(),$titles)){
                        $titles[$element->innerHtml()]++;
                    }else{
                        $titles[$element->innerHtml()] = 1;
                    }
                    break;
                }
            }
            return false;
        });
    }

    public static function generateCorrectHtml($html, $title){
        $page = new Dom();
        $page->loadStr($html,[]);
        /**
         * @var Dom\Collection $elements
         */
        $body = $page->find('body');
        /**
         * @var Dom\HtmlNode $element
         */
        $element_left_css = [];
        $tags = [];
        $body->each(function ($collection)use (&$element_left_css, &$element_top_css, &$tags, $title){
            $elements = $collection->getChildren();
            /**
             * @var Dom\HtmlNode $element
             */
            $i_c = 0;
            foreach ($elements as $key=>&$element){
                if($element instanceof Dom\HtmlNode) {
                    if(!empty($element->innerHtml()) && $element->innerHtml() != $title && !preg_match('/(<span class="[a-zA-Z0-9]{1,}" style="font-size:[0-9]{1,}px;vertical-align:baseline;">(([0-9]{1,})|([0-9]{1,} {1,}))<\/span>)/m',$element->innerHtml())){
                        $i_c++;
                        $styles = $element->getAttribute('style');
                        $styles_arr = explode(';', $styles);
                        $left = null;
                        $css_top = null;
                        foreach ($styles_arr as $style) {
                            $style_arr = explode(':', $style);
                            $style_name = str_replace(' ','',$style_arr[0]);
                            if (isset($style_name) && $style_name == 'left') {
                                $left = intval($style_arr[1]);
                                if (isset($element_left_css[$left])) {
                                    $element_left_css[$left]++;
                                } else {
                                    $element_left_css[$left] = 1;
                                }
                            }
                        }
                        $tags[] = [
                            'left' => $left,
                            'top' => $css_top,
                            'html' => $element->innerHtml()
                        ];
                    }
                }
            }
        });


        arsort($element_left_css);
        $element_left_css = array_keys($element_left_css);
        if(count($element_left_css) >= 2){
            $min_left = min($element_left_css[0], $element_left_css[1]);
            $max_left = max($element_left_css[0], $element_left_css[1]);
        }else{
            $min_left = $max_left = $element_left_css[0];
        }

        /**
         * @var Dom\HtmlNode $e
         */
        $ps = [];
        $element_index = 0;

        foreach ($tags as $k=>$e){
            $current_left = $e['left'];
            $is_new_p = false;
            if(preg_match('/(<span class="[a-zA-Z0-9]{1,}" style="font-size:[0-9]px;vertical-align:super;">(([0-9]{1,})|([0-9]{1,} {1,}))<\/span>)/m',$e['html'])){
                $is_sup_number = new Dom();
                $is_sup_number->loadStr($e['html'],[]);
                /**
                 *@var Dom\HtmlNode $is_sup_number, $collect
                 */
                $is_sup_number = $is_sup_number->find('span');
                $i = 1;
                $is_sup_number->each(function ($collect) use (&$i, &$is_new_p, &$element_index, $current_left, $e){
                    if(preg_match('/(<span class="[a-zA-Z0-9]{1,}" style="font-size:[0-9]px;vertical-align:super;">(([0-9]{1,})|([0-9]{1,} {1,}))<\/span>)/m',$collect->__toString())){
                        if($is_new_p == false && $i == 1){
                            $ps[$element_index] = [
                                'left' => $current_left,
                                'text' => $e['html']
                            ];
                            $element_index++;
                            $is_new_p = true;
                            return;
                        }
                    }
                    $i++;
                });
            }
            if(!empty($ps) && !$is_new_p){
                $prev_element_index = $element_index - 1;
                if(isset($ps[$prev_element_index])){
                    $prev_left = $ps[$prev_element_index]['left'];

                    if(
                        (
                            ($current_left == $prev_left && $current_left == $min_left) ||
                            ($current_left != $prev_left && $current_left < $prev_left)
                        ) && ($prev_left <= $max_left)
                        ){
                        $ps[$prev_element_index]['text'] = $ps[$prev_element_index]['text'].' '.$e['html'];
                    }else{
                        $ps[$element_index] = [
                            'left' => $current_left,
                            'text' => $e['html']
                        ];
                        $element_index++;
                    }
                }
            }else{
                $ps[$element_index] = [
                    'left' => $current_left,
                    'text' => $e['html']
                ];
                $element_index++;
            }
        }


        $html = '<body>';

        foreach ($ps as $p){
            if($p['left'] > $max_left){
                $html .= '<p style="text-align: center" class="ft01">'.$p['text'].'</p>';
            }else{
                $indent = 0;
                if($p['left'] == $max_left){
                    $indent = $max_left - $min_left;
                }
                $html .= '<p style="text-indent:'.$indent.'px;" class="ft01">'.$p['text'].'</p>';
            }
        }

        $html .= '</body>';
        return $html;
    }
}