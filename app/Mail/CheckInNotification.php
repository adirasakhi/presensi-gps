<?php
// app/Mail/CheckInNotification.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Presensi;

class CheckInNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $presensiData;

    public function __construct($presensiData)
    {
        $this->presensiData = $presensiData;
    }

    public function build()
    {
        return $this->view('emails.checkin')->with(['presensiData' => $this->presensiData]);
    }
}
