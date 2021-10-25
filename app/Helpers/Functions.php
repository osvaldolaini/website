<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class Functions
{

    public static function month(string $string){
        switch ($string) {
            case "01":    $mes = 'Janeiro';     break;
            case "02":    $mes = 'Fevereiro';   break;
            case "03":    $mes = 'Março';       break;
            case "04":    $mes = 'Abril';       break;
            case "05":    $mes = 'Maio';        break;
            case "06":    $mes = 'Junho';       break;
            case "07":    $mes = 'Julho';       break;
            case "08":    $mes = 'Agosto';      break;
            case "09":    $mes = 'Setembro';    break;
            case "10":    $mes = 'Outubro';     break;
            case "11":    $mes = 'Novembro';    break;
            case "12":    $mes = 'Dezembro';    break;
        }
        return $mes;
    }
    public static function payment_form($payment)
    {
        switch ($payment) {
            case "DIN": $background= 'background-color:#fff';   break;
            case "PIX": $background= 'background-color:#ffa';   break;
            case "BOL": $background= 'background-color:#aff';   break;
            case "CAR": $background= 'background-color:#aaf';   break;
            default:    $background= 'background-color:#fff';   break;
        }
        return $background;
    }
    public static function status(string $string)
    {
        switch ($string) {
            case 0:
                $active= '<div class="btn btn-xs btn-danger text-white mx-1" style="cursor:default"><i class="fas fa-lg fa-thumbs-down "></i></div>';
                break;
            case 1:
                $active= '<div class="btn btn-xs btn-success text-white mx-1" style="cursor:default"><i class="fas fa-lg fa-thumbs-up"></i></div>';
                break;
            case 2:
                $active= '<div class="btn btn-xs btn-warning text-white mx-1 " style="cursor:default"><i class="fas fa-lg fa-book-dead"></i></div>';
             break;
             case 3:
                $active= '<div class="btn btn-xs btn-warning text-white mx-1 " style="cursor:default"><i class="fas fa-lg fa-exclamation-triangle"></i></div>';
             break;

            default:
                $active= '<div class="btn btn-xs btn-danger text-white mx-1" style="cursor:default"><i class="fas fa-lg fa-thumbs-down "></i></div>';
                break;
        }
        return $active;
    }

    public static function buttons($id, $level = null, $location,$commitDel=false)
    {
        $btnEdit = '<a href="'.url($location.'/'.$id.'/editar').'" class="btn btn-xs btn-secondary text-white mx-1 shadow" data-trigger="hover" data-tooltip="tooltip" data-placement="top" title="Editar">
                        <i class="fa fa-lg fa-fw fa-pen"></i>
                    </a>';

        if($level){
            if(Auth::user()->group->level > 10){
                $btnDelete ='';
            }else{
                if($commitDel==false){
                    $btnDelete = '<a href="#" data-id="'.$id.'" class="btn btn-xs btn-danger text-white mx-1 shadow delete" data-trigger="hover" data-tooltip="tooltip" data-placement="top" title="Apagar">
                        <i class="fa fa-lg fa-fw fa-trash"></i>
                    </a>';
                }else{
                    $btnDelete = '<a href="#" data-id="'.$id.'" class="btn btn-xs btn-danger text-white mx-1 shadow delete-commit" data-trigger="hover" data-tooltip="tooltip" data-placement="top" title="Apagar">
                        <i class="fa fa-lg fa-fw fa-trash"></i>
                    </a>';
                }

            }
        }else{
            $btnDelete = '<a href="#" data-id="'.$id.'" class="btn btn-xs btn-danger text-white mx-1 shadow delete" data-trigger="hover" data-tooltip="tooltip" data-placement="top" title="Apagar">
                <i class="fa fa-lg fa-fw fa-trash"></i>
            </a>';
        }

        $btnDetails = '<a data-id="'.$id.'" class="btn btn-xs btn-primary text-white mx-1 shadow viewModel" data-trigger="hover" data-tooltip="tooltip" data-placement="top" title="Ver">
                        <i class="fa fa-lg fa-fw fa-eye"></i>
                    </a>';
        return '<nobr>'.$btnEdit.$btnDelete.$btnDetails.'</nobr>';
    }

    public static function valueDB($value)
    {
        if($value){
            str_replace(' ', '', $value);
            ltrim($value);
            $value = str_replace('.', '', $value);
            $value = str_replace(',', '.', $value);
            return str_replace(' ', '', $value);
        }
    }

}
