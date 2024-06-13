<?php

namespace App\Actions\Logging;

use App\Models\Logging;

class StoreLogAction
{
    public function storeCheckEmailLog(string $incomingEmail, ?string $userIdentifier, ?string $userName)
    {
        Logging::create([
            'id' => $userIdentifier,
            'user' => $userName,
            'activity' => 'Checking email',
            'value' => $incomingEmail,
        ]);
    }
}
