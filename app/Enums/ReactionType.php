<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ReactionType extends Enum
{
    const Like = 0;
    const Love = 1;
    const Haha = 2;
    const Wow = 3;
    const Sad = 4;
    const Angry = 5;
}
