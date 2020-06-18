<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Romana_corregido_angol;
use App\Romana_corregido_lautaro;

class Romanas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:romanas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para cargar las tablas de los pesajes corregidos';

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
     * @return mixed
     */
    public function handle()
    {
        //Obtiene ultima fecha del registro de pesaje corregido en la tabla 'romana_corregido_lautaro'
        $UltimoResgistroLautaro = DB::connection('mysql')
            ->table('romana_corregido_lautaro')
            ->select('fecha')
            ->orderBy('fecha', 'desc')
            ->first();
        $resultArrayRegistroLautaro = json_decode(json_encode($UltimoResgistroLautaro), true);
        if (empty($UltimoResgistroLautaro)) {
            //Romana Lautaro        
            //Obtiene el pesajes con estado "Fuera de limite MOP" de la tabla Pesaje_Mop_Simple_Lautaro
            $datosLautaro = DB::connection('mysql_romanas')
                ->table('P_Mop_Simple_Lautaro')
                ->select('folio_mop', 'fe_ent', 'patente')
                ->where('estado', '=', 'Fuera del límite MOP')
                ->get();
        } elseif (count($resultArrayRegistroLautaro) == 1) {
            $fecha = $resultArrayRegistroLautaro['fecha'];
            $datosLautaro = DB::connection('mysql_romanas')
                ->table('P_Mop_Simple_Lautaro')
                ->select('folio_mop', 'fe_ent', 'patente')
                ->where('estado', '=', 'Fuera del límite MOP')
                ->where('fe_ent', '>', $fecha)
                ->get();
        }
        $resultArrayLautaro = json_decode(json_encode($datosLautaro), true);

        //Se recorre para obtener los registros con estado 'Dentro del límite MOP' para saber si se 
        //corrigio el pesaje en Lautaro
        if (count($resultArrayLautaro) > 0) {
            foreach ($resultArrayLautaro as $valueDuplicado) {
                $fecha = $valueDuplicado['fe_ent'];
                $patente88 = $valueDuplicado['patente'];
                $from = $fecha;
                $to = date('Y-m-d H:i:s', strtotime($fecha . '+ 1 hour'));

                $datosLautaro1 = DB::connection('mysql_romanas')
                    ->table('P_Mop_Simple_Lautaro')
                    ->select('folio_mop', 'fe_ent', 'patente')
                    ->where('patente', '=', $patente88)
                    ->where('estado', '=', 'Dentro del límite MOP')
                    ->whereBetween('fe_ent', array($from, $to))
                    ->get();
                $resultArrayLimiteMOP = json_decode(json_encode($datosLautaro1), true);

                //Se valida que no exista el registro en la tabla
                if (count($resultArrayLimiteMOP) > 0) {
                    foreach ($resultArrayLimiteMOP as $value) {
                        $folio = $value['folio_mop'];
                        $fech = $value['fe_ent'];
                        $patente = $value['patente'];
                        $datosLautaro2 = DB::connection('mysql')
                            ->table('romana_corregido_lautaro')
                            ->select('fecha')
                            ->where('fecha', '=', $fech)
                            ->get();
                        $resultArray5 = json_decode(json_encode($datosLautaro2), true);
                        //Se interta el registro en la tabla
                        if (empty($resultArray5)) {
                            //DB::connection('mysql')->table('romana_corregido_lautaro')->insert(['folio_mop' => $folio, 'patente' => $patente, 'fecha' => $fech]);
                            $newdata = new Romana_corregido_lautaro();
                            $newdata->folio_mop = $folio;
                            $newdata->patente = $patente;
                            $newdata->fecha = $fech;
                            $newdata->save();
                        }
                    }
                }
            }
        }

        //Obtiene ultima fecha del registro de pesaje corregido en la tabla 'romana_corregido_angol'
        $UltimoResgistroAngol = DB::connection('mysql')
            ->table('romana_corregido_angol')
            ->select('fecha')
            ->orderBy('fecha', 'desc')
            ->first();
        $resultArrayRegistroAngol = json_decode(json_encode($UltimoResgistroAngol), true);

        if (empty($resultArrayRegistroAngol)) {
            //Romana Angol
            //Obtiene el pesajes con estado "Fuera de limite MOP" de la tabla Pesaje_Mop_Simple_Angol
            $datosAngol = DB::connection('mysql_romanas')
                ->table('P_Mop_Simple_Angol')
                ->select('folio_mop', 'fe_ent', 'patente')
                ->where('estado', '=', 'Fuera del límite MOP')
                ->get();
        } elseif (count($resultArrayRegistroAngol) == 1) {
            $fecha = $resultArrayRegistroAngol['fecha'];
            $datosAngol = DB::connection('mysql_romanas')
                ->table('P_Mop_Simple_Angol')
                ->select('folio_mop', 'fe_ent', 'patente')
                ->where('fe_ent', '>', $fecha)
                ->where('estado', '=', 'Fuera del límite MOP')
                ->get();
        }
        $resultArrayAngol = json_decode(json_encode($datosAngol), true);


        //Se recorre para obtener los registros con estado 'Dentro del límite MOP' para saber si se 
        //corrigio el pesaje en Angol
        if (count($resultArrayAngol) > 0) {
            foreach ($resultArrayAngol as $valueDuplicado) {
                $fecha = $valueDuplicado['fe_ent'];
                $patente88 = $valueDuplicado['patente'];
                $from = $fecha;
                $to = date('Y-m-d H:i:s', strtotime($fecha . '+ 1 hour'));

                $datosAngol1 = DB::connection('mysql_romanas')
                    ->table('P_Mop_Simple_Angol')
                    ->select('folio_mop', 'fe_ent', 'patente')
                    ->where('patente', '=', $patente88)
                    ->where('estado', '=', 'Dentro del límite MOP')
                    ->whereBetween('fe_ent', array($from, $to))
                    ->get();
                $resultArray1 = json_decode(json_encode($datosAngol1), true);

                //Se valida que no exista el registro en la tabla
                if (count($resultArray1) > 0) {
                    foreach ($resultArray1 as $valueDuplicado) {
                        $folio = $valueDuplicado['folio_mop'];
                        $fech = $valueDuplicado['fe_ent'];
                        $patente = $valueDuplicado['patente'];
                        $datosAngol2 = DB::connection('mysql')
                            ->table('romana_corregido_angol')
                            ->select('fecha')
                            ->where('fecha', '=', $fech)
                            ->get();
                        $resultArray5 = json_decode(json_encode($datosAngol2), true);
                        //Se interta el registro en la tabla
                        if (empty($resultArray5)) {
                            //DB::connection('mysql')->table('romana_corregido_angol')->insert(['folio_mop' => $folio, 'patente' => $patente, 'fecha' => $fech]);
                            $newdata = new Romana_corregido_angol();
                            $newdata->folio_mop = $folio;
                            $newdata->patente = $patente;
                            $newdata->fecha = $fech;
                            $newdata->save();
                        }
                    }
                }
            }
        }
    }
}
