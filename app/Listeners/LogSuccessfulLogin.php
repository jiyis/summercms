<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Repository\LogRepository;
use Carbon\Carbon;

class LogSuccessfulLogin
{
    public $request;

    public $logger;

    /**
     * LogSuccessfulLogin constructor.
     * @param Request $request
     * @param LogRepository $logger
     */
    public function __construct(Request $request, LogRepository $logger)
    {
        $this->request = $request;
        $this->logger = $logger;
    }

    /**
     * @param Login $event
     */
    public function handle(Login $event)
    {
        //$event->user->last_login_at = Carbon::now();
        $event->user->ip = $this->request->ip();
        $event->user->save();
        $attributes = [
            'userid'       =>  $event->user->id,
            'username'      =>  $event->user->name,
            'httpuseragent' => $_SERVER['HTTP_USER_AGENT'],
            'sessionid'     => session()->getId(),
            'ip'            => getClientIps()
        ];
        $this->logger->log($attributes);
    }
}
