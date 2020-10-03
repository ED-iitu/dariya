<?php


namespace Gufy\PdfToHtml;


use PHPHtmlParser\Dom;

class PageGenerator
{
    public static function generateCorrectHtml($html){
        $page = new Dom();
        $page->loadStr($html,[]);
        /**
         * @var Dom\Collection $elements
         */
        $div = $page->find('div');
        /**
         * @var Dom\HtmlNode $element
         */
        $element_left_css = [];
        $tags = [];
        $div->each(function ($collection)use (&$element_left_css, &$tags){
            $elements = $collection->getChildren();
            /**
             * @var Dom\HtmlNode $element
             */
            foreach ($elements as $key=>&$element){
                $styles = $element->getAttribute('style');
                $styles_arr = explode(';',$styles);
                $left = null;
                foreach ($styles_arr as $style){
                    $style_arr = explode(':', $style);
                    if(isset($style_arr[0]) && $style_arr[0] == 'left'){
                        $left = intval($style_arr[1]);
                        if(isset($element_left_css[$left])){
                            $element_left_css[$left]++;
                        }else{
                            $element_left_css[$left] = 1;
                        }
                    }
                }
                if($element->getTag()->name() == 'p' && $element->hasChildren()){
                    if(!is_numeric($element->text())){
                        $tags[] = [
                            'left' => $left,
                            'html' => $element->innerHtml()
                        ];
                    }
                }
            }
        });

        arsort($element_left_css);
        $element_left_css = array_keys($element_left_css);
        $min_left = min($element_left_css[0], $element_left_css[1]);
        $max_left = max($element_left_css[0], $element_left_css[1]);
        //dd($element_left_css, $min_left, $max_left);
        /**
         * @var Dom\HtmlNode $e
         */
        $ps = [];
        $element_index = 0;
        foreach ($tags as $k=>$e){
            $current_left = $e['left'];
            if(!empty($ps)){
                $prev_element_index = $element_index - 1;
                if(isset($ps[$prev_element_index])){
                    $prev_left = $ps[$prev_element_index]['left'];
                    if((($current_left == $prev_left && $current_left == $min_left) || ($current_left != $prev_left && $current_left < $prev_left)) && ($prev_left <= $max_left)){
                        $ps[$prev_element_index]['text'] = $ps[$prev_element_index]['text'].''.$e['html'];
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


        $html = '<body><div id="page-div" style="position:relative">';

        foreach ($ps as $p){
            if($p['left'] > $max_left){
                $html .= '<p style="margin:0;left:'.$p['left'].'px;text-align: center" class="ft01">'.$p['text'].'</p>';
            }else{
                $html .= '<p style="margin:0;left:'.$p['left'].'px;" class="ft01">'.$p['text'].'</p>';
            }
        }

        $html .= '</div></body>';

        return $html;
    }
}