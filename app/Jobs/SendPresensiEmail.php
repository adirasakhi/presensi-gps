<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\CheckInNotification;
use App\Models\Presensi;

class SendPresensiEmail implements ShouldQueue
{
    public function handle()
    {
        // Ambil data presensi hari ini
        $presensiData = Presensi::whereDate('tgl_presensi', now()->toDateString())->get();

        // Kirim email
        Mail::to('loloxthree@email.com')->send(new CheckInNotification($presensiData));
    }
}
