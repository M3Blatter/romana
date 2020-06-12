<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use DB;
use Excel;
use App\Exports\PMSRomanasExport;
use App\Exports\PMSRomanasExport2;
use Illuminate\Database\Eloquent\Collection;

class RomanasReporte extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:romanasreporte';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para reporte de email automatico';

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
        $nombreexcel = 'reporte_diario_romana_sobrepeso';
        $nombreexcel2 = 'reporte_diario_romana_sobrepeso_corregido';

        /*
        * Romana Lautaro
        */

        //Pesaje_Mop_Simple_Lautaro
        $data = DB::connection('mysql_romanas')
            ->table('P_Mop_Simple_Lautaro')
            ->select('folio_mop', 'fe_ent', 'patente', 'bruto', 'maximo', 'sobrepeso')
            ->Where(DB::raw("DATE_FORMAT(fe_ent, '%Y-%m-%d')"), DB::raw('CURDATE() - interval 1 day'))
            ->orderBy('fe_ent', 'DESC')
            ->get();
        $datos = DB::connection('mysql_romanas')
            ->table('P_Mop_Simple_Lautaro')
            ->select('folio_mop', 'fe_ent', 'patente', 'bruto', 'maximo', 'sobrepeso')
            ->Where(DB::raw("DATE_FORMAT(fe_ent, '%Y-%m-%d')"), DB::raw('CURDATE() - interval 1 day'))
            ->where('estado', '=', 'Fuera del límite MOP')
            ->orderBy('fe_ent', 'DESC')
            ->get();
        $datosLautaro = DB::connection('mysql_test')
            ->table('romana_corregido_lautaro')
            ->select('folio_mop', 'fecha', 'patente')
            ->Where(DB::raw("DATE_FORMAT(fecha, '%Y-%m-%d')"), DB::raw('CURDATE() - interval 1 day'))
            ->orderBy('fecha', 'DESC')
            ->get();

        $correos = array();
        /* array_push($correos, 'sergio.stapung@tecnodatos.cl');*/
        array_push($correos, 'martin.blatter@tecnodatos.cl');
        array_push($correos, 'sergio.stapung@tecnodatos.cl');

        $datos2 = 'Romana Lautaro';

        if (count($datos) > 0) {

            // Genera excel  y Correo
            Excel::store(new PMSRomanasExport(new Collection($datos)), $nombreexcel . '.xlsx');
            Excel::store(new PMSRomanasExport2(new Collection($datosLautaro)), $nombreexcel2 . '.xlsx');
            $subject = "Reporte Diario Sobrepesos " . $datos2 . " Día De Ayer.";
            $email = $correos;
            $nombre = '';
            Mail::send(
                'email.pmsromanas',
                ['data' => $datos2, 'total' => $data, 'dato' => $datos, 'corregidos' => $datosLautaro],
                function ($mail) use ($email, $nombre, $subject, $nombreexcel, $nombreexcel2) {
                    $mail->from(config('mail.from.address'), config('mail.from.name'));
                    $mail->to($email, $nombre);
                    $mail->subject($subject);
                    $mail->attach(base_path() . '/storage/app/' . $nombreexcel . '.xlsx');
                    $mail->attach(base_path() . '/storage/app/' . $nombreexcel2 . '.xlsx');
                }
            );
        }

        /*
        * Romana angol
        */

        //Pesaje_Mop_Simple
        $data = DB::connection('mysql_romanas')
            ->table('P_Mop_Simple_Angol')
            ->select('folio_mop', 'fe_ent', 'patente', 'bruto', 'maximo', 'sobrepeso')
            ->Where(DB::raw("DATE_FORMAT(fe_ent, '%Y-%m-%d')"), DB::raw('CURDATE() - interval 1 day'))
            ->orderBy('fe_ent', 'DESC')
            ->get();
        $datos = DB::connection('mysql_romanas')
            ->table('P_Mop_Simple_Angol')
            ->select('folio_mop', 'fe_ent', 'patente', 'bruto', 'maximo', 'sobrepeso')
            ->Where(DB::raw("DATE_FORMAT(fe_ent, '%Y-%m-%d')"), DB::raw('CURDATE() - interval 1 day'))
            ->where('estado', '=', 'Fuera del límite MOP')
            ->orderBy('fe_ent', 'DESC')
            ->get();
        $datosAngol = DB::connection('mysql_test')
            ->table('romana_corregido_angol')
            ->select('folio_mop', 'fecha', 'patente')
            ->Where(DB::raw("DATE_FORMAT(fecha, '%Y-%m-%d')"), DB::raw('CURDATE() - interval 1 day'))
            ->orderBy('fecha', 'DESC')
            ->get();

        $correos = array();
        /* array_push($correos, 'sergio.stapung@tecnodatos.cl');*/
        array_push($correos, 'martin.blatter@tecnodatos.cl');
        array_push($correos, 'sergio.stapung@tecnodatos.cl');

        $datos2 = 'Romana Angol';


        if (count($datos) > 0) {

            // Genera excel  y Correo
            Excel::store(new PMSRomanasExport(new Collection($datos)), $nombreexcel . '.xlsx');
            Excel::store(new PMSRomanasExport2(new Collection($datosAngol)), $nombreexcel2 . '.xlsx');
            $subject = "Reporte Diario Sobrepesos " . $datos2 . " Día De Ayer.";
            $email = $correos;
            $nombre = '';
            Mail::send(
                'email.pmsromanas',
                ['data' => $datos2, 'total' => $data, 'dato' => $datos, 'corregidos' => $datosAngol],
                function ($mail) use ($email, $nombre, $subject, $nombreexcel, $nombreexcel2) {
                    $mail->from(config('mail.from.address'), config('mail.from.name'));
                    $mail->to($email, $nombre);
                    $mail->subject($subject);
                    $mail->attach(base_path() . '/storage/app/' . $nombreexcel . '.xlsx');
                    $mail->attach(base_path() . '/storage/app/' . $nombreexcel2 . '.xlsx');
                }
            );
        }
    }
}
