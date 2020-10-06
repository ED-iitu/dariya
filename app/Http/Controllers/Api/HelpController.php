<?php


namespace App\Http\Controllers\Api;


use App\Info;
use App\SupportTicket;

class HelpController extends Controller
{
    public function index(){
        $info_types = [];
        $types = Info::getTypeLabels();
        array_walk($types,function ($key, $value) use (&$info_types){
            $info_types[$value] = [
                'type' => $value,
                'description' => $key,
                'info' => []
            ];
        });

        Info::query()->where('status', 1)->each(function ($info) use (&$info_types){
            /**
             * @var Info $info
             */
            if(isset($info_types[$info->type])){
                $info_types[$info->type]['info'][] = $info->attributesToArray();
            }
        });
        return $this->sendResponse($info_types,'Список информации');
    }

    public function create(){
        $body = $this->getParsedBody();
        SupportTicket::query()->create($body);
        return $this->sendResponse($body,'Ваша заявка успешно принят!');
    }
}