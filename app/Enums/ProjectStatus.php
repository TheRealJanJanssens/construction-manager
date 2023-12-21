<?php

namespace App\Enums;

use App\Traits\Enum\Options;

enum UnitStatus: string
{
    use Options;

    case COMPLETED_MEETINGS = 'COMPLETED_MEETINGS';
    case TOTAL_ATTENDEES = 'TOTAL_ATTENDEES';

    public function label(): string
    {
        return match($this)
        {
            UnitStatus::COMPLETED_MEETINGS => 'Completed Meetings',
            UnitStatus::TOTAL_ATTENDEES => 'Total Attendees'
        };
    }
}
