<?php

namespace App\Enums;

enum RefundStatus: int
{
    case PROCESS = 1;
    case REJECT = 2;
    case CONFIRM = 3;
}
