<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use Exception;
use App\Http\Controllers\Controller;

class ApiBaseController extends Controller
{

//    protected $perfil;
//    
    protected $namespace = 'App\\Entities\\';
    protected $model;
    protected $class;
    protected $rules;
    protected $guard='api';

    public function __construct()
    {
        $this->class = $this->namespace . $this->model;
    }

    public function index()
    {
        $data = $this->class::all();
        return $this->sendResponse($data, 'OK');
    }

    public function destroy($id)
    {
        $this->class::destroy($id);
        return $this->sendResponse(['deleted' => true], 'OK');
    }

    public function store(Request $request)
    {
        try {
//          $this->validate($request, $this->rules);
//            if (empty($errors)) {
            $this->class::create($request->all());
            return $this->sendResponse(['created' => true], 'OK');
//            }
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
//            $this->validate($request, $this->rules);
//            if (empty($errors)){
            $registro = $this->class::find($id);
            $registro->update($request->all());
            $registro->save();
            return $this->sendResponse(['updated' => true], 'OK');
//            }
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function show($cadena,$send=true)
    {
        if (!strpos($cadena, '=')&&!strpos($cadena, '>')&&!strpos($cadena, '<')&&!strpos($cadena, ']')&&!strpos($cadena, '['))
            $data = $this->class::find($cadena);
        else {
            $filtros = explode('&', $cadena);
            if (!strpos($cadena, 'ields='))
                $data = $this->class::all();
            else {
                foreach ($filtros as $filtro) {
                    $campos = explode('=', $filtro);
                    $value = $campos[0];
                    $key = $campos[1];
                    if ($value == 'fields')
                        $data = $this->fields($key);
                }
            }
           
            foreach ($filtros as $filtro) {
                foreach (['=','<','>',']','['] as $operacion){
                    $campos = explode($operacion, $filtro);
                    
                    if (count($campos)==2){
                        
                        $value = $campos[0];
                        $key = $campos[1];
                        if ($value != 'fields')
                            $data = $data->filter(function ($filtro) use ($value, $key,$operacion) {
                                switch ($operacion){
                                    case '=' : return $filtro->$value == $key;break;
                                    case '>' : return $filtro->$value > $key; break;
                                    case '<' : return $filtro->$value < $key; break;
                                    case ']' : return $filtro->$value >= $key; break;
                                    case '[' : return $filtro->$value <= $key; break;
                                }
                            });
                    }
                }
            }
        }
        if ($send) return $this->sendResponse($data, 'OK');
        else return $data;
        
    }

    protected function fields($fields)
    {
        $campos = explode(',', $fields);
        foreach ($campos as $campo) {
            $value[] = $campo;
        };
        return $this->class::all($value);
    }

    protected function sendResponse($result, $message)
    {
        return response()->json($result);
        //return Response::json(ResponseUtil::makeResponse($message, $result));
    }

    protected function sendError($error, $code = 404)
    {
        return response()->json(['message'=>$error,'data'=>$code]);
        //return Response::json(ResponseUtil::makeError($error), $code);
    }

}
