<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use \App\Http\Middleware\TrustProxies;
use Fruitcake\Cors\HandleCors;


class Kernel extends ConsoleKernel
{
    /**
     * Los comandos de consola registrados por tu aplicación.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\ImportProducts::class,
    ];

    protected $middleware = [
        ConsoleKernel::class,
        // \App\Http\Middleware\Cors::class,
    ];

    protected $routeMiddleware = [
        // otros middlewares...
        'cors' => \App\Http\Middleware\Cors::class
    ];


    /**
     * Definir las tareas de programación.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Aquí puedes definir tareas programadas si lo necesitas
    }

    /**
     * Registra los comandos de la aplicación.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands'); // Carga los comandos de la carpeta Commands

        require base_path('routes/console.php'); // Carga otras rutas de consola, si las tienes
    }
}
