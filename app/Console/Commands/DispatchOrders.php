<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\PendingDispatchesJob;
use App\Utils\Endpoints\Endpoint;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DispatchOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dispatch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch ';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::beginTransaction();
        collect(PendingDispatchesJob::all())->each(function (PendingDispatchesJob $job) {
            $order = $job->order;

            if (! $order instanceof Order) return;

            $order->dispatch();
        });
        DB::commit();

        Endpoint::waitAllPromisesFinish();
        return 0;
    }
}
