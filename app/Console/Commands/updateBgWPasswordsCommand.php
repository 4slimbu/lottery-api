<?php

namespace App\Console\Commands;

use App\Acme\Models\LogsBgwRequests;
use App\Acme\Models\User;
use App\Acme\Services\BgwService;
use Illuminate\Console\Command;

class updateBgWPasswordsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bgw:updatePW';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        logger()->debug('Converting PW', ['state' => 'START']);
        $bgwService = new BgwService();
        LogsBgwRequests::query()->orderBy('id', 'ASC')->chunk(100, function($logs) use ($bgwService) {
            foreach($logs as $log) {
                $dgw_DO = $bgwService->convertBgwToArray($log->xml);

                $username = array_get($dgw_DO, 'Header.Security.UsernameToken.Username');
                $password = array_get($dgw_DO, 'Header.Security.UsernameToken.Password');

                $user = User::query()->where('monster_username', $username)->first();
                if(is_null($user)) {
                    logger()->error('No user found for : ' . $username);
                    continue;
                }

                if(!is_null($username) && !is_null($password)) {
                    $bgwService->updateMapMonsterUser($username, $password, $user->id);
                }
            }
            logger()->debug('Converting PW', ['state' => 'PROGRESS 100+']);
        });
        logger()->debug('Converting PW', ['state' => 'COMPLETE']);
        return;
    }
}
